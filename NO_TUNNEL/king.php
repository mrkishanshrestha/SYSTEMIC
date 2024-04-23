<?php
    require_once '../SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->isLoggedIn('http://client.systemic.com/DASHBOARD');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $kali->sysInfo('COMPANY_NAME');?></title>
    
    <?php
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('JQUERY');
        $kali->link('ASSETS');
    ?>

</head>
<body>
<script>
    
document.addEventListener("DOMContentLoaded", function(event) { 

    juju.alerty({
        position:"bottom_right",
        status: "success",
        title: "Page Status",
        msg: "welcome To Systemic",
    });

});

</script>



<!-- home mainpage section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3><?php echo $kali->sysInfo('COMPANY_NAME');?></h3>
        <span >College Management System (CLIENT)
        </span>
        <a href="#login-form" class="btn kali-glow">Login Now</a>
    </div>

</section>

<!-- home mainpage section ends -->

<!-- LOGIN starts  -->

<section id="user-login-form">

    <form id="login-form" method="post">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">LOGIN FORM</legend>

            <span class="error-log grid-fill danger-glow" id="login-error-log"></span>
            
            <div class="kali-inputbox">
                <span>Username / Email</span>
                <input type="text"  name="USERNAME" id="USERNAME" placeholder="Enter Your Username Or Email" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Password</span>
                <input type="password" name="PASSWORD" id="PASSWORD" placeholder="Enter Your Username Or Email" value="" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" id="SUBMIT" value="LET'S GO" class="kali-btn">
            </div> 

           <div class="kali-inputbox kali-inputbtn">
                <button id="SIGN_UP" onclick="javascript:openSignup(this);" class="kali-btn">SIGN UP</button>
            </div>  

        </fieldset>
    </form>

</section>

<!-- LOGIN ends -->

<section style="display:none;" id="user-signup-form">

    <form id="login-form" method="post">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">SIGNUP FORM</legend>

            <span class="error-log grid-fill danger-glow" id="signup-error-log"></span>
            
            <div class="kali-inputbox">
                <span>Username</span>
                <input type="text"  name="USERNAME" id="USERNAME" placeholder="Enter Your Username" value="" required>
            </div>
           
            <div class="kali-inputbox">
                <span>Full Name</span>
                <input type="text" name="FULL_NAME" id="FULL_NAME" placeholder="Enter Fullname" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Email</span>
                <input type="text"  name="EMAIL" id="EMAIL" placeholder="Enter Your Email" value="" required>
            </div>
                
            <div class="kali-inputbox">
                <span>Address</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="Enter Address" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number"  name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Your Contact Number" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Password</span>
                <input type="password" name="PASSWORD" id="PASSWORD" placeholder="Enter Your Password" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Re-Password</span>
                <input type="password" name="RE_PASSWORD" id="RE_PASSWORD" placeholder="Enter Your Repassword" value="" required>
            </div>
                                    
            <div class="kali-inputbox">
                <span>User Profile Image</span>
                <input type="file" name="USER_PROFILE_PICTURE" id="USER_PROFILE_PICTURE" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" id="SUBMIT" value="SIGN UP" class="kali-btn">
            </div> 

           <div class="kali-inputbox kali-inputbtn">
                <button id="SIGN_UP" onclick="javascript:openLogin(this);" class="kali-btn">Login Now</button>
            </div>  

        </fieldset>
    </form>

</section>



<!-- home mainpage section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3>About Us</h3>
        <span >Hear It Now</span>
        <a class="btn kali-glow" onclick="playAboutUs();">Play Now</a><br>
        <a class="btn kali-glow" >Stop</a>
    </div>

</section>

<!-- home mainpage section ends -->


<?php $kali->getCode('ROOT/CORE/FOOTER/',true);?>

</body>
</html>