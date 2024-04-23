<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'CREATE');
    try{

    if(isset($_POST['ID'])){

        switch($_POST['ID']){

            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `name` FROM `branch` WHERE `contact_number`=:contact_number || `phone_number`=:contact_number';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;

                                
            case 'PHONE_NUMBER':
                $sql = 'SELECT  `name` FROM `branch` WHERE `phone_number`=:phone_number || `contact_number`=:phone_number';
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

    }

    die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

