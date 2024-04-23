<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$result='';


    if($_POST['SEARCH_DATA']!=''){

        $ACCESS_TO = strtoupper($kali->getSite());

        $SQL = 'SELECT FF.id, FF.faculty_refid, FF.college_refid, FF.amount, FF.admission_fee, 
                FA.name, FA.short_name, college.domain_cnamE
            FROM `faculty_finance` FF
        INNER JOIN `college` as college ON college.id = FF.college_refid
        INNER JOIN `faculty` as FA ON FA.id = FF.faculty_refid
         WHERE FA.short_name LIKE :value';
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


