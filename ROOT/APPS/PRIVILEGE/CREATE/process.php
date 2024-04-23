<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

      $COLLEGE_REFID = "";
      $BRANCH_REFID = "";
      $AUTHORITY = $kali->dataCheck(['DATA'=>'AUTHORITY_NAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
      $APPLICATION = $kali->dataCheck(['DATA'=>'APPLICATION_NAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
      $APPLICATION_RIGHTS = $kali->dataCheck(['DATA'=>'APPLICATION_RIGHTS','CASE'=>'STRING','CHARACTER'=>'UPPER','NOTREQUIRED'=>true]);


      if(($_SESSION['MY_AUTHORITY']=="KING")){
        
      }else{
        if($_SESSION['MY_AUTHORITY']=="CLIENT"){
        
          $COLLEGE = $kali->dataCheck(['DATA'=>'COLLEGE','CASE'=>'STRING','CHARACTER'=>'LOWER']);
          $BRANCH = $kali->dataCheck(['DATA'=>'BRANCH','CASE'=>'STRING','CHARACTER'=>'LOWER']);
          
          $sql = 'SELECT  `id` FROM `college` WHERE `id`=:id';
          $data = $kali->kaliPull($sql,['id'=>$COLLEGE]);
          if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'COLLEGE NOT FOUND !','TARGET'=>['COLLEGE']]);
          }
          $COLLEGE_REFID = $data['id'];
          
          $sql = 'SELECT  `id` FROM `branch` WHERE `id`=:id';
          $data = $kali->kaliPull($sql,['id'=>$BRANCH]);
          if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'BRANCH NOT FOUND !','TARGET'=>['BRANCH']]);
          }
          $BRANCH_REFID = $data['id'];
  
        }else{
          $sql = 'SELECT  `college_refid`, `branch_refid` FROM `user` WHERE `id`=:id';
          $data = $kali->kaliPull($sql,['id'=>$_SESSION['KOHOMAH']]);
          if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'INVALID USER !','TARGET'=>['APPLICATION_NAME']]);
          }
          $COLLEGE_REFID = $data['college_refid'];
          $BRANCH_REFID = $data['branch_refid'];
        }
      }



      $sql = 'SELECT  `id` FROM `application_manifest` WHERE `id`=:id';
      $data = $kali->kaliPull($sql,['id'=>$APPLICATION]);
      if(!$data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'APPLICATION NOT FOUND !','TARGET'=>['APPLICATION']]);
      }
      $APPLICATION_REFID = $data['id'];

      $sql = 'SELECT  `id` FROM `authority` WHERE `id`=:id';
      $data = $kali->kaliPull($sql,['id'=>$AUTHORITY]);
      if(!$data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'AUTHORITY NOT FOUND !'.$AUTHORITY,'TARGET'=>['AUTHORITY']]);
      }
      $AUTHORITY_REFID = $data['id'];
      
        /*data checking start */
        $sql = 'SELECT  `college_refid` FROM `privilege` WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid && `authority_refid`=:authority_refid && `application_refid`=:application_refid';
        $data = $kali->kaliPull($sql,['college_refid'=>$COLLEGE_REFID,'branch_refid'=>$BRANCH_REFID,'authority_refid'=>$AUTHORITY_REFID,'application_refid'=>$APPLICATION_REFID]);
        if($data){

          $SQL = 'UPDATE `privilege` SET `rights_x`=:rights_x WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid && `authority_refid`=:authority_refid && `application_refid`=:application_refid';
          $PUSH_DATA = [
            'college_refid'=>$COLLEGE_REFID,
            'branch_refid'=>$BRANCH_REFID,
            'authority_refid'=>$AUTHORITY_REFID,
            'application_refid'=>$APPLICATION_REFID,
            'rights_x'=>$APPLICATION_RIGHTS
          ];

          $kali->kaliPush($SQL,$PUSH_DATA);
          $kali->kaliReply([ "ERROR"=> false,'MSG'=>'PRIVILEGE UPDATED SUCESSFULLY']);
          
          //$kali->kaliReply(['ERROR'=>true,'MSG'=>'DATA ALREADY ADDED','TARGET'=>['APPLICATION_RIGHTS']]);
        }
        /*data checking end */


        
        $SQL = 'INSERT INTO `privilege`(`id`, `college_refid`, `branch_refid`, `authority_refid`, `application_refid`, `rights_x`) VALUES (:id, :college_refid, :branch_refid, :authority_refid, :application_refid, :rights_x)';
        $PUSH_DATA = [
          'id'=>$kali->makeId(),
          'college_refid'=>$COLLEGE_REFID,
          'branch_refid'=>$BRANCH_REFID,
          'authority_refid'=>$AUTHORITY_REFID,
          'application_refid'=>$APPLICATION_REFID,
          'rights_x'=>$APPLICATION_RIGHTS
        ];

        try{
          //$kali->beginTransaction();
            $kali->kaliPush($SQL,$PUSH_DATA);
          //$kali->commit();
        }catch(Exception $e){
          $kali->rollBack();
          echo "Failed: " . $e->getMessage();
        }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'PRIVILEGE ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>