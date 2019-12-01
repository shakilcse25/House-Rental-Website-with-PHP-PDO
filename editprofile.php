<?php
  include 'inc/header.php';
  include 'inc/navbar.php';
 ?>

   <div class="edit_area" style="margin-top:80px;">
     <div class="edit_area_main container">
       <form enctype="multipart/form-data" class="edit_profile_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
         <div class="fam_bac_sub">
           <div class="image_input">
             <p>Update Your Profile Picture</p>
             <div class="inner_image_input">
               <div class="main_input">
                 <input type="file" class="form-control-file" name="image1" placeholder="Update Profile Image">
               </div>
             </div>
           </div>
           <div class="fam_bac_sub_inner">
             <div class="fname">
               <input type="text" class="form-control" name="fname" placeholder="First Name">
             </div>
             <div class="lname">
               <input type="text" class="form-control" name="lname" placeholder="Last Name">
             </div>
             <div class="address">
               <input type="text" class="form-control" name="address" placeholder="Your Address">
             </div>
             <div class="phone">
               <input type="text" class="form-control" name="phone" placeholder="Phone No">
             </div>
             <div class="nid">
               <input type="text" class="form-control" name="nid" placeholder="Your NID No">
             </div>
             
             <div class="description">
               <textarea class="form-control" rows="8" cols="80" placeholder="Description(Optional)" name="description"></textarea>
             </div>
             <p class="text-center" style="margin-top:10px;">
               <input type="submit" style="margin-bottom:0px;" class="btn btn-info" name="editprofile" value="Update Profile">
             </p>
           </div>
         </div>
       </form>
     </div>
   </div>


 <?php
  include 'inc/footer.php';
  ?>
