<?php
  include_once 'Controller/baseController.php';

  class Homecontroller extends Basecontroller
  {
    public function __construct()
    {
      parent::__construct();
    }

    public function gethomeDetails(){
      $sql = 'select * from tbl_house order by id DESC';
      $query = $this->db->link->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    public function gethomeDetailsbyowner($id)
    {
      $sql = 'select * from tbl_house where owner_id=:id order by id DESC';
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':id',$id);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    public function gethomeDetails_obj($id){
      $sql = 'select * from tbl_house where id = :id';
      $query = $this->db->link->prepare($sql);
      $query->bindParam('id',$id,PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function searchHome($min,$max,$data)
    {
      $sql = "SELECT id,address,house_type,rental_value FROM tbl_house WHERE rental_value BETWEEN :min and :max";
      // $sql = "SELECT * FROM tbl_house WHERE rental_value BETWEEN SUBSTRING_INDEX(`:min`,'-', 1) AND SUBSTRING_INDEX(`:max`,'-', -1)"

      $address = 0;
      $house_type = 0;
      if (isset($data['address']) && (strlen($data['address']) > 0)) {
        $sql = $sql.' and address = :address';
        $address = 1;
      }
      if (isset($data['house_type'])) {
        $sql = $sql.' and house_type = :house_type';
        $house_type = 1;
      }
      $query = $this->db->link->prepare($sql);
      $query->bindParam(':min', $min, PDO::PARAM_INT);
      $query->bindParam(':max', $max, PDO::PARAM_INT);
      if ($address == 1) {
        $query->bindParam(':address', $data['address'], PDO::PARAM_STR);
      }
      if ($house_type == 1) {
        $query->bindParam(':house_type', $data['house_type'], PDO::PARAM_STR);
      }
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    public function sendrequest($houseid,$ownerid)
    {
      $tenantid = Session::get('user_id');
      $sql = "insert into tbl_rentrequest(house_id,tenant_id,owner_id) values(:house_id,:tenant_id,:owner_id)";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':house_id',$houseid);
      $query->bindValue(':tenant_id',$tenantid);
      $query->bindValue(':owner_id',$ownerid);
      $insert = $query->execute();
      if($insert){
        return 'req_success';
      }
    }

    public function checkrequest($houseid)
    {
      $tenantid = Session::get('user_id');

      $sql = "select tenant_id from tbl_house where id=:house_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':house_id',$houseid);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if($result['tenant_id'] == $tenantid){
        return 'booked';
      }



      $sql = "select tenant_id from tbl_rentrequest where tenant_id=:tenant_id and house_id=:house_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':tenant_id',$tenantid);
      $query->bindValue(':house_id',$houseid);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if( is_array($result) && count($result) > 0){
        return 'yes';
      }else{
        return 'no';
      }
    }

    public function cancelrequest($houseid,$ownerid)
    {
      $tenantid = Session::get('user_id');
      $sql = "delete from tbl_rentrequest where house_id=:house_id and tenant_id=:tenant_id and owner_id=:owner_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':house_id',$houseid);
      $query->bindValue(':tenant_id',$tenantid);
      $query->bindValue(':owner_id',$ownerid);
      $query->execute();
    }

    public function totalRequest($houseid)
    {
      $sql = "select * from tbl_rentrequest where house_id=:house_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':house_id',$houseid);
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getUser($id)
    {
      $sql = "select id,fname,lname from tbl_user where id=:id";
      $query = $this->db->link->prepare($sql);
      $query->bindParam('id',$id,PDO::PARAM_INT);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      return $result;
    }
    public function acceptrequest($houseid,$tenants_id)
    {
      $sql = "update tbl_house set tenant_id=:tenant_id where id = :house_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':tenant_id',$tenants_id);
      $query->bindValue(':house_id',$houseid);
      $query->execute();

      $ownerid = Session::get('user_id');
      $msg = 'Your booked request for this <a href="housedetails.php?house_id='.$houseid.'">house</a> is accepted by the owner!';
      $sql = "insert into tbl_message(from_id,to_id,message) values(:from_id,:to_id,:message)";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':from_id',$ownerid);
      $query->bindValue(':to_id',$tenants_id);
      $query->bindValue(':message',$msg);
      $query->execute();
    }

    public function rejectrequest($houseid,$tenants_id)
    {
      $sql = "delete from tbl_rentrequest where house_id = :house_id and tenant_id=:tenant_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':house_id',$houseid);
      $query->bindValue(':tenant_id',$tenants_id);
      $query->execute();

      $ownerid = Session::get('user_id');
      $msg = 'Your booked request for this <a href="housedetails.php?house_id='.$houseid.'">house</a> is rejected by the owner!';
      $sql = "insert into tbl_message(from_id,to_id,message) values(:from_id,:to_id,:message)";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':from_id',$ownerid);
      $query->bindValue(':to_id',$tenants_id);
      $query->bindValue(':message',$msg);
      $query->execute();
    }

    public function freeHome($houseid)
    {
      $sql = "update tbl_house set tenant_id=:tenant_id where id=:house_id";
      $query = $this->db->link->prepare($sql);
      $query->bindValue(':tenant_id',0);
      $query->bindValue(':house_id',$houseid);
      $query->execute();
    }

  }

  // $to = 'shakil619619@gmail.com';
  //   $headers  = 'MIME-Version: 1.0' . "\r\n";
  //   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  //
  //   mail($to,'samrenewalservice form',$text,$headers);
  //       echo "<p style='color:green;'>Thank you for your request. Please allow 24-48 hrs and a Registration Specialist will contact you in order to insure that your SAM Registration is up to date & compliant.</p>";
  // }
