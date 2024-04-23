<?php 
require_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $kali->sysInfo('COMPANY_NAME');?></title>

    <?php   
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('KALI_FORM');
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('FONT_AWESOME');
    ?>
    
</head>
<body>





<div id="body-content">


    <div id="friends-container" class="friends-container">

        <div id="friends-container-title" class="friends-container-title">
            <span>Find Friends</span>
           
                <div class="kali-inputbox grid-fill" style="width:80vw;">
                    <input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search Friends">
                </div>
        
        </div>

        <div>
            <a class="friends-container-navigation">My Friends / </a>
            <a class="friends-container-navigation"> Pending Requests / </a>
            <a class="friends-container-navigation"> Received Requests </a>
        </div>
        

        <div id="friends-container-friends-list" class="friends-container-friends-list">




                
        
               <!-- <div id="friends-list-card" class="friends-list-card">

                    <div id="friends-list-img" class="friends-list-img">
                        <img src="https://scontent.fktm7-1.fna.fbcdn.net/v/t39.30808-1/264673492_3083216861925982_4870591346022152078_n.jpg?stp=dst-jpg_p160x160&_nc_cat=102&ccb=1-5&_nc_sid=7206a8&_nc_ohc=b0Av4ClkB7wAX-NVES8&_nc_ht=scontent.fktm7-1.fna&oh=00_AT9EALW_0NeqxGYN3PtxqeOI0S4m2lYneUh6Sp-ZVKO8PA&oe=62511ECE" alt="">
                    </div>

                    
                    <div id="friends-list-title" class="friends-list-title">
                        <span class="friends-list-title-name">KisHan ShrEstha</span>
                        <span class="friends-list-title-email">kishan@jagat.com</span>
                        <span class="friends-list-title-mutual">25 Mutual Friends</span>
                    </div>

                                        
                    <div id="friends-list-setting" class="friends-list-setting">
                    <i class="fa-solid fa-message"></i>
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                
                
                </div>-->


        </div>


    
    </div>


</div>   







</body>
</html>


