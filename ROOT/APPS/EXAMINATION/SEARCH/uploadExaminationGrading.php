<?php 

require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="EXAMINATION";
$kali->checkAccess($APPLICATION,'UPDATE');

try{

    if($_POST['JACKX']=='CHECKED'){

        $USER_REFID = $kali->dataCheck(['DATA'=>'USER_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EXAMINATION_DEATILS_REFID = $kali->dataCheck(['DATA'=>'EXAMINATION_DEATILS_REFID','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EXAMINATION_REMARKS = $kali->dataCheck(['DATA'=>'EXAMINATION_REMARKS','CASE'=>'STRING','CHARACTER'=>'CAMEL']);
        $EXAMINATION_MARKS = $kali->dataCheck(['DATA'=>'EXAMINATION_MARKS','CASE'=>'NUMBER','CHARACTER'=>'CAMEL']);

        $sql = 'SELECT `full_marks`, `pass_marks` FROM `examination_details` WHERE `id`=:EXAMINATION_DEATILS_REFID ';
        $data = $kali->kaliPull($sql,['EXAMINATION_DEATILS_REFID'=>$EXAMINATION_DEATILS_REFID]);
        if(!$data){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Examination','TARGET'=>['EXAMINATION_RECORD_REFID']]);
        }

        if($data['full_marks']<$EXAMINATION_MARKS){
          $kali->kaliReply(['ERROR'=>true,'MSG'=>'Grade Greater Than Total Mark','TARGET'=>['EXAMINATION_MARKS']]);
        }

        $STATUS="FAIL";
        if($EXAMINATION_MARKS>=$data['pass_marks']){
          $STATUS="PASS";
        }

        $sql = 'SELECT `id` FROM `examination_record` WHERE `examination_details_refid`= :EXAMINATION_DEATILS_REFID AND `user_refid`=:USER_REFID';
        $data = $kali->kaliPull($sql,['EXAMINATION_DEATILS_REFID'=>$EXAMINATION_DEATILS_REFID,'USER_REFID'=>$USER_REFID]);
        if($data){

          $SQL = 'UPDATE `examination_record` SET 
          `obtained_marks`=:obtained_marks,`remarks`=:remarks, `status`=:status
           WHERE `examination_details_refid`=:EXAMINATION_RECORD_REFID AND `user_refid`=:USER_REFID';
          $PUSH_DATA = [
            'obtained_marks'=>$EXAMINATION_MARKS,
            'remarks'=>$EXAMINATION_REMARKS,
            'status'=>$STATUS,
            'EXAMINATION_RECORD_REFID'=>$EXAMINATION_DEATILS_REFID,
            'USER_REFID'=>$USER_REFID,
          ];

        }else{

          $SQL = 'INSERT INTO `examination_record`
            (`id`, `examination_details_refid`, `user_refid`, `obtained_marks`, `status`, `remarks`)
            VALUES (:id, :examination_details_refid, :user_refid, :obtained_marks, :status, :remarks)';
            $PUSH_DATA = [
              'id'=>$kali->makeId(),
              'examination_details_refid'=>$EXAMINATION_DEATILS_REFID ,
              'user_refid'=>$USER_REFID,
              'obtained_marks'=>$EXAMINATION_MARKS,
              'status'=>$STATUS,
              'remarks'=>$EXAMINATION_REMARKS,
            ];
            
        }

      $kali->kaliPush($SQL,$PUSH_DATA);
      $kali->kaliReply([ "ERROR"=> false,'MSG'=>'EXAMINATION GRADED SUCESSFULLY']);

    }

  }catch(Exception $e){
    die($e->getMessage());
  }

?>