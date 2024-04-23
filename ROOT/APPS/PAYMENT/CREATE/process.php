<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="PAYMENT";
$kali->checkAccess($APPLICATION,'VIEW');

$result='';

    if($_POST['SEARCH_DATA']!=''){

        if($_POST['FACULTY_REFID']==''){
            $SQL = 'SELECT student.id,student.user_refid, student.roll_no,student.gurdian_number,student.faculty_period, faculty.short_name as faculty_name, faculty.based_on as faculty_based_on, user.id, user.authority_refid, user.college_refid, user.branch_refid, user.username, user.first_name, user.middle_name, user.last_name, user.contact_number, user.phone_number, user.address, user.email, user.document_id, user.profile_picture_id, user.edate
                    FROM `user` as user
                    INNER JOIN `student_data` student ON user.id = student.user_refid
            INNER JOIN `faculty` faculty ON faculty.id = student.faculty_refid
                    WHERE 
                    (user.id LIKE :name || user.first_name LIKE :name || user.username LIKE :name || student.roll_no LIKE :name || user.email LIKE :name || user.contact_number LIKE :name || student.gurdian_number LIKE :name) limit 10
                    ';
                    $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%' ];
                    $result = $kali->kaliPulls($SQL,$BIND);
                    if(!$result){
                        $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
                        die;
                    }
        }else{

            $SQL = 'SELECT student.id,student.user_refid, student.roll_no, student.gurdian_number,student.faculty_refid, student.faculty_period, faculty.short_name as faculty_name, faculty.based_on as faculty_based_on, user.id, user.authority_refid, user.college_refid, user.branch_refid, user.username, user.first_name, user.middle_name, user.last_name, user.contact_number, user.phone_number, user.address, user.email, user.document_id, user.profile_picture_id, user.edate
            FROM `user` as user
            INNER JOIN `student_data` student ON user.id = student.user_refid
            INNER JOIN `faculty` faculty ON faculty.id = student.faculty_refid
            WHERE 
            (user.first_name LIKE :name || user.username LIKE :name || student.roll_no LIKE :name || user.email LIKE :name || user.contact_number LIKE :name || student.gurdian_number LIKE :name) && (student.faculty_refid = :faculty_refid && student.faculty_period=:faculty_period) limit 10
            ';
            $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%','faculty_refid'=>$_POST['FACULTY_REFID'],'faculty_period'=>$_POST['FACULTY_PERIOD'] ];
            $result = $kali->kaliPulls($SQL,$BIND);
            if(!$result){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
                die;
            }

        }

        $counter = 0;;
        foreach($result as $rows){
            $BALANCE =  ($kali->getBalance($result[$counter]['id']));
            $result[$counter]['BALANCE'] = $BALANCE;
            $counter++;
        }
    }
    
    

    $kali->kaliReply($result);
?>


