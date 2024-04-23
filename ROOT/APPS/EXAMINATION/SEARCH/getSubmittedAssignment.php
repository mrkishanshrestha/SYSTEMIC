<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION = "ASSIGNMENT";
$kali->checkAccess($APPLICATION,'SEARCH');

    if($_POST['COURSE_REFID']!=''){
        $sql = 'SELECT assr.id as assignment_record_id , assr.user_refid, assr.assignment_refid, assr.course_refid, assr.assignment_files_x as submitted_assignment_files_x, assr.submited_date, assr.submit_status, assr.check_status, assr.mark_obtained,
        ass.id as assignment_id,  ass.user_refid,  ass.title,  ass.assignment_files_x,  ass.due_date,  ass.mark, ass.description,  ass.assigned_date
        FROM `assignment_record` assr
        INNER JOIN `assignment` ass ON ass.id = assr.assignment_refid
        WHERE assr.course_refid = :course_refid AND assr.user_refid = :user_refid';
        $data = $kali->kaliPulls($sql,['course_refid'=>$_POST['COURSE_REFID'],'user_refid'=>$_SESSION['KOHOMAH']]);
        if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'You Havent Done Any Assignmnets ! Dooo Soon !!!']);
            die;
        }
    }     

    $kali->kaliReply($data);
?>


