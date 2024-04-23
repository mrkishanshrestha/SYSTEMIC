<?php include '../SYSTEM/IMPORT/BACKEND/kali.php';?>
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
        $kali->link('QR');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('GLOBAL_DESIGN');
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
}

#qrcode {
  width:160px;
  height:160px;
  margin-top:15px;
}

</style>


<body>

<?php if($_SESSION['USERKONAM']!='KING'){
        $ppImgSrc = $kali->userInfo('PROFILE_PICTURE');  
      }
  ?>

<div class="dash_container">

              <!-- DASH TITLE STARTS HERE -->
              <div class="dash_title">
                <img src="<?php echo $ppImgSrc;?>" alt="" />
                <div class="dash_note">
                  <h1>Hello, <?php echo $_SESSION['USERKONAM'];?></h1>
                  <p>Welcome to dashboard</p>
                </div>
              </div>
              <!-- DASH TITLE ENDS HERE -->

              <!-- MAIN CARDS STARTS HERE -->
              <div class="dash_cards">


              <?php if($_SESSION['MY_POST']=='KING'){?>

                <div class="card">
                  <i class="fa-solid fa-users fa-3x" aria-hidden="true"></i>
                  <div class="dash_card_title">
                    <p class="">Total no of Clients</p>
                    <span class=""><?php echo $kali->getData('TOTAL_CLIENTS');?></span>
                  </div>
                </div>
              <?php } ?>


              
              <?php if($_SESSION['MY_POST']=='KING'){?>
                    <div class="card">
                      <i class="fa-solid fa-users fa-3x" aria-hidden="true"></i>
                      <div class="dash_card_title">
                        <p class="">Total no of Users In Database</p>
                        <span class=""><?php echo $kali->getData('TOTAL_USERS');?></span>
                      </div>
                    </div>
              <?php } ?>

              <?php if($_SESSION['MY_POST']=='KING'){?>
              <div class="card">
                <i class="fa-solid fa-users fa-3x" aria-hidden="true"></i>
                <div class="dash_card_title">
                  <p class="">Total no of Users In Database</p>
                  <span class=""><?php echo $kali->getData('TOTAL_USERS');?></span>
                </div>
              </div>
              <?php } ?>

                    
              
              <?php if($_SESSION['MY_POST']=='CLIENT'){?>
                    <div class="card">
                      <i class="fa-solid fa-school fa-3x" aria-hidden="true"></i>
                      <div class="dash_card_title">
                        <p class="">Total no of Students In DB</p>
                        <span class=""><?php echo $kali->getData('TOTAL_STUDENTS');?></span>
                      </div>
                    </div>
            <?php } ?>





            <?php if($_SESSION['MY_POST']=='CLIENT'){?>
                    <div class="card">
                      <i class="fa-solid fa-school fa-3x" aria-hidden="true"></i>
                      <div class="dash_card_title">
                        <p class="">Total no of Students In DB</p>
                        <span class=""><?php echo $kali->getData('TOTAL_STUDENTS');?></span>
                      </div>
                    </div>
            <?php } ?>









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

 
<?php if($_SESSION['MY_POST']=='CLIENT'){?>

<div class="card">
  <i class="fa-solid fa-users fa-3x" aria-hidden="true"></i>
  <div class="dash_card_title">
    <p class="">Total no of Colleges</p>
    <span class=""><?php echo $kali->getData('TOTAL_COLLEGES');?></span>
  </div>
</div>
<?php } ?>

              </div>
              <!-- MAIN CARDS ENDS HERE -->


<canvas style="width: 150px;" id="QR-DATA"></canvas>
<script>
  juju.qr('<?php echo $kali->userInfo('FULLNAME'); ?>','QR-DATA');
</script>














































              
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











                        var qrcode = new QRCode("qrcode");

                            function makeCode () {    
                              var elText = document.getElementById("text");
                              
                              if (!elText.value) {
                                alert("Input a text");
                                elText.focus();
                                return;
                              }
                              
                              qrcode.makeCode(elText.value);
                            }

                            makeCode();

                            $("#text").
                              on("blur", function () {
                                makeCode();
                              }).
                              on("keydown", function (e) {
                                if (e.keyCode == 13) {
                                  makeCode();
                                }
                              });

                  </script>
             
              
</div><!--dash_container-->



  </body>
</html>
