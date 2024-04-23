<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $COLLEGE_NAME = $kali->dataCheck(['DATA'=>'COLLEGE_NAME','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $BRANCH_NAME = $kali->dataCheck(['DATA'=>'BRANCH_NAME','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $ADDRESS = $kali->dataCheck(['DATA'=>'ADDRESS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $GEO_LOCATION = $kali->dataCheck(['DATA'=>'GEO_LOCATION','CASE'=>'STRING','CHARACTER'=>'CAMEL']);

        $CONTACT_NUMBER = $kali->dataCheck(['DATA'=>'CONTACT_NUMBER','CASE'=>'NUMBER']);
        $PHONE_NUMBER = $kali->dataCheck(['DATA'=>'PHONE_NUMBER','CASE'=>'NUMBER']);
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

        $sql = 'SELECT  `name` FROM `branch` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>$BRANCH_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Branch Name Taken','TARGET'=>['BRANCH_NAME']]);
        }
        
        //**data checking start */

        $COLLEGE_ID = '';
        $sql = 'SELECT  `id` FROM `college` WHERE `short_name`=:short_name';
        $data = $kali->kaliPull($sql,['short_name'=>$COLLEGE_NAME]);
        if($data){
          $COLLEGE_ID=$data['id'];
        }else{
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid College','TARGET'=>['COLLEGE_NAME']]);
        }
        
        // Checking Branch limit count
        $sql = 'SELECT user.id ,client_edata.branch_limit, count(branch.name) as active_branch
        FROM `user` user 
        INNER JOIN `client_edata` client_edata
        INNER JOIN `branch` branch ON branch.college_refid = :college_refid
        WHERE user.id = :id';
        $data = $kali->kaliPull($sql,['id'=>$USER_ID,'college_refid'=>$COLLEGE_ID]);
        if($data){
            if($data['branch_limit']===$data['active_branch']){
              $kali->kaliReply(['ERROR'=>true,'MSG'=>'Creating Branch Limit Has Reached. Contact Admin For More','TARGET'=>['COLLEGE_NAME']]);
            }
        }

        $uq_id = $kali->makeId(); 
        
        $SQL = 'INSERT INTO `branch`(`id`, `college_refid`, `name`, `address`, `geo_location`, `contact_number`, `phone_number`,`faculty_id_x`) VALUES (:id, :college_refid, :name, :address, :geo_location, :contact_number, :phone_number,:faculty_id_x) '; 
        $PUSH_DATA = [
         
          'id'=>$uq_id,
          'college_refid'=>$COLLEGE_ID,
          'name'=>$BRANCH_NAME,
          'address'=>$ADDRESS,
          'geo_location'=>$GEO_LOCATION, 
          'contact_number'=>$CONTACT_NUMBER,
          'phone_number'=>$PHONE_NUMBER,
          'faculty_id_x'=>$FACULTY_NAME,
        ];

        $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'BRANCH ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>