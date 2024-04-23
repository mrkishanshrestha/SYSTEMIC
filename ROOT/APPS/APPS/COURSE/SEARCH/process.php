<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$kali->whoHasAccess(['STUDENT']);
$result='';


    if($_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT `id`, `course_name`, `course_code`, `credit_hrs`, `lecture_hrs`, `tutorial_hrs`, `lab_hrs`, `faculty_id`,`faculty_period`,`course_document`,
                (SELECT `based_on` FROM `faculty` WHERE `id`=faculty_id) as based_on,
                (SELECT `name` FROM `faculty` WHERE `id`=faculty_id) as faculty
                 FROM `course`  WHERE
            (`course_name` LIKE :name || `course_code` LIKE :name ) limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%' ];
        $result = $kali->kaliPulls($SQL,$BIND);
        if(!$result){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;
        }
    }     

    $kali->kaliReply($result);
?>


