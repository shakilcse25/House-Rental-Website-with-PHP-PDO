<?php
  include_once 'Controller/Message.php';
 ?>
<nav class="navbar navbar-expand-sm bg-light navbar-light fixed_nav">
  <div class="main_nav container">
    <div class="left_nav  col-sm-5">
      <ul class="navbar-nav">
        <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="availablehouse.php">Availabe House</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#contact">Contact</a></li>
      </ul>
    </div>
    <?php
      $msg = new Message();
      $allmsg = $msg->getMessage(Session::get('user_id'));
      if (isset($_GET['logout']) && $_GET['logout']=='yes') {
        Session::sessionDestroy();
      }
     ?>
    <div class="right_nav col-sm-7 row">
      <div class="main_right_nav col-sm-9">
        <ul class="navbar-nav">
          <?php
            if(Session::get('login') == true && Session::get('user') == 'owner'){ ?>
              <li class="nav-item"><a class="nav-link" href="owner_profile.php?id=<?php echo Session::get('user_id'); ?>">Your Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="add_houserent.php">Add For Rent</a></li>
          <?php } ?>
        </ul>
      </div>



     <div class="dropdown_area col-sm-3 row">
     <?php
       if(Session::get('login')==true && (Session::get('user') == 'owner' || Session::get('user') == 'tenant')){
      ?>
        <div class="notification_dropdown col-sm-5">
          <div class="dropdown">
            <button type="button" class="btn btn-primary" data-toggle="dropdown">
              <i class="fas fa-bell"></i><sup><span style="margin-left:3px;" class="badge badge-light"><?php echo count($allmsg); ?></span></sup>
            </button>
            <div class="dropdown-menu">
              <?php
                if($msg){
                  foreach ($allmsg as $message) {
               ?>
              <div class="dropdown-item">
                <p><?php echo $message['message']; ?></p>
              </div>
            <?php } }else{ ?>
              <p class="dropdown-item">No new message!</p>
            <?php } ?>
            </div>
          </div>
        </div>


        <div class="user_dropdown col-sm-7">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><?php echo Session::get('fname')." ".Session::get('lname');?></i> </button>
          <div class="dropdown-menu">
              <a class="dropdown-item" href="?logout=yes">Logout</a>
          </div>
        </div>
      <?php } else{ ?>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="user_register.php">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="user_login.php">Login</a></li>
        </ul>
      <?php } ?>
     </div>



    </div>

  </div>
</nav>
