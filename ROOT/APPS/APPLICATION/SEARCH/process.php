<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$result='';

    if(($_SERVER['REQUEST_METHOD']=="POST")){

        if($kali->isUser(['KING']) && $_POST['SEARCH_DATA']!=''){
            $SQL = 'SELECT * FROM `application_manifest` 
            WHERE 
            `name` LIKE :name limit 10';
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


