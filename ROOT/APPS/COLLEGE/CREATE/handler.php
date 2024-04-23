<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="COLLEGE";
$kali->checkAccess($APPLICATION,'CREATE');

    try{

    if(isset($_POST['ID'])){

        switch($_POST['ID']){

            case 'COLLEGE_NAME':
                $sql = 'SELECT  `name` FROM `college` WHERE `name`=:name';
                $data = $kali->kaliPull($sql,['name'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['COLLEGE_NAME']]);
                }
                break;


            case 'COLLEGE_SHORT_NAME':
                $sql = 'SELECT  `name` FROM `college` WHERE `short_name`=:short_name';
                $data = $kali->kaliPull($sql,['short_name'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['COLLEGE_SHORT_NAME']]);
                }
                break;

                
            case 'EMAIL':
                $sql = 'SELECT  `name` FROM `college` WHERE `email`=:email';
                $data = $kali->kaliPull($sql,['email'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
                }
                break;
                
            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `name` FROM `college` WHERE `contact_number`=:contact_number || `phone_number`=:contact_number';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;

                                
            case 'PHONE_NUMBER':
                $sql = 'SELECT  `name` FROM `college` WHERE `phone_number`=:phone_number || `contact_number`=:phone_number';
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

    $kali->kaliReply(['ERROR'=>false,'MSG'=>'','TARGET'=>['']]);
      die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

