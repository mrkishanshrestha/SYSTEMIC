<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $COLLEGE_AFFILIATION = $_POST['COLLEGE_AFFILIATION'];
        $COLLEGE_NAME = $_POST['COLLEGE_NAME'];
        $COLLEGE_SHORT_NAME = $_POST['COLLEGE_SHORT_NAME'];
        $ADDRESS = $_POST['ADDRESS'];
        $GEO_LOCATION = $_POST['GEO_LOCATION'];
        $COLLEGE_EMAIL = $_POST['COLLEGE_EMAIL'];
        $CONTACT_NUMBER = $_POST['CONTACT_NUMBER'];
        $PHONE_NUMBER = $_POST['PHONE_NUMBER'];
        $EST_DATE = $_POST['EST_DATE'];
        $DESCRIPTION = $_POST['DESCRIPTION'];
        $DOMAIN_CNAME = $_POST['DOMAIN_CNAME'];
        $USER_ID = $_SESSION['KOHOMAH'];

        //**data checking start */

        $sql = 'SELECT client.college_limit, count(cole.name) as activeColleges FROM `client` INNER JOIN college cole ON cole.user_id = client.id WHERE client.id=:id';
        $data = $kali->kaliPull($sql,['id'=>$USER_ID]);
        if($data){
            if($data['college_limit']==$data['activeColleges']){
              $kali->kaliReply(['ERROR'=>true,'MSG'=>'College Creating Limit Reached. Contact Admin For More','TARGET'=>['COLLEGE_NAME']]);
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

      //**data checking end */

        $COLLEGE_BACKGROUND_IMAGE;
        $COLLEGE_LOGO;
        if(isset($_FILES['COLLEGE_BACKGROUND_IMAGE'])){
          $COLLEGE_BACKGROUND_IMAGE = $kali->uploadFIle($_FILES['COLLEGE_BACKGROUND_IMAGE'],['DIR'=>'CLIENTS/COLLEGES/'.$DOMAIN_CNAME,'FOLDER'=>'IMG']);
          if($COLLEGE_BACKGROUND_IMAGE['ERROR']){
            $COLLEGE_BACKGROUND_IMAGE['TARGET']=['COLLEGE_BACKGROUND_IMAGE'];
            $kali->kaliReply($COLLEGE_BACKGROUND_IMAGE);
            die;
          }
        }

        if(isset($_FILES['COLLEGE_LOGO'])){
          $COLLEGE_LOGO =  $kali->uploadFIle($_FILES['COLLEGE_BACKGROUND_IMAGE'],['DIR'=>'CLIENTS/COLLEGES/'.$DOMAIN_CNAME,'FOLDER'=>'IMG']);
          if($COLLEGE_LOGO['ERROR']){
            $COLLEGE_LOGO['TARGET']=['COLLEGE_LOGO'];
            $kali->kaliReply($COLLEGE_LOGO);
            die;
          }
        }


        $COLLEGE_BACKGROUND_IMAGE_ID = $COLLEGE_BACKGROUND_IMAGE['FILE_NAME'];
        $COLLEGE_LOGO_ID = $COLLEGE_LOGO['FILE_NAME'];

        $uq_id = $kali->makeId(); 
        
        $SQL = 'INSERT INTO `college`(`id`, `user_id`, `name`, `short_name`, `email`, `address`, `geo_location`, `est_date`, `affiliation`, `description`, `college_logo`, `college_background_image`, `domain_cname`, `entry_date`) VALUES (:id, :user_id, :name, :short_name, :email, :address, :geo_location, :est_date, :affiliation, :description, :college_logo, :college_background_image, :domain_cname, now())'; 
        $PUSH_DATA = [
         
          'id'=>$uq_id,
          'user_id'=>$USER_ID,
          'name'=>$COLLEGE_NAME,
          'short_name'=>$COLLEGE_SHORT_NAME,
          'email'=>$COLLEGE_EMAIL,
          'address'=>$ADDRESS,
          'geo_location'=>$GEO_LOCATION, 
          'est_date'=>$EST_DATE,
          'affiliation'=>$COLLEGE_AFFILIATION, 
          'description'=>$DESCRIPTION,
          'college_logo'=>$COLLEGE_LOGO_ID,
          'college_background_image'=>$COLLEGE_BACKGROUND_IMAGE_ID,
          'domain_cname'=>$DOMAIN_CNAME,
        ];

        $kali->kaliPush($SQL,$PUSH_DATA);


      if(mail($COLLEGE_EMAIL,'Hello World','You Have Sucessfully Created An Account In Systemic.',"From:shresthabishal68@gmail.com")){
      }else{
        $kali->kaliReply(['ERROR'=>true,'MSG'=>'Sending Mail Failed']);
      }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'USER ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>