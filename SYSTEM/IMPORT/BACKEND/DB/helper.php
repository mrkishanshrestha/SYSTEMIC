<?php

include_once 'connectar.php';

class helper extends connectar{
  
    public $con;
    public $domain;

    function __costruct(){
      $this->domain = "https://kishan.vantageloaf.work";
      $this->connection = $this->connect();
    }

    function sess($data){
      return $_SESSION[$data];
    }



    function kaliPull($SQL,$datax){

      $this->con = $this->connect();
      $stmt = $this->con->prepare($SQL);
      foreach(array_keys($datax) as $data){
        $stmt->bindParam(':'.$data, $datax[$data]);
      }    
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC );

      if($result!=NULL){
        return $result;
      } else {
        return NULL;
      }
      
      $this->disconnect();
    }

    function kaliUpdate($SQL,$datax){
      try{
        $con = $this->connect();
        $stmt = $con->prepare($SQL); 
          foreach(array_keys($datax) as $data){
            $stmt->bindParam(':'.$data, $datax[$data]);
          }      
          return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
      }

      function getSiteBackground(){

        $SiteName = explode('.',$_SERVER['HTTP_HOST']);
        $data = $this->kaliPull('SELECT `college_background_image` FROM `college` WHERE `domain_cname`=:domain_cname',['domain_cname'=>$SiteName[0]]);
        return $dir = 'https://kishan.vantageloaf.work/CLIENTS/COLLEGES/'.strtoupper($SiteName[0]).'/'.$data['college_background_image'];

      }


    
    
      function kaliPulls($SQL,$datax){

      $this->con = $this->connect();
      $stmt = $this->con->prepare($SQL);
      foreach(array_keys($datax) as $data){
        $stmt->bindParam(':'.$data, $datax[$data]);
      }       
      $stmt->execute();
      $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

      if($result!=NULL){
        return $result;
      } else {
        return NULL;
      }

      $this->disconnect();
    }

    function kaliPush($SQL,$datax){
        try{
          $con = $this->connect();
          $stmt = $con->prepare($SQL); 
          foreach(array_keys($datax) as $data){
            $stmt->bindParam(':'.$data, $datax[$data]);
          }      
        $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }


    function kaliDel($SQL,$datax){
        $this->kaliPush($SQL,$datax);
    }


    function getUserInfo($data,$USER_REFID=null){

        try{

          if($USER_REFID==null){
            $USER_REFID = $_SESSION['KOHOMAH'];
          }


          $SQL = 'SELECT * FROM `user` WHERE `id`= :id'; 
          $result = $this->kaliPull($SQL,['id'=>$USER_REFID]);
          if($result){

              switch($data){

                case 'ALL':
                  return $result;

                case 'FULLNAME':
                  if($_SESSION['MY_AUTHORITY']=="KING"){
                    return 'KING';
                  }else{
                    return $result['first_name'];
                  }

                case 'FIRST_NAME':
                  if($_SESSION['MY_AUTHORITY']=="KING"){
                    return 'KING';
                  }else{
                    return $result['first_name'];
                  }
              
                case 'MIDDLE_NAME':
                if($_SESSION['MY_AUTHORITY']=="KING"){
                  return 'KISHAN';
                }else{
                  return $result['middle_name'];
                }
                  
                case 'LAST_NAME':
                if($_SESSION['MY_AUTHORITY']=="KING"){
                  return 'SHRESTHA';
                }else{
                  return $result['last_name'];
                }
                  
                case 'EMAIL':
                  return $result['email'];
                
                case 'ADDRESS':
                  return $result['address'];
                
                case 'CONTACT_NUMBER':
                  return $result['contact_number'];
                    
                case 'PHONE_NUMBER':
                  return $result['phone_number'];
                  
                    
                case 'PROFILE_PICTURE':

                  if($_SESSION['MY_AUTHORITY']=="KING"){
                    $dir ='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTF9wTf4cgxtGtFm_t9UlZKU4eFXQyFZlPkow&usqp=CAU';    
                  }
                  else if($_SESSION['MY_AUTHORITY']=="CLIENT"){
                    $dir = $this->domain."/ROOT/DATA/USER_DATA/CLIENT/".$result['id'].'/'.$result['profile_picture_id'];
                  }else
                  {
                    $dir = $this->domain."/ROOT/DATA/USER_DATA/".$result['id'].'/'.$result['profile_picture_id'];
                  }
                  /*elseif($_SESSION['MY_AUTHORITY']=="STUDENT"){
                    $SiteName = explode('.',$_SERVER['HTTP_HOST']);
                    $dir = $this->domain."/CLIENTS/COLLEGES/".strtoupper($SiteName[0]).'/STUDENT/'.$result['roll_no'].'/'.$result['profile_picture_id'];
                  }else{
                    $dir = $this->domain."/ROOT/DATA/USER_DATA/".$result['username'].'/'.$result['profile_picture_id'];
                  }*/
                  return $dir;

                case 'COLLEGE_NAME':
                    if($result['college_refid']!=NULL){
                      $sql = 'SELECT `name` FROM `college` WHERE `id`=:id';
                      $result2 = $this->kaliPull($sql,['id'=>$result['college_refid']]);
                      return $result2['name'];
                    }else{
                      return "SYSTEMIC";
                    }
                  break;
 
                case 'BRANCH_NAME':
                    if($result['college_refid']!=NULL){
                      $sql = 'SELECT `name` FROM `branch` WHERE `id`=:id';
                      $result2 = $this->kaliPull($sql,['id'=>$result['branch_refid']]);
                      return $result2['name'];
                    }else{
                      return "";
                    }
                  break;
                  
        
                default:
                  die('dead IN userInfo() getting PROFILE PICTURE.');  
                
              }

          }else{
            die('Unexpected Hack Found on getUserInfo(); ');
          }

        }catch(Exception $e){
          die($e->getMessage());
        }

    }

    function getBalance($TUPLE_ID=null){

        $data="";
        if($TUPLE_ID!=null){
          $data = $TUPLE_ID;
        }else if($_SESSION['MY_AUTHORITY']=="STUDENT") {
          $data = $_SESSION['KOHOMAH'];
        }else{
          die('cannot get data from get balance function ');
        }
      
        $sql = 'SELECT  sum(`debit_amount`) as debit_amount, sum(`credit_amount`) as credit_amount FROM `financial_statement` WHERE `user_refid`=:user_refid';
        $data = $this->kaliPull($sql,['user_refid'=>$data]);
        if($data){
            $BALANCE = $data['credit_amount']-$data['debit_amount'];
            return $BALANCE;
        }else{
          die('Something Went Wrong. Reload Page');
            //$this->thisReply(['ERROR'=>true,'MSG'=>'Something Went Wrong. Reload Page']);
        }

    }


    function getColleges(){

    }


    function getStudentInfo($data){

      if(!isset($data['CASE'])){
          die('case is not set in get student info func tion ');
      }

      if($_SESSION['MY_AUTHORITY']=="STUDENT"){
            $USER_REFID = $_SESSION['KOHOMAH'];
        }else if(isset($data['ID'])){
            $USER_REFID = $data['ID'];
        }else{
            die('id not sent');
        }


        switch ($data['CASE']){

        case 'PRESENT_DAYS':
          $SQL2 = 'SELECT count(id) as presentDays FROM `student_attendance` WHERE `user_refid`=:user_refid AND `status`="PRESENT"  GROUP BY date ';
          $data2 = $this->kaliPull($SQL2,['user_refid'=>$USER_REFID]);
          if($data2){
              return $data2['presentDays'];
          }
          break;

          case 'ABSENT_DAYS':
            $SQL2 = 'SELECT count(id) as absentDays FROM `student_attendance` WHERE `user_refid`=:user_refid AND `status`="ABSENT"  GROUP BY date ';
            $data2 = $this->kaliPull($SQL2,['user_refid'=>$USER_REFID]);
            if($data2){
                if($data2['absentDays']=="" || $data2['absentDays']==null){
                    return "0";
                }
                return $data2['absentDays'];
            }
          break;

        case 'CLASSES_ATTENDED':

              $sql = 'SELECT DISTINCT course.faculty_id, course.faculty_period, user.college_refid, user.branch_refid 
              FROM `user` user
              INNER JOIN `student_data` stud_data ON stud_data.user_refid = user.id
              INNER JOIN `course` course ON course.faculty_id = stud_data.faculty_refid && course.faculty_period = stud_data.faculty_period
              WHERE user.id=:user_refid';
              $data= $this->kaliPull($sql,['user_refid'=>$USER_REFID]);
              if($data){

                $MY_TOTAL_PRESENT_DAYS=0;

                $sql = 'SELECT COUNT(`id`) as presentCount FROM `student_attendance` WHERE `user_refid`=:user_refid && `status`=:status';
                $data2= $this->kaliPull($sql,['user_refid'=>$USER_REFID,'status'=>"PRESENT"]);
                if($data2){
                  $MY_TOTAL_PRESENT_DAYS = $data2['presentCount'];
                }

                $sql = 'SELECT `user_refid` FROM `student_data` WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid && `faculty_refid`= :faculty_refid && `faculty_period`=:faculty_period';
                $data= $this->kaliPulls($sql,['college_refid'=>$data['college_refid'],'branch_refid'=>$data['branch_refid'],'faculty_refid'=>$data['faculty_id'],'faculty_period'=>$data['faculty_period']]);
                if($data){

                  $PRESENT_COUNT_ARRAY=[];

                  foreach($data as $row){

                    $sql = 'SELECT COUNT(`id`) as presentCount FROM `student_attendance` WHERE `user_refid`=:user_refid ';
                    $data= $this->kaliPull($sql,['user_refid'=>$row['user_refid']]);
                    if($data){
                        array_push($PRESENT_COUNT_ARRAY,$data['presentCount']);
                    }
                  }

                }

                return $this->getPercentage($MY_TOTAL_PRESENT_DAYS,max($PRESENT_COUNT_ARRAY));
              }
        break;

        default:
          die('asdad');

        }
    }

    function getPercentage($value,$total){
       $data = ($value/$total)*100;
       return number_format((float)$data, 2, '.', '');
    }


    function getCourseInfo($data){

      if(!isset($data['CASE'])){
          die('case is not set in get student info func tion ');
      }

      if(!isset($data['COURSE_REFID'])){
          die('COURSE_REFID is not set in getCourseInfo info function ');
      }

      $COURSE_REFID = $data['COURSE_REFID'];

      if($_SESSION['MY_AUTHORITY']=="STUDENT"){
            $USER_REFID = $_SESSION['KOHOMAH'];
        }else if(isset($data['ID'])){
            $USER_REFID = $data['ID'];
        }else{
            die('id not sent');
        }

        switch ($data['CASE']){

          case 'ASSIGNMENT_COMPLETED':
            $SQL2 = 'SELECT count(`id`) as assignment_completed FROM `assignment_record` WHERE `course_refid`=:course_refid AND `user_refid` = :user_refid';
            $data2 = $this->kaliPull($SQL2,['course_refid'=>$data['COURSE_REFID'],'user_refid'=>$USER_REFID]);
            if($data2){
                return $data2['assignment_completed'];
            }
            break;

          
          case 'TOTAL_ASSIGNMENTS':
            $SQL2 = 'SELECT count(`id`) as TOTAL_ASSIGNMENTS FROM `assignment` WHERE `course_refid`=:course_refid';
            $data2 = $this->kaliPull($SQL2,['course_refid'=>$data['COURSE_REFID']]);
            if($data2){
                return $data2['TOTAL_ASSIGNMENTS'];
            }
          break;
  

          case 'ASSIGNMENT_PENDING':
              $SQL2 = 'SELECT count(`id`) as assignment_pending FROM `assignment` ass
              WHERE ass.id NOT IN 
                  (
                      SELECT assignment_refid FROM assignment_record WHERE user_refid=:user_refid && assignment_refid=ass.id
                  )
              and ass.course_refid = :course_refid 
              ;';
              $data2 = $this->kaliPull($SQL2,['course_refid'=>$data['COURSE_REFID'],'user_refid'=>$USER_REFID]);
              if($data2){
                return $data2['assignment_pending'];
              }
              break;


          case 'PRESENT_DAYS':
            $SQL2 = 'SELECT count(`status`) as PRESENT_DAYS FROM `student_attendance` WHERE `user_refid`=:user_refid AND `course_refid`= :course_refid AND `status`="PRESENT" ';
            $data2 = $this->kaliPull($SQL2,['user_refid'=>$USER_REFID,'course_refid'=>$data['COURSE_REFID']]);
            if($data2){
                return $data2['PRESENT_DAYS'];
            }
            break;
      
          case 'ABSENT_DAYS':
            $SQL2 = 'SELECT count(`status`) as ABSENT_DAYS FROM `student_attendance` WHERE `user_refid`=:user_refid AND `course_refid`= :course_refid AND ( `status`="PENDING" OR `status`="ABSENT") ';
            $data2 = $this->kaliPull($SQL2,['user_refid'=>$USER_REFID,'course_refid'=>$data['COURSE_REFID']]);
            if($data2){
                return $data2['ABSENT_DAYS'];
            }
            break;

          case 'CLASSES_ATTENDED':

            $sql = 'SELECT DISTINCT course.faculty_id, course.faculty_period, user.college_refid, user.branch_refid 
            FROM `user` user
            INNER JOIN `student_data` stud_data ON stud_data.user_refid = user.id
            INNER JOIN `course` course ON course.faculty_id = stud_data.faculty_refid && course.faculty_period = stud_data.faculty_period
            WHERE user.id=:user_refid';
            $data= $this->kaliPull($sql,['user_refid'=>$USER_REFID]);
            if($data){

              $MY_TOTAL_PRESENT_DAYS = $this->getCourseInfo(['CASE'=>'PRESENT_DAYS','COURSE_REFID'=>$COURSE_REFID]);

              $sql = 'SELECT `user_refid` FROM `student_data` WHERE `college_refid`=:college_refid && `branch_refid`=:branch_refid && `faculty_refid`= :faculty_refid && `faculty_period`=:faculty_period';
              $data= $this->kaliPulls($sql,['college_refid'=>$data['college_refid'],'branch_refid'=>$data['branch_refid'],'faculty_refid'=>$data['faculty_id'],'faculty_period'=>$data['faculty_period']]);
              if($data){

                $PRESENT_COUNT_ARRAY=[];

                foreach($data as $row){

                  $sql = 'SELECT COUNT(`id`) as presentCount FROM `student_attendance` WHERE `user_refid`=:user_refid && `status`=:status';
                  $data= $this->kaliPull($sql,['user_refid'=>$row['user_refid'],'status'=>"PRESENT"]);
                  if($data){
                      array_push($PRESENT_COUNT_ARRAY,$data['presentCount']);
                  }
                }

              }

              return $this->getPercentage($MY_TOTAL_PRESENT_DAYS,max($PRESENT_COUNT_ARRAY));
            }
      break;
    
    
        default:
          die('asdad');
    }


    }


    function getData($option){

      if($_SESSION['MY_AUTHORITY']=='KING'){
        switch($option){

          case 'TOTAL_CLIENTS':
              $SQL = 'SELECT count(id) as total_clients FROM `client`  ';
              $data = $this->kaliPull($SQL,[]);
              if($data){
                  return $data['total_clients'];
              }
          break;
  
          case 'TOTAL_USERS':
            $SQL = 'SELECT count(id) as total_users FROM `user`  ';
            $data = $this->kaliPull($SQL,[]);
            if($data){
                return $data['total_users'];
            }
          break;
  
  
          case 'TOTAL_COLLEGES':
            $SQL = 'SELECT count(id) as total FROM `college`  ';
            $data = $this->kaliPull($SQL,[]);
            if($data){
                return $data['total'];
            }
          break;
  
          
          case 'TOTAL_STUDENTS':
            $SQL = 'SELECT count(id) as total FROM `user`  ';
            $data = $this->kaliPull($SQL,[]);
            if($data){
                return $data['total'];
            }
          break;
  
          default:
          die('dead in getData function');
  
        }
      }

      if($_SESSION['MY_AUTHORITY']=='CLIENT'){

        switch($option){

          case 'TOTAL_COLLEGES':
            $SQL = 'SELECT count(id) as total FROM `college` WHERE `user_id`=:user_id ';
            $data = $this->kaliPull($SQL,['user_id'=>$_SESSION['KOHOMAH']]);
            if($data){
                return $data['total'];
            }
          break;
  
          default:
          die('dead in getData function');
  
  
        }
      }


    }

    function processPerformance($USER_REFID){

          $MAIN_DATA = [];

          $sql = 'SELECT DISTINCT
                  exam_details.examination_refid, exam.title,exam.year,exam.full_mark, exam.pass_mark
                  FROM `user` 
                  INNER JOIN `student_data` stud_data ON stud_data.user_refid = user.id
                  INNER JOIN `course` course ON course.faculty_id = stud_data.faculty_refid && course.faculty_period = stud_data.faculty_period 
                  INNER JOIN `examination_details` exam_details ON exam_details.course_refid = course.id 
                  INNER JOIN `examination` exam ON exam.id = exam_details.examination_refid 
                  WHERE user.id = :USER_REFID';
              $bind = ['USER_REFID'=>$USER_REFID];
              $data = $this->kaliPulls($sql,$bind);
              if($data){

                $newArray = [];
                foreach($data as $rows){
                    $sql = 'SELECT sum(exam_record.obtained_marks) as total_obtained_marks 
                    FROM `examination_details` exam_details 
                    INNER JOIN `examination_record` exam_record ON exam_record.examination_details_refid = exam_details.id && exam_record.user_refid = :USER_REFID 
                    WHERE exam_details.examination_refid = :examination_refid';
                    $bind = ['USER_REFID'=>$USER_REFID,'examination_refid'=>$rows['examination_refid']];
                    $data = $this->kaliPull($sql,$bind);
                    if($data){
                        $scorePercentage = ($data['total_obtained_marks']/500)*100;
                        array_push($newArray,$scorePercentage);
                    }
                }

                $MAIN_DATA['TEST_SCORE']=$newArray;

              }else{
                die('error in processPerformance');
            }

        $sql2="SELECT DISTINCT
        sum(mark_obtained) as totalAssignmentMarks
        FROM `user` 
        INNER JOIN `student_data` stud_data ON stud_data.user_refid = user.id
        INNER JOIN `course` course ON course.faculty_id = stud_data.faculty_refid && course.faculty_period = stud_data.faculty_period 
        INNER JOIN `assignment` assignment ON assignment.course_refid = course.id
        INNER JOIN `assignment_record` assignment_record ON assignment_record.assignment_refid = assignment.id
        WHERE user.id = :USER_REFID";
        $bind = ['USER_REFID'=>$USER_REFID];
        $data = $this->kaliPull($sql2,$bind);
        if($data){
          $MAIN_DATA['ASSIGNMENT_MARKS']=$data['totalAssignmentMarks'];
          $CLASSES_ATTENDED_DATA = $this->getStudentInfo(['CASE'=>'CLASSES_ATTENDED','ID'=>$USER_REFID]);
          $MAIN_DATA['ATTENDANCE']=$CLASSES_ATTENDED_DATA;
        }else{die('error in processPerformance'); }

        return $MAIN_DATA;
 
    }


    function performanceEvulator($USER_REFID){

      // creating sample data for trainning
      $training_data = [];

        // Generat[ing 50 data datas
        for ($i = 0; $i < 100; $i++) {
            $test_scores = [
                rand(1, 100),
                rand(1, 100),
                rand(1, 100),
                rand(1, 100),
                rand(1, 100)
            ];
            
            $assignment_marks = rand(1, 100);
            $attendance = rand(1, 5);
            $final_score = rand(1, 95);
            
            $training_data[] = [
                'test_scores' => $test_scores,
                'assignment_marks' => $assignment_marks,
                'attendance' => $attendance,
                'final_score' => $final_score
            ];
        }

      // New student data for prediction

      $newData = $this->processPerformance($USER_REFID);

      $new_student = ['test_scores' => $newData['TEST_SCORE'], 'assignment_marks' => $newData['ASSIGNMENT_MARKS'], 'attendance' => $newData['ATTENDANCE']];

      // Implement a simple linear regression
      /*function linear_regression($training_data, $new_student) {

              $sum_x1 = $sum_x2 = $sum_y = $sum_x1y = $sum_x2y = 0;

              foreach ($training_data as $data) {
                  $sum_x1 += $data['test_scores'][0];
                  $sum_x2 += $data['test_scores'][1];
                  $sum_y += $data['final_score'];
                  $sum_x1y += $data['test_scores'][0] * $data['final_score'];
                  $sum_x2y += $data['test_scores'][1] * $data['final_score'];
              }

              $n = count($training_data);

              $slope_x1 = ($n * $sum_x1y - $sum_x1 * $sum_y) / ($n * pow($sum_x1, 2) - pow($sum_x1, 2));
              $slope_x2 = ($n * $sum_x2y - $sum_x2 * $sum_y) / ($n * pow($sum_x2, 2) - pow($sum_x2, 2));
              $intercept = ($sum_y - $slope_x1 * $sum_x1 - $slope_x2 * $sum_x2) / $n;

              // Predict the final score for the new student
              $predicted_final_score = $intercept + $slope_x1 * $new_student['test_scores'][0] + $slope_x2 * $new_student['test_scores'][1];

              return $predicted_final_score;
      }*/

        function linear_regression($training_data, $new_student) {

          /**
           * kati oota feature le effect garxa 
           */
          $num_features = 4; // Number of features including assignment_marks, attendance, and test_scores
      
          // Initialize sum variable for each feature and the targset variable. Final Gardess
          /*
          initialized to store the sums of the features and the product of each feature with the target variable
           */
          $sum_features = array_fill(0, $num_features, 0);
          $sum_feature_target = array_fill(0, $num_features, 0);
      
          // Calculate sums
          /**
           *  enters a loop to calculate the sums for each feature
           * loop through the training data, extract features and final scores, and accumulates the sums
           */
          foreach ($training_data as $data) {
              $features = array_merge([$data['assignment_marks'], $data['attendance']], $data['test_scores']);
              $final_score = $data['final_score'];
              
              for ($i = 0; $i < $num_features; $i++) {
                  $sum_features[$i] += $features[$i];
                  $sum_feature_target[$i] += $features[$i] * $final_score;
              }
          }
      
          $n = count($training_data);
      
          // Calculate regression coefficients (slopes) for each feature
          /**
           *  calculate the regression coefficients (slopes) for each feature. 
           * ses the formula for linear regression to compute these coefficients based on the sums previously calculated.
           * 
           */
          $coefficients = [];

          for ($i = 0; $i < $num_features; $i++) {
              $finalScoreSum = array_sum(array_map(fn($data) => $data['final_score'], $training_data));
              $testScoreSquaredSum = array_sum(array_map(fn($data) => $data['test_scores'][$i] * $data['test_scores'][$i], $training_data));
              $testScoreSum = array_sum(array_map(fn($data) => $data['test_scores'][$i], $training_data));
          
              $coefficients[] = ($n * $sum_feature_target[$i] - $sum_features[$i] * $finalScoreSum)
                              / ($n * $testScoreSquaredSum - pow($testScoreSum, 2));
          }
          
          // Calculate the sum of final_scores
         // calculate the intercept of the regression model using the computed coefficients and the sums of the features and target variables.
          $sum_final_scores = array_sum(array_map(fn($data) => $data['final_score'], $training_data));

          $intercept = ($sum_final_scores - array_sum(array_map(fn($coef, $feature) => $coef * $feature, $coefficients, $sum_features))) / $n;

          // Calculate the predicted final score for the new student
          $new_features = array_merge([$new_student['assignment_marks'], $new_student['attendance']], $new_student['test_scores']);
          // equation (intercept + sum of coefficients * features).
          $predicted_final_score = $intercept + array_sum(array_map(fn($coef, $feature) => $coef * $feature, $coefficients, $new_features));
      
          return $predicted_final_score;
        }

        // Predict the final score for the new student
        $predicted_score = linear_regression($training_data, $new_student);
        return round($predicted_score, 2);

      }
          

    }

    function calculateWeightedPerformance($testScores, $attendancePerformance, $assignmentMarks) {
          $testScoresWeight = 0.4;
          $attendancePerformanceWeight = 0.3;
          $assignmentMarksWeight = 0.3;
      
          $weightedPerformance = ($testScoresWeight * array_sum($testScores)) +
              ($attendancePerformanceWeight * $attendancePerformance) +
              ($assignmentMarksWeight * $assignmentMarks);
      
          // Scale the weighted performance to a maximum of 100%
          $maxPossibleScore = ($testScoresWeight * 100) + ($attendancePerformanceWeight * 100) + ($assignmentMarksWeight * 100);
          $percentageScore = min(($weightedPerformance / $maxPossibleScore) * 100, 100); // Ensure max 100%
      
          return $percentageScore;
    }
      
?>