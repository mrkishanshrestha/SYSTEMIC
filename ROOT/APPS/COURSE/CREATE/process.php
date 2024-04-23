<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$appTitle="COURSE";
$kali->whoHasAccess(['KING']);

try{

    if($_POST['JACKX']=='CHECKED'){

        $FACULTY = $kali->dataCheck(['DATA'=>'FACULTY','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COURSE_NAME = $kali->dataCheck(['DATA'=>'COURSE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COURSE_CODE = $kali->dataCheck(['DATA'=>'COURSE_CODE','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $CREDIT_HRS = $kali->dataCheck(['DATA'=>'CREDIT_HRS','CASE'=>'NUMBER']);
        $LECTURE_HRS = $kali->dataCheck(['DATA'=>'LECTURE_HRS','CASE'=>'NUMBER']);
        $TUTORIAL_HRS = $kali->dataCheck(['DATA'=>'TUTORIAL_HRS','CASE'=>'NUMBER']);
        $LAB_HRS = $kali->dataCheck(['DATA'=>'LAB_HRS','CASE'=>'NUMBER']);
        $FACULTY_PERIOD = $kali->dataCheck(['DATA'=>'FACULTY_PERIOD','CASE'=>'NUMBER']);

        $sql = 'SELECT  `id` FROM `faculty` WHERE `name`=:name';
        $FACULTY_ID = $kali->kaliPull($sql,['name'=>$FACULTY]);
        if(!$FACULTY_ID){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Faculty','TARGET'=>['FACULTY']]);
        }

        $sql = 'SELECT  `periods` FROM `faculty` WHERE `name`=:name';
        $FACULTY = $kali->kaliPull($sql,['name'=>$FACULTY]);
        if($FACULTY_PERIOD>$FACULTY['periods']){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Faculty Periods','TARGET'=>['FACULTY_PERIOD']]);
        }

        $sql = 'SELECT  `course_name` FROM `course` WHERE `course_name`=:course_name';
        $data = $kali->kaliPull($sql,['course_name'=>$COURSE_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Course Name Taken','TARGET'=>['COURSE_NAME']]);
        }

        $sql = 'SELECT  `course_code` FROM `course` WHERE `course_code`=:course_code ';
        $data = $kali->kaliPull($sql,['course_code'=>$COURSE_CODE]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Course Code Taken','TARGET'=>['COURSE_CODE']]);
        }
        
        $COURSE_DOCUMENT_ID;
        $DOMAIN_CNAME = $kali->getSite();
        if(isset($_FILES['COURSE_DOCUMENT'])){
          $COURSE_DOCUMENT_ID = $kali->uploadFIle(['FILE'=>$_FILES['COURSE_DOCUMENT'],'DIR'=>'ROOT/DATA/APP_DATA/COURSE','FOLDER'=>$COURSE_NAME,'TYPE'=>'PDF']);
          if($COURSE_DOCUMENT_ID['ERROR']){
            $COURSE_DOCUMENT_ID['TARGET']=['COURSE_DOCUMENT'];
            $kali->kaliReply($COURSE_DOCUMENT_ID);
            die;
          }
        }

        $COURSE_DOCUMENT = $COURSE_DOCUMENT_ID['FILE_NAME'];

       $uq_id = $kali->makeId(); 
        
        $SQL = 'INSERT INTO `course`(`id`, `course_name`, `course_code`, `credit_hrs`, `lecture_hrs`, `tutorial_hrs`, `lab_hrs`,`faculty_id`,`faculty_period`,`course_document`) VALUES (:id, :course_name, :course_code, :credit_hrs, :lecture_hrs, :tutorial_hrs, :lab_hrs, :faculty_id, :faculty_period, :course_document)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'course_name'=>$COURSE_NAME,
          'course_code'=>$COURSE_CODE,
          'credit_hrs'=>$CREDIT_HRS,
          'lecture_hrs'=>$LECTURE_HRS,
          'tutorial_hrs'=>$TUTORIAL_HRS,
          'lab_hrs'=>$LAB_HRS,
          'faculty_id'=>$FACULTY_ID['id'],
          'faculty_period'=>$FACULTY_PERIOD,
          'course_document'=>$COURSE_DOCUMENT
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'COURSE ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>