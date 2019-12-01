<?php
  include_once 'Controller/baseController.php';

  class Message extends Basecontroller
  {
    public function __construct()
    {
      parent::__construct();
    }

    public function getMessage($id)
    {
      $sql = "select * from tbl_message where to_id=:id order by id DESC limit 5";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':id',$id);
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
    public function adminmsg($value)
    {
      $email = $value['email'];
      $message = $value['message'];
      $sql = "insert into tbl_adminmsg(email,message) values(:email,:message)";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':email',$email);
      $query->bindValue(':message',$message);
      $query->execute();
    }

  }
 ?>
