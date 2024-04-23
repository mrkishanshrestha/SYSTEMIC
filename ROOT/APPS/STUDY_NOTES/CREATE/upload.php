<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $FACULTY = $kali->dataCheck(['DATA'=>'FACULTY','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $FACULTY_PERIOD = $kali->dataCheck(['DATA'=>'FACULTY_PERIOD','CASE'=>'NUMBER']);
        $COURSE_CODE = $kali->dataCheck(['DATA'=>'COURSE','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        
        $FACULTY_ID="";
        $sql = 'SELECT  `id` FROM `faculty` WHERE `short_name`=:short_name';
        $result = $kali->kaliPull($sql,['short_name'=>$FACULTY]);
        if($result){
            $FACULTY_ID = $result['id'];
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Faculty','TARGET'=>['FACULTY']]);
        }

        $COURSE_ID="";
        $sql = 'SELECT  `id` FROM `course` WHERE `course_code`=:course_code ';
        $data = $kali->kaliPull($sql,['course_code'=>$COURSE_CODE]);
        if($data){
            $COURSE_ID=$data['id'];
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Course','TARGET'=>['COURSE']]);
        }
        
        $DOCUMENT_ID;
        $DOMAIN_CNAME = $kali->getSite();
        if(isset($_FILES['DOCUMENT'])){
          $DOCUMENT_ID = $kali->uploadFIle(['FILE'=>$_FILES['DOCUMENT'],'DIR'=>'CLIENTS/COLLEGES/APP_DATA/STUDY_NOTES','FOLDER'=>$COURSE_CODE,'TYPE'=>'PDF']);
          if($DOCUMENT_ID['ERROR']){
            $DOCUMENT_ID['TARGET']=['DOCUMENT'];
            $kali->kaliReply($DOCUMENT_ID);
            die;
          }
        }

        $DOCUMENT = $DOCUMENT_ID['FILE_NAME'];

       $uq_id = $kali->makeId(); 
        
        $SQL = 'INSERT INTO `study_notes`(`id`, `course_id`,`faculty_id`,`faculty_period`,`document`) VALUES (:id, :course_id, :faculty_id, :faculty_period, :document)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'course_id'=>$COURSE_ID,
          'faculty_id'=>$FACULTY_ID,
          'faculty_period'=>$FACULTY_PERIOD,
          'document'=>$DOCUMENT
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'STUDY NOTES ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>