<?php 
require_once '../../../SYSTEM/IMPORT/BACKEND/kali.php'; ?>

<?php
    $kali->link('ROOT/CORE/HEADER/script.js','JS');
    $kali->link('ROOT/CORE/HEADER/design.css','CSS');
?>

<header class="header" id="header">

    <div id="menu-btn">MENU</div>

    <a href="<?php echo $kali->sysInfo('COMPANY_DOMAIN');?>" class="logo"> <i ><img src="<?php echo $kali->sysInfo('COMPANY_LOGO');?>" alt=""></i><?php echo $kali->sysInfo('COMPANY_NAME');?> </a>

    <nav class="navbar" id="navbar">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#destination">destination</a>
        <a href="#services">services</a>
        <a href="#gallery">gallery</a>
        <a href="#blogs">blogs</a>
    </nav>

    <a  href="#login-form" class="btn">LOGIN NOW</a>

</header>
