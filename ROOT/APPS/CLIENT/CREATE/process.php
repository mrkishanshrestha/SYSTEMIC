<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $USERNAME = $kali->dataCheck(['DATA'=>'USERNAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $FNAME = $kali->dataCheck(['DATA'=>'FNAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $MNAME = $kali->dataCheck(['DATA'=>'MNAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
        $LNAME = $kali->dataCheck(['DATA'=>'LNAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COLLEGE_LIMIT = $kali->dataCheck(['DATA'=>'COLLEGE_LIMIT','CASE'=>'NUMBER']);
        $BRANCH_LIMIT = $kali->dataCheck(['DATA'=>'BRANCH_LIMIT','CASE'=>'NUMBER']);

        if(!$kali->isUser(['KING'])){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'YOU ARE NOT KING']);
        }

        if($USERNAME=="KING"){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'User Name Taken','TARGET'=>['USERNAME']]);
        }

        //**data checking start */
        $sql = 'SELECT  `username` FROM `user` WHERE `username`=:username';
        $data = $kali->kaliPull($sql,['username'=>$USERNAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'User Name Taken','TARGET'=>['USERNAME']]);
        }

        $sql = 'SELECT  `username` FROM `user` WHERE `phone_number`=:phone_number';
        $data = $kali->kaliPull($sql,['phone_number'=>$PHONE_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Phone Numner Exists','TARGET'=>['PHONE_NUMBER']]);
        }

        $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:contact_number';
        $data = $kali->kaliPull($sql,['contact_number'=>$CONTACT_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
        }
        
        $sql = 'SELECT  `username` FROM `user` WHERE `email`=:email';
        $data = $kali->kaliPull($sql,['email'=>$EMAIL]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Email Already Taken','TARGET'=>['EMAIL']]);
        }

        
        $uq_id = $kali->makeId(); 
      //**data checking end */

        $profile_photo_id;
        $user_doc_id;
        if(isset($_FILES['CLIENT_PROFILE_PICTURE'])){
          $profile_photo_id = $kali->uploadFIle(['FILE'=>$_FILES['CLIENT_PROFILE_PICTURE'],'TYPE'=>'IMAGE','DIR'=>'SYSTEM','FOLDER'=>'CLIENT/'.$uq_id]);
          if($profile_photo_id['ERROR']){
            $profile_photo_id['TARGET']=['CLIENT_PROFILE_PICTURE'];
            $kali->kaliReply($profile_photo_id);
            die;
          }
        }

        if(isset($_FILES['CLIENT_DOCUMENT'])){
          $user_doc_id = $kali->uploadFIle(['FILE'=>$_FILES['CLIENT_DOCUMENT'],'TYPE'=>'IMAGE','DIR'=>'SYSTEM','FOLDER'=>'CLIENT/'.$uq_id]);
          if($user_doc_id['ERROR']){
            $user_doc_id['TARGET']=['CLIENT_DOCUMENT'];
            $kali->kaliReply($user_doc_id);
            die;
          }
        }
        
        $DOCUMENT_ID = $user_doc_id['FILE_NAME'];
        $PROFILE_PICTURE = $profile_photo_id['FILE_NAME'];

        $PASSWORD = $kali->makeId();
        $HASHED_PASSWORD = $kali->hashPassword($PASSWORD);

        $sql = 'SELECT  `id` FROM `authority` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>"CLIENT"]);
        if($data){
          $AUTHORITY_ID = $data['id'];
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'AUTHORITY NOT FOUND !','TARGET'=>['EMAIL']]);
        }
        
        
        $SQL = 'INSERT INTO `user`(`id`, `authority_refid`, `username`, `first_name`, `middle_name`, `last_name`, `contact_number`, `phone_number`, `address`, `email`,`document_id`, `profile_picture_id`, `edate`) VALUES (:id, :authority_refid, :username, :first_name, :middle_name, :last_name, :contact_number, :phone_number, :address, :email, :document_id, :profile_picture_id, now() );';
        $PUSH_DATA = [
          'id'=>$uq_id,
          'authority_refid'=>$AUTHORITY_ID,
          'username'=>$USERNAME,
          'first_name'=>$FNAME,
          'middle_name'=>$MNAME,
          'last_name'=>$LNAME,
          'contact_number'=>$CONTACT_NUMBER,
          'phone_number'=>$PHONE_NUMBER,
          'address'=>$ADDRESS, 
          'email'=>$EMAIL,
          'document_id'=>$DOCUMENT_ID, 
          'profile_picture_id'=>$PROFILE_PICTURE
        ];

        $SQL2 = 'INSERT INTO `client_edata`(`id`, `user_refid`, `college_limit`, `branch_limit`, `edate`) VALUES (:id, :user_refid, :college_limit, :branch_limit, now() )';
        $PUSH_DATA2 = [
          'id'=>$kali->makeId(),
          'user_refid'=>$uq_id,
          'college_limit'=>$COLLEGE_LIMIT,
          'branch_limit'=>$BRANCH_LIMIT
        ];

        $SQL3 = 'INSERT INTO `user_security`(`id`, `user_refid`, `password`) VALUES (:id, :user_refid, :password) ';
        $PUSH_DATA3 = [
          'id'=>$kali->makeId(),
          'user_refid'=>$uq_id,
          'password'=>$HASHED_PASSWORD,
        ];
        try{
          //$kali->beginTransaction();

            $kali->kaliPush($SQL,$PUSH_DATA);
            $kali->kaliPush($SQL2,$PUSH_DATA2);
            $kali->kaliPush($SQL3,$PUSH_DATA3);
            
            if(mail($EMAIL,'NEW SYSTEMIC ACCOUNT','You Have Sucessfully Created An Account In Systemic. Your Login Password is : '.$PASSWORD)){
              }else{
              $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
            }
      
          //$kali->commit();
        }catch(Exception $e){
          $kali->rollBack();
          echo "Failed: " . $e->getMessage();
        }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'CLIENT ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>