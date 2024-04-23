
<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "CLASSROOM";
    $RIGHTS = "DASH";
?>

    <?php
        $kali->link('FONT_AWESOME');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('CIRCLE_BAR');
        $kali->link('KALI_FORM');
        $kali->link('ASSETS');
        $kali->link('QR');
    ?>

<body>

<div class="dash_container">


            <!-- MAIN CARDS STARTS HERE -->
            <div class="dash_cards">

            <div class="card">
              <i class="fa-solid fa-sack-dollar fa-3x" aria-hidden="true"></i>
              <div class="dash_card_title">
                <p class="">Total Assignments : <?php echo $kali->getCourseInfo(['CASE'=>'TOTAL_ASSIGNMENTS','COURSE_REFID'=>$_GET['COURSE_REFID'],'ID'=>$_SESSION['KOHOMAH']]);?></p>
              </div>
            </div>


              <!-- Student Dashboard Content  START -->
              <?php if($kali->checkMyAutho('STUDENT')){?>
                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Assignments Completed : <?php echo $kali->getCourseInfo(['CASE'=>'ASSIGNMENT_COMPLETED','COURSE_REFID'=>$_GET['COURSE_REFID']]);?></p>
                    </div>
                  </div>

                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Assignmants Pending : <?php echo $kali->getCourseInfo(['CASE'=>'ASSIGNMENT_PENDING','COURSE_REFID'=>$_GET['COURSE_REFID']]);?></p>
                    </div>
                  </div>

                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Class Attended : <?php echo $kali->getCourseInfo(['CASE'=>'PRESENT_DAYS','COURSE_REFID'=>$_GET['COURSE_REFID']]);?></p>
                    </div>
                  </div>

                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total Class Missed : <?php echo $kali->getCourseInfo(['CASE'=>'ABSENT_DAYS','COURSE_REFID'=>$_GET['COURSE_REFID']]);?></p>
                    </div>
                  </div>

                  <div id="attendance-circle-bar"></div>
                  <?php $DATA = $kali->getCourseInfo(['CASE'=>'CLASSES_ATTENDED','COURSE_REFID'=>$_GET['COURSE_REFID']])?>
                  <script>
                      juju.createCircleBar('attendance-bar',"Attendance",<?php echo $DATA;?>,'attendance-circle-bar');
                  </script>



                <?php } ?>
              <!-- Student Dashboard Content  END -->

              



              </div>
              <!-- MAIN CARDS ENDS HERE -->

      </div>
      <!--dash_container-->
  


