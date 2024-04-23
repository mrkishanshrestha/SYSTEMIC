<?php

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

if(isset($_POST['UPDATE']) && $_POST['UPDATE']=="JACKX_UPDATE"){

    $MY_ID = $kali->dataCheck(['DATA'=>'DB_TUPLE_ID','CASE'=>'STRING','NOTREQUIRED']);
    $COLLEGE_NAME = $kali->dataCheck(['DATA'=>'COLLEGE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $SHORT_NAME = $kali->dataCheck(['DATA'=>'SHORT_NAME','CASE'=>'STRING','CHARACTER'=>'UPPER']);
    $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $GEO_LOCATION = $kali->dataCheck(['DATA'=>'GEO_LOCATION','CASE'=>'STRING','CHARACTER'=>'LOWER']);
    $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
    $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
    $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
    $AFFILIATION = $kali->dataCheck(['DATA'=>'AFFILIATION','CASE'=>'STRING','CHARACTER'=>'UPPER']);
    $DESCRIPTION = $kali->dataCheck(['DATA'=>'DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
    $DOMAIN_CNAME = $kali->dataCheck(['DATA'=>'DOMAIN_CNAME','CASE'=>'STRING','CHARACTER'=>'UPPER']);
    $FACULTY_ARRAY = $kali->dataCheck(['DATA'=>'FACULTY_ARRAY','CASE'=>'STRING','CHARACTER'=>'UPPER']);

    $NEW_COLLEGE_LOGO="";
    $NEW_COLLEGE_BACKGROUND="";
    //**data checking start */
    if($MY_ID==""){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $FACULTY_ARRAY = explode(',',$FACULTY_ARRAY);
    $FACULTY_ID_ARRAY=[];

    foreach($FACULTY_ARRAY as $FACULTY){
      
      $sql = 'SELECT `id` FROM `faculty` WHERE `short_name`=:short_name';
      $data = $kali->kaliPull($sql,['short_name'=>$FACULTY]);
      if($data){
        array_push($FACULTY_ID_ARRAY,$data['id']);
      }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FAculty','TARGET'=>['FACULTY_ARRAY']]);
      }

    }

    $FACULTY_NAME = implode(',',$FACULTY_ID_ARRAY);
  
    $sql = 'SELECT  `id`,`college_background_image`,`college_logo`,`domain_cname` FROM `college` WHERE `id`=:id';
    $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
    if($data){
        $MY_ID = $data['id'];
        $NEW_COLLEGE_LOGO=$data['college_logo'];
        $NEW_COLLEGE_BACKGROUND=$data['college_background_image'];
        $DOMAIN_CNAME =$data['domain_cname']; 
    }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
    }

    $sql = 'SELECT  `name` FROM `college` WHERE `name`=:name AND `id`!=:id';
    $data = $kali->kaliPull($sql,['name'=>$COLLEGE_NAME,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Collehe Name Taken','TARGET'=>['COLLEGE_NAME']]);
    }

    $sql = 'SELECT  `name` FROM `college` WHERE `short_name`=:short_name AND `id`!=:id';
    $data = $kali->kaliPull($sql,['short_name'=>$SHORT_NAME,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'College Short Name Taken','TARGET'=>['SHORT_NAME']]);
    }

    $sql = 'SELECT  `name` FROM `college` WHERE `domain_cname`=:domain_cname AND `id`!=:id';
    $data = $kali->kaliPull($sql,['domain_cname'=>$DOMAIN_CNAME,'id'=>$MY_ID]);
    if($data){
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'College Domain Cname Taken','TARGET'=>['DOMAIN_CNAME']]);
    }

    
    //IF FILE IS SENT
    if(isset($_FILES['LOGO'])){

        $sql = 'SELECT `college_logo` FROM `college` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
        if($data){
            $dir = 'D:/CODE/DEPLOY/SYSTEMIC/ROOT/DATA/COLLEGE_DATA/'.$MY_ID.'/'.$data['college_logo'];
            if(file_exists($dir)){
                unlink($dir);
            }
    
            $COLLEGE_LOGO =  $kali->uploadFIle(['FILE'=>$_FILES['LOGO'],'DIR'=>'ROOT/DATA/COLLEGE_DATA/'.$MY_ID,'TYPE'=>'IMAGE']);
            if($COLLEGE_LOGO['ERROR']){
              $COLLEGE_LOGO['TARGET']=['LOGO'];
              $kali->kaliReply($COLLEGE_LOGO);
              die;
            }
    
            $NEW_COLLEGE_LOGO = $COLLEGE_LOGO['FILE_NAME'];
        }

    }

        
    //IF FILE IS SENT
    if(isset($_FILES['BACKGROUND'])){

        $sql = 'SELECT `college_background_image` FROM `college` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$MY_ID]);
        if($data){

            $dir = 'D:/CODE/DEPLOY/SYSTEMIC/ROOT/DATA/COLLEGE_DATA/'.$MY_ID.'/'.$data['college_background_image'];
            if(file_exists($dir)){
                unlink($dir);
            }
    
            $COLLEGE_BACKGROUND =  $kali->uploadFIle(['FILE'=>$_FILES['BACKGROUND'],'DIR'=>'ROOT/DATA/COLLEGE_DATA/','TYPE'=>'IMAGE','FOLDER'=>$MY_ID]);
            if($COLLEGE_BACKGROUND['ERROR']){
              $COLLEGE_BACKGROUND['TARGET']=['LOGO'];
              $kali->kaliReply($COLLEGE_BACKGROUND);
              die;
            }
    
            $NEW_COLLEGE_BACKGROUND = $COLLEGE_BACKGROUND['FILE_NAME'];
        }

    }

    $SQL = 'UPDATE `college` SET `name`=:name,`short_name`=:short_name,`address`=:address,`geo_location`=:geo_location,`contact_number`=:contact_number,`phone_number`=:phone_number,`email`=:email,`affiliation`=:affiliation,`description`=:description,`college_logo`=:college_logo,`college_background_image`=:college_background_image,`domain_cname`=:domain_cname, `faculty_id_x`=:faculty_id_x WHERE `id`=:id AND `user_refid`=:user_refid'; 
    $PUSH_DATA = [
      'id'=>$MY_ID,
      'user_refid'=>$_SESSION['KOHOMAH'],

      'name'=>$COLLEGE_NAME,
      'short_name'=>$SHORT_NAME,
      'address'=>$ADDRESS,
      'geo_location'=>$GEO_LOCATION,
      'contact_number'=>$CONTACT_NUMBER,
      'phone_number'=>$PHONE_NUMBER,
      'email'=>$EMAIL,
      'affiliation'=>$AFFILIATION,
      'description'=>$DESCRIPTION,
      'domain_cname'=>$DOMAIN_CNAME,
      'faculty_id_x'=>$FACULTY_NAME,

      'college_logo'=>$NEW_COLLEGE_LOGO,
      'college_background_image'=>$NEW_COLLEGE_BACKGROUND,
    ];


  $kali->kaliPush($SQL,$PUSH_DATA);

  $kali->kaliReply([ "ERROR"=> false,'MSG'=>'FACULTY UPDATED SUCESSFULLY']);

}






