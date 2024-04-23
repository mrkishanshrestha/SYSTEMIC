<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$result='';


    if($_POST['SEARCH_DATA']!=''){

        $ACCESS_TO = strtoupper($kali->getSite());

        $SQL ="SELECT course.id,
        course.course_name,course.course_code,course.faculty_period,course.faculty_id,
        ( SELECT short_name FROM `faculty` WHERE id = course.faculty_id) as faculty_shortname,
        ( SELECT user_refid FROM `course_assigned` WHERE course_refid = course.id) as user_refid,
        ( SELECT CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`) FROM `user` WHERE id = user_refid) as userdetail
        FROM `course` course WHERE course.course_name LIKE :value ";
        $BIND = ['value'=>'%'.$_POST['SEARCH_DATA'].'%' ];
        $result = $kali->kaliPulls($SQL,$BIND);
        if(!$result){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;
        }
    $kali->kaliReply($result);
    }     

    $kali->kaliReply($result);
?>


