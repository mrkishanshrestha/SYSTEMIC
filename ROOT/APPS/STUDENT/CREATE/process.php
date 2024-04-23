<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="STUDENT";
$kali->checkAccess($APPLICATION,'CREATE');

try{


    if($_POST['JACKX']=='CHECKED'){

        $FACULTY_REFID = $kali->dataCheck(['DATA'=>'FACULTY','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $FACULTY_PERIOD = $kali->dataCheck(['DATA'=>'FACULTY_PERIOD','CASE'=>'NUMBER']);
        $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
        $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $GURDIAN_NUMBER = $kali->dataCheck(['DATA'=>'GURDIAN_NUMBER','CASE'=>'NUMBER']);
  
        //get college and branch refid
        $COLLEGE_REFID='';
        $sql = 'SELECT  `college_refid`,`branch_refid`,(SELECT `short_name` FROM `college` WHERE `id`=user.college_refid) as college_shortname FROM `user` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$_SESSION['KOHOMAH']]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong','TARGET'=>['FACULTY']]);
        }
        $COLLEGE_REFID = $data['college_refid'];
        $BRANCH_REFID = $data['branch_refid'];
        $COLLEGE_SHORTNAME = $data['branch_refid'];

        //get faculty id
        $FACULTY="";
        $sql = 'SELECT  `id`,`periods`,`short_name` FROM `faculty` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$FACULTY_REFID]);
        if($data){
          $FACULTY_REFID = $data['id'];
          $FACULTY = $data['short_name'];
          if($FACULTY_PERIOD>$data['periods']){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY PERIOD ','TARGET'=>['FACULTY_PERIOD']]);
          }
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY ','TARGET'=>['FACULTY']]);
        }

        
        //get faculty id          
        $FACULTY_ANNUAL_FEE = 0;
        $FACULTY_ADMISSION_FEE= 0;
        $sql = 'SELECT `id`, `faculty_refid`, `college_refid`, `amount`, `admission_fee` FROM `faculty_finance` WHERE `faculty_refid`=:faculty_refid AND `college_refid`=:college_refid';
        $data = $kali->kaliPull($sql,['faculty_refid'=>$FACULTY_REFID,'college_refid'=>$COLLEGE_REFID]);
        if($data){
          $FACULTY_ANNUAL_FEE = $data['amount'];
          $FACULTY_ADMISSION_FEE= $data['admission_fee'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Error In Faculy Financial Gathering '.$COLLEGE_REFID,'TARGET'=>['FACULTY']]);
        }

        
        $STUDENT_ROLLNO = $kali->makeId(5);
        $STUDENT_IDENTITY = $COLLEGE_SHORTNAME.'_'.strtolower($FACULTY).'_'.$STUDENT_ROLLNO;

        //**data checking start */
        $sql = 'SELECT  `username` FROM `user` WHERE `email`=:email';
        $data = $kali->kaliPull($sql,['email'=>$EMAIL]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Email Taken','TARGET'=>['EMAIL']]);
        }

        $sql = 'SELECT  `username` FROM `user` WHERE `contact_number`=:contact_number ';
        $data = $kali->kaliPull($sql,['contact_number'=>$CONTACT_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
        }

        $sql = 'SELECT  `id` FROM `authority` WHERE `name`=:name ';
        $AUTHORITY_REFID = $kali->kaliPull($sql,['name'=>'STUDENT']);
        if(!$AUTHORITY_REFID){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Something Went Wrong On Creation','TARGET'=>['CONTACT_NUMBER']]);
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
          'authority_refid'=>$AUTHORITY_REFID['id'],
          'college_refid'=>$COLLEGE_REFID,
          'branch_refid'=>$BRANCH_REFID,
          'username'=>$STUDENT_ROLLNO,
          'first_name'=>$FIRST_NAME,
          'middle_name'=>$MIDDLE_NAME,
          'last_name'=>$LAST_NAME,
          'contact_number'=>$CONTACT_NUMBER,
          'phone_number'=>$CONTACT_NUMBER,
          'address'=>$ADDRESS, 
          'email'=>$EMAIL,
          'document_id'=>$USER_DOCUMENT_ID, 
          'profile_picture_id'=>$USER_PROFILE_PICTURE_ID,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      
        $SQL = 'INSERT INTO `student_data`(`id`,`college_refid`, `branch_refid`, `user_refid`, `roll_no`, `gurdian_number`, `join_date`, `faculty_refid`, `faculty_period`) VALUES 
        (:id,:college_refid, :branch_refid, :user_refid, :roll_no, :gurdian_number, now(), :faculty_refid, :faculty_period)'; 
        $PUSH_DATA = [
          'id'=>$kali->makeId(),
          'college_refid'=>$COLLEGE_REFID,
          'branch_refid'=>$BRANCH_REFID,
          'user_refid'=>$uq_id,
          'roll_no'=>$STUDENT_ROLLNO,
          'gurdian_number'=>$GURDIAN_NUMBER,
          'faculty_refid'=>$FACULTY_REFID,
          'faculty_period'=>$FACULTY_PERIOD,
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $SQL3 = 'INSERT INTO `user_security`(`id`, `user_refid`, `password`, `2FA`) VALUES (:id, :user_refid, :password, :2FA) ';
      $PUSH_DATA3 = [
        'id'=>$kali->makeId(),
        'user_refid'=>$uq_id,
        'password'=>$Hashed_Password,
        '2FA'=>'FALSE',
      ];
      $kali->kaliPush($SQL3,$PUSH_DATA3);

      $SQL4 = 'INSERT INTO `financial_statement`(`id`, `user_refid`, `credit_amount`, `description`, `entry_date`) 
      VALUES 
      (:id, :user_refid,:credit_amount, :description, now()) ';
      $PUSH_DATA4 = [
        'id'=>$kali->makeId(),
        'user_refid'=>$uq_id,
        'credit_amount'=>$FACULTY_ADMISSION_FEE,
        'description'=>"COLLEGE ADMISSION FEE",
      ];
      $kali->kaliPush($SQL4,$PUSH_DATA4);

      $FIN_BALACE = $FACULTY_ANNUAL_FEE + $FACULTY_ADMISSION_FEE;
      
      $SQL5 = 'INSERT INTO `financial_statement`(`id`, `user_refid`, `credit_amount`, `description`, `entry_date`) 
      VALUES 
      (:id, :user_refid, :credit_amount, :description, now()) ';
      $PUSH_DATA5 = [
        'id'=>$kali->makeId(),
        'user_refid'=>$uq_id,
        'credit_amount'=>$FACULTY_ANNUAL_FEE,
        'description'=>"COLLEGE ANNUAL FEE",
      ];
      $kali->kaliPush($SQL5,$PUSH_DATA5);

      if(mail($EMAIL,'SYSTEMIC ACCOUNT CREATED','Hello '.$FIRST_NAME.', You Have Sucessfully Created An Account In Systemic. You New Username is '.$STUDENT_ROLLNO.' , Identity is '.$STUDENT_IDENTITY.' And Password Is : '.$PASSWORD,"From:shresthabishal68@gmail.com")){
      }else{
        /* $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);  */
      }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'STUDENT ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>