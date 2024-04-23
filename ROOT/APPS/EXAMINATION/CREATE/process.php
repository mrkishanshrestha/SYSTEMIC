<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="EXAMINATION";
$kali->checkAccess($APPLICATION,'CREATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $EXAMINATION_TITLE = $kali->dataCheck(['DATA'=>'EXAMINATION_TITLE','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EXAMINATION_YEAR = $kali->dataCheck(['DATA'=>'EXAMINATION_YEAR','CASE'=>'NUMBER','CHARACTER'=>'CAMEL']);;

        $sql = 'SELECT `college_refid`, `branch_refid`  FROM `user` WHERE `id`=:id ';
        $data22 = $kali->kaliPull($sql,['id'=>$_SESSION['KOHOMAH']]);
        if(!$data22){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'SYSTEM ERROR !','TARGET'=>['EXAMINATION_TITLE','EXAMINATION_YEAR']]);
        }

        $sql = 'SELECT `id` FROM `examination` WHERE `title`=:title && `year`=:year && `college_refid`=:college_refid && `branch_refid`=:branch_refid';
        $data = $kali->kaliPull($sql,['title'=>$EXAMINATION_TITLE,'year'=>$EXAMINATION_YEAR,'college_refid'=>$data22['college_refid'],'branch_refid'=>$data22['branch_refid']]);
        if($data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Already Exixts Of Same Value','TARGET'=>['EXAMINATION_TITLE','EXAMINATION_YEAR']]);
        }

        $uq_id = $kali->makeId(); 

        $SQL = 'INSERT INTO `examination`(`id`, `title`, `year`, `college_refid`, `branch_refid`) 
         VALUES (:id, :title, :year, :college_refid, :branch_refid)'; 
        $PUSH_DATA = [
          'id'=>$uq_id,
          'title'=>$EXAMINATION_TITLE,
          'year'=>$EXAMINATION_YEAR,
          'college_refid'=>$data22['college_refid'],
          'branch_refid'=>$data22['branch_refid'],
        ];

      $kali->kaliPush($SQL,$PUSH_DATA);

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'EXAMINATION ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>