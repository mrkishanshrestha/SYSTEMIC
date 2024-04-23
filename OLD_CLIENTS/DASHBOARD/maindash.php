<?php include '../../SYSTEM/IMPORT/BACKEND/kali.php';?>
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
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('QR');
    ?>

</head>

<style>
body {
    background: black;
}

.clock {
    color: #17D4FE;
    font-size: 60px;
    font-family: Orbitron;
    letter-spacing: 7px;
   


}</style>

<body>

<div class="dash_container">

              <!-- DASH TITLE STARTS HERE -->
              <div class="dash_title">
                <img src="<?php echo $kali->userInfo('PROFILE_PICTURE');?>" alt="" />
                <div class="dash_note">
                  <h1>Hello, <?php echo $kali->userInfo('FULLNAME'); ?></h1>
                  <p>Welcome to dashboard</p>
                </div>
              </div>
              <!-- DASH TITLE ENDS HERE -->

              <!-- MAIN CARDS STARTS HERE -->
              <div class="dash_cards">

                <?php if($_SESSION['MY_POST']=='STUDENT'){  ?>

                <div class="card">
                  <i class="fa-solid fa-sack-dollar fa-3x" aria-hidden="true"></i>
                  <div class="dash_card_title">
                    <p class="">Total Due Balance</p>
                    <span class=""><?php echo $kali->getBalance();?></span>
                  </div>
                </div>

                <?php }?>


                
                <?php if($_SESSION['MY_POST']=='STUDENT'){  ?>

                    <div class="card">
                      <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                      <div class="dash_card_title">
                        <p class="">Total College Visits</p>
                        <span class=""><?php echo $kali->getStudentInfo(['CASE'=>'PRESENT_DAYS']);?></span>
                      </div>
                    </div>

                <?php }?>

                                
                <?php if($_SESSION['MY_POST']=='STUDENT'){  ?>
                  <div class="card">
                    <i class="fa-solid fa-eye-low-vision fa-3x" aria-hidden="true"></i>
                    <div class="dash_card_title">
                      <p class="">Total College Absents</p>
                      <span class=""><?php echo $kali->getStudentInfo(['CASE'=>'ABSENT_DAYS']);?></span>
                    </div>
                  </div>

                  <?php }?>






                <div id="MyClockDisplay" class="clock" onload="showTime()"></div>

                <section class="main" style="font-size: 1.8rem;width: 380px;">
                            <section class="display">
                                <div class="wrapper">
                                    <h2 id="cityoutput"></h2>
                                    <p id="description"></p>
                                    <p id="temp"></p>
                                    <p id="wind"></p>
                                </div>
                            </section>
                        </section>







            
<canvas style="width: 150px;" id="QR-DATA"></canvas>
<script>
  juju.qr('<?php echo $kali->userInfo('FULLNAME'); ?>','QR-DATA');
</script>











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













































              
              <script>
                    
                    function showTime(){
                        var date = new Date();
                        var h = date.getHours(); // 0 - 23
                        var m = date.getMinutes(); // 0 - 59
                        var s = date.getSeconds(); // 0 - 59
                        var session = "AM";
                        
                        if(h == 0){
                            h = 12;
                        }
                        
                        if(h > 12){
                            h = h - 12;
                            session = "PM";
                        }
                        
                        h = (h < 10) ? "0" + h : h;
                        m = (m < 10) ? "0" + m : m;
                        s = (s < 10) ? "0" + s : s;
                        
                        var time = h + ":" + m + ":" + s + " " + session;
                        document.getElementById("MyClockDisplay").innerText = time;
                        document.getElementById("MyClockDisplay").textContent = time;
                        
                        setTimeout(showTime, 1000);
                        
                    }

                    showTime();






                    var btn = document.querySelector('#add');
                    var city = document.querySelector('#cityoutput')
                    var descrip = document.querySelector('#description')
                    var temp = document.querySelector('#temp')
                    var wind = document.querySelector('#wind')

                    apik = "3045dd712ffe6e702e3245525ac7fa38"


                    function convertion(val){
                        return (val - 273).toFixed(2)
                    }

                    function hello(){

                        fetch('https://api.openweathermap.org/data/2.5/weather?q=Kathmandu&appid='+apik)
                        .then(res => res.json())

                        .then(data => {
                            var nameval = data['name']
                            var descrip = data['weather']['0']['description']
                            var tempature = data['main']['temp']
                            var wndspd = data['wind']['speed']
                            city.innerHTML=`Weather <span>`
                            temp.innerHTML = `Temperature: <span>${ convertion(tempature)} C</span>`
                            description.innerHTML = `Sky Conditions: <span>${descrip}<span>`
                            wind.innerHTML = `Wind Speed: <span>${wndspd} km/h<span>`

                        })

                        .catch(err => alert('You entered Wrong city name'))

                    }

                    hello();

              </script>
         


              
</div><!--dash_container-->



  </body>
</html>
