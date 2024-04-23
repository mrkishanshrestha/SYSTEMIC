<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

 
        if(isset($_POST['SEARCH'])){


            if($_SESSION['MY_AUTHORITY']=="STUDENT"){

                $sql = 'SELECT DISTINCT  student_attendance.user_refid , user.username, user.first_name,
                        user.last_name, user.middle_name, user.profile_picture_id, student_data.roll_no  
                        FROM `student_attendance` student_attendance
                        INNER JOIN `user` user ON user.id = student_attendance.user_refid
                        INNER JOIN `student_data` student_data ON student_data.user_refid = student_attendance.user_refid
                        WHERE `course_refid`= :course_refid AND student_data.user_refid=:STUDENT_REFID';
                $bind = ['course_refid'=>$_POST['COURSE_REFID'],'STUDENT_REFID'=>$_SESSION['KOHOMAH']];

            }else{

                $sql = 'SELECT DISTINCT  student_attendance.user_refid , user.username, user.first_name,
                        user.last_name, user.middle_name, user.profile_picture_id, student_data.roll_no  
                        FROM `student_attendance` student_attendance
                        INNER JOIN `user` user ON user.id = student_attendance.user_refid
                        INNER JOIN `student_data` student_data ON student_data.user_refid = student_attendance.user_refid
                        WHERE `course_refid`= :course_refid';
                $bind = ['course_refid'=>$_POST['COURSE_REFID']];

            }

            $data = $kali->kaliPulls($sql,$bind);
            if($data){

                $counter = 0; 
                $rdata = [];
                foreach($data as $rows){

                    if($_POST['START_DATE']=="" && $_POST['END_DATE']==""){
                        $SQL2 = 'SELECT count(`status`) as presentCount FROM `student_attendance` WHERE `user_refid`=:user_refid AND `course_refid`= :course_refid AND `status`="PRESENT" ';
                        $data2 = $kali->kaliPull($SQL2,['user_refid'=>$rows['user_refid'],'course_refid'=>$_POST['COURSE_REFID']]);
                        if($data2){
                            $data[$counter]['PRESENT_COUNT'] = $data2['presentCount'];
                        }
    
                        $SQL2 = 'SELECT count(`status`) as absentCount FROM `student_attendance` WHERE `user_refid`=:user_refid AND `course_refid`= :course_refid AND (`status`="ABSENT" || `status`="PENDING") ';
                        $data2 = $kali->kaliPull($SQL2,['user_refid'=>$rows['user_refid'],'course_refid'=>$_POST['COURSE_REFID']]);
                        if($data){
                            $data[$counter]['ABSENT_COUNT'] = $data2['absentCount'];
                        }
                    }else{
                        $SQL2 = 'SELECT count(`status`) as presentCount FROM `student_attendance` WHERE ( `date` BETWEEN :startDate AND :endDate ) AND `user_refid`=:user_refid AND `course_refid`= :course_refid AND `status`="PRESENT" ';
                        $data2 = $kali->kaliPull($SQL2,['startDate'=>$_POST['START_DATE'],'endDate'=>$_POST['END_DATE'],'user_refid'=>$rows['user_refid'],'course_refid'=>$_POST['COURSE_REFID']]);
                        if($data2){
                            $data[$counter]['PRESENT_COUNT'] = $data2['presentCount'];
                        }
    
                        $SQL2 = 'SELECT count(`status`) as absentCount FROM `student_attendance` WHERE ( `date` BETWEEN :startDate AND :endDate ) AND `user_refid`=:user_refid AND `course_refid`= :course_refid AND (`status`="ABSENT" || `status`="PENDING") ';
                        $data2 = $kali->kaliPull($SQL2,['startDate'=>$_POST['START_DATE'],'endDate'=>$_POST['END_DATE'],'user_refid'=>$rows['user_refid'],'course_refid'=>$_POST['COURSE_REFID']]);
                        if($data){
                            $data[$counter]['ABSENT_COUNT'] = $data2['absentCount'];
                        }
                    }

                    $counter++;
                }

                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found ','TARGET'=>['COURSE_REFID']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





