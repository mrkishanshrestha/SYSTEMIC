<?php require_once '../../SYSTEM/IMPORT/BACKEND/kali.php';


?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $kali->sysInfo('COMPANY_NAME');?></title>
    
    <?php
        $kali->link('FONT_AWESOME');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('GLOBAL_DESIGN');
    ?>

</head>
<body>

<div class="dash_container">

              <!-- DASH TITLE STARTS HERE -->
              <div class="dash_title">
                <img src="<?php echo $kali->clientInfo('PROFILE_PICTURE');?>" alt="" />
                <div class="dash_note">
                  <h1>Hello, <?php echo $kali->clientInfo('FULLNAME'); ?></h1>
                  <p>Welcome to dashboard</p>
                </div>
              </div>
              <!-- DASH TITLE ENDS HERE -->

              <!-- MAIN CARDS STARTS HERE -->
              <div class="dash_cards">

                <div class="card">
                  <i class="fa fa-calendar fa-3x" aria-hidden="true"></i>
                  <div class="dash_card_title">
                    <p class="">Number of Users</p>
                    <span class=" ">2</span>
                  </div>
                </div>

                <div class="card">
                  <i class="fa fa-calendar fa-3x" aria-hidden="true"></i>
                  <div class="dash_card_title">
                    <p class="">Total no of houses</p>
                    <span class="">12</span>
                  </div>
                </div>

                <div class="card">
                  <i
                    class="fa fa-video-camera fa-3x"
                    aria-hidden="true"
                  ></i>
                  <div class="dash_card_title">
                    <p class="">Number of Rooms</p>
                    <span class="">340</span>
                  </div>
                </div>

                <div class="card">
                  <i
                    class="fa fa-thumbs-up fa-3x"
                    aria-hidden="true"
                  ></i>
                  <div class="dash_card_title">
                    <p class="">Number of Active Users</p>
                    <span class="">645</span>
                  </div>
                </div>

              </div>
              <!-- MAIN CARDS ENDS HERE -->

              <!-- DASH BODY CONTAINER START-->
              <div class="mailBox-container">

                    <!-- GRID SHORTCUTS START 
                    <div class="grid-cuts">

                        <div class="grid-cuts-title">
                          <div>
                            <h1>Application Shortcuts</h1>
                            <p>Get Your Application Soon</p>
                          </div>
                          <i class="fa fa-usd" aria-hidden="true"></i>
                        </div>

                        <div class="grid-cuts-cards">

                              <div class="card1">
                                <h1>User Create</h1>
                                <p>User Create</p>
                              </div>

                              <div class="card2">
                                <h1>User Search</h1>
                                <p>Search User</p>
                              </div>

                              <div class="card3">
                                <h1>Users</h1>
                                <p>In Take</p>
                              </div>

                              <div class="card4">
                                <h1>Rooms</h1>
                                <p>Book</p>
                              </div>

                        </div>

                    </div>
                    GRID SHORTCUTS END -->


              </div>
              <!-- DASH BODY CONTAINER END-->
              
</div><!--dash_container-->



  </body>
</html>
