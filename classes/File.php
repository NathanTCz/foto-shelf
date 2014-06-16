<?php
require_once 'classes/Database.php';

class File extends Database {
  public $name;
  public $size;
  public $type;
  public $owner;
  public $path;
  public $id;
  public $albumn_id;

  public function __construct ($name, $size, $type, $owner, $path, $id = 0, $albumn_id = 0) {
    $this->name = $name;
    $this->size = $size;
    $this->type = $type;
    $this->owner = $owner;
    $this->path = $path;
    $this->id = $id;
    $this->type = $albumn_id;
  }

  public function validate () {
    return true;
  }
}
?>