<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $FACULTY_NAME = $kali->dataCheck(['DATA'=>'FACULTY_NAME','CASE'=>'STRING']);;
        $FACULTY_SHORT_NAME = $kali->dataCheck(['DATA'=>'FACULTY_SHORT_NAME','CASE'=>'STRING']);
        $DESCRIPTION = $kali->dataCheck(['DATA'=>'DESCRIPTION','CASE'=>'STRING']);
        $BASED_ON = $kali->dataCheck(['DATA'=>'BASED_ON','CASE'=>'STRING']);
        $NO_OF_PERIODS = $kali->dataCheck(['DATA'=>'NO_OF_PERIODS','CASE'=>'NUMBER']);

        //**data checking start */
        
        if(!in_array($BASED_ON,['YEARLY','SEMESTER'])){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Based On Action'.$BASED_ON,'TARGET'=>['BASED_ON']]);
        }

        $sql = 'SELECT  `name` FROM `faculty` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>$FACULTY_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Faculty Name Taken','TARGET'=>['FACULTY_NAME']]);
        }

        $sql = 'SELECT  `name` FROM `faculty` WHERE `short_name`=:short_name ';
        $data = $kali->kaliPull($sql,['short_name'=>$FACULTY_SHORT_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Faculty Short Name Taken','TARGET'=>['FACULTY_SHORT_NAME']]);
        }

       $uq_id = $kali->makeId(); 
        
        $SQL = 'INSERT INTO `faculty`(`id`, `name`, `short_name`, `based_on`,`periods`, `description`) VALUES (:id, :name, :short_name, :based_on, :periods,:description)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'name'=>$FACULTY_NAME,
          'short_name'=>$FACULTY_SHORT_NAME,
          'based_on'=>$BASED_ON,
          'periods'=>$NO_OF_PERIODS,
          'description'=>$DESCRIPTION,
        ];


      $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>