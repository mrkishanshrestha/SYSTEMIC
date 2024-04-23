<?php
     require_once 'SYSTEM/IMPORT/BACKEND/kali.php';
     header("Access-Control-Allow-Origin: *");

     if(!isset($_SESSION['KOHOMAH'])){die('Kailya Tera Kya Hoga !!!');}

     else if(isset($_SESSION['KOHOMAH']) && isset($_SESSION['LOGGED_IN'])){
        if($_SESSION['LOGGED_IN']=='XA'){
            $kali->isLoggedIn('https://www.systemic.com/DASHBOARD',true);
        }
    }else{
        $kali->sendOTPCode($_SESSION['KOHOMAH'],$_SESSION['2FA'],'LOGIN');
    }
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
        $kali->link('ASSETS/js/script2.js','JS');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('JQUERY');
        $kali->link('ASSETS');
    ?>

</head>

<body>


<!-- LOGIN starts  -->

<section id="2FA-verification">

    <form id="TWOFA-verification-form" method="post">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">2FA Verification Via <?php echo $_SESSION['2FA']; ?>
        </legend>

            <span class="error-log grid-fill danger-glow" id="2FA-verification-error-log"></span>

            <div class="kali-inputbox" style="display:none;">
                <span></span>
                <input type="password" name="METHOD" id="METHOD" value="<?php echo $_SESSION['2FA']; ?>" required>
                <input type="password" name="OTP_CASE" id="METHOD" value="LOGIN" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>OTP ( One-Time Password )</span>
                <input type="password" name="2FA_OTP_CODE" id="2FA_OTP_CODE" placeholder="Enter Your OTP Code" value="" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" id="SUBMIT" value="Verify Code" class="kali-btn">
            </div> 

        </fieldset>
    </form>

</section>


</body>
</html>