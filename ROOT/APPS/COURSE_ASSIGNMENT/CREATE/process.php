<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{


    if($_POST['JACKX']=='CHECKED'){

        $FACULTY_REFID = $kali->dataCheck(['DATA'=>'FACULTY_ID','CASE'=>'STRING']);
        $FACULTY_PERIOD = $kali->dataCheck(['DATA'=>'FACULTY_PERIOD','CASE'=>'STRING']);
        $COURSE_REFID = $kali->dataCheck(['DATA'=>'COURSE_ID','CASE'=>'STRING']);
        $TEACHER_REFID = $kali->dataCheck(['DATA'=>'TEACHER','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $uq_id = $kali->makeId(); 
        $COLLEGE_REFID="";

        $sql = 'SELECT  `id` FROM `college` WHERE `id`=( SELECT `college_refid` FROM `user` WHERE `id`=:user_refid)';
        $data = $kali->kaliPull($sql,['user_refid'=>$_SESSION['KOHOMAH']]);
        if($data){
          $COLLEGE_REFID = $data['id'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong Domain Name','TARGET'=>['FACULTY_ID']]);
        }
              
       
        $sql = 'SELECT  `id`,`branch_refid` FROM `user` WHERE `id`=:teacher_refid AND `college_refid`=:college_refid AND `authority_refid`= ( SELECT `id` FROM `authority` WHERE `name`=:authority )';
        $data = $kali->kaliPull($sql,['teacher_refid'=>$TEACHER_REFID,'college_refid'=>$COLLEGE_REFID,'authority'=>'TEACHER']);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Teacher','TARGET'=>['FACULTY_ID']]);
        }
        $BRANCH_REFID = $data['branch_refid'];

        $sql = 'SELECT  `id` FROM `course` WHERE `id`=:course_refid AND faculty_period=:faculty_period';
        $data = $kali->kaliPull($sql,['course_refid'=>$COURSE_REFID,'faculty_period'=>$FACULTY_PERIOD]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Course','TARGET'=>['FACULTY_ID']]);
        }
        $COURSE_REFID = $data['id'];

        $sql = 'SELECT  `id` FROM `faculty` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$FACULTY_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Faculty','TARGET'=>['FACULTY_ID']]);
        }

        $sql = 'SELECT  `id` FROM `course_assigned` WHERE `COLLEGE_REFID`=:COLLEGE_REFID AND `BRANCH_REFID`=:BRANCH_REFID AND `faculty_refid`=:faculty_refid AND `course_refid`=:course_refid';
        $data = $kali->kaliPull($sql,['COLLEGE_REFID'=>$COLLEGE_REFID ,'BRANCH_REFID'=>$BRANCH_REFID ,'faculty_refid'=>$FACULTY_REFID,'course_refid'=>$COURSE_REFID]);
        if($data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Course Has Already Been Assigned','TARGET'=>['FACULTY_ID']]);
        }

        $SQL = 'INSERT INTO `course_assigned`(`id`, `college_refid`,`branch_refid`, `faculty_refid`,`course_refid`, `user_refid`) VALUES (:id, :college_refid, :branch_refid, :faculty_refid, :course_refid, :user_refid)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'college_refid'=>$COLLEGE_REFID,
          'faculty_refid'=>$FACULTY_REFID,
          'course_refid'=>$COURSE_REFID,
          'branch_refid'=>$BRANCH_REFID,
          'user_refid'=>$TEACHER_REFID,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'COURSE ASSIGNED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>