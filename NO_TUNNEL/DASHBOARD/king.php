<?php 
require_once '../../SYSTEM/IMPORT/BACKEND/kali.php';
$kali->isNotLoggedIn('http://systemic.com');





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $kali->sysInfo('COMPANY_NAME');?></title>

    <?php   
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('FONT_AWESOME');    
    ?>
    
</head>
<body>

<?php  

    /*if( $kali->sess('WELCOME_SOUND_PLAYED')==false && $kali->sess('USERKONAM')=='KING'){
        echo'<script>juju.playSound("http://systemic.com/SYSTEM/IMPORT/SITE_DATA/SOUNDS/welcomekishan.mp3");</script>';
        $_SESSION['WELCOME_SOUND_PLAYED']=true;
    }*/



    $dataX=[
        ['PLACE'=>'BODY','TITLE'=>'DASHBOARD','LINK'=>'http://client.systemic.com/DASHBOARD/maindash.php','ICON'=>'fa-brands fa-dashcube'],
        ['PLACE'=>'BODY','TITLE'=>'COLLEGE','LINK'=>'http://client.systemic.com/APPS/COLLEGE/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','TITLE'=>'FACULTY','LINK'=>'http://client.systemic.com/APPS/FACULTY/MAIN','ICON'=>'fa-solid fa-book'],
        
        ['PLACE'=>'FOOT','TITLE'=>'Profile','LINK'=>'http://client.systemic.com/ROOT/APPS/PROFILE','ICON'=>'fa-solid fa-user'],
        ['PLACE'=>'FOOT','TITLE'=>'Logout','LINK'=>'http://client.systemic.com/logout.php','ICON'=>'fa-solid fa-arrow-right-from-bracket'],
    ];
    $kali->makeSideBar($dataX);
?>

<div id="dashnav" class="dashnav">

    <div class="dashnav-left">
    </div>
  
    <div class="dashnav-center">
        <!--
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass iconic-card-icon"></i>
            <input type="search" style="height:35px;" id="nav-search-bar" class="nav-search-bar" placeholder="Search Anything">
        </div>
        -->
        <div style="color:white;font-size:2.8em;">
            <a style="color:var(--text-color);text-decoration: none;" href="http://client.systemic.com">systemic</a>
        </div>

    </div>
    
    <div class="dashnav-right">    
        <i class="fa-solid fa-arrow-left iconic-card-icon" onclick="history.go(-1);"></i>
        <i class="fa-solid fa-arrow-rotate-right iconic-card-icon" onclick="document.getElementById('dash-frame').contentWindow.location.reload();"></i>
        <i class="fa-solid fa-bell iconic-card-icon" ></i>
    </div>
    
</div>

<div id="dash-container">
    <iframe class="dash-frame" id="dash-frame" src="http://client.systemic.com/DASHBOARD/maindash.php">
    </iframe>
</div>

<?php  $kali->getCode('http://systemic.com/ROOT/CORE/FOOTER/king.php'); ?>


</body>
</html>
