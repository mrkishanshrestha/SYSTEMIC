<?php

include_once 'SYSTEM/IMPORT/BACKEND/kali.php';
$kali->isLoggedIn('https://www.systemic.com/DASHBOARD');


$kali->verifyOTPCode($_SESSION['KOHOMAH'],$_POST['OTP_CASE'],$_POST['2FA_OTP_CODE']);

?>