<?php
require_once 'classes/Database.php';
require_once 'classes/File.php';

Class User extends Database {
  private $user_id;
  private $email;
  private $files = array();
  

  public function __construct ($email, $uid) {
    // instantiate parent class
    parent::__construct();

    $this->user_id = $uid;
    $this->email = $email;
  }

  public function get_files () {
    $files = parent::get_files();

    foreach ($files as $pic) {
      $f = new File($pic->name,
                    $pic->size,
                    $pic->type,
                    $pic->owner,
                    $pic->path,
                    $pic->id,
                    $pic->albumn_id
      );

      $this->files[] = $f;
    }

    return $this->files;
  }

  public function add_file (&$file) {
    parent::add_item($file->name, $file->path, $file->size, $file->type, $file->owner);
  }

  public function get_email () {
    return $this->email;
  }

  public function get_another_email ($id) {
    return parent::get_email($id);
  }

  public function get_uid () {
    return $this->user_id;
  }
}
?>
