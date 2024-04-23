<?php
    require_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';
?>
<html>
<head>
    <?php
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
   ?>

</head>
<body>

<?php

    if($_SESSION['MY_POST']=="STUDENT"){
        $SQL = 'SELECT `id`, `username`, `roll_no`, `first_name`, `middle_name`, `last_name`, `email`, `address`, `contact_number`, `gurdian_number`, `college_id`, `branch_id`, `faculty_id`, `faculty_period`, `profile_picture_id`, `document_id`, `description`, `access_to` FROM `student` WHERE `id`=:id';
    }elseif($_SESSION['MY_POST']=="CLIENT"){
        $SQL='SELECT `id`, `username`, `first_name`, `middle_name`, `last_name`, `contact_number`, `phone_number`, `address`, `email`, `document_id`, `profile_picture_id`, `college_limit`, `branch_limit`, `description`, `owns`, `edate` FROM `client` WHERE `id`=:id';
    }else{
        $SQL='SELECT `id`, `post`, `username`, `first_name`, `middle_name`, `last_name`, `contact_number`, `phone_number`, `address`, `email`, `document_id`, `profile_picture_id`, `description`, `edate`, `access_to` FROM `user` WHERE `id`=:id';
    }

    $result = $kali->kaliPull($SQL,['id'=>$_SESSION['KOHOMAH']]);
    if(!$result){
        die('some thing went wrong please tru again');
    }


?>



<section id="profileEdit-form">
    <form  id="profile-edit-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">UPDATE PROFILE</legend>

            <span class="error-log grid-fill danger-glow" id="profile-edit-form-error-log"></span>


            <div class="kali-inputbox">
                <span>First Name</span>
                <input type="text" name="DB_TUPLE_ID" id="DB_TUPLE_ID" style="display:none;" value="<?php echo $result['id'];?>" required>
                <input type="text" name="FIRST_NAME" id="FIRST_NAME" placeholder="Enter First Name" value="<?php echo $result['first_name'];?>" required>
            </div>

            <div class="kali-inputbox">
                <span>Middle Name</span>
                <input type="text" name="MIDDLE_NAME" id="MIDDLE_NAME" placeholder="Enter Middle Name" value="<?php echo $result['middle_name'];?>" >
            </div>
           
            <div class="kali-inputbox">
                <span>Last Name</span>
                <input type="text" name="LAST_NAME" id="LAST_NAME" placeholder="Enter Last Name" value="<?php echo $result['last_name'];?>" required>
            </div>
           
                        
            <div class="kali-inputbox">
                <span>Email</span>
                <input type="email" name="EMAIL" id="EMAIL" placeholder="Enter Email" value="<?php echo $result['email'];?>" required>
            </div>
            
            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number" name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Contact Number" value="<?php echo $result['contact_number'];?>"   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

            
            <?php if($_SESSION['MY_POST']=="STUDENT"){ ?>
            <div class="kali-inputbox">
                <span>Gurdian Number</span>
                <input type="number" name="GURDIAN_NUMBER" id="GURDIAN_NUMBER"  placeholder="Enter Phone Number"  value="<?php  echo $result['gurdian_number'];?>"  maxlength=10 required>
            </div>
            <?php }else{?>


            <div class="kali-inputbox">
                <span>Gurdian Number</span>
                <input type="number" name="PHONE_NUMBER" id="PHONE_NUMBER"  placeholder="Enter Phone Number"  value="<?php  echo $result['phone_number'];?>"  maxlength=10 required>
            </div>

            <?php }?>


            <div class="kali-inputbox">
                <span>Gurdian Number</span>
                <input type="number" name="GURDIAN_NUMBER" id="GURDIAN_NUMBER"  placeholder="Enter Phone Number"  value="<?php  if($_SESSION['MY_POST']=="STUDENT"){ echo $result['gurdian_number']; }else{ echo $result['phone_number']; };?>"  maxlength=10 required>
            </div>
           
            <div class="kali-inputbox">
                <span>Address</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="Enter Address"  value="<?php echo $result['address'];?>"  required>
            </div>
            
            <div class="kali-inputbox ">
                <span>Description</span>
                <input type="text"  style="width: 40vw;" name="DESCRIPTION" id="DESCRIPTION" placeholder="Enter Description" value="<?php echo $result['description'];?>"  required>
            </div>

            <div class="kali-inputbox">
                <span>Profile Image</span>
                <input type="file" name="USER_PROFILE_PICTURE" id="USER_PROFILE_PICTURE" >
            </div>

            <div class="kali-inputbox">
                <span>Documents (Image File)</span>
                <input type="file" name="USER_DOCUMENT" id="USER_DOCUMENT" >
            </div>

                        
            <div class="kali-inputbox ">
                <span>New Password</span>
                <input type="password"  style="width: 40vw;" name="NEW_PASSWORD" id="NEW_PASSWORD" placeholder="Enter New Password" >
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="LET'S GO" class="kali-btn">
            </div>  
        </fieldset>
    </form>

</section>

</body>
</html>
