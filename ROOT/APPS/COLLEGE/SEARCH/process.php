<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="COLLEGE";
$kali->checkAccess($APPLICATION,'SEARCH');

$result='';


    if($_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT `id`, `user_refid`, `name`, `short_name`, `address`, `contact_number`, `phone_number`, `geo_location`, `email`, `est_date`, `affiliation`, `description`, `college_logo`, `college_background_image`, `domain_cname`, `faculty_id_x`,`entry_date`
         FROM `college` WHERE 
            (`name` LIKE :name || `short_name` LIKE :name || `email` LIKE :name || `domain_cname` LIKE :name || `phone_number` LIKE :name || `contact_number` LIKE :name)  && `user_refid`=:user_refid limit 10';
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


