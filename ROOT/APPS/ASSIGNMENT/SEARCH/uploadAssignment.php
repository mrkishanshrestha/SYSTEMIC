<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="ASSIGNMENT";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $ASSIGNMENT_REFID = $kali->dataCheck(['DATA'=>'ASSIGNMENT_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ASSIGNMENT_DESCRIPTION = $kali->dataCheck(['DATA'=>'ASSIGNMENT_DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

        $sql = 'SELECT  `course_refid`, `due_date` FROM `assignment` WHERE `id`=:ASSIGNMENT_REFID';
        $data = $kali->kaliPull($sql,['ASSIGNMENT_REFID'=>$ASSIGNMENT_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Assignment','TARGET'=>['ASSIGNMENT_REFID']]);
        }

        $today = date("Y-m-d");
        $submitted_status = "";
        if($today > $data['due_date']){
          $submitted_status = "LATE";
        }else if($today < $data['due_date']){
          $submitted_status = "EARLY";
        }else{
          $submitted_status = "ON TIME";
        }

        $uq_id = $kali->makeId(); 

        $ASSIGNMENT_DOCUMENT_ID;
        $DOMAIN_CNAME = $kali->getSite();
        if(isset($_FILES['ASSIGNMENT_DOCUMENT'])){
          $ASSIGNMENT_DOCUMENT_ID = $kali->uploadFIle(['FILE'=>$_FILES['ASSIGNMENT_DOCUMENT'],'DIR'=>'ROOT/DATA/USER_DATA/'.$_SESSION['KOHOMAH'].'/ASSIGNMENT','FOLDER'=>$ASSIGNMENT_REFID,'TYPE'=>'PDF']);
          if($ASSIGNMENT_DOCUMENT_ID['ERROR']){
            $ASSIGNMENT_DOCUMENT_ID['TARGET']=['ASSIGNMENT_DOCUMENT'];
            $kali->kaliReply($ASSIGNMENT_DOCUMENT_ID);
            die;
          }
        }

        $ASSIGNMENT_DOCUMENT = $ASSIGNMENT_DOCUMENT_ID['FILE_NAME'];

        $SQL = 'INSERT INTO `assignment_record`(`id`, `user_refid`, `assignment_refid`, `course_refid`, `assignment_files_x`, `submited_date`, `submit_status`)
        VALUES (:id, :user_refid, :assignment_refid, :course_refid, :assignment_files_x, now(), :submit_status)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'user_refid'=>$_SESSION['KOHOMAH'],
          'assignment_refid'=>$ASSIGNMENT_REFID,
          'course_refid'=>$data['course_refid'],
          'assignment_files_x'=>$ASSIGNMENT_DOCUMENT,
          'submit_status'=>$submitted_status,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ASSIGNMENT UPLOADED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>