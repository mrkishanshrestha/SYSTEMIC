<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$result='';

    if(($_SERVER['REQUEST_METHOD']=="POST")){

        if($kali->isUser(['KING']) && $_POST['SEARCH_DATA']!=''){
            $SQL = 'SELECT user.username,user.id, user.authority_refid, user.username, user.first_name, user.middle_name, user.last_name, user.contact_number, user.phone_number, user.address, user.email, user.document_id, user.profile_picture_id, user.edate, client_edata.college_limit, client_edata.branch_limit FROM `user` user
            INNER JOIN 	`client_edata` client_edata ON client_edata.user_refid = user.id
            WHERE 
            (user.first_name LIKE :name || user.middle_name LIKE :name || user.last_name LIKE :name || user.contact_number LIKE :name || user.email LIKE :name || user.phone_number LIKE :name)  limit 10';
            $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%' ];
            $result = $kali->kaliPulls($SQL,$BIND);
            if(!$result){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Foundss']);
                die;
            }
        }  

    }
   

    $kali->kaliReply($result);
?>


