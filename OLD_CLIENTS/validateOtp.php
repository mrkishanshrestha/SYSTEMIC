<?php

require_once '../SYSTEM/IMPORT/BACKEND/kali.php';



if($_POST['SEARCH_DATA']!=''){
    $MY_ID="";
    $SQL = 'SELECT `id`,`first_name`  FROM `student` WHERE `email`=:email';
    $BIND = ['email'=>$_POST['EMAIL']];
    $result = $kali->kaliPull($SQL,$BIND);
    if(!$result){

        $SQL = 'SELECT `id`,`first_name`  FROM `client` WHERE `email`=:email';
        $BIND = ['email'=>$_POST['EMAIL']];
        $result = $kali->kaliPull($SQL,$BIND);
        if(!$result){

                $SQL = 'SELECT `id`,`first_name` FROM `student` WHERE `email`=:email';
                $BIND = ['email'=>$_POST['EMAIL']];
                $result = $kali->kaliPull($SQL,$BIND);
                if(!$result){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Email Not A=Rsgistered']);
                    die;
                }

        }


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
            $SQL3 = 'UPDATE `user_security` SET `password`=:password WHERE `user_id`=:user_id ';
            $PUSH_DATA3 = [
              'user_id'=>$MY_ID,
              'password'=>$NEWPASSWORD,
            ];
            $kali->kaliPush($SQL3,$PUSH_DATA3);

            $SQL4 = 'DELETE FROM `otp` WHERE `id`=:id ';
            $PUSH_DATA4 = [
              'id'=>$result2['id'],
            ];
            $kali->kaliDel($SQL4,$PUSH_DATA4);

            $siteName = $kali->getSite();
            if(mail($MY_EMAIL,$siteName.' Ypur New Password is','Hello, Your New Password is '.$NEWPASSWORD,"From:mr.kishanshrestha@gmail.com")){
            }else{
              $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
            }

            $kali->kaliReply(['ERROR'=>false,'MSG'=>'Reset Password Complete And Sent To Your Email']);

        }else{
            die('invalid otp');
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid OTP Try Again']);
        }
        

    }else{
        die;
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid OTP Try Again']);
    }




die('her');




}

?>