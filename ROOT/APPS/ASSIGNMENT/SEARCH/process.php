<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION = "ASSIGNMENT";
$kali->checkAccess($APPLICATION,'SEARCH');

    if($_POST['COURSE_REFID']!=''){
        $sql = 'SELECT * FROM `assignment` ass
        WHERE ass.id NOT IN 
            (
                SELECT assignment_refid FROM assignment_record WHERE user_refid=:user_refid && assignment_refid=ass.id
            )
        and ass.course_refid = :course_refid  ORDER BY ass.assigned_date
        ;';
        $data = $kali->kaliPulls($sql,['course_refid'=>$_POST['COURSE_REFID'],'user_refid'=>$_SESSION['KOHOMAH']]);
        if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Assignmnets ! Hurray !!!']);
            die;
        }
    }     

    $kali->kaliReply($data);
?>


