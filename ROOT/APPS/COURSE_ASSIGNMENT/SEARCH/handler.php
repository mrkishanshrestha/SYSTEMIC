<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

    if(isset($_POST['ID'])){


        switch($_POST['ID']){

            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `first_name` FROM `user` WHERE (`contact_number`=:contact_number OR  `phone_number`=:contact_number) AND `id`!=:id';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;
                
            case 'PHONE_NUMBER':
                $sql = 'SELECT  `first_name` FROM `user` WHERE (`phone_number`=:phone_number OR `contact_number`=:phone_number) AND `id`!=:id';
                $data = $kali->kaliPull($sql,['phone_number'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
                }
                break;
               
            case 'EMAIL':
                $sql = 'SELECT  `first_name` FROM `user` WHERE `email`=:email AND `id`!=:id';
                $data = $kali->kaliPull($sql,['email'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
                }
                break;

            default:
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Option Sent Via Post']);
                throw new ErrorException('Invalid Option Sent Via Post On Handlerphp');
                break;

        }

        die;

    }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }   
?>

