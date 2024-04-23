<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="ASSIGNMENT";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $ASSIGNMENT_RECORD_REFID = $kali->dataCheck(['DATA'=>'ASSIGNMENT_RECORD_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ASSIGNMENT_REMARKS = $kali->dataCheck(['DATA'=>'ASSIGNMENT_REMARKS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ASSIGNMENT_MARKS = $kali->dataCheck(['DATA'=>'ASSIGNMENT_MARKS','CASE'=>'NUMBER','CHARACTER'=>'CAMEL']);

        $sql = 'SELECT `mark` FROM `assignment` WHERE `id`= ( SELECT `assignment_refid` FROM `assignment_record` WHERE `id`=:ASSIGNMENT_RECORD_REFID)';
        $data = $kali->kaliPull($sql,['ASSIGNMENT_RECORD_REFID'=>$ASSIGNMENT_RECORD_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Assignment','TARGET'=>['ASSIGNMENT_RECORD_REFID']]);
        }

        if($data['mark']<$ASSIGNMENT_MARKS){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Grade Greater Than Total Mark','TARGET'=>['ASSIGNMENT_MARKS']]);
        }

        $SQL = 'UPDATE `assignment_record` SET 
        `mark_obtained`=:mark_obtained,`remarks`=:remarks WHERE `id`=:ASSIGNMENT_RECORD_REFID';
        $PUSH_DATA = [
          'mark_obtained'=>$ASSIGNMENT_MARKS,
          'remarks'=>$ASSIGNMENT_REMARKS,
          'ASSIGNMENT_RECORD_REFID'=>$ASSIGNMENT_RECORD_REFID,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ASSIGNMENT GRADED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>