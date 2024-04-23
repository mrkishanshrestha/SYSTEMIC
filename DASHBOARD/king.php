<?php 
require_once '../SYSTEM/IMPORT/BACKEND/kali.php';
$kali->isNotLoggedIn('https://kishan.vantageloaf.work');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $kali->sysInfo('COMPANY_NAME');?></title>

    <?php   
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('KALI_HEADER');
        $kali->link('ROOT/CORE/KALI_HEADER/script.js','JS');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('FONT_AWESOME');    
    ?>

</head>
<body>

<?php  


    if( $kali->sess('WELCOME_SOUND_PLAYED')==false && $kali->sess('USERKONAM')=='KING'){
        echo'<script>juju.playSound("https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/welcomekishan.mp3");</script>';
        $_SESSION['WELCOME_SOUND_PLAYED']=true;
    }

    $dataX=[
        ['PLACE'=>'BODY','APP_NAME'=>'DASHBOARD','TITLE'=>'DASHBOARD','LINK'=>$kali->domain.'/DASHBOARD/maindash.php','ICON'=>'fa-brands fa-dashcube'],
        
        ['PLACE'=>'BODY','APP_NAME'=>'CLIENT','TITLE'=>'CLIENT','LINK'=>$kali->domain.'/ROOT/APPS/CLIENT/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'FACULTY','TITLE'=>'FACULTY','LINK'=>$kali->domain.'/ROOT/APPS/FACULTY/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'FACULTY_FINANCE','TITLE'=>'FACULTY FINANCE','LINK'=>$kali->domain.'/ROOT/APPS/FACULTY_FINANCE/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'COURSE','TITLE'=>'COURSE','LINK'=>$kali->domain.'/ROOT/APPS/COURSE/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'APPLICATION','TITLE'=>'APPLICATION','LINK'=>$kali->domain.'/ROOT/APPS/APPLICATION/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'COLLEGE','TITLE'=>'COLLEGE','LINK'=>$kali->domain.'/ROOT/APPS/COLLEGE/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'BRANCH','TITLE'=>'BRANCH','LINK'=>$kali->domain.'/ROOT/APPS/BRANCH/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'COURSE_ASSIGNMENT','TITLE'=>'COURSE ASSIGNMENT','LINK'=>$kali->domain.'/ROOT/APPS/COURSE_ASSIGNMENT/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'CLASSROOM','TITLE'=>'CLASSROOM','LINK'=>$kali->domain.'/ROOT/APPS/CLASSROOM/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'EXAMINATION','TITLE'=>'EXAMINATION','LINK'=>$kali->domain.'/ROOT/APPS/EXAMINATION/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'PAYMENT','TITLE'=>'PAYMENT','LINK'=>$kali->domain.'/ROOT/APPS/PAYMENT/CREATE','ICON'=>'fa-solid fa-book'],
        
        ['PLACE'=>'BODY','APP_NAME'=>'PRIVILEGE','TITLE'=>'PRIVILEGE','LINK'=>$kali->domain.'/ROOT/APPS/PRIVILEGE/MAIN','ICON'=>'fa-solid fa-book'],
        
        ['PLACE'=>'BODY','APP_NAME'=>'USER','TITLE'=>'USER','LINK'=>$kali->domain.'/ROOT/APPS/USER/MAIN','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','APP_NAME'=>'STUDENT','TITLE'=>'STUDENT','LINK'=>$kali->domain.'/ROOT/APPS/STUDENT/MAIN','ICON'=>'fa-solid fa-book'],

        ['PLACE'=>'FOOT','APP_NAME'=>'PROFILE','TITLE'=>'PROFILE','LINK'=>$kali->domain.'/ROOT/APPS/PROFILE','ICON'=>'fa-solid fa-user'],
        ['PLACE'=>'FOOT','APP_NAME'=>'LOGOUT','TITLE'=>'LOGOUT','LINK'=>$kali->domain.'/logout.php','ICON'=>'fa-solid fa-arrow-right-from-bracket'],
    ];

    $kali->makeSideBar($dataX);

?>


<?php $kali->insert('KALI_HEADER');?>

<div id="dash-container">
    <iframe class="dash-frame" id="dash-frame" src="https://www.systemic.com/DASHBOARD/maindash.php">
    </iframe>
</div>


</body>
</html>
