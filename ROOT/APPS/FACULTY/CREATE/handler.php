<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        switch($_POST['ID']){

            case 'FACULTY_NAME':
                $sql = 'SELECT  `name` FROM `faculty` WHERE `name`=:name';
                $data = $kali->kaliPull($sql,['name'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['FACULTY_NAME']]);
                }
                break;


            case 'FACULTY_SHORT_NAME':
                $sql = 'SELECT  `short_name` FROM `faculty` WHERE `short_name`=:short_name';
                $data = $kali->kaliPull($sql,['short_name'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['FACULTY_SHORT_NAME']]);
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

