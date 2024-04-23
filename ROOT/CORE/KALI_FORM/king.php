<?php 

echo "hello";


?>
<body>
<link rel="stylesheet" href="design.css">

<section id="login-form">

    <form  action="processlogin.php" method="post">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">LOGIN FORM</legend>
            
            <div class="kali-inputbox">
                <span>Username / Email</span>
                <input type="text" name="username" placeholder="Enter Your Username Or Email" value="">
            </div>
            
            <div class="kali-inputbox">
                <span>Password</span>
                <input type="password" name="username" placeholder="Enter Your Username Or Email" value="">
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="submit" value="LET'S GO" class="kali-btn">
            </div>  
        </fieldset>
    </form>

</section>
</body>