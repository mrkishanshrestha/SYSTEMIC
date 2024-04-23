<?php
require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';



    /*if(isset($_POST['update'])){

        $SQL = 'UPDATE `user` SET `name`=:name,`contact_number`=:contact_number,`phone_number`=:phone_number,`address`=:address WHERE `id`=:id';
        $BIND = ['name'=>$_POST['name'],'contact_number'=>$_POST['contact'],'phone_number'=>$_POST['phone'],'address'=>$_POST['address'],'id'=>$_POST['userid']];
        $result = $kali->kaliUpdate($SQL,$BIND);
        if($result){
            $kali->kaliReply(['ERROR'=>false,'MSG'=>'User Updated']);
        }
        die;
    }

    if($kali->isUser('KING')){
        $SQL = 'SELECT `id`, `username`, `name`, `contact_number`, `phone_number`, `address`, `email`, `post`, `document_id`, `profile_picture_id`, `status`, `description`, `edate` FROM `user` WHERE 
            (`name` LIKE :name || `contact_number` LIKE :name || `email` LIKE :name || `phone_number` LIKE :name) && `post`=:post limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%','post'=>'TENANT' ];
        $result = $kali->kaliPulls($SQL,$BIND);
    }else{
        $SQL = 'SELECT `id`, `username`, `name`, `contact_number`, `phone_number`, `address`, `email`, `post`, `document_id`, `profile_picture_id`, `status`, `description`, `edate` FROM `user` WHERE 
        (`name` LIKE :name || `contact_number` LIKE :name || `email` LIKE :name || `phone_number` LIKE :name) && `whos_renter`=:whos_renter limit 10';
        $BIND = ['name'=>'%'.$_POST['SEARCH_DATA'].'%','whos_renter'=>$_SESSION['KOHOMAH'] ];
        $result = $kali->kaliPulls($SQL,$BIND);
    }       
    
    */

    
    if(isset($_POST['SEARCH_DATA']) && $_POST['SEARCH_DATA']!=''){
        $SQL = 'SELECT `username`, `name`, `contact_number`, `phone_number`, `address`, `email`, `document_id`, `profile_picture_id`, `status`, `description`, `edate` FROM `user` WHERE `username` LIKE :username || `email` LIKE :email || `phone_number` LIKE :phone_number || `contact_number` LIKE :contact_number limit 10';
        $BIND = ['username'=>$_POST['SEARCH_DATA'].'%','email'=>$_POST['SEARCH_DATA'].'%','contact_number'=>$_POST['SEARCH_DATA'].'%','phone_number'=>$_POST['SEARCH_DATA'].'%'];
        $result = $kali->kaliPulls($SQL,$BIND);
        if($result==''){$kali->kaliReply(['ERROR'=>true]);}
    }else{
        $kali->kaliReply(['ERROR'=>true]);
    }



 

    $kali->kaliReply($result);
?>


