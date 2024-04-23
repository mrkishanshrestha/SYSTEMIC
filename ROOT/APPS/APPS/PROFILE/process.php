<?php 

include_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'NUMBER']);
        $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
        $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        if($_SESSION['MY_POST']=="STUDENT"){
            $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'GURDIAN_NUMBER','CASE'=>'NUMBER']);
        }else {
          $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
        }
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $DESCRIPTION = $kali->dataCheck(['DATA'=>'DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

        
        $NEW_PASSWORD = $kali->dataCheck(['DATA'=>'NEW_PASSWORD','CASE'=>'STRING','CHARACTER'=>'LOWER','NOTREQUIRED'=>true]);


      $table="";
      if($_SESSION['MY_POST']=="STUDENT"){
        $table="student";
      }elseif($_SESSION['MY_POST']=="CLIENT"){
        $table="client";
      }else{
        $table="user";
      }


        $SQL = ' UPDATE '.$table.' SET `first_name`=:first_name,`middle_name`=:middle_name,`last_name`=:last_name,`contact_number`=:contact_number,`address`=:address,`email`=:email,`description`=:description WHERE `id`=:id'; //`document_id`=:document_id,`profile_picture_id`=:profile_picture_id,
        $PUSH_DATA = [
    
          'id'=>$MY_ID,
          'first_name'=>$FIRST_NAME,
          'middle_name'=>$MIDDLE_NAME,
          'last_name'=>$LAST_NAME,
          'contact_number'=>$CONTACT_NUMBER,
          'address'=>$ADDRESS,
          'email'=>$EMAIL,
          'description'=>$DESCRIPTION,
    
         // 'profile_picture_id'=>$NEW_USER_PROFILE_PICTURE,
         // 'document_id'=>$NEW_USER_DOCUMENT,
        ];
    
      $kali->kaliPush($SQL,$PUSH_DATA);

      if($NEW_PASSWORD!=""){

        $SQL3 = 'UPDATE `user_security` SET `password`=:password WHERE `user_id`=:user_id';
        $PUSH_DATA3 = [
          'user_id'=>$MY_ID,
          'password'=>$NEW_PASSWORD,
        ];
        
        $kali->kaliPush($SQL3,$PUSH_DATA3);
        
        if(mail($EMAIL,'PASSWORD CHANGE IN '.strtoupper($kali->getSite()),'Hello '.$FIRST_NAME.', You Have Sucessfully Changed YOur Password. And Your New Password  Is : '.$NEW_PASSWORD,"From:shresthabishal68@gmail.com")){
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
        }

      }


      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'CLIENT ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>