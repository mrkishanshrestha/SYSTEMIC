<?php

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

        if(isset($_POST['SELECT_OPTION'])){
            $sql = 'SELECT `faculty_id_x` FROM `college` WHERE `id`=:id';
            $data = $kali->kaliPull($sql,['id'=>$_POST['COLLEGE_REFID']]);
            if($data){
                $faculty = [];
                $faculty_array = explode(',',$data['faculty_id_x']);
                foreach($faculty_array as $faculty_refid){
                    $sql = 'SELECT `id`,`name` FROM `faculty` WHERE `id`=:id';
                    $data = $kali->kaliPull($sql,['id'=>$faculty_refid]);
                    array_push($faculty,['id'=>$data['id'],'name'=>$data['name']]);
                }
                $kali->kaliReply($faculty);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found','TARGET'=>['COLLEGE_REFID']]);
            }
        }


        die;
                
    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }


?>