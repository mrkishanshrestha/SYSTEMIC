
<?php 
include '../SYSTEM/IMPORT/BACKEND/kali.php';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $kali->sysInfo('COMPANY_NAME');?></title>
    
    <?php
        $kali->link('FONT_AWESOME');
        $kali->link('ASSETS');
        $kali->link('JQUERY');
        $kali->link('CIRCLE_BAR');
        $kali->link('SPEED_BAR');
        $kali->link('BAR_GRAPH');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
    ?>
    <link rel="stylesheet" href="ASSETS/css/design_2.css">
    <script src="ASSETS/js/script_2.js"></script>

</head>

<style>

.clock {
    color: var(--clock-color);
    font-size: 3rem;
    font-family: Orbitron;
    letter-spacing: 7px;
    padding-left: 2rem;
}

</style>

<body>
  


<div class="dash_container">

      <div class="dash-header">

            <!-- DASH TITLE STARTS HERE -->
            <div class="dash_title">
              <img src="<?php echo $kali->getUserInfo('PROFILE_PICTURE');?>" alt="" />
              <div class="dash_note">
                <h1>Hello, <?php echo $kali->getUserInfo('FULLNAME'); ?></h1>
                <h2><?php echo $kali->getUserInfo('COLLEGE_NAME');?></h2>
                <h2><?php echo $kali->getUserInfo('BRANCH_NAME');?></h2>
                <h2> ( <?php echo $_SESSION['MY_AUTHORITY'] ?> )</h2>
                <p>Welcome to Dashboard</p>
              </div>

           </div>

            <!-- MAIN CARDS STARTS HERE -->
            <div class="dash_cards">

              <!-- Student Dashboard Content  START -->
              <?php if($kali->checkMyAutho('STUDENT')){?>

                  <div class="card">
                    <i class="fa-solid fa-sack-dollar fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Due Balance : <?php echo $kali->getBalance();?></p>
                    </div>
                  </div>

                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Classes Attended : <?php echo $kali->getStudentInfo(['CASE'=>'PRESENT_DAYS']);?></p>
                    </div>
                  </div>

                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Classes Missed : <?php if($kali->getStudentInfo(['CASE'=>'ABSENT_DAYS'])=="0" || $kali->getStudentInfo(['CASE'=>'ABSENT_DAYS'])==""){
                       echo "0"; 
                      }else{
                        echo $kali->getStudentInfo(['CASE'=>'ABSENT_DAYS']);
                      }?></p>
                    </div>
                  </div>

                  <div id="attendance-circle-bar"></div>

                  <?php 
                    $DATA = $kali->getStudentInfo(['CASE'=>'CLASSES_ATTENDED']);
                    $pData = $kali->processPerformance($_SESSION['KOHOMAH']);
                    $weightedPerformanceScore = calculateWeightedPerformance($pData['TEST_SCORE'], $DATA, $pData['ASSIGNMENT_MARKS']);
                   
                  ?>

                  <div id="speed-bar"></div>

                  <script>
                    juju.createCircleBar('attendance-bar',"Classes -- Attended : ",<?php echo $DATA;?>,'attendance-circle-bar');
                    createSpeedBar("speed-bar",'Your Predicted Performance For Finals',<?php echo $weightedPerformanceScore;?>);
                    /*<div id="barchart-main"></div>createBarGraph("barchart-main",'Student Exam Perfomance');*/
                </script>

                <?php } ?>
              <!-- Student Dashboard Content  END -->


              <?php if($kali->checkMyAutho('TEACHER')){
                      $sql = 'SELECT COUNT(`id`) AS total_courses_assigned FROM `course_assigned` WHERE `user_refid` = :user_refid';
                      $data = $kali->kaliPull($sql,['user_refid'=>$_SESSION['KOHOMAH']]);
                      if(!$data){
                      }
              ?>
              <div class="card">
                    <i class="fa-solid fa-sack-dollar fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Course Assigned : <?php echo $data['total_courses_assigned'];?></p>
                    </div>
              </div>
              <?php }?>


              
              <?php if($kali->checkMyAutho('ADMIN')){
                      $sql = 'SELECT count(student_data.roll_no) as total_students FROM `user`
                      INNER JOIN `student_data` student_data ON student_data.branch_refid = user.branch_refid
                      WHERE user.id=:user_refid';
                      $students_data = $kali->kaliPull($sql,['user_refid'=>$_SESSION['KOHOMAH']]);
                      if(!$students_data){
                      }
              ?>
              <div class="card">
                    <i class="fa-solid fa-sack-dollar fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Students : <?php echo $students_data['total_students'];?></p>
                    </div>
              </div>

              
              <?php }?>






          
              <section class="main" style="font-size: 1.8rem;width: 380px;">
                  <section class="display">
                      <div class="wrapper">
                          <h2 id="cityoutput"></h2>
                          <p id="description"></p>
                          <p id="temp"></p>
                          <p id="wind"></p>
                      </div>
                  </section>
              </section>


              <!-- OR CODE DISPLAY CODE START -->
              <canvas style="width: 150px;" id="QR-DATA"></canvas>
              <script>
                juju.qr('<?php echo $kali->userInfo('FULLNAME'); ?>','QR-DATA');
              </script>
              <!-- OR CODE DISPLAY CODE END -->

              </div>
              <!-- MAIN CARDS ENDS HERE -->

             <!-- weather widget start --><div id="m-booked-bl-simple-30418"> <div class="booked-wzs-160-110 weather-customize" style="background-color:#137AE9;width:160px;" id="width1"> <div class="booked-wzs-160-110_in"> <div class="booked-wzs-160-data"> <div class="booked-wzs-160-left-img wrz-18"></div> <div class="booked-wzs-160-right"> <div class="booked-wzs-day-deck"> <div class="booked-wzs-day-val"> <div class="booked-wzs-day-number"><span class="plus">+</span>24</div> <div class="booked-wzs-day-dergee"> <div class="booked-wzs-day-dergee-val">&deg;</div> <div class="booked-wzs-day-dergee-name">C</div> </div> </div> <div class="booked-wzs-day"> <div class="booked-wzs-day-d"><span class="plus">+</span>25&deg;</div> <div class="booked-wzs-day-n"><span class="plus">+</span>20&deg;</div> </div> </div> <div class="booked-wzs-160-info"> <div class="booked-wzs-160-city">Kathmandu</div> <div class="booked-wzs-160-date">Friday, 14</div> </div> </div> </div> <div class="booked-wzs-center"><span class="booked-wzs-bottom-l"> See 7-Day Forecast</span></div> </div> </div> </div><script type="text/javascript"> var css_file=document.createElement("link"); var widgetUrl = location.href; css_file.setAttribute("rel","stylesheet"); css_file.setAttribute("type","text/css"); css_file.setAttribute("href",'https://s.bookcdn.com/css/w/booked-wzs-widget-160.css?v=0.0.1'); document.getElementsByTagName("head")[0].appendChild(css_file); function setWidgetData_30418(data) { if(typeof(data) != 'undefined' && data.results.length > 0) { for(var i = 0; i < data.results.length; ++i) { var objMainBlock = document.getElementById('m-booked-bl-simple-30418'); if(objMainBlock !== null) { var copyBlock = document.getElementById('m-bookew-weather-copy-'+data.results[i].widget_type); objMainBlock.innerHTML = data.results[i].html_code; if(copyBlock !== null) objMainBlock.appendChild(copyBlock); } } } else { alert('data=undefined||data.results is empty'); } } var widgetSrc = "https://widgets.booked.net/weather/info?action=get_weather_info;ver=7;cityID=5536;type=1;scode=55494;ltid=3458;domid=w209;anc_id=25487;countday=undefined;cmetric=1;wlangID=1;color=137AE9;wwidth=160;header_color=ffffff;text_color=333333;link_color=08488D;border_form=1;footer_color=ffffff;footer_text_color=333333;transparent=0;v=0.0.1";widgetSrc += ';ref=' + widgetUrl;widgetSrc += ';rand_id=30418';var weatherBookedScript = document.createElement("script"); weatherBookedScript.setAttribute("type", "text/javascript"); weatherBookedScript.src = widgetSrc; document.body.appendChild(weatherBookedScript) </script><!-- weather widget end -->
          

            </div>
            <!-- DASH TITLE ENDS HERE -->

      </div>
      <!--dash_container-->

      
  
  </body>
</html>

