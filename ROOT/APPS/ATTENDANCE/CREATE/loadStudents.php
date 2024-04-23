<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

date_default_timezone_set('Asia/Kathmandu');

$currentDate = date("Y-m-d");
    try{

        if(isset($_POST['SEARCH'])){

            $sql = 'SELECT course.course_name, course.faculty_period, course.faculty_id
            FROM course course
            WHERE course.id = :course_refid';
            $data = $kali->kaliPull($sql,['course_refid'=>$_POST['COURSE_REFID']]);
            if($data){

                $sql = 'SELECT  stud_data.user_refid, course.id as course_refid, stud_data.roll_no,
                 user.first_name, user.last_name, user.middle_name, user.username, user.profile_picture_id,
                 (SELECT `status` FROM `student_attendance` WHERE `user_refid`= stud_data.user_refid AND `course_refid`= :course_refid AND `date`=:currentDate) as ATTENDANCE_STATUS
                FROM `student_data` stud_data 
                INNER JOIN `user` user ON user.id = stud_data.user_refid
                INNER JOIN `course` course ON course.id = :course_refid
                WHERE stud_data.faculty_refid = :faculty_refid AND stud_data.faculty_period = :faculty_period';
                $data = $kali->kaliPulls($sql,['course_refid'=>$_POST['COURSE_REFID'],'faculty_refid'=>$data['faculty_id'],'currentDate'=>$currentDate,'faculty_period'=>$data['faculty_period']]);
                if($data){
                    $kali->kaliReply($data);
                }else{
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found '.$_POST['COURSE_REFID'] ,'TARGET'=>['FACULTY']]);
                }
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found '.$_POST['COURSE_REFID'] ,'TARGET'=>['FACULTY']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





