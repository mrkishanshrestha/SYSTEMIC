<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "CLASSROOM";
    $RIGHTS = "DASH";
?>
<html>
<head>

    <?php
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('JQUERY');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('FONT_AWESOME');
        $kali->link('ICONIC_CARD');
        $kali->link('BOOTSTRAP');
    ?>

</head>
<body>

<?php

  $sql = "SELECT `course_name`,`course_code` FROM `course` WHERE id=:course_refid";
  $data = $kali->kaliPull($sql,['course_refid'=>$_GET['COURSE_REFID']]);
  if(!$data){
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Course Erroe','TARGET'=>['COURSE_REFID']]);
  }

?>

<style>
  .classroom-iframe{
    width:100%;
    height:85vh;
  }

  .container{
    width:100% !important;
  }
  </style>

<span><h1><?php echo $data['course_name'].'( '.$data['course_code'].' )';?></h1></span>

<div class="container">

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#menu1">Assignment</a></li>
    <li><a data-toggle="tab" href="#menu2">Notices</a></li>
    <li><a data-toggle="tab" href="#menu3">Attendance</a></li>
    <li><a data-toggle="tab" href="#menu4">Examination</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/CLASSROOM/HOME/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>

    <div id="menu1" class="tab-pane fade">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/ASSIGNMENT/MAIN/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>

    <div id="menu2" class="tab-pane fade">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/NOTICE/MAIN/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>

    <div id="menu3" class="tab-pane fade">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/ATTENDANCE/MAIN/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>

    <div id="menu4" class="tab-pane fade">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/EXAMINATION/SEARCH/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>

  </div>

</div>


</body>
</html>
