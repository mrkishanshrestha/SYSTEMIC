<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="ATTENDANCE";
    $kali->checkAccess($APPLICATION,'DASH');
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

<section class="main-board" id="main-board">

    <div class="iconic-card-conatiner">
        <?php
        if($kali->checkAccess($APPLICATION,'CREATE',true)){
        ?>
            <div class="iconic-card" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/ATTENDANCE/CREATE/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>');">
                <div><i class="fa-solid fa-user-plus iconic-card-icon"></i></div>
                <span class="iconic-card-title">Take Attendance</span>
            </div>
        <?php
        }
        ?>

        <?php
        if($kali->checkAccess($APPLICATION,'VIEW',true)){
        ?>
            <div class="iconic-card">
                <div><i class="fa-solid fa-magnifying-glass iconic-card-icon" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/ATTENDANCE/SEARCH/king.php?COURSE_REFID=<?php echo $_GET['COURSE_REFID'];?>');"></i></div>
                <span class="iconic-card-title">View Attendance Report</span>
            </div>
            <?php
        }
        ?>

    </div>

</section>

</body>
</html>
