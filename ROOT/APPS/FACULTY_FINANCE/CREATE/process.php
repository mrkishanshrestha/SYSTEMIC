<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{


    if($_POST['JACKX']=='CHECKED'){

        $COLLEGE_REFID = $kali->dataCheck(['DATA'=>'COLLEGE_REFID','CASE'=>'STRING']);
        $FACULTY_REFID = $kali->dataCheck(['DATA'=>'FACULTY_REFID','CASE'=>'NUMBER']);
        $AMOUNT = $kali->dataCheck(['DATA'=>'AMOUNT','CASE'=>'NUMBER']);
        $ADMISSION_FEE = $kali->dataCheck(['DATA'=>'ADMISSION_FEE','CASE'=>'NUMBER']);

        $sql = 'SELECT  `id` FROM `college` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$COLLEGE_REFID]);
        if($data){
          $COLLEGE_REFID = $data['id'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['COLLEGE_REFID']]);
        }

        $sql = 'SELECT  `id` FROM `faculty` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$FACULTY_REFID]);
        if($data){
          $FACULTY_REFID = $data['id'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['FACULTY_REFID']]);
        }

        $sql = 'SELECT  `id` FROM `faculty_finance` WHERE `college_refid`=:college_refid AND `faculty_refid`=:faculty_refid';
        $data = $kali->kaliPull($sql,['college_refid'=>$COLLEGE_REFID ,'faculty_refid'=>$FACULTY_REFID]);
        if($data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Already Exists','TARGET'=>['FACULTY_REFID']]);
        }

        $uq_id = $kali->makeId(); 
        $SQL = 'INSERT INTO `faculty_finance`(`id`, `faculty_refid`, `college_refid`, `amount`, `admission_fee`) VALUES (:id, :faculty_refid, :college_refid, :amount, :admission_fee)'; 
        $PUSH_DATA = [
         
          'id'=>$uq_id,
          'faculty_refid'=>$FACULTY_REFID,
          'college_refid'=>$COLLEGE_REFID,
          'amount'=>$AMOUNT,
          'admission_fee'=>$ADMISSION_FEE,

        ];

      $kali->kaliPush($SQL,$PUSH_DATA);
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY FINANCE ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>