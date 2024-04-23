<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{
 
        if(isset($_POST['USER_REFID'])){

            $sql = 'SELECT DISTINCT
                    exam_details.examination_refid, exam.title,exam.year,exam.full_mark, exam.pass_mark
                    FROM `user` 
                    INNER JOIN `student_data` stud_data ON stud_data.user_refid = user.id
                    INNER JOIN `course` course ON course.faculty_id = stud_data.faculty_refid && course.faculty_period = stud_data.faculty_period 
                    INNER JOIN `examination_details` exam_details ON exam_details.course_refid = course.id 
                    INNER JOIN `examination` exam ON exam.id = exam_details.examination_refid 
                    WHERE user.id = :USER_REFID';
            $bind = ['USER_REFID'=>$_POST['USER_REFID']];
            $data = $kali->kaliPulls($sql,$bind);
            if($data){

                $newArray = [];
                $counter = 0;
                foreach($data as $rows){
                    $sql = 'SELECT sum(exam_record.obtained_marks) as total_obtained_marks 
                    FROM `examination_details` exam_details 
                    INNER JOIN `examination_record` exam_record ON exam_record.examination_details_refid = exam_details.id && exam_record.user_refid = :USER_REFID 
                    WHERE exam_details.examination_refid = :examination_refid';
                    $bind = ['USER_REFID'=>$_POST['USER_REFID'],'examination_refid'=>$rows['examination_refid']];
                    $data = $kali->kaliPull($sql,$bind);
                    if($data){
                        $scorePercentage = ($data['total_obtained_marks']/500)*100;
                        $newArray[$counter]=['name'=>$rows['title'],'base_title'=>$rows['title'],'score'=>$scorePercentage];
                    }
                    $counter++;
                }
                $kali->kaliReply($newArray);

            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found ','TARGET'=>['COURSE_REFID']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





