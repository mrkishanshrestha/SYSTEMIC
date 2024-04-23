<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="ASSIGNMENT";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $ASSIGNMENT_TITLE = $kali->dataCheck(['DATA'=>'ASSIGNMENT_TITLE','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ASSIGNMENT_TITLE = $kali->dataCheck(['DATA'=>'ASSIGNMENT_TITLE','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COURSE_REFID = $kali->dataCheck(['DATA'=>'COURSE_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ASSIGNMENT_MARK = $kali->dataCheck(['DATA'=>'ASSIGNMENT_MARK','CASE'=>'NUMBER']);
        $DUE_DATE = $_POST['DUE_DATE'];
        $ASSIGNMENT_DESCRIPTION = $kali->dataCheck(['DATA'=>'ASSIGNMENT_DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

        $sql = 'SELECT  `id` FROM `course` WHERE `id`=:course_refid';
        $data = $kali->kaliPull($sql,['course_refid'=>$COURSE_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Course','TARGET'=>['FACULTY']]);
        }

        $uq_id = $kali->makeId(); 

        $ASSIGNMENT_DOCUMENT_ID;
        $DOMAIN_CNAME = $kali->getSite();
        if(isset($_FILES['ASSIGNMENT_DOCUMENT'])){
          $ASSIGNMENT_DOCUMENT_ID = $kali->uploadFIle(['FILE'=>$_FILES['ASSIGNMENT_DOCUMENT'],'DIR'=>'ROOT/DATA/APP_DATA/ASSIGNMENT/'.$COURSE_REFID,'FOLDER'=>$uq_id,'TYPE'=>'PDF']);
          if($ASSIGNMENT_DOCUMENT_ID['ERROR']){
            $ASSIGNMENT_DOCUMENT_ID['TARGET']=['ASSIGNMENT_DOCUMENT'];
            $kali->kaliReply($ASSIGNMENT_DOCUMENT_ID);
            die;
          }
        }

        $ASSIGNMENT_DOCUMENT = $ASSIGNMENT_DOCUMENT_ID['FILE_NAME'];

        $SQL = 'INSERT INTO `assignment`(`id`, `user_refid`, `course_refid`, `title`, `assignment_files_x`, `due_date`, `mark`, `description`,`assigned_date`)
         VALUES (:id, :user_refid, :course_refid, :title, :assignment_files_x, :due_date, :mark, :description, now() )'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'user_refid'=>$_SESSION['KOHOMAH'],
          'course_refid'=>$COURSE_REFID,
          'title'=>$ASSIGNMENT_TITLE,
          'assignment_files_x'=>$ASSIGNMENT_DOCUMENT,
          'due_date'=>$DUE_DATE,
          'mark'=>$ASSIGNMENT_MARK,
          'description'=>$ASSIGNMENT_DESCRIPTION,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ASSIGNMENT ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>