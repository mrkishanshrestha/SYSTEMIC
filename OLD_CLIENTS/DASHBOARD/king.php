<?php 
require_once '../../SYSTEM/IMPORT/BACKEND/kali.php';
$kali->isNotLoggedIn('http://achs.systemic.com');
$SiteName = explode('.',$_SERVER['HTTP_HOST']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $kali->sysInfo('SITE_NAME');?> kishan</title>

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

    /*if( $kali->sess('WELCOME_SOUND_PLAYED')==false && $kali->sess('USERKONAM')=='KING'){
        echo'<script>juju.playSound("http://systemic.com/SYSTEM/IMPORT/SITE_DATA/SOUNDS/welcomekishan.mp3");</script>';
        $_SESSION['WELCOME_SOUND_PLAYED']=true;
    }*/
    $SiteName = explode('.',$_SERVER['HTTP_HOST']);

    $dataX=[
        ['PLACE'=>'BODY','TITLE'=>'DASHBOARD','LINK'=>'http://'.$SiteName[0].'.systemic.com/DASHBOARD/maindash.php','ICON'=>'fa-brands fa-dashcube'],
     
        /*['PLACE'=>'BODY','TITLE'=>'NOTES','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/NOTES','ICON'=>'fa-solid fa-book'],
        ['PLACE'=>'BODY','TITLE'=>'TO-DO','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/GALLERY','ICON'=>'fa-solid fa-table-list'],
        ['PLACE'=>'BODY','TITLE'=>'GALLERY','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/TO-DO','ICON'=>'fa-solid fa-image'],
        ['RIGHTS'=>['CLIENT','RECEPTIONIST'],'PLACE'=>'BODY','TITLE'=>'FRIENDS','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/FRIENDS','ICON'=>'fa-solid fa-user-group'],
        */
        ['RIGHTS'=>['CLIENT','RECEPTIONIST'],'PLACE'=>'BODY','TITLE'=>'USER','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/USER/MAIN','ICON'=>'fa-solid fa-user-group'],
        ['RIGHTS'=>['RECEPTIONIST'],'PLACE'=>'BODY','TITLE'=>'STUDENT','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/STUDENTS/MAIN','ICON'=>'fa-solid fa-user-group'],
        ['RIGHTS'=>['TEACHER'],'PLACE'=>'BODY','TITLE'=>'ATTENDANCE','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/ATTENDANCE/MAIN','ICON'=>'fa-solid fa-user-group'],
        ['RIGHTS'=>['CLIENT','ADMIN','ACCOUNTANT'],'PLACE'=>'BODY','TITLE'=>'FACULTY FINANCE','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/FACULTY_FINANCE/MAIN','ICON'=>'fa-solid fa-money-bill-trend-up'],
        ['RIGHTS'=>['CLIENT','ADMIN','COORDINATOR'],'PLACE'=>'BODY','TITLE'=>'COURSE ASSIGNMENT','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/COURSE_ASSIGNMENT/MAIN','ICON'=>'fa-solid fa-money-bill-trend-up'],
        ['RIGHTS'=>['STUDENT'],'PLACE'=>'BODY','TITLE'=>'COURSE','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/COURSE/SEARCH','ICON'=>'fa-solid fa-money-bill-trend-up'],
        ['RIGHTS'=>['ACCOUNTANT'],'PLACE'=>'BODY','TITLE'=>'PAYMENT','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/PAYMENT/MAIN','ICON'=>'fa-solid fa-money-bill-trend-up'],
        ['RIGHTS'=>['TEACHER','STUDENT'],'PLACE'=>'BODY','TITLE'=>'STUDY NOTES','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/STUDY_NOTES/MAIN','ICON'=>'fa-solid fa-money-bill-trend-up'],

        
        ['PLACE'=>'FOOT','TITLE'=>'Profile','LINK'=>'http://'.$SiteName[0].'.systemic.com/APPS/PROFILE','ICON'=>'fa-solid fa-user'],
        ['PLACE'=>'FOOT','TITLE'=>'Logout','LINK'=>'http://'.$SiteName[0].'.systemic.com/logout.php','ICON'=>'fa-solid fa-arrow-right-from-bracket'],
    ];
    $kali->makeSideBar($dataX);
?>

<?php $kali->insert('KALI_HEADER');?>


<div id="dash-container">
    <iframe class="dash-frame" id="dash-frame" src="<?php echo 'http://'.$SiteName[0].'.systemic.com/DASHBOARD/maindash.php';?>">
    </iframe>
</div>


</body>
</html>
