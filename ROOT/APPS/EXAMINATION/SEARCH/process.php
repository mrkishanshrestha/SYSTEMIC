<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION = "ASSIGNMENT";
$kali->checkAccess($APPLICATION,'SEARCH');

    if($_POST['COURSE_REFID']!=''){
        $sql = 'SELECT `college_refid`,`branch_refid`  FROM `user`WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$_SESSION['KOHOMAH']]);
        if($data){
            
            $sql = 'SELECT * FROM `examination`WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid ';
            $data = $kali->kaliPulls($sql,['college_refid'=>$data['college_refid'],'branch_refid'=>$data['branch_refid']]);
            if($data){
                $kali->kaliReply($data);
            }
            
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Assignmnets ! Hurray !!!']);
            die;
        }
    }     

?>


