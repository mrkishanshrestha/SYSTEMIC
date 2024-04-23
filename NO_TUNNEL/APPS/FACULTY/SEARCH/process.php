<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

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


        $SQL = 'UPDATE `college` SET `name`=:name,`short_name`=:short_name,`address`=:address,`geo_location`=:geo_location,`contact_number`=:contact_number,`phone_number`=:phone_number,`email`=:email,`est_date`=:est_date,`affiliation`=:affiliation,`description`=:description,`domain_cname`=:domain_cname WHERE `id`=:id AND `user_id`=:user_id';
        $BIND = [
            'name'=>$_POST['name'],
            'short_name'=>$_POST['short_name'],
            'address'=>$_POST['address'],
            'geo_location'=>$_POST['geo_location'],
            'contact_number'=>$_POST['contact_number'],
            'phone_number'=>$_POST['phone_number'],
            'email'=>$_POST['email'],
            'est_date'=>$_POST['est_date'],
            'affiliation'=>$_POST['affiliation'],
            'description'=>$_POST['description'],
            'domain_cname'=>$_POST['domain_cname'],

            
            'id'=>$_POST['selfid'],
            'user_id'=>$_SESSION['KOHOMAH'],

            
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

    if($_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT `id`, `user_id`, `name`, `short_name`, `address`, `contact_number`, `phone_number`, `geo_location`, `email`, `est_date`, `affiliation`, `description`, `college_logo`, `college_background_image`, `domain_cname`, `entry_date` FROM `college` WHERE 
            (`name` LIKE :name || `short_name` LIKE :name || `email` LIKE :name || `domain_cname` LIKE :name || `phone_number` LIKE :name || `contact_number` LIKE :name)  && `user_id`=:user_id limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%', 'user_id'=>$_SESSION['KOHOMAH'] ];
        $result = $kali->kaliPulls($SQL,$BIND);
        if(!$result){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'No Data Found']);
            die;
        }
    }     

    $kali->kaliReply($result);
?>


