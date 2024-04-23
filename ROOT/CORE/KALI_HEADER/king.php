<?php 
include_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';
$SiteName = explode('.',$_SERVER['HTTP_HOST']);
die('jhkjh');
?>

    <link rel="stylesheet" href="styles.css">

    <?php
        $kali->link('JQUERY');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('FONT_AWESOME');
        $kali->link('ROOT/CORE/KALI_HEADER/design.css','CSS');
    ?>
    
	<script>
		$(document).ready(function(){

            juju.alerty({
                position:'bottom_right',
                title:'hello',
                msg:'hello world',
                status:'success',
            });


			$(".profile .kali_navbar_icon").click(function(){
			  $(this).parent().toggleClass("active");
			  $(".notifications").removeClass("active");
			});

			$(".notifications .kali_navbar_icon").click(function(){
			  $(this).parent().toggleClass("active");
			   $(".profile").removeClass("active");
			});

			$(".show_all .link").click(function(){
			  $(".notifications").removeClass("active");
			  $(".popup").show();
			});

			$(".close").click(function(){
			  $(".popup").hide();
			});
		});
        
	</script>

<body>

<div class="header-wrapper">

  <div class="kali_navbar">

    <div class="kali_navbar_left">
      <div class="logo">
        <a href="#"></a>
      </div>
    </div>


    
    <div class="kali_navbar_center">
      <div>
        <?php $SiteName = explode('.',$_SERVER['HTTP_HOST']); ?>
        <a class="site-title" href="king.php">asdasdasdasd<?php echo strtoupper($SiteName[0]);?></a>
      </div>
    </div>



    <div class="kali_navbar_right">

      <div class="notifications">
          
        <div class="kali_navbar_icon"><i class="far fa-bell"></i></div>
        
        <div class="notification_conatiner">

                <div class="notification-card">
                    <div class="notification_icon">
                        <i class="far fa-bell"></i>
                    </div>
                    <div class="notify_data">
                        <div class="title"> 
                            Friend Requestasdasdsadasd
                        </div>
                        <div class="sub_title">
                          Aayush Manadhar Has Sent You a FAasaSASriend Request
                      </div>
                    </div>
                </div> 




                <div class="show_all">
                    <p class="link">Show All Activities</p>
                </div> 

        </div>
        
      </div>










      <div class="profile">
        <div class="kali_navbar_icon">
          <img src="https://i.pinimg.com/280x280_RS/21/43/60/214360882539a727ad63921c477f273c.jpg" alt="profile_pic">
          <span class="name">John Alex</span>
          <i class="fas fa-chevron-down"></i>
        </div>

        <div class="profile_dd">
          <ul class="profile_ul">
            <li class="profile_li"><a class="profile" href="#"><span class="picon"><i class="fas fa-user-alt"></i>
                </span>Profile</a>
            </li>

            <li>
              <div class="btn">My Account</div>
            </li>
            <li><a class="settings" href="#"><span class="picon"><i class="fas fa-cog"></i></span>Settings</a></li>
            <li><a class="logout" href="<?php echo 'http://systemic.com/logout.php';?>"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
          </ul>
        </div>
      </div>








    </div>
  </div>
  
  <div class="popup">
    <div class="shadow"></div>
    <div class="inner_popup">
        <div class="notification_conatiner">

            <p>All Notifications</p>
            <p class="close"><i class="fas fa-times" aria-hidden="true"></i></p>
            
        </div>
    </div>
  </div>
  
</div>

</body>
</html>