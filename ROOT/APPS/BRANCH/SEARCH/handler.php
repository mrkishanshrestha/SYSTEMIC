<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'VIEW');

    try{

        switch($_POST['ID']){

            case 'BRANCH_NAME':
                $sql = 'SELECT  `name` FROM `branch` WHERE `name`=:name AND `id`!=:id';
                $data = $kali->kaliPull($sql,['name'=>$_POST['VALUE'],'id'=>$_POST['DB_TUPLE_ID']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['BRANCH_NAME']]);
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

