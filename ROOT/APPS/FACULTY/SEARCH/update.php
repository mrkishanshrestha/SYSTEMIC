<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){
    
    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'NUMBER','NOTREQUIRED']);
    $FACULTY_NAME = $kali->dataCheck(['DATA'=>'FACULTY_NAME','CASE'=>'STRING']);;
    $FACULTY_SHORT_NAME = $kali->dataCheck(['DATA'=>'FACULTY_SHORT_NAME','CASE'=>'STRING']);
    $DESCRIPTION = $kali->dataCheck(['DATA'=>'DESCRIPTION','CASE'=>'STRING']);
    $BASED_ON = $kali->dataCheck(['DATA'=>'BASED_ON','CASE'=>'STRING']);
    $NO_OF_PERIODS = $kali->dataCheck(['DATA'=>'NO_OF_PERIODS','CASE'=>'NUMBER']);

    //**data checking start */
    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }
    
    $sql = 'SELECT  `id` FROM `faculty` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){
        $MY_ID = $data['id'];
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }


    if(!in_array($BASED_ON,['YEARLY','SEMESTER'])){
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Based On Action'.$BASED_ON,'TARGET'=>['BASED_ON']]);
    }

    $sql = 'SELECT  `name` FROM `faculty` WHERE `name`=:name AND `id`!=:id';
    $data = $kali->kaliPull($sql,['name'=>$FACULTY_NAME,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Faculty Name Taken','TARGET'=>['FACULTY_NAME']]);
    }

    $sql = 'SELECT  `name` FROM `faculty` WHERE `short_name`=:short_name AND `id`!=:id';
    $data = $kali->kaliPull($sql,['short_name'=>$FACULTY_SHORT_NAME,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Faculty Short Name Taken','TARGET'=>['FACULTY_SHORT_NAME']]);
    }

    $SQL = 'UPDATE `faculty` SET `name`=:name,`short_name`=:short_name,`based_on`=:based_on,`periods`=:periods,`description`=:description WHERE `id`=:id'; 
    $PUSH_DATA = [
      'id'=>$MY_ID,
      'name'=>$FACULTY_NAME,
      'short_name'=>$FACULTY_SHORT_NAME,
      'based_on'=>$BASED_ON,
      'periods'=>$NO_OF_PERIODS,
      'description'=>$DESCRIPTION,
    ];


  $kali->kaliPush($SQL,$PUSH_DATA);

  $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY UPDATED SUCESSFULLY']);

}






