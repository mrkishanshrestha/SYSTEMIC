<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        switch($_POST['ID']){

            case 'USERNAME':
                $sql = 'SELECT  `username` FROM `client` WHERE `username`=:username';
                $data = $kali->kaliPull($sql,['username'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['USERNAME']]);
                }
                break;


            case 'EMAIL':
                $sql = 'SELECT  `username` FROM `client` WHERE `email`=:email';
                $data = $kali->kaliPull($sql,['email'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
                }
                break;

                
            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `username` FROM `client` WHERE `contact_number`=:contact_number';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;
                
            case 'SECONDARY_NUMBER':
                $sql = 'SELECT  `username` FROM `client` WHERE `phone_number`=:phone_number';
                $data = $kali->kaliPull($sql,['phone_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
                }
                break;

            default:
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Option Sent Via Post']);
                throw new ErrorException('Invalid Option Sent Via Post On Handlerphp');
                break;

        }

        die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

