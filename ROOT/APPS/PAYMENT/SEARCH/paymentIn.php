<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="PAYMENT";
$kali->checkAccess($APPLICATION,'VIEW');

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'NUMBER']);
    $PAYMENT_AMOUNT = $kali->dataCheck(['DATA'=>'PAYMENT_AMOUNT','CASE'=>'NUMBER']);
    $PAYMENT_DESCRIPTION = $kali->dataCheck(['DATA'=>'PAYMENT_DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

    //**data checking start */
    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }


    $EMAIL="";$FIRST_NAME="";

    $sql = 'SELECT  `id`,`email`,`first_name`,`college_refid`,`branch_refid` FROM `user` WHERE `id`=:user_refid';
    $data = $kali->kaliPull($sql,['user_refid'=>$MY_ID]);
    if($data){
        $MY_ID = $data['id'];
        $EMAIL = $data['email'];
        $FIRST_NAME = $data['first_name'];
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $SQL5 = 'INSERT INTO `financial_statement`(`id`, `user_refid`, `debit_amount`, `description`, `entry_date`)
    VALUES 
    (:id, :user_refid, :debit_amount, :description, now()) ';
    $PUSH_DATA5 = [
      'id'=>$kali->makeId(),
      'user_refid'=>$MY_ID,
      'debit_amount'=>$PAYMENT_AMOUNT,
      'description'=>$PAYMENT_DESCRIPTION,
    ];
    $kali->kaliPush($SQL5,$PUSH_DATA5);

    
    if(mail($EMAIL,'Thank You For Payment','Hello '.$FIRST_NAME.', You Have Sucessfully Deposited Amount Of Rs.'.$PAYMENT_AMOUNT.' in our account For Reason : '.$PAYMENT_DESCRIPTION.' . Thank You - ',"From:mr.kishanshrestha@gmail.com")){
    }else{
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
    }

  $kali->kaliReply([ "ERROR"=> false,'MSG'=>'Payment In Success']);

}






