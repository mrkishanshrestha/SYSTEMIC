<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="EXAMINATION";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $EXAMINATION_REFID = $kali->dataCheck(['DATA'=>'EXAMINATION_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COURSE_REFID = $kali->dataCheck(['DATA'=>'COURSE_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EXAMINATION_FULL_MARKS = $kali->dataCheck(['DATA'=>'EXAMINATION_FULL_MARKS','CASE'=>'NUMBER','CHARACTER'=>'CAMEL']);
        $EXAMINATION_PASS_MARKS = $kali->dataCheck(['DATA'=>'EXAMINATION_PASS_MARKS','CASE'=>'NUMBER','CHARACTER'=>'CAMEL']);

        $sql = 'SELECT `id` FROM `examination` WHERE `id`=:EXAMINATION_REFID';
        $data = $kali->kaliPull($sql,['EXAMINATION_REFID'=>$EXAMINATION_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid EXAMINATION','TARGET'=>['EXAMINATION_FULL_MARKS']]);
        }

        $uq_id = $kali->makeId(); 

        $EXAMINATION_DOCUMENT_ID;
        $DOMAIN_CNAME = $kali->getSite();
        if(isset($_FILES['EXAMINATION_DOCUMENT'])){
          $EXAMINATION_DOCUMENT_ID = $kali->uploadFIle(['FILE'=>$_FILES['EXAMINATION_DOCUMENT'],'DIR'=>'ROOT/DATA/APP_DATA/EXAMINATION/'.$EXAMINATION_REFID,'FOLDER'=>$COURSE_REFID,'TYPE'=>'PDF']);
          if($EXAMINATION_DOCUMENT_ID['ERROR']){
            $EXAMINATION_DOCUMENT_ID['TARGET']=['EXAMINATION_DOCUMENT'];
            $kali->kaliReply($EXAMINATION_DOCUMENT_ID);
            die;
          }
        }

        $EXAMINATION_DOCUMENT = $EXAMINATION_DOCUMENT_ID['FILE_NAME'];

        $SQL = 'INSERT INTO `examination_details`
                (`id`, `examination_refid`, `course_refid`, `full_marks`, `pass_marks`)
        VALUES (:id, :examination_refid, :course_refid, :full_marks, :pass_marks)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'examination_refid'=>$EXAMINATION_REFID,
          'course_refid'=>$COURSE_REFID,
          'full_marks'=>$EXAMINATION_FULL_MARKS,
          'pass_marks'=>$EXAMINATION_PASS_MARKS,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'EXAMINATION UPLOADED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>