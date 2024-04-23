<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['USERNAME'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `username`=:username';
            $data = $kali->kaliPull($sql,['username'=>$_POST['USERNAME']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['USERNAME']]);
            }
        }
    
        if(isset($_POST['EMAIL'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `email`=:email';
            $data = $kali->kaliPull($sql,['email'=>$_POST['EMAIL']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
            }
        }
    
        if(isset($_POST['CONTACT_NUMBER'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:contact_number';
            $data = $kali->kaliPull($sql,['contact_number'=>$_POST['CONTACT_NUMBER']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
            }
        }
    
    
        if(isset($_POST['PHONE_NUMBER'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `phone_number`=:phone_number';
            $data = $kali->kaliPull($sql,['phone_number'=>$_POST['PHONE_NUMBER']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
            }
        }

        die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

