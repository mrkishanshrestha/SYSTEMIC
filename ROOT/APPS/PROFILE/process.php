<?php 

include_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $USER_REFID = $_SESSION['KOHOMAH'];
        $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
        $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

        $sql = 'SELECT  `phone_number` FROM `user` WHERE ( `phone_number`=:phone_number OR `contact_number`=:phone_number  )AND id!=:id';
        $data = $kali->kaliPull($sql,['phone_number'=>$PHONE_NUMBER,'id'=>$USER_REFID]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Phone Numner Exists','TARGET'=>['PHONE_NUMBER']]);
        }

        $sql = 'SELECT  `phone_number` FROM `user` WHERE ( `phone_number`=:contact_number OR `contact_number`=:contact_number ) AND id!=:id';
        $data = $kali->kaliPull($sql,['contact_number'=>$CONTACT_NUMBER,'id'=>$USER_REFID]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
        }
        
        $sql = 'SELECT  `email` FROM `user` WHERE `email`=:email AND id!=:id';
        $data = $kali->kaliPull($sql,['email'=>$EMAIL,'id'=>$USER_REFID]);;
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Email Already Taken','TARGET'=>['EMAIL']]);
        }

      //**data checking end */
      $SQL = 'UPDATE `user` SET `first_name`=:first_name, `middle_name`=:middle_name, `last_name`=:last_name, `contact_number`=:contact_number, `phone_number`=:phone_number, `address`=:address, `email`=:email WHERE `id`=:id';
    
        $PUSH_DATA = [
          'id'=>$USER_REFID,
          'first_name'=>$FIRST_NAME,
          'middle_name'=>$MIDDLE_NAME,
          'last_name'=>$LAST_NAME,
          'contact_number'=>$CONTACT_NUMBER,
          'phone_number'=>$PHONE_NUMBER,
          'address'=>$ADDRESS, 
          'email'=>$EMAIL
        ];

      $result = $kali->kaliUpdate($SQL,$PUSH_DATA);
      if($result){
          $kali->kaliReply(['ERROR'=>false,'MSG'=>'PROFILE UPDATED SUCESSFULLY']);
          die;
      }

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>