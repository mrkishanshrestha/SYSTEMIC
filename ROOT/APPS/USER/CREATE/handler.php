<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

    if(isset($_POST['ID'])){

        switch($_POST['ID']){

            
            case 'USERNAME':
                $sql = 'SELECT  `username` FROM `user` WHERE `username`=:username';
                $data = $kali->kaliPull($sql,['username'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['USERNAME']]);
                }
                break;



            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `first_name` FROM `user` WHERE `contact_number`=:contact_number OR `phone_number`=:contact_number';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;


            case 'PHONE_NUMBER':
                $sql = 'SELECT  `first_name` FROM `user` WHERE `phone_number`=:phone_number OR `contact_number`=:phone_number';
                $data = $kali->kaliPull($sql,['phone_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
                }
                break;

                
            case 'EMAIL':
                $sql = 'SELECT  `first_name` FROM `user` WHERE `email`=:email';
                $data = $kali->kaliPull($sql,['email'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
                }
            break;


            default:
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Option Sent Via Post']);
                throw new ErrorException('Invalid Option Sent Via Post On Handlerphp');
                break;

        }

    }

    if(isset($_POST['SELECT_OPTION'])){
        $sql = 'SELECT `name`, `id` FROM `branch` WHERE `college_refid`=:college_refid';
        $data = $kali->kaliPulls($sql,['college_refid'=>$_POST['COLLEGE']]);
        if($data){
            $kali->kaliReply($data);
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found','TARGET'=>['FACULTY']]);
        }
    }

    die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

