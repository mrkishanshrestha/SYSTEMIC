
<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{
        if(isset($_POST['SELECT_OPTION'])){

            $sql = 'SELECT course.course_name,course.course_code, ca.id, ca.college_id, ca.course_id, ca.user_id, ca.faculty_id,course.faculty_period FROM `course_assigned` ca
            INNER JOIN `course` as course ON course.id = ca.course_id
            WHERE `user_id`=:user_id AND course.faculty_period=:faculty_period AND  ca.faculty_id=(SELECT `id` FROM `faculty` WHERE `short_name`=:short_name LIMIT 1)';
            $data = $kali->kaliPulls($sql,['user_id'=>$_SESSION['KOHOMAH'],'faculty_period'=>$_POST['FACULTY_PERIOD'],'short_name'=>$_POST['FACULTY']]);
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





