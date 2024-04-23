<?php

require_once '../SYSTEM/IMPORT/BACKEND/kali.php';



if($_POST['SEARCH_DATA']!=''){
    $MY_ID="";
    $SQL = 'SELECT `id`,`first_name`  FROM `student` WHERE `email`=:email';
    $BIND = ['email'=>$_POST['SEARCH_DATA']];
    $result = $kali->kaliPull($SQL,$BIND);
    if(!$result){

        $SQL = 'SELECT `id`,`first_name`  FROM `client` WHERE `email`=:email';
        $BIND = ['email'=>$_POST['SEARCH_DATA']];
        $result = $kali->kaliPull($SQL,$BIND);
        if(!$result){

                $SQL = 'SELECT `id`,`first_name` FROM `student` WHERE `email`=:email';
                $BIND = ['email'=>$_POST['SEARCH_DATA']];
                $result = $kali->kaliPull($SQL,$BIND);
                if(!$result){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Email Not A=Rsgistered']);
                    die;
                }

        }

    }

    $MY_ID = $result['id'];
    $opt_code = $kali->makeId();


            $SQL = 'SELECT `id` FROM `otp` WHERE `otp_owner_id`=:otp_owner_id';
            $BIND = ['otp_owner_id'=>$MY_ID];
            $result22 = $kali->kaliPull($SQL,$BIND);
            if($result22){
                $kali->kaliReply(['ERROR'=>false,'MSG'=>'Reset Password Sent']);
            }


    $SQL5 = 'INSERT INTO `otp`(`id`, `otp_code`, `otp_owner_id`) VALUES (:id, :otp_code, :otp_owner_id) ';
    $PUSH_DATA5 = [
      'id'=>$kali->makeId(),
      'otp_code'=>$opt_code,
      'otp_owner_id'=>$MY_ID
    ];
    $kali->kaliPush($SQL5,$PUSH_DATA5);

    $siteName = $kali->getSite();
    if(mail($_POST['SEARCH_DATA'],$siteName.' Password Reset','Hello '.$result['first_name'].', Your Password REset OTP is '.$opt_code,"From:mr.kishanshrestha@gmail.com")){
    }else{
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
    }


    $kali->kaliReply(['ERROR'=>false,'MSG'=>'Reset Password Sent']);


}     





?>


