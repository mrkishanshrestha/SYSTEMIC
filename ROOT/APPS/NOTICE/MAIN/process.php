<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="NOTICE";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if(isset($_POST['COURSE_REFID'])){

        $TITLE = $kali->dataCheck(['DATA'=>'TITLE','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $MESSAGE = $kali->dataCheck(['DATA'=>'MESSAGE','CASE'=>'STRING']);
        $COURSE_REFID = $kali->dataCheck(['DATA'=>'COURSE_REFID','CASE'=>'STRING']);
  
        $sql = 'SELECT  `id` FROM `course` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$COURSE_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['COURSE_REFID']]);
        }
        
        $uq_id = $kali->makeId(); 

        $SQL = 'INSERT INTO `notice`(`id`, `course_refid`, `msg`, `title`, `datetime`)
         VALUES (:id, :course_refid , :msg, :title, now() )'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'course_refid'=>$COURSE_REFID,
          'msg'=>$MESSAGE,
          'title'=>$TITLE,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'STUDENT ADDED SUCESSFULLY']);

    }
    
    $kali->kaliReply([ "ERROR"=> true,'MSG'=>'ERROR']);

  }catch(Exception $e){
    die($e->getMessage());
  }

?>