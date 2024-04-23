<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'VIEW');

$result='';


    if($_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT college.id as college_refid, college.name as college_name, college.user_refid, branch.id, branch.college_refid, branch.name as branch_name, branch.address, branch.geo_location, branch.contact_number, branch.phone_number, branch.faculty_id_x
         FROM `college`as college
         INNER JOIN branch as branch ON branch.college_refid = college.id
          WHERE 
            (college.name LIKE :name || branch.name LIKE :name || college.short_name LIKE :name || college.email LIKE :name || college.domain_cname LIKE :name || college.phone_number LIKE :name || college.contact_number LIKE :name || branch.phone_number LIKE :name || branch.contact_number LIKE :name)  && `user_refid`=:user_refid limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%', 'user_refid'=>$_SESSION['KOHOMAH'] ];
        $result = $kali->kaliPulls($SQL,$BIND);
        if(!$result){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;
        }else{

            $counter=0;
            foreach($result as $rows){
               $faculty_id_x = explode(',',$rows['faculty_id_x']);
               $result[$counter]['faculty_short_name']=[];
                foreach($faculty_id_x as $faculty_id){

                   $SQL2 = 'SELECT `short_name` FROM `faculty` WHERE `id`=:id';
                   $BIND2 = ['id'=>$faculty_id ];
                   $result2 = $kali->kaliPull($SQL2,$BIND2);
                   array_push($result[$counter]['faculty_short_name'],$result2['short_name']);
                   
                }
                $counter++;
     
            }

        }
    }     

    $kali->kaliReply($result);
?>


