<?php 
include_once '../../../SYSTEM/IMPORT/BACKEND/kali.php'; 
/*
you need to enable global css to modifythis footer manually 
<link rel="stylesheet" href="<?php echo $kali->pathMaker('GLOBAL_DESIGN');?>">*/
?>

<?php
        $kali->link('FONT_AWESOME');
        $kali->link('ROOT/CORE/FOOTER/design.css','CSS');
?>

<section class="footer">

<div class="box-container">

    <div class="box">
        <a href="#" class="logo"><img src="<?php echo $kali->sysInfo('COMPANY_LOGO');?>" alt=""><?php echo $kali->sysInfo('COMPANY_NAME');?>
     </a>
        <p>Make Your System More Better</p>
        <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
        </div>
    </div>


    <div class="box">
        <h3>contact info</h3>
        <p> <i class="fas fa-map"></i> Kathmandu, Nepal </p>
        <p> <i class="fas fa-phone"></i> +977-9851337363 </p>
        <p> <i class="fas fa-envelope"></i> systemic@systemic.com </p>
        <p> <i class="fas fa-clock"></i> 12:00am - 12:00pm </p>
    </div>

    <div class="box">
        <h3>Remarks</h3>
        <p>Remark for this website</p>
        <form action="">
            <input type="text" name="" placeholder="enter your remark" class="email" id="">
            <input type="submit" value="Leave Remarks" class="btn">
        </form>
    </div>

</div>

</section>

<div class="developers">created by <span><a href="https://facebook.com/hello2121">mr.KisHan ShrEstha</a> </span> | all rights reserved!</div>

<script src="<?php// echo $kali->pathMaker('ROOT/CORE/FOOTER/script.js');?>"></script>