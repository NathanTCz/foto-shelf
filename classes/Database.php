<?php
require '/var/www/config/fs_config.php';

class Database {
  public $DB;


//PRIVATE FUNCTIONS
  private function resolve_data ($query) {
    $meta = $query->result_metadata();

    while ($field = $meta->fetch_field()) {
      $parameters[] = &$row[$field->name];
    }

    call_user_func_array(array($query, 'bind_result'), $parameters);
    
    $results = array();

    while ($query->fetch()) {
      $obj = new stdClass();

      foreach($row as $key => $val) {
        $obj->$key = $val;
      }

      $results[] = $obj;
    }

    return $results;
  }


//PUBLIC FUNCTIONS
  public function __construct () {
    global$DB_HOST;
    global$DB_USER;
    global$DB_PASS;
    global $DB_NAME;

    $this->DB = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
  }

  public function get_files () {
    $query = $this->DB->prepare ("
      SELECT *
      FROM `file`
    ");

    $query->execute();

    return $this->resolve_data($query);
  }

  public function get_email ($id) {
    $query = $this->DB->prepare ("
      SELECT email
      FROM user
      WHERE user_id = ?
    ");

    $query->bind_param('d', $id);
    $query->execute();

    return $this->resolve_data($query);
  }

  public function delete_item ($id, $user_id, $table) {
    // Delete note
    $query1 = $this->DB->prepare ("
      DELETE FROM $table
      WHERE s_id = ?
      AND user_id = ?
    ");

    $query1->bind_param('dd', $id, $user_id);
    $query1->execute();

    // Delete associated tags
    $query2 = $this->DB->prepare ("
      DELETE FROM tag
      WHERE t_id = ?
    ");

    $query2->bind_param('d', $id);
    $query2->execute();
  }

  public function update_item ($id, $user_id, $table, $column, $value) {
    $query = $this->DB->prepare ("
      UPDATE $table
      SET $column = ?
      WHERE s_id = ?
      AND user_id = ?
    ");

    $query->bind_param('sdd', $value, $id, $user_id);
    $query->execute();
  }
  public function add_item ($name, $path, $size, $type, $owner) {
    $query = $this->DB->prepare ("
      INSERT INTO `file`
      (`albumn_id`, `name`, `path`, `size`, `type`, `owner`)
      VALUES ('0', ?, ?, ?, ?, ?)
    ");

    $query->bind_param('ssdsd', $name, $path, $size, $type, $owner);
    $query->execute();
  }

  public function search_data ($id, $data) {
    $wowc_data = $data;
    $data = '%' . $data . '%';

    $query = $this->DB->prepare ("
      SELECT *
      FROM stuph AS s
        LEFT OUTER JOIN tag AS t
          ON s.s_id = t.t_id
      WHERE s.user_id = ?
      AND (
        s.body LIKE ? OR t.name LIKE ?
      )
      GROUP BY s.s_id
      ORDER BY s.time DESC
    ");
    
    $query->bind_param('dss', $id, $data, $data);
    $query->execute();
    
    return $this->resolve_data($query);
  }

}
?>
