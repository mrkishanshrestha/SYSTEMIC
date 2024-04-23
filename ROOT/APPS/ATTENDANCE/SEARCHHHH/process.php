<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$result='';


    if($_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT faculty.short_name as faculty_name, faculty.based_on as faculty_based_on, college.domain_cname as collegeDomain, stud.id, stud.username, stud.roll_no, stud.first_name, stud.middle_name, stud.last_name, stud.email, stud.address, stud.contact_number, stud.gurdian_number, stud.college_id, stud.branch_id, stud.faculty_id, stud.faculty_period, stud.profile_picture_id, stud.document_id, stud.description
         FROM `student` as stud
        INNER JOIN `college` as college ON college.id = stud.college_id 
        INNER JOIN `faculty` as faculty ON faculty.id = stud.faculty_id 
        
        WHERE
            (stud.first_name LIKE :name || stud.username LIKE :name || stud.roll_no LIKE :name || stud.email LIKE :name || stud.contact_number LIKE :name || stud.gurdian_number LIKE :name) limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%' ];
        $result = $kali->kaliPulls($SQL,$BIND);
        if(!$result){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;
        }
    }     

    $kali->kaliReply($result);
?>


