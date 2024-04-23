<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    if($_SESSION['MY_AUTHORITY']!='KING'){
        die('trying to hack');
    }
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

<section id="userCreate-form">

    <form  id="user-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE CLIENTS</legend>

            <span class="error-log grid-fill danger-glow" id="user-create-error-log"></span>
  
            <div class="kali-inputbox grid-fill">
                <span>User Name</span>
                <input type="text" name="USERNAME" id="USERNAME" placeholder="Enter Username" value="" required>
            </div>
                    
            <div class="kali-inputbox">
                <span>First Name</span>
                <input type="text" name="FNAME" id="FNAME" placeholder="Enter First Name" value="" required>
            </div>
                    
            <div class="kali-inputbox">
                <span>Middle Name</span>
                <input type="text" name="MNAME" id="MNAME" placeholder="Enter Middle Name" value="" >
            </div>
                    
            <div class="kali-inputbox">
                <span>Last Name</span>
                <input type="text" name="LNAME" id="LNAME" placeholder="Enter Last Name" value="" required>
            </div>
                        
            <div class="kali-inputbox">
                <span>Email</span>
                <input type="email" name="EMAIL" id="EMAIL" placeholder="Enter Email" value="" required>
            </div>
            
            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number" name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Contact Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

            <div class="kali-inputbox">
                <span>Secondary Phone Number</span>
                <input type="number" name="PHONE_NUMBER" id="PHONE_NUMBER"  placeholder="Enter Phone Number" value=""   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 maxlength=10 required>
            </div>
        
            <div class="kali-inputbox">
                <span>Colleges Limit</span>
                <input type="number" name="COLLEGE_LIMIT" id="COLLEGE_LIMIT" placeholder="Enter College Limit" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>
            
              
            <div class="kali-inputbox">
                <span>Branches Limit</span>
                <input type="number" name="BRANCH_LIMIT" id="BRANCH_LIMIT" placeholder="Enter Branch Limit" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>
            
            
            <div class="kali-inputbox">
                <span>Address</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="Enter Address" value="" required>
            </div>

      
            <div class="kali-inputbox">
                <span>Client Profile Image</span>
                <input type="file" name="CLIENT_PROFILE_PICTURE" id="CLIENT_PROFILE_PICTURE" required>
            </div>
      
            <div class="kali-inputbox">
                <span>Client Document</span>
                <input type="file" name="CLIENT_DOCUMENT" id="CLIENT_DOCUMENT" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="LET'S GO" class="kali-btn">
            </div>  
        </fieldset>
    </form>

</section>

</body>
</html>
