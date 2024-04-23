<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'VIEW');

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'STRING','NOTREQUIRED']);

    $COLLEGE_NAME = $kali->dataCheck(['DATA'=>'COLLEGE_NAME','CASE'=>'STRING','CHARACTER'=>'UPPER']);
    $BRANCH_NAME = $kali->dataCheck(['DATA'=>'BRANCH_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $GEO_LOCATION = $kali->dataCheck(['DATA'=>'GEO_LOCATION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

    $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
    $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
    $FACULTY_ARRAY = $kali->dataCheck(['DATA'=>'FACULTY_ARRAY','CASE'=>'STRING','CHARACTER'=>'UPPER']);
    $USER_ID = $_SESSION['KOHOMAH'];
    $college_refid="";

    //**data checking start */
    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $FACULTY_ARRAY = explode(',',$FACULTY_ARRAY);
    $FACULTY_ID_ARRAY=[];

    foreach($FACULTY_ARRAY as $FACULTY){
      
      $sql = 'SELECT `id` FROM `faculty` WHERE `short_name`=:short_name';
      $data = $kali->kaliPull($sql,['short_name'=>$FACULTY]);
      if($data){
        array_push($FACULTY_ID_ARRAY,$data['id']);
      }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FAculty','TARGET'=>['FACULTY_ARRAY']]);
      }

    }

    $FACULTY_NAME = implode(',',$FACULTY_ID_ARRAY);
      
    $sql = 'SELECT  `id` FROM `college` WHERE `short_name`=:short_name';
    $data = $kali->kaliPull($sql,['short_name'=>$COLLEGE_NAME]);
    if($data){
        $college_refid = $data['id'];
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $sql = 'SELECT  `id` FROM `branch` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){
        $MY_ID = $data['id'];
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $sql = 'SELECT  `name` FROM `branch` WHERE `name`=:name AND `id`!=:id';
    $data = $kali->kaliPull($sql,['name'=>$BRANCH_NAME,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Branch Name Taken','TARGET'=>['BRANCH_NAME']]);
    }

    $SQL = 'UPDATE `branch` SET `college_refid`=:college_refid,`name`=:name,`address`=:address,`geo_location`=:geo_location,`contact_number`=:contact_number,`phone_number`=:phone_number, `faculty_id_x`=:faculty_id_x WHERE `id`=:id '; 
    $PUSH_DATA = [
      'id'=>$MY_ID,
      'college_refid'=>$college_refid,
      'name'=>$BRANCH_NAME,
      'address'=>$ADDRESS,
      'geo_location'=>$GEO_LOCATION,
      'contact_number'=>$CONTACT_NUMBER,
      'phone_number'=>$PHONE_NUMBER,
      'faculty_id_x'=>$FACULTY_NAME,
    ];

  $kali->kaliPush($SQL,$PUSH_DATA);

  $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY UPDATED SUCESSFULLY']);

}






