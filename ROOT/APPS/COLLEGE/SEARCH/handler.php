<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="COLLEGE";
$kali->checkAccess($APPLICATION,'SEARCH');

    try{

        switch($_POST['ID']){

            case 'COLLEGE_NAME':
                $sql = 'SELECT  `name` FROM `college` WHERE `name`=:name AND `id`!=:id';
                $data = $kali->kaliPull($sql,['name'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['COLLEGE_NAME']]);
                }
                break;


            case 'SHORT_NAME':
                $sql = 'SELECT  `name` FROM `college` WHERE `short_name`=:short_name AND `id`!=:id';
                $data = $kali->kaliPull($sql,['short_name'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['SHORT_NAME']]);
                }
                break;

                
            case 'CONTACT_NUMBER':
                $sql = 'SELECT  `name` FROM `college` WHERE (`contact_number`=:contact_number OR  `phone_number`=:contact_number) AND `id`!=:id';
                $data = $kali->kaliPull($sql,['contact_number'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
                }
                break;
                
            case 'PHONE_NUMBER':
                $sql = 'SELECT  `name` FROM `college` WHERE (`phone_number`=:phone_number OR `contact_number`=:phone_number) AND `id`!=:id';
                $data = $kali->kaliPull($sql,['phone_number'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
                }
                break;
               
            case 'EMAIL':
                $sql = 'SELECT  `name` FROM `college` WHERE `email`=:email AND `id`!=:id';
                $data = $kali->kaliPull($sql,['email'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
                }
                break;

            case 'DOMAIN_CNAME':
                $sql = 'SELECT  `name` FROM `college` WHERE `domain_cname`=:domain_cname AND `id`!=:id';
                $data = $kali->kaliPull($sql,['domain_cname'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['DOMAIN_CNAME']]);
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

