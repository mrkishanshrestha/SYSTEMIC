<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){
    
    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'STRING','NOTREQUIRED']);
    $USERNAME = $kali->dataCheck(['DATA'=>'USERNAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
    $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>TRUE]);
    $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
    $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
    $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'SECONDARY_NUMBER','CASE'=>'NUMBER']);
    $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $COLLEGE_LIMIT = $kali->dataCheck(['DATA'=>'COLLEGE_LIMIT','CASE'=>'NUMBER']);
    $BRANCH_LIMIT = $kali->dataCheck(['DATA'=>'BRANCH_LIMIT','CASE'=>'NUMBER']);
    $NEW_PROFILE_PICTURE="";

    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }
    
    $sql = 'SELECT  `username`,`profile_picture_id` FROM `user` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){
        $NEW_PROFILE_PICTURE=$data['profile_picture_id'];
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    //**data checking start */

    $sql = 'SELECT  `username` FROM `user` WHERE `phone_number`=:phone_number AND `id`!=:id';
    $data = $kali->kaliPull($sql,['phone_number'=>$PHONE_NUMBER,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Phone Numner Taken','TARGET'=>['PHONE_NUMBER']]);
    }

    $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:contact_number AND `id`!=:id';
    $data = $kali->kaliPull($sql,['contact_number'=>$CONTACT_NUMBER,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
    }
    
    $sql = 'SELECT  `username` FROM `user` WHERE `email`=:email AND `id`!=:id';
    $data = $kali->kaliPull($sql,['email'=>$EMAIL,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Email Already Taken','TARGET'=>['EMAIL']]);
    }

    //IF FILE IS SENT
    if(isset($_FILES['PROFILE_PICTURE'])){

        $sql = 'SELECT `id`,`username`,`profile_picture_id` FROM `user` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
        if($data){
            $dir = 'D:/CODE/DEPLOY/SYSTEMIC/ROOT/DATA/USER_DATA/CLIENT/'.$data['id'].'/'.$data['profile_picture_id'];
            if(file_exists($dir)){
                unlink($dir);
            }
    
            $PROFILE_PICTURE =  $kali->uploadFIle(['FILE'=>$_FILES['PROFILE_PICTURE'],'DIR'=>'SYSTEM','TYPE'=>'IMAGE','FOLDER'=>'CLIENT/'.$data['id']]);
            if($PROFILE_PICTURE['ERROR']){
              $PROFILE_PICTURE['TARGET']=['PROFILE_PICTURE'];
              $kali->kaliReply($PROFILE_PICTURE);
              die;
            }
    
            $NEW_PROFILE_PICTURE = $PROFILE_PICTURE['FILE_NAME'];
        }

    }

    $SQL = 'UPDATE `user` SET `first_name`=:first_name,`middle_name`=:middle_name,`last_name`=:last_name,`contact_number`=:contact_number,`phone_number`=:phone_number,`address`=:address,`email`=:email, `profile_picture_id`=:profile_picture_id WHERE `id`=:id';
    $BIND = ['first_name'=>$FIRST_NAME,'middle_name'=>$MIDDLE_NAME,'last_name'=>$LAST_NAME,'contact_number'=>$CONTACT_NUMBER,'phone_number'=>$PHONE_NUMBER,'address'=>$ADDRESS,'email'=>$EMAIL, 'profile_picture_id'=>$NEW_PROFILE_PICTURE, 'id'=>$MY_ID];
    $result = $kali->kaliUpdate($SQL,$BIND);

    $SQL2 = 'UPDATE `client_edata` SET `college_limit`=:college_limit,`branch_limit`=:branch_limit WHERE `user_refid`=:user_refid';
    $BIND2 = ['college_limit'=>$COLLEGE_LIMIT,'branch_limit'=>$BRANCH_LIMIT, 'user_refid'=>$MY_ID];
    $result2 = $kali->kaliUpdate($SQL2,$BIND2);

    if($result && $result2 ){
        $kali->kaliReply(['ERROR'=>false,'MSG'=>'Client Updated']);
        die;
    }

    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Client Cannot Be Updated '.$_POST['user_id']]);
    die;
}






