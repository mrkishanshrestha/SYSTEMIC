<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

try{

    if($_POST['JACKX']=='CHECKED'){

        $APPLICATION_NAME = $kali->dataCheck(['DATA'=>'APPLICATION_NAME','CASE'=>'STRING','CHARACTER'=>'UPPER']);

        if(!$kali->isUser(['KING'])){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'YOU ARE NOT KING']);
        }

        //**data checking start */
        $sql = 'SELECT  `name` FROM `application_manifest` WHERE `name`=:name';
        $data = $kali->kaliPull($sql,['name'=>$APPLICATION_NAME]);
        if($data){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Application Name Taken','TARGET'=>['APPLICATION_NAME']]);
        }

        
        $SQL = 'INSERT INTO `application_manifest`(`id`, `uid`, `name`) VALUES (:id, :uid, :name);';
        $PUSH_DATA = [
          'id'=>$kali->makeId(),
          'uid'=>$kali->makeId(),
          'name'=>$APPLICATION_NAME,
        ];

        try{
          //$kali->beginTransaction();
            $kali->kaliPush($SQL,$PUSH_DATA);
          //$kali->commit();
        }catch(Exception $e){
          $kali->rollBack();
          echo "Failed: " . $e->getMessage();
        }

      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'APPLICATION ADDED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>