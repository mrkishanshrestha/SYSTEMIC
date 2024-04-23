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

<style>
  .classroom-iframe{
    width:100%;
    height:85vh;
  }

  .container{
    width:100% !important;
  }
  </style>

<div class="container">

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Assigned</a></li>
    <?php if($kali->checkMyAutho('STUDENT')){?>
    <li><a data-toggle="tab" href="#menu1">Completed</a></li>
    <?php } ?>
    <?php if($kali->checkMyAutho('TEACHER')){?>
    <li><a data-toggle="tab" href="#menu2">Assign Now</a></li>
    <?php } ?>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/ASSIGNMENT/SEARCH/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>

    <div id="menu1" class="tab-pane fade">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/ASSIGNMENT/SEARCH/submited_king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>
    <?php if($kali->checkMyAutho('TEACHER')){?>
    <div id="menu2" class="tab-pane fade">
      <h3></h3>
      <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/ASSIGNMENT/ASSIGN_NOW/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>"></iframe>
    </div>
    <?php } ?>

  </div>

</div>


</body>
</html>
