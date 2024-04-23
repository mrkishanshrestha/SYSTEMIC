<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{


    if($_POST['JACKX']=='CHECKED'){
      
        $COLLEGE_REFID = "";
        $BRANCH_REFID = "";
        $AUTHORITY = $kali->dataCheck(['DATA'=>'AUTHORITY','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $USERNAME = $kali->dataCheck(['DATA'=>'USERNAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
        $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);


        if($_SESSION['MY_AUTHORITY']=='CLIENT'){
          $COLLEGE_REFID = $kali->dataCheck(['DATA'=>'COLLEGE','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
          $BRANCH_REFID = $kali->dataCheck(['DATA'=>'BRANCH','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        }else{
          $sql = 'SELECT  `college_refid`,`branch_refid` FROM `user` WHERE `id`=:id';
          $userData = $kali->kaliPull($sql,['id'=>$_SESSION['KOHOMAH']]);
          if($userData){
            $COLLEGE_REFID = $userData['college_refid'];
            $BRANCH_REFID = $userData['branch_refid'];
          }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['USERNAME']]);
          }
        }

        //**data checking start */
        $sql = 'SELECT  `name` FROM `college` WHERE `id`=:COLLEGE_REFID';
        $college_data = $kali->kaliPull($sql,['COLLEGE_REFID'=>$COLLEGE_REFID]);
        if(!$college_data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid College Name Sent','TARGET'=>['COLLEGE']]);
        }

        $sql = 'SELECT  `name` FROM `branch` WHERE `id`=:BRANCH_REFID and `college_refid`=:COLLEGE_REFID';
        $data = $kali->kaliPull($sql,['BRANCH_REFID'=>$BRANCH_REFID,'COLLEGE_REFID'=>$COLLEGE_REFID]);
        if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'College And Branch Selecetion Is Incorrect','TARGET'=>['COLLEGE','BRANCH']]);
        }

        $sql = 'SELECT  `id` FROM `authority` WHERE `name`=:name';
        $authority_data = $kali->kaliPull($sql,['name'=>$AUTHORITY]);
        if(!$data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Authority Sent','TARGET'=>['AUTHORITY']]);
        }

        $sql = 'SELECT  `username` FROM `user` WHERE `username`=:username';
        $data = $kali->kaliPull($sql,['username'=>$USERNAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Username Taken','TARGET'=>['COLLEGE_NAME']]);
        }
      
        $sql = 'SELECT  `username` FROM `user` WHERE `email`=:email';
        $data = $kali->kaliPull($sql,['email'=>$EMAIL]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Email Taken','TARGET'=>['EMAIL']]);
        }

        $sql = 'SELECT  `username` FROM `user` WHERE `phone_number`=:phone_number OR `contact_number`=:phone_number ';
        $data = $kali->kaliPull($sql,['phone_number'=>$PHONE_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Phone Number Taken','TARGET'=>['PHONE_NUMBER']]);
        }
        
        $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:contact_number OR `phone_number`=:contact_number';
        $data = $kali->kaliPull($sql,['contact_number'=>$CONTACT_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
        }


        $uq_id = $kali->makeId(); 

        //**data checking end */
        $USER_PROFILE_PICTURE;
        $USER_DOCUMENT;
        if(isset($_FILES['USER_PROFILE_PICTURE'])){
          $USER_PROFILE_PICTURE = $kali->uploadFIle(['FILE'=>$_FILES['USER_PROFILE_PICTURE'],'DIR'=>'SYSTEM','FOLDER'=>$uq_id,'TYPE'=>'IMAGE']);
          if($USER_PROFILE_PICTURE['ERROR']){
            $USER_PROFILE_PICTURE['TARGET']=['USER_PROFILE_PICTURE'];
            $kali->kaliReply($USER_PROFILE_PICTURE);
            die;
          }
        }

        if(isset($_FILES['USER_DOCUMENT'])){
          $USER_DOCUMENT =  $kali->uploadFIle(['FILE'=>$_FILES['USER_DOCUMENT'],'DIR'=>'SYSTEM','FOLDER'=>$uq_id,'TYPE'=>'IMAGE']);
          if($USER_DOCUMENT['ERROR']){
            $USER_DOCUMENT['TARGET']=['USER_DOCUMENT'];
            $kali->kaliReply($USER_DOCUMENT);
            die;
          }
        }

        $USER_PROFILE_PICTURE_ID = $USER_PROFILE_PICTURE['FILE_NAME'];
        $USER_DOCUMENT_ID = $USER_DOCUMENT['FILE_NAME'];

        $PASSWORD = $kali->makeId();
        $Hashed_Password = $kali->hashPassword($PASSWORD);
        
        $SQL = 'INSERT INTO `user`(`id`, `authority_refid`, `college_refid`, `branch_refid`, `username`, `first_name`, `middle_name`, `last_name`, `contact_number`, `phone_number`, `address`, `email`, `document_id`, `profile_picture_id`,`edate`) VALUES (:id, :authority_refid , :college_refid, :branch_refid, :username, :first_name, :middle_name, :last_name, :contact_number, :phone_number, :address, :email, :document_id, :profile_picture_id, now())'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'authority_refid'=>$authority_data['id'],
          'college_refid'=>$COLLEGE_REFID,
          'branch_refid'=>$BRANCH_REFID,
          'username'=>$USERNAME,
          'first_name'=>$FIRST_NAME,
          'middle_name'=>$MIDDLE_NAME,
          'last_name'=>$LAST_NAME,
          'contact_number'=>$CONTACT_NUMBER,
          'phone_number'=>$PHONE_NUMBER,
          'address'=>$ADDRESS, 
          'email'=>$EMAIL,
          'document_id'=>$USER_DOCUMENT_ID, 
          'profile_picture_id'=>$USER_PROFILE_PICTURE_ID,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $SQL3 = 'INSERT INTO `user_security`(`id`, `user_refid`, `password`) VALUES (:id, :user_refid, :password) ';
      $PUSH_DATA3 = [
        'id'=>$kali->makeId(),
        'user_refid'=>$uq_id,
        'password'=>$Hashed_Password,
      ];
      $kali->kaliPush($SQL3,$PUSH_DATA3);

      if(mail($EMAIL,'SYSTEMIC'.$college_data['name'],'Hello '.$USERNAME.', Your Account Was Sucessfully Created In Systemic. Your New Login Password Is : '.$PASSWORD,"From:mr.kishanshrestha@gmail.com")){
      }else{
        //$kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
      }
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'USERHAS BEEN ADDED SUCESSFULLY']);
      

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>