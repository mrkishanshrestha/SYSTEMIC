<?php

include_once 'SYSTEM/IMPORT/BACKEND/kali.php';
$kali->isLoggedIn('https://www.systemic.com/DASHBOARD');

if($_POST['SEARCH_DATA']!=''){


  $reply = $kali->verifyOTPCode($_POST['EMAIL'],'PASSWORD_RESET',$_POST['OTP']);
  $kali->kaliReply($reply);
/*
    $MY_ID="";
    $SQL = 'SELECT `id`,`first_name`  FROM `user` WHERE `email`=:email';
    $BIND = ['email'=>$_POST['EMAIL']];
    $result = $kali->kaliPull($SQL,$BIND);
    if(!$result){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Email Not Registered']);
        die;
    }

    $MY_ID = $result['id'];
    $MY_OTP = $_POST['OTP'];
    $MY_EMAIL = $_POST['EMAIL'];

    $SQL = 'SELECT `id`, `otp_code`, `otp_owner_id` FROM `otp` WHERE `otp_owner_id`=:otp_owner_id';
    $BIND = ['otp_owner_id'=>$MY_ID];
    $result2 = $kali->kaliPull($SQL,$BIND);
    if($result2){

        if($result2['otp_code']==$MY_OTP){

            $NEWPASSWORD = $kali->makeId();
            $NEW_HASHED_PASSWORD = $kali->hashPassword($NEWPASSWORD);

            $SQL3 = 'UPDATE `user_security` SET `password`=:password WHERE `user_refid`=:user_refid ';
            $PUSH_DATA3 = [
              'user_refid'=>$MY_ID,
              'password'=>$NEW_HASHED_PASSWORD,
            ];
            $kali->kaliPush($SQL3,$PUSH_DATA3);

            $SQL4 = 'DELETE FROM `otp` WHERE `id`=:id ';
            $PUSH_DATA4 = [
              'id'=>$result2['id'],
            ];
            $kali->kaliDel($SQL4,$PUSH_DATA4);

            $siteName = $kali->getSite();

            if(mail($MY_EMAIL,$siteName.' New Password','Hello, Your New Password is '.$NEWPASSWORD,"From:mr.kishanshrestha@gmail.com")){
            }else{
              $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
            }
            $kali->kaliReply(['ERROR'=>false,'MSG'=>'Your New Password Has Been Sent To Your Email']);

        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid OTP Try Again']);
            die('invalid otp');
        }
        
    }else{
        die;
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid OTP Try Again']);
    }




die('her');

*/


}

?>