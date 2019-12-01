<?php
  include 'inc/header.php';
  include 'inc/navbar.php';
  include 'Controller/Homecontroller.php';
  Session::checkSession();
?>

<div class="profile_area">
  <div class="profile_main container">
    <div class="inner_profile row">
      <div class="left_profile col-sm-3">
        <div class="left_profile_inner">
          <div class="profile_title">
            <div class="profile_image">
              <img src="assets/images/owner.png" class="img-thumbnail" alt="Owner">
            </div>
            <p class="text-center"> <i class="fas fa-user" style="margin-right:5px;"></i> <?php echo Session::get('fname')." ".Session::get('lname'); ?> </p>
          </div>
          <div class="profile_nav">
            <ul class="main_profile_nav">
              <li> <i class="fas fa-envelope"></i> <strong>Email:</strong> shakilcse@gmail.com </li>
              <li> <i class="fas fa-phone"></i> <strong>Phone:</strong> 01723653352 </li>
              <li> <i class="fas fa-address-card"></i> <strong>Address:</strong> Mirpur,Dhaka </li>
              <li> <i class="fas fa-id-card-alt"></i> <strong>NID:</strong> 2343673947904733 </li>
              <li> <i class="fas fa-angle-double-right"></i> <strong>Description:</strong> <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> </li>
            </ul>

            <?php
              if(Session::get('user') == 'owner'){
             ?>

            <ul class="extra_nav">
              <li style="margin:20px 0px;"> <a class="btn btn-info" href="">Your Tenent List</a> </li>
              <li> <a class="btn btn-primary" href="editprofile.php">Edit Profile</a> </li>
            </ul>
          <?php } ?>
          </div>
        </div>
      </div>
      <div class="right_profile col-sm-9">
        <div class="right_profile_inner">
          <div class="house_main">
            <div class="available_house col-sm-12">
              <h4>Availabe House List for rent</h4>

<?php
  $home = new Homecontroller();
  $id=0;
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  }
  $ava_home = $home->gethomeDetailsbyowner($id);
 ?>


              <div class="all_house row">

      <?php
      if(count($ava_home) > 0) {
        foreach ($ava_home as $house){
        $houseid = $house['id'];
        $total_req = $home->totalRequest($houseid);
       ?>

                <div class="single_house card">
                  <div class="single_house_inner card-body">
                    <div class="house_title">
                      <p style="font-weight:600;">  <i class="fas fa-map-marker-alt"></i> <?php echo $house['address']; ?> </p>
                      <p class="rent"> <i class="fas fa-money-check-alt"></i> <?php echo $house['rental_value']; ?> </p>
                    </div>
                    <div class="house_img">
                      <img src="assets/images/house/house29.png" alt="House">
                    </div>
                    <?php if(is_array($total_req) && count($total_req) > 0){ ?>
                    <p style="display:inline-block;margin-top:10px;padding:4px 6px;color:#fff;border-radius:3px;background-color:cornflowerblue;"><span style="margin-left:5px;" class="badge badge-light"> <?php echo count($total_req); ?></span> request !</p>
                  <?php } ?>
                    <a href="housedetails.php?house_id=<?php echo $house['id']; ?>">Details</a>
                  </div>
                </div>


        <?php } }else{ echo "You havn't any availabe/free room."; } ?>


              </div>
            </div>
            <div class="booked_house">
              <h4>Booked House List</h4>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  include 'inc/footer.php';
?>
