<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="BRANCH";
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

<h1 class="dash-title">Application : Branch</h1>

<section class="main-board" id="main-board">

    <div class="iconic-card-conatiner">
    
            <div class="iconic-card" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/BRANCH/CREATE/');">
                <div><i class="fa-solid fa-user-plus iconic-card-icon"></i></div>
                <span class="iconic-card-title">CREATE <?php echo $APPLICATION; ?></span>
            </div>
            
            <div class="iconic-card">
                <div><i class="fa-solid fa-magnifying-glass iconic-card-icon" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/BRANCH/SEARCH/');"></i></div>
                <span class="iconic-card-title">SEARCH <?php echo $APPLICATION; ?></span>
            </div>
    </div>

</section>

</body>
</html>
