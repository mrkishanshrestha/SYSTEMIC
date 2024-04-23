<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['ID'])){


        switch($_POST['ID']){

            case 'COURSE_NAME':
                $sql = 'SELECT  `course_name` FROM `course` WHERE `course_name`=:course_name';
                $data = $kali->kaliPull($sql,['course_name'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['COURSE_NAME']]);
                }
                break;


            case 'COURSE_CODE':
                $sql = 'SELECT  `course_code` FROM `course` WHERE `course_code`=:course_code';
                $data = $kali->kaliPull($sql,['course_code'=>$_POST['VALUE']]);
                if($data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['COURSE_CODE']]);
                }
                break;

          
            default:
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Option Sent Via Post']);
                throw new ErrorException('Invalid Option Sent Via Post On Handlerphp');
                break;

        }

    }

    if(isset($_POST['SELECT_OPTION'])){
        $sql = 'SELECT `periods`,`based_on` FROM `faculty` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>$_POST['FACULTY']]);
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

