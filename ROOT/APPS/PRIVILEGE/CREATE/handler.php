<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['USERNAME'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `username`=:username';
            $data = $kali->kaliPull($sql,['username'=>$_POST['USERNAME']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['USERNAME']]);
            }
        }
    
        if(isset($_POST['EMAIL'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `email`=:email';
            $data = $kali->kaliPull($sql,['email'=>$_POST['EMAIL']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['EMAIL']]);
            }
        }
    
        if(isset($_POST['CONTACT_NUMBER'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:contact_number OR `phone_number`=:contact_number';
            $data = $kali->kaliPull($sql,['contact_number'=>$_POST['CONTACT_NUMBER']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['CONTACT_NUMBER']]);
            }
        }
    
    
        if(isset($_POST['PHONE_NUMBER'])){
            $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:phone_number OR `phone_number`=:phone_number';
            $data = $kali->kaliPull($sql,['phone_number'=>$_POST['PHONE_NUMBER']]);
            if($data){
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Exists','TARGET'=>['PHONE_NUMBER']]);
            }
        }

        if(isset($_POST['SELECT_OPTION'])){
            $sql = 'SELECT `name`, `id` FROM `branch` WHERE `college_refid`=:college_refid';
            $data = $kali->kaliPulls($sql,['college_refid'=>$_POST['COLLEGE']]);
            if($data){
                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found','TARGET'=>['FACULTY']]);
            }
        }

        if(isset($_POST['FIND_RIGHTS'])){

                $COLLEGE_REFID = "";
                $BRANCH_REFID = "";
                if($_POST['COLLEGE_REFID']=="" || $_POST['BRANCH_REFID'] ==''){
                    $sql = 'SELECT `college_refid`,`branch_refid` FROM `user` WHERE `id`=:id';
                    $data = $kali->kaliPull($sql,['id'=>$_SESSION['KOHOMAH']]);
                    if($data){
                        $COLLEGE_REFID = $data['college_refid'];
                        $BRANCH_REFID = $data['branch_refid'];
                    }
                }else{
                    $sql = 'SELECT `id` FROM `college` WHERE `id`=:id';
                    $data = $kali->kaliPull($sql,['id'=>$_POST['COLLEGE_REFID']]);
                    if(!$data){
                        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid College','TARGET'=>['COLLEGE']]);
                    }

                    $sql = 'SELECT `id` FROM `branch` WHERE `id`=:id';
                    $data = $kali->kaliPull($sql,['id'=>$_POST['BRANCH_REFID']]);
                    if(!$data){
                        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Branch','TARGET'=>['BRANCH']]);
                    }
                    
                    $COLLEGE_REFID = $_POST['COLLEGE_REFID'];
                    $BRANCH_REFID = $_POST['BRANCH_REFID'];
                }
                
                $sql = 'SELECT `id` FROM `authority` WHERE `id`=:id';
                $data = $kali->kaliPull($sql,['id'=>$_POST['AUTHORITY_REFID']]);
                if(!$data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Authority','TARGET'=>['AUTHORITY_NAME']]);
                }

                $sql = 'SELECT `id` FROM `application_manifest` WHERE `id`=:id';
                $data = $kali->kaliPull($sql,['id'=>$_POST['APPLICATION_REFID']]);
                if(!$data){
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Application','TARGET'=>['APPLICATION_NAME']]);
                }

                if($COLLEGE_REFID==null && $BRANCH_REFID==null){
                    $COLLEGE_REFID = "";
                    $BRANCH_REFID = "";
                }

                
                $sql = 'SELECT `rights_x` FROM `privilege` WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid &&
                 `authority_refid`=:authority_refid && `application_refid`=:application_refid';
                $data = $kali->kaliPull($sql,[
                    'college_refid'=>$COLLEGE_REFID,
                    'branch_refid'=>$BRANCH_REFID,
                    'authority_refid'=>$_POST['AUTHORITY_REFID'],
                    'application_refid'=>$_POST['APPLICATION_REFID'],
                ]);
                if($data){
                    $kali->kaliReply($data);
                }else{
                    $kali->kaliReply(['ERROR'=>true,'MSG'=>$COLLEGE_REFID,'TARGET'=>[]]);
                }





               

        }

        

        die;
        
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>

