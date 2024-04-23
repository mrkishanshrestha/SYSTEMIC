<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="COLLEGE";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $COLLEGE_AFFILIATION = $kali->dataCheck(['DATA'=>'COLLEGE_AFFILIATION','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $COLLEGE_NAME = $kali->dataCheck(['DATA'=>'COLLEGE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COLLEGE_SHORT_NAME = $kali->dataCheck(['DATA'=>'COLLEGE_SHORT_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $GEO_LOCATION = $kali->dataCheck(['DATA'=>'GEO_LOCATION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $COLLEGE_EMAIL = $kali->dataCheck(['DATA'=>'GEO_LOCATION','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
        $EST_DATE = $_POST['EST_DATE'];
        $DESCRIPTION = $kali->dataCheck(['DATA'=>'DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $DOMAIN_CNAME = $kali->dataCheck(['DATA'=>'DOMAIN_CNAME','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $FACULTY_ARRAY = $kali->dataCheck(['DATA'=>'FACULTY_ARRAY','CASE'=>'ARRAY']);
        $USER_ID = $_SESSION['KOHOMAH'];


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

        $sql = 'SELECT  `name` FROM `college` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>$COLLEGE_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'College Name Taken','TARGET'=>['COLLEGE_NAME']]);
        }
        
        //**data checking start */

        // Checking College limit count
        $sql = 'SELECT user.id, client_edata.college_limit, count(college.name) as active_college
        FROM `user` user 
        INNER JOIN `client_edata` client_edata
        INNER JOIN 	`college` college
        ON client_edata.user_refid = user.id && college.user_refid = user.id WHERE user.id=:id;';
        $data = $kali->kaliPull($sql,['id'=>$USER_ID]);
        if($data){
            if($data['college_limit']===$data['active_college']){
              $kali->kaliReply(['ERROR'=>true,'MSG'=>'Creating College Limit Has Reached. Contact Admin For More','TARGET'=>['COLLEGE_NAME']]);
            }
        }

        $sql = 'SELECT  `name` FROM `college` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>$COLLEGE_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'College Name Taken','TARGET'=>['COLLEGE_NAME']]);
        }

        $sql = 'SELECT  `name` FROM `college` WHERE `domain_cname`=:domain_cname';
        $data = $kali->kaliPull($sql,['domain_cname'=>$DOMAIN_CNAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Domain Cname Taken','TARGET'=>['DOMAIN_CNAME']]);
        }


        $uq_id = $kali->makeId(); 
        
        //**data checking end */
        $COLLEGE_BACKGROUND_IMAGE;
        $COLLEGE_LOGO;
        if(isset($_FILES['COLLEGE_BACKGROUND_IMAGE'])){
          $COLLEGE_BACKGROUND_IMAGE = $kali->uploadFIle(['FILE'=>$_FILES['COLLEGE_BACKGROUND_IMAGE'],'DIR'=>'ROOT/DATA/COLLEGE_DATA/'.$uq_id,'TYPE'=>'IMAGE']);
          if($COLLEGE_BACKGROUND_IMAGE['ERROR']){
            $COLLEGE_BACKGROUND_IMAGE['TARGET']=['COLLEGE_BACKGROUND_IMAGE'];
            $kali->kaliReply($COLLEGE_BACKGROUND_IMAGE);
            die;
          }
        }

        if(isset($_FILES['COLLEGE_LOGO'])){
          $COLLEGE_LOGO =  $kali->uploadFIle(['FILE'=>$_FILES['COLLEGE_LOGO'],'DIR'=>'ROOT/DATA/COLLEGE_DATA/'.$uq_id,'TYPE'=>'IMAGE']);
          if($COLLEGE_LOGO['ERROR']){
            $COLLEGE_LOGO['TARGET']=['COLLEGE_LOGO'];
            $kali->kaliReply($COLLEGE_LOGO);
            die;
          }
        }

        $COLLEGE_BACKGROUND_IMAGE_ID = $COLLEGE_BACKGROUND_IMAGE['FILE_NAME'];
        $COLLEGE_LOGO_ID = $COLLEGE_LOGO['FILE_NAME'];

        
        
        $SQL = 'INSERT INTO `college`(`id`, `user_refid`, `name`, `short_name`, `email`,`contact_number`, `phone_number`, `address`, `geo_location`, `est_date`, `affiliation`, `description`, `college_logo`, `college_background_image`, `domain_cname`, `faculty_id_x`, `entry_date`) VALUES (:id, :user_refid, :name, :short_name, :email,:contact_number, :phone_number, :address, :geo_location, :est_date, :affiliation, :description, :college_logo, :college_background_image, :domain_cname, :faculty_id_x, now())'; 
        $PUSH_DATA = [
         
          'id'=>$uq_id,
          'user_refid'=>$USER_ID,
          'name'=>$COLLEGE_NAME,
          'short_name'=>$COLLEGE_SHORT_NAME,
          'email'=>$COLLEGE_EMAIL,
          'contact_number'=>$CONTACT_NUMBER,
          'phone_number'=>$PHONE_NUMBER,
          'address'=>$ADDRESS,
          'geo_location'=>$GEO_LOCATION, 
          'est_date'=>$EST_DATE,
          'affiliation'=>$COLLEGE_AFFILIATION, 
          'description'=>$DESCRIPTION,
          'college_logo'=>$COLLEGE_LOGO_ID,
          'college_background_image'=>$COLLEGE_BACKGROUND_IMAGE_ID,
          'domain_cname'=>$DOMAIN_CNAME,
          'faculty_id_x'=>$FACULTY_NAME,
        ];

        $kali->kaliPush($SQL,$PUSH_DATA);

      if(mail($COLLEGE_EMAIL,'Hello World','Your College Has Been Sucessfully Registered In SYSTEMIC.')){
      }else{
        //$kali->kaliReply(['ERROR'=>true,'MSG'=>'Failed While Sending Email']);
      }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'COLLGE REGISTERED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>