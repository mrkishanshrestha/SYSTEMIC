<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

 
        if(isset($_POST['SEARCH'])){


            $domain = $kali->getSite();
            $sql = 'SELECT `id`, `username`, `roll_no`, `first_name`, `middle_name`, `last_name`, `email`, `address`, `contact_number`, `gurdian_number`, `college_id`, 
            (SELECT `domain_cname` FROM `college` WHERE `domain_cname`=:domain_cname) as collegeDomain,
            `branch_id`, `faculty_id`, `faculty_period`, `profile_picture_id`, `document_id`, `description` FROM `student` WHERE
            `branch_id`=:branch_id AND `faculty_id`=(SELECT `id` FROM `faculty` WHERE `short_name`=:faculty_short_name LIMIT 1) AND `faculty_period`=:faculty_period';
            $data = $kali->kaliPulls($sql,['domain_cname'=>$domain,'branch_id'=>$_POST['BRANCH_ID'],'faculty_short_name'=>$_POST['FACULTY_SHORT_NAME'],'faculty_period'=>$_POST['FACULTY_PERIOD']]);
            if($data){

                $counter = 0;
                $currentDate = date("Y-m-d");
                foreach($data as $rows){

                    $SQL2 = 'SELECT count(`status`) as presentCount FROM `student_attendance` WHERE `student_id`=:student_id AND `branch_id`=:branch_id AND `faculty_id`=:faculty_id AND `course_id`=(SELECT `id` FROM `course` WHERE `course_code`=:course_code limit 1) AND `date`=:currentDate AND `status`="PRESENT" ';
                    $data2 = $kali->kaliPull($SQL2,['student_id'=>$rows['id'],'branch_id'=>$rows['branch_id'],'faculty_id'=>$rows['faculty_id'],'course_code'=>$_POST['COURSE'],'currentDate'=>$currentDate]);
                    if($data2){
                        $data[$counter]['PRESENT_COUNT'] = $data2['presentCount'];
                    }

                    $SQL2 = 'SELECT count(`status`) as absentCount FROM `student_attendance` WHERE `student_id`=:student_id AND `branch_id`=:branch_id AND `faculty_id`=:faculty_id AND `course_id`=(SELECT `id` FROM `course` WHERE `course_code`=:course_code limit 1) AND `date`=:currentDate AND (`status`="ABSENT" || `status`="PENDING") ';
                    $data2 = $kali->kaliPull($SQL2,['student_id'=>$rows['id'],'branch_id'=>$rows['branch_id'],'faculty_id'=>$rows['faculty_id'],'course_code'=>$_POST['COURSE'],'currentDate'=>$currentDate]);
                    if($data2){
                        $data[$counter]['ABSENT_COUNT'] = $data2['absentCount'];
                    }
                    $counter++;
                }

                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found '.$_POST['BRANCH_ID'],'TARGET'=>['FACULTY']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





