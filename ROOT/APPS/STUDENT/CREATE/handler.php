<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="STUDENT";
$kali->checkAccess($APPLICATION,'CREATE');

    try{

    if(isset($_POST['ID'])){

        switch($_POST['ID']){


            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `first_name` FROM `student` WHERE `contact_number`=:contact_number OR `gurdian_number`=:contact_number';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;


            case 'GURDIAN_NUMBER':
                $sql = 'SELECT  `first_name` FROM `student` WHERE `phone_number`=:gurdian_number OR `gurdian_number`=:gurdian_number';
                $data = $kali->kaliPull($sql,['phone_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
                }
                break;

                
            case 'EMAIL':
                $sql = 'SELECT  `first_name` FROM `student` WHERE `email`=:email';
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

    die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

