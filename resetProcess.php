<?php

include_once 'SYSTEM/IMPORT/BACKEND/kali.php';
$kali->isLoggedIn($kali->domain.'/DASHBOARD');

if($_POST['SEARCH_DATA']!=''){

  $reply = $kali->sendOTPCode($_POST['SEARCH_DATA'],'EMAIL','PASSWORD_RESET');
  $kali->kaliReply($reply);
  /*
    $MY_ID="";
    $SQL = 'SELECT `id`, `first_name`  FROM `user` WHERE `email`=:email';
    $BIND = ['email'=>$_POST['SEARCH_DATA']];
    $result = $kali->kaliPull($SQL,$BIND);
    if(!$result){
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Email Not Registered']);
      die;
    }else{

      $MY_ID = $result['id'];
      $opt_code = $kali->makeId();
      $siteName = $kali->getSite();

              $SQL = 'SELECT `id`,`otp_code` FROM `otp` WHERE `otp_owner_id`=:otp_owner_id';
              $BIND = ['otp_owner_id'=>$MY_ID];
              $result22 = $kali->kaliPull($SQL,$BIND);
              if($result22){
                  if(mail($_POST['SEARCH_DATA'],$siteName.' Password Reset','Hello '.$result['first_name'].', Your Password REset OTP is '.$result22['otp_code'],"From:mr.kishanshrestha@gmail.com")){
                    $kali->kaliReply(['ERROR'=>false,'MSG'=>'New Password Has Been Sent To Your Email.']);
                  }else{
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
                  }
              }

              $SQL5 = 'INSERT INTO `otp`(`id`, `otp_code`, `otp_owner_id`) VALUES (:id, :otp_code, :otp_owner_id) ';
              $PUSH_DATA5 = [
                'id'=>$kali->makeId(),
                'otp_code'=>$opt_code,
                'otp_owner_id'=>$MY_ID
              ];
              $kali->kaliPush($SQL5,$PUSH_DATA5);

              if(mail($_POST['SEARCH_DATA'],$siteName.' Password Reset','Hello '.$result['first_name'].', Your Password REset OTP is '.$opt_code,"From:mr.kishanshrestha@gmail.com")){
              }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
              }

              $kali->kaliReply(['ERROR'=>false,'MSG'=>'New Password Has Been Sent To Your Email.']);

  }  */

}





?>


