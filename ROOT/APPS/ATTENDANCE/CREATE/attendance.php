<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['ATTENDANCE'])){

            $USER_REFID = $kali->dataCheck(['DATA'=>'USER_REFID','CASE'=>'STRING']);
            $COURSE_REFID = $kali->dataCheck(['DATA'=>'COURSE_REFID','CASE'=>'STRING']);
            $STATUS = $kali->dataCheck(['DATA'=>'STATUS','CASE'=>'STRING']);

            $sql = 'SELECT user.id, user.college_refid, user.branch_refid FROM `user` user WHERE user.id=:USER_REFID';
            $udata = $kali->kaliPull($sql,['USER_REFID'=>$USER_REFID]);
            if(!$udata){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid User ','TARGET'=>['BRANCH']]);
            }

            $sql = 'SELECT course.id FROM `course` course WHERE course.id=:COURSE_REFID';
            $data = $kali->kaliPull($sql,['COURSE_REFID'=>$COURSE_REFID]);
            if(!$data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Course ','TARGET'=>['BRANCH']]);
            }


            $currentDate = date("Y-m-d");
            $sql = 'SELECT `id` 
            FROM `student_attendance` 
            WHERE `USER_REFID`=:USER_REFID AND `course_refid`=:course_refid AND `date`=:currentDate';
            $data = $kali->kaliPull($sql,['course_refid'=>$COURSE_REFID,'USER_REFID'=>$USER_REFID,'currentDate'=>$currentDate]);
            if($data){
                $SQL = 'UPDATE `student_attendance` SET `status`=:status WHERE `id`=:id '; 
                $PUSH_DATA = [
                  'id'=>$data['id'],
                  'status'=>$STATUS,
                ];
            
              $kali->kaliPush($SQL,$PUSH_DATA);
              $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ATTENDANCE DONE']);

            }else{

                $SQL3 = 'INSERT INTO `student_attendance`(`id`,`college_refid`=:college_refid,`branch_refid`=:branch_refid, `USER_REFID`, `course_refid`, `date`, `taken_by`, `status`) VALUES (:id, :USER_REFID, :course_refid, :currentDate, :taken_by, :status) ';
                $PUSH_DATA3 = [
                    'id'=>$kali->makeId(),
                    'college_refid'=>$udata['college_refid'],
                    'branch_refid'=>$udata['branch_refid'],
                    'USER_REFID'=>$USER_REFID,
                    'course_refid'=>$COURSE_REFID,
                    'taken_by'=>$_SESSION['KOHOMAH'],
                    'currentDate'=>$currentDate,
                    'status'=>$STATUS
                ];
                $kali->kaliPush($SQL3,$PUSH_DATA3);
    
                $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ATTENDANCE DONE']);

            }

            $kali->kaliReply([ "ERROR"=> true,'MSG'=>'SOMETHING WENT WRONG']);

        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>


