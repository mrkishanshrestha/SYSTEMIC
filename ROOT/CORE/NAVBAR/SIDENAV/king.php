<?php 
include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

$GLOBALS['kali'] = &$kali;

$dataX=[
    ['PLACE'=>'BODY','TITLE'=>'DASHBOARD','LINK'=>'http://sweethome.com/ROOT/ELEMENTS/DASHBOARD/maindash.php','ICON'=>'fa-brands fa-dashcube'],
    ['PLACE'=>'BODY','TITLE'=>'USERS','LINK'=>'http://sweethome.com/ROOT/ELEMENTS/APPS/USER/MAIN','ICON'=>'fa-solid fa-users'],
    ['PLACE'=>'BODY','TITLE'=>'HOME','LINK'=>'http://sweethome.com/ROOT/ELEMENTS/APPS/HOME/MAIN','ICON'=>'fa-solid fa-house'],
    ['PLACE'=>'BODY','TITLE'=>'ROOM','LINK'=>'http://sweethome.com/ROOT/ELEMENTS/APPS/ROOM/MAIN','ICON'=>'fa-solid fa-person-shelter'],

    ['PLACE'=>'FOOT','TITLE'=>'Profile','LINK'=>'http://sweethome.com/ROOT/ELEMENTS/APPS/PROFILE','ICON'=>'fa-solid fa-user'],
    ['PLACE'=>'FOOT','TITLE'=>'Logout','LINK'=>'http://sweethome.com/logout.php','ICON'=>'fa-solid fa-arrow-right-from-bracket'],
];
makeDash($dataX);
?>
    <?php
    ?>

    <?php
    
    function makeDash($dataX){
        $kali=$GLOBALS['kali'];
        echo "
        <nav class='sidebar close'>
            <header>
                <div class='image-text'>
                    <a href='king.php'>
                    <span class='image'>
                        <img src='".$kali->sysInfo('COMPANY_LOGO')."'  alt=''>
                    </span>
                    </a>
                    <div class='text logo-text'>
                        <span class='name'>".$kali->sysInfo('COMPANY_NAME')."</span>
                        <span class='profession'>asdasd</span>
                    </div>
                </div>

                <i class='fa-solid fa-chevron-right toggle'></i>
            </header>

            <div class='menu-bar'>
                <div class='menu'>

                    <ul class='menu-links'>
                    ";

                foreach($dataX as $data){
                    if($data['PLACE']=='BODY'){
                        echo"
                        <li class='nav-link' onclick='changeDash(\"".$data['LINK']."\");'>
                            <a>
                                <i class='bx ".$data['ICON']." icon' ></i>
                                <span class='text nav-text'>".$data['TITLE']."</span>
                            </a>
                        </li>";
                    }
                }
                echo"
                    </ul>
                </div>

                <div class='bottom-content'> ";

                    foreach($dataX as $data){
                        if($data['PLACE']=='FOOT'){
                            echo"
                                <li class=''>
                                    <a href=".$data['LINK']." >
                                    <i class=' ".$data['ICON']." icon'></i>
                                        <span class='text nav-text'>".$data['TITLE']."</span>
                                    </a>
                                </li>";
                        }
                    }
                    
                    echo"
                </div>
            </div>
        </nav>

 ";

}

?>
