<?php
    require_once 'SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->isLoggedIn('https://www.systemic.com/DASHBOARD',true);
    header("Access-Control-Allow-Origin: *");
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
        title: "Hello World",
        msg: "welcome To Systemic",
    });

});

</script>



<!-- home mainpage section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3><?php echo $kali->sysInfo('COMPANY_NAME');?></h3>
        <span >College Management System kishankishan
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
                </br>
                <span style="cursor:pointer;text-decoration:underline;" onclick="$('#reset-password-form').toggle();$('#user-login-form').toggle();">Forget Password ?</span>
            </div> 

        </fieldset>
    </form>

</section>



<section id="reset-password-form" style="display:none;">

    <form id="reset-form" method="post">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">RESET FORM</legend>

            <span class="error-log grid-fill danger-glow" id="reset-error-log"></span>
            
            <div class="kali-inputbox grid-fill">
                <span>Email</span>
                <input type="text"  name="RESET_EMAIL" id="RESET_EMAIL" placeholder="Email Assciated With Your Account" value="" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input class="btn" type="button" onclick="processReset();" value="Reset Now" class="kali-btn">
                </br>
                <span style="cursor:pointer;text-decoration:underline;" onclick="$('#reset-password-form').toggle();$('#user-login-form').toggle();">Login Now !</span>
             </div> 

        </fieldset>
    </form>

</section>


<section id="otpSection-form" style="display:none;">

    <form id="otp-form" method="post">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">OTP FORM</legend>

            <span class="error-log grid-fill danger-glow" id="reset-error-log"></span>
            
            <div class="kali-inputbox grid-fill">
                <span>Email:</span>
                <input type="text"  name="RESET_EMAIL" id="RESET_EMAIL" placeholder="Enter Your Email Linked To Account" value="" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>OTP CODE:</span>
                <input type="text"  name="OTP" id="OTP" placeholder="Enter Your OTP" value="" required>
            </div>


            <div class="kali-inputbox kali-inputbtn">
                <button id="forgetPassowrd" onclick="validateOTP();" class="kali-btn">VALIDATE</button>
            </div> 

        </fieldset>
    </form>

</section>




<?php $kali->getCode('ROOT/CORE/FOOTER/',true);?>

</body>
</html>