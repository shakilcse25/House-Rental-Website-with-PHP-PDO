<?php
  include_once '../lib/Database.php';
  include_once '../lib/helper.php';
  class Admincontroller
  {
    public $db;
    public $help;
    public function __construct()
    {
      $this->db = new Database();
      $this->help = new Helper();
    }
  }
 ?>
