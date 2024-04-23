<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "PAYMENT";
    $RIGHTS = "DASH";
    $kali->checkAccess($APPLICATION,$RIGHTS);
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
    
            <div class="iconic-card" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/PAYMENT/CREATE/');">
                <div><i class="fa-solid fa-user-plus iconic-card-icon"></i></div>
                <span class="iconic-card-title">Make Payments</span>
            </div>
            
            <div class="iconic-card">
                <div><i class="fa-solid fa-magnifying-glass iconic-card-icon" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/PAYMENT/SEARCH/');"></i></div>
                <span class="iconic-card-title">Search Statements</span>
            </div>
    </div>

</section>

</body>
</html>
