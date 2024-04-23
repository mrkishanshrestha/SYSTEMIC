<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="STUDENT";
$kali->checkAccess($APPLICATION,'VIEW');

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'STRING']);
    $USERNAME = $kali->dataCheck(['DATA'=>'USERNAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
    $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
    $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
    $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
    $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
    $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
   

    $NEW_USER_PROFILE_PICTURE="";
    $NEW_USER_DOCUMENT="";
    //**data checking start */
    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

        
    $sql = 'SELECT  `username`,`id`,`profile_picture_id`,`document_id` FROM `user` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){
        $MY_ID = $data['id'];
        $NEW_USER_PROFILE_PICTURE=$data['profile_picture_id'];
        $NEW_USER_DOCUMENT=$data['document_id'];
        $USERNAME=$data['username'];
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $sql = 'SELECT  `first_name` FROM `user` WHERE (`phone_number`=:phone_number OR `contact_number`=:phone_number ) AND `id`!=:id';
    $data = $kali->kaliPull($sql,['phone_number'=>$CONTACT_NUMBER,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
    }

    $sql = 'SELECT  `first_name` FROM `user` WHERE (`contact_number`=:contact_number OR `phone_number`=:contact_number) AND `id`!=:id';
    $data = $kali->kaliPull($sql,['contact_number'=>$PHONE_NUMBER,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Phone Number Taken','TARGET'=>['PHONE_NUMBER']]);
    }

    
    //IF FILE IS SENT
    if(isset($_FILES['USER_PROFILE_PICTURE'])){

        $sql = 'SELECT `profile_picture_id` FROM `user` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
        if($data){
            $dir = 'D:/CODE/DEPLOY/SYSTEMIC/ROOT/DATA/USER_DATA/'.$USERNAME.'/'.$data['profile_picture_id'];
            if(file_exists($dir)){
                unlink($dir);
            }
    
            $NEW_USER_PROFILE_PICTURE =  $kali->uploadFIle(['FILE'=>$_FILES['USER_PROFILE_PICTURE'],'DIR'=>'SYSTEM','FOLDER'=>$USERNAME,'TYPE'=>'IMAGE']);
            if($NEW_USER_PROFILE_PICTURE['ERROR']){
              $NEW_USER_PROFILE_PICTURE['TARGET']=['USER_PROFILE_PICTURE'];
              $kali->kaliReply($NEW_USER_PROFILE_PICTURE);
              die;
            }
    
            $NEW_USER_PROFILE_PICTURE = $NEW_USER_PROFILE_PICTURE['FILE_NAME'];
        }

    }

        
    //IF FILE IS SENT
    if(isset($_FILES['USER_DOCUMENT'])){

        $sql = 'SELECT `document_id` FROM `user` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
        if($data){

            $dir = 'D:/CODE/DEPLOY/SYSTEMIC/ROOT/DATA/USER_DATA/'.$USERNAME.'/'.$data['document_id'];
            if(file_exists($dir)){
                unlink($dir);
            }
    
            $NEW_USER_DOCUMENT =  $kali->uploadFIle(['FILE'=>$_FILES['USER_DOCUMENT'],'DIR'=>'SYSTEM','TYPE'=>'IMAGE','FOLDER'=>$USERNAME]);
            if($NEW_USER_DOCUMENT['ERROR']){
              $NEW_USER_DOCUMENT['TARGET']=['USER_DOCUMENT'];
              $kali->kaliReply($NEW_USER_DOCUMENT);
              die;
            }
    
            $NEW_USER_DOCUMENT = $NEW_USER_DOCUMENT['FILE_NAME'];
        }

    }

   

    $SQL = ' UPDATE `user` SET `id`=:id,`post`=:post,`first_name`=:first_name,`middle_name`=:middle_name,`last_name`=:last_name,`contact_number`=:contact_number,`phone_number`=:phone_number,`address`=:address,`email`=:email,`document_id`=:document_id,`profile_picture_id`=:profile_picture_id WHERE `id`=:id'; 
    $PUSH_DATA = [

    'id'=>$MY_ID,
    'post'=>$USER_POST,

      'first_name'=>$FIRST_NAME,
      'middle_name'=>$MIDDLE_NAME,
      'last_name'=>$LAST_NAME,
      'contact_number'=>$CONTACT_NUMBER,
      'phone_number'=>$PHONE_NUMBER,
      'address'=>$ADDRESS,
      'email'=>$EMAIL,

      'profile_picture_id'=>$NEW_USER_PROFILE_PICTURE,
      'document_id'=>$NEW_USER_DOCUMENT,
    ];


  $kali->kaliPush($SQL,$PUSH_DATA);

  $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY UPDATED SUCESSFULLY']);

}






