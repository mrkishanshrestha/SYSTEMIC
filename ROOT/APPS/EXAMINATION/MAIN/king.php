<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "EXAMINATION";
    $RIGHTS = "DASH";
    $kali->checkAccess($APPLICATION,$RIGHTS);
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

    <?php if($kali->checkAccess($APPLICATION,'CREATE',true)){?>
      <li class="active"><a data-toggle="tab" href="#home">Create Exam</a></li>
    <?php } ?>


  </ul>

  <div class="tab-content">

      <?php if($kali->checkAccess($APPLICATION,'CREATE',true)){?>
        <div id="home" class="tab-pane fade in active">
          <h3></h3>
          <iframe class="classroom-iframe" src="https://www.systemic.com/ROOT/APPS/EXAMINATION/CREATE/king.php"></iframe>
        </div>
      <?php } ?>

  </div>

</div>


</body>
</html>
