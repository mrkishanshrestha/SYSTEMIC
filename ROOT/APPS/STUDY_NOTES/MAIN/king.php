<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
?>
<html>
<head>

    <?php
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('FONT_AWESOME');
        $kali->link('ICONIC_CARD');
    ?>

</head>
<body>

<?php

$appTitle="ATTENDANCE";
$site = $kali->getSite();


?>

<h1>Application : User</h1>

<section class="main-board" id="main-board">

    <div class="iconic-card-conatiner">
    
    <?php if($_SESSION['MY_POST']=="TEACHER"){?>
            <div class="iconic-card" onclick="juju.changeDash('http://<?php echo $site?>.systemic.com/APPS/STUDY_NOTES/CREATE/');">
                <div><i class="fa-solid fa-user-plus iconic-card-icon"></i></div>
                <span class="iconic-card-title">Upload Study Notes</span>
            </div>
    <?php }?>
            
            <div class="iconic-card">
                <div><i class="fa-solid fa-magnifying-glass iconic-card-icon" onclick="juju.changeDash('http://<?php echo $site?>.systemic.com/APPS/STUDY_NOTES/SEARCH/');"></i></div>
                <span class="iconic-card-title">Search Study Notes</span>
            </div>
    </div>

</section>

</body>
</html>
