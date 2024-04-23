<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'STRING']);
    $COLLEGE = $kali->getSite();
    $NEW_COLLEGE_ID = 0;
    $NEW_FACULTY_ID = 0;
    $FACULTY = $kali->dataCheck(['DATA'=>'FACULTY','CASE'=>'STRING','CHARACTER'=>'UPPER']);
    $AMOUNT = $kali->dataCheck(['DATA'=>'AMOUNT','CASE'=>'NUMBER']);
    $ADMISSION_FEE = $kali->dataCheck(['DATA'=>'ADMISSION_FEE','CASE'=>'NUMBER']);

    //**data checking start */
    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $sql = 'SELECT  `id` FROM `college` WHERE `domain_cname`=:domain_cname';
    $data = $kali->kaliPull($sql,['domain_cname'=>$COLLEGE]);
    if($data){
      $NEW_COLLEGE_ID = $data['id'];
    }else{
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['FACULTY']]);
    }
       
    $sql = 'SELECT  `id` FROM `faculty` WHERE `short_name`=:short_name';
    $data = $kali->kaliPull($sql,['short_name'=>$FACULTY]);
    if($data){
      $NEW_FACULTY_ID = $data['id'];
    }else{
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['FACULTY']]);
    }

    $sql = 'SELECT  `id` FROM `faculty_finance` WHERE `college_id`=:college_id AND `faculty_id`=:faculty_id AND `id`!=:id';
    $data = $kali->kaliPull($sql,['college_id'=>$NEW_COLLEGE_ID ,'faculty_id'=>$NEW_FACULTY_ID,'id'=>$MY_ID]);
    if($data){
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Already Exists','TARGET'=>['FACULTY']]);
    }


    $SQL = ' UPDATE `faculty_finance` SET `faculty_id`=:faculty_id,`amount`=:amount,`admission_fee`=:admission_fee WHERE `id`=:id'; 
    $PUSH_DATA = [

    'id'=>$MY_ID,
    'faculty_id'=>$NEW_FACULTY_ID,
    'amount'=>$AMOUNT,
    'admission_fee'=>$ADMISSION_FEE,
    ];


  $kali->kaliPush($SQL,$PUSH_DATA);

  $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY FINANCE UPDATED SUCESSFULLY']);

}






