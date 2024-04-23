<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

 
        if(isset($_POST['ATTENDANCE'])){

            
        $BRANCH_ID = $kali->dataCheck(['DATA'=>'BRANCH_ID','CASE'=>'NUMBER']);
        $STUDENT_ID = $kali->dataCheck(['DATA'=>'STUDENT_ID','CASE'=>'NUMBER']);
        $FACULTY = $kali->dataCheck(['DATA'=>'FACULTY','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $FACULTY_PERIOD = $kali->dataCheck(['DATA'=>'FACULTY_PERIOD','CASE'=>'NUMBER']);
        $COURSE = $kali->dataCheck(['DATA'=>'COURSE','CASE'=>'STRING','CHARACTER'=>'UPPER']);
        $STATUS = $kali->dataCheck(['DATA'=>'STATUS','CASE'=>'STRING','CHARACTER'=>'UPPER']);
            //get college id
            $collegeDomain = $kali->getSite();
            $COLLEGE_ID='';
            $sql = 'SELECT  `id` FROM `college` WHERE `domain_cname`=:domain_cname';
            $data = $kali->kaliPull($sql,['domain_cname'=>$collegeDomain]);
            if($data){
            $COLLEGE_ID = $data['id'];
            }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid College ','TARGET'=>['BRANCH']]);
            }


            //get branch id
            $sql = 'SELECT  `id` FROM `branch` WHERE `id`=:branch_id';
            $data = $kali->kaliPull($sql,['branch_id'=>$BRANCH_ID]);
            if($data){
                $BRANCH_ID = $data['id'];
            }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid BRANCH ','TARGET'=>['BRANCH']]);
            }


            //get faculty id
            $FACULTY_ID='';
            $sql = 'SELECT  `id`,`periods` FROM `faculty` WHERE `short_name`=:short_name';
            $data = $kali->kaliPull($sql,['short_name'=>$FACULTY]);
            if($data){
            $FACULTY_ID = $data['id'];
            if($FACULTY_PERIOD>$data['periods']){
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY PERIOD ','TARGET'=>['FACULTY_PERIOD']]);
            }
            }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY ','TARGET'=>['FACULTY']]);
            }

            
            //get faculty id
            $COURSE_ID='';
            $sql = 'SELECT  `id` FROM `course` WHERE `course_code`=:course_code';
            $data = $kali->kaliPull($sql,['course_code'=>$COURSE]);
            if($data){
            $COURSE_ID = $data['id'];
            }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid FACULTY ','TARGET'=>['FACULTY']]);
            }




            
            $currentDate = date("Y-m-d");
            $sql = 'SELECT `id`, `college_id`, `branch_id`, `faculty_id`, `course_id`, `date`, `taken_by`, `status` FROM `student_attendance` 
            WHERE `college_id`=:college_id AND `student_id`=:student_id AND `branch_id`=:branch_id AND `faculty_id`=:faculty_id AND `course_id`=:course_id AND `date`=:currentDate';
            $data = $kali->kaliPull($sql,['college_id'=>$COLLEGE_ID,'branch_id'=>$BRANCH_ID,'faculty_id'=>$FACULTY_ID,'course_id'=>$COURSE_ID,'student_id'=>$STUDENT_ID,'currentDate'=>$currentDate]);
            if($data){

                $SQL = 'UPDATE `student_attendance` SET `status`=:status WHERE `id`=:id '; 
                $PUSH_DATA = [
                  'id'=>$data['id'],
                  'status'=>$STATUS,
                ];
            
              $kali->kaliPush($SQL,$PUSH_DATA);
              
              $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ATTENDANCE DONE']);

            }

            //get student id
            $sql = 'SELECT `id`, `username`, `roll_no`, `first_name`, `middle_name`, `last_name`, `email`, `address`, `contact_number`, `gurdian_number`, `college_id`, `branch_id`, `faculty_id`, `faculty_period`, `profile_picture_id`, `document_id`, `description` FROM `student` WHERE `id`=:id ';
            $data = $kali->kaliPull($sql,['id'=>$STUDENT_ID]);
            if($data){

                                
                    $SQL3 = 'INSERT INTO `student_attendance`(`id`,`student_id`, `college_id`, `branch_id`, `faculty_id`, `course_id`, `date`, `taken_by`, `status`) VALUES (:id, :student_id, :college_id, :branch_id, :faculty_id, :course_id, now(), :taken_by, :status) ';
                    $PUSH_DATA3 = [
                        'id'=>$kali->makeId(),
                        'college_id'=>$COLLEGE_ID,
                        'student_id'=>$STUDENT_ID,
                        'branch_id'=>$BRANCH_ID,
                        'faculty_id'=>$FACULTY_ID,
                        'course_id'=>$COURSE_ID,
                        'taken_by'=>$_SESSION['KOHOMAH'],
                        'status'=>$STATUS
                    ];
                    $kali->kaliPush($SQL3,$PUSH_DATA3);

                    $kali->kaliReply([ "ERROR"=> false,'MSG'=>'ATTENDANCE DONE']);



            }else{
            $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Student Reload Page ','TARGET'=>['FACULTY']]);
            }


        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>


