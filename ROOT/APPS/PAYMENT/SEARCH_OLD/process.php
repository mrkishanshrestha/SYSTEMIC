<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{


    if($_POST['JACKX']=='CHECKED'){

        $BRANCH = $kali->dataCheck(['DATA'=>'BRANCH','CASE'=>'NUMBER']);
        $FACULTY = $kali->dataCheck(['DATA'=>'FACULTY','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $FACULTY_PERIOD = $kali->dataCheck(['DATA'=>'FACULTY_PERIOD','CASE'=>'NUMBER']);
        $FIRST_NAME = $kali->dataCheck(['DATA'=>'FIRST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $MIDDLE_NAME = $kali->dataCheck(['DATA'=>'MIDDLE_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL','NOTREQUIRED'=>true]);
        $LAST_NAME = $kali->dataCheck(['DATA'=>'LAST_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EMAIL = $kali->dataCheck(['DATA'=>'EMAIL','CASE'=>'STRING','CHARACTER'=>'LOWER']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $GURDIAN_NUMBER = $kali->dataCheck(['DATA'=>'GURDIAN_NUMBER','CASE'=>'NUMBER']);
        $DESCRIPTION = $kali->dataCheck(['DATA'=>'DESCRIPTION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);


        //get college id
        $collegeDomain = $kali->getSite();
        $COLLEGE_ID='';
        $sql = 'SELECT  `id` FROM `college` WHERE `domain_cname`=:domain_cname';
        $data = $kali->kaliPull($sql,['domain_cname'=>$collegeDomain]);
        if($data){
          $COLLEGE_ID = $data['id'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid College ','TARGET'=>['BRANCH']]);
        }


        //get branch id
        $BRANCH_ID='';
        $sql = 'SELECT  `id` FROM `branch` WHERE `id`=:branch_id';
        $data = $kali->kaliPull($sql,['branch_id'=>$BRANCH]);
        if($data){
          $BRANCH_ID = $data['id'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid BRANCH ','TARGET'=>['BRANCH']]);
        }


        //get faculty id
        $FACULTY_ID='';
        $sql = 'SELECT  `id`,`periods` FROM `faculty` WHERE `short_name`=:short_name';
        $data = $kali->kaliPull($sql,['short_name'=>$FACULTY]);
        if($data){
          $FACULTY_ID = $data['id'];
          if($FACULTY_PERIOD>$data['periods']){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY PERIOD ','TARGET'=>['FACULTY_PERIOD']]);
          }
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY ','TARGET'=>['FACULTY']]);
        }

        //get faculty id          
        $FACULTY_ANNUAL_FEE = 0;
        $FACULTY_ADMISSION_FEE= 0;
        $sql = 'SELECT `id`, `faculty_id`, `college_id`, `amount`, `admission_fee` FROM `faculty_finance` WHERE `faculty_id`-:faculty_id AND `college_id`=:college_id';
        $data = $kali->kaliPull($sql,['faculty_id'=>$FACULTY_ID,'college_id'=>$COLLEGE_ID]);
        if($data){
          $FACULTY_ANNUAL_FEE = $data['amount'];
          $FACULTY_ADMISSION_FEE= $data['admission_fee'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY ','TARGET'=>['FACULTY']]);
        }

        
        $STUDENT_ROLLNO = $kali->makeId();
        $STUDENT_USERNAME = strtolower($FACULTY).'_'.$STUDENT_ROLLNO.'_'.$collegeDomain;

        //**data checking start */
        $sql = 'SELECT  `username` FROM `student` WHERE `email`=:email';
        $data = $kali->kaliPull($sql,['email'=>$EMAIL]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Email Taken','TARGET'=>['EMAIL']]);
        }

        $sql = 'SELECT  `username` FROM `student` WHERE `gurdian_number`=:gurdian_number OR `contact_number`=:gurdian_number ';
        $data = $kali->kaliPull($sql,['gurdian_number'=>$GURDIAN_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Phone Number Taken','TARGET'=>['PHONE_NUMBER']]);
        }
        
        $sql = 'SELECT  `username` FROM `student` WHERE `contact_number`=:contact_number OR `gurdian_number`=:contact_number';
        $data = $kali->kaliPull($sql,['contact_number'=>$CONTACT_NUMBER]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Contact Number Taken','TARGET'=>['CONTACT_NUMBER']]);
        }


        //**data checking end */
        $USER_PROFILE_PICTURE;
        $USER_DOCUMENT;
        if(isset($_FILES['USER_PROFILE_PICTURE'])){
          $USER_PROFILE_PICTURE = $kali->uploadFIle(['FILE'=>$_FILES['USER_PROFILE_PICTURE'],'DIR'=>'CLIENTS/COLLEGES/'.strtoupper($collegeDomain).'/STUDENT','FOLDER'=>$STUDENT_ROLLNO,'TYPE'=>'IMAGE']);
          if($USER_PROFILE_PICTURE['ERROR']){
            $USER_PROFILE_PICTURE['TARGET']=['USER_PROFILE_PICTURE'];
            $kali->kaliReply($USER_PROFILE_PICTURE);
            die;
          }
        }

        if(isset($_FILES['USER_DOCUMENT'])){
          $USER_DOCUMENT =  $kali->uploadFIle(['FILE'=>$_FILES['USER_PROFILE_PICTURE'],'DIR'=>'CLIENTS/COLLEGES/'.strtoupper($collegeDomain).'/STUDENT','FOLDER'=>$STUDENT_ROLLNO,'TYPE'=>'IMAGE']);
          if($USER_DOCUMENT['ERROR']){
            $USER_DOCUMENT['TARGET']=['USER_DOCUMENT'];
            $kali->kaliReply($USER_DOCUMENT);
            die;
          }
        }

        $USER_PROFILE_PICTURE_ID = $USER_PROFILE_PICTURE['FILE_NAME'];
        $USER_DOCUMENT_ID = $USER_DOCUMENT['FILE_NAME'];

        $uq_id = $kali->makeId(); 
        $siteName = $kali->getSite();
        $PASSWORD = $kali->makeId();


        $SQL = 'INSERT INTO `student`(`id`, `username`, `roll_no`, `first_name`, `middle_name`, `last_name`, `email`, `address`, `contact_number`, `gurdian_number`, `college_id`, `branch_id`, `faculty_id`, `faculty_period`, `profile_picture_id`, `document_id`,`description`) VALUES (:id, :username, :roll_no, :first_name, :middle_name, :last_name, :email, :address, :contact_number, :gurdian_number, :college_id, :branch_id, :faculty_id, :faculty_period, :profile_picture_id, :document_id, :description)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'username'=>$STUDENT_USERNAME,
          'roll_no'=>$STUDENT_ROLLNO,
          'first_name'=>$FIRST_NAME,
          'middle_name'=>$MIDDLE_NAME,
          'last_name'=>$LAST_NAME,
          'email'=>$EMAIL,
          'address'=>$ADDRESS, 
          'contact_number'=>$CONTACT_NUMBER,
          'gurdian_number'=>$GURDIAN_NUMBER,
          'college_id'=>$COLLEGE_ID,
          'branch_id'=>$BRANCH_ID,
          'faculty_id'=>$FACULTY_ID,
          'faculty_period'=>$FACULTY_PERIOD,
          'description'=>$DESCRIPTION,
          'document_id'=>$USER_DOCUMENT_ID, 
          'profile_picture_id'=>$USER_PROFILE_PICTURE_ID
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $SQL3 = 'INSERT INTO `user_security`(`id`, `user_id`, `password`) VALUES (:id, :user_id, :password) ';
      $PUSH_DATA3 = [
        'id'=>$kali->makeId(),
        'user_id'=>$uq_id,
        'password'=>$PASSWORD,
      ];
      $kali->kaliPush($SQL3,$PUSH_DATA3);

      
      $SQL4 = 'INSERT INTO `student_financial_record`(`id`, `student_id`, `college_id`, `credit_amount`, `description`, `entry_date`) 
      VALUES 
      (:id, :student_id, :college_id, :credit_amount, :description, now()) ';
      $PUSH_DATA4 = [
        'id'=>$kali->makeId(),
        'student_id'=>$uq_id,
        'college_id'=>$COLLEGE_ID,
        'credit_amount'=>$FACULTY_ADMISSION_FEE,
        'description'=>"COLLEGE ADMISSION fEE",
      ];
      $kali->kaliPush($SQL4,$PUSH_DATA4);

      $FIN_BALACE = $FACULTY_ANNUAL_FEE + $FACULTY_ADMISSION_FEE;
      
      $SQL5 = 'INSERT INTO `student_financial_record`(`id`, `student_id`, `college_id`, `credit_amount`, `description`, `entry_date`) 
      VALUES 
      (:id, :student_id, :college_id, :credit_amount, :description, now()) ';
      $PUSH_DATA5 = [
        'id'=>$kali->makeId(),
        'student_id'=>$uq_id,
        'college_id'=>$COLLEGE_ID,
        'credit_amount'=>$FACULTY_ANNUAL_FEE,
        'description'=>"COLLEGE ANNUAL fEE",
      ];
      $kali->kaliPush($SQL5,$PUSH_DATA5);



      if(mail($EMAIL,$siteName,'Hello '.$FIRST_NAME.', You Have Sucessfully Created An Account In '.$collegeDomain.'. You New Username is '.$STUDENT_USERNAME.' And Password Is : '.$PASSWORD,"From:shresthabishal68@gmail.com")){
      }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
      }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'STUDENT ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>