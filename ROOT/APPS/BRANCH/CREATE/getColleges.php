<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

    if(isset($_POST['SELECT_OPTION'])){
        $sql = 'SELECT `faculty_id_x` FROM `college` WHERE `short_name`=:short_name';
        $data = $kali->kaliPull($sql,['short_name'=>$_POST['COLLEGE_SHORT_NAME']]);
        if($data){

               $faculty_id_x = explode(',',$data['faculty_id_x']);
               $faculty_short_name=[];
                foreach($faculty_id_x as $faculty_id){

                   $SQL2 = 'SELECT `short_name` FROM `faculty` WHERE `id`=:id';
                   $BIND2 = ['id'=>$faculty_id ];
                   $result2 = $kali->kaliPull($SQL2,$BIND2);
                   array_push($faculty_short_name,$result2['short_name']);
                   
                }

            $kali->kaliReply($faculty_short_name);
        }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found','TARGET'=>['FACULTY']]);
        }
    }


    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>


