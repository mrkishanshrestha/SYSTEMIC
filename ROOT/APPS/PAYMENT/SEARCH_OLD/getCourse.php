
<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

 
        if(isset($_POST['SELECT_OPTION'])){

            $sql = 'SELECT course.course_name,course.course_code, ca.id, ca.college_id, ca.course_id, ca.user_id, ca.faculty_id FROM `course_assigned` ca
            INNER JOIN `course` as course ON course.id = ca.course_id
            WHERE `user_id`=:user_id';
            $data = $kali->kaliPulls($sql,['user_id'=>$_SESSION['KOHOMAH']]);
            if($data){
                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found '.$_POST['FACULTY'],'TARGET'=>['FACULTY']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





