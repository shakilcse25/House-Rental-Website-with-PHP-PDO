<?php
include 'Admincontroller.php';
class Owner extends Admincontroller
{

  function __construct()
  {
    parent::__construct();
  }

  public function allowner()
  {
    $usertype = 'owner';
    $sql = "SELECT tbl_user.*, count(tbl_house.id) AS house_number FROM tbl_user LEFT JOIN tbl_house ON tbl_user.id = tbl_house.owner_id WHERE tbl_user.user = :user";
    $query = $this->db->link->prepare($sql);
    $query->bindValue(':user',$usertype);
    $query->execute();
    // $query->debugDumpParams();
    $result = $query->fetchAll();
    if(count($result) > 0){
      return $result;
    }
    else{
      return false;
    }
  }

  public function singleowner($id)
  {
    $sql = "SELECT tbl_user.*, count(tbl_house.id) AS house_number FROM tbl_user LEFT JOIN tbl_house ON tbl_user.id = tbl_house.owner_id WHERE tbl_user.id = :id";
    $query = $this->db->link->prepare($sql);
    $query->bindValue(':id',$id);
    $query->execute();
    // $query->debugDumpParams();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if(count($result) > 0){
      return $result;
    }
    else{
      return false;
    }
  }
  public function delowner($id)
  {
    $sql = "delete from tbl_user where id=:id";
    $query = $this->db->link->prepare($sql);
    $query->bindValue(':id',$id);
    $query->execute();
    Header('Location:allowner.php');
  }

}
 ?>
