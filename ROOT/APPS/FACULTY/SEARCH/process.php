<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$kali->whoHasAccess(['KING']);
$result='';

    if(isset($_FILES['COLLEGE_LOGO'])){


        $sql = 'SELECT `college_logo`,`domain_cname` FROM `college` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$_POST['SELFID']]);
        if($data){
            $dir = 'D:/CODE/DEPLOY/SYSTEMIC/CLIENTS/COLLEGES/'.strtoupper($data['domain_cname']).'/IMG/'.$data['college_logo'];
            if(file_exists($dir)){
                unlink($dir);
            }

            $COLLEGE_LOGO =  $kali->uploadFIle($_FILES['COLLEGE_LOGO'],['DIR'=>'CLIENTS/COLLEGES/'.strtoupper($data['domain_cname']),'FOLDER'=>'IMG']);
            if($COLLEGE_LOGO['ERROR']){
              $COLLEGE_LOGO['TARGET']=['COLLEGE_LOGO'];
              $kali->kaliReply($COLLEGE_LOGO);
              die;
            }

            $SQL = 'UPDATE `college` SET `college_logo`=:college_logo WHERE `id`=:id';
            $BIND = [
                'college_logo'=>$COLLEGE_LOGO['FILE_NAME'],
                'id'=>$_POST['SELFID'],
            ];
            $result = $kali->kaliUpdate($SQL,$BIND);

            if($result){
                $kali->kaliReply(['ERROR'=>false,'MSG'=>'College Updated']);
                die;
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'College Cannot Updated '.$_POST['user_id']]);
                die;
            }

        }

      }


 
      if(isset($_POST['update'])){

        $SQL = 'UPDATE `faculty` SET `name`=:name,`short_name`=:short_name, `based_on`=:based_on,`periods`=:periods,`description`=:description WHERE `id`=:id';
        $BIND = [
            'name'=>$_POST['name'],
            'short_name'=>$_POST['short_name'],
            'based_on'=>$_POST['based_on'],
            'periods'=>$_POST['periods'],
            'description'=>$_POST['description'],
            'id'=>$_POST['selfid'],
        ];

        $result = $kali->kaliUpdate($SQL,$BIND);
        if($result){
            $kali->kaliReply(['ERROR'=>false,'MSG'=>'Faculty Updated']);
            die;
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Faculty Cannot Updated']);
            die;
        }
    }

    if($_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT `id`, `name`, `based_on`, `periods`, `short_name`, `description` FROM `faculty` WHERE
            (`name` LIKE :name || `short_name` LIKE :name ) limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%' ];
        $result = $kali->kaliPulls($SQL,$BIND);
        if(!$result){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;
        }
    }     

    $kali->kaliReply($result);
?>


