<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="EXAMINATION";
    $kali->checkAccess($APPLICATION,'CREATE');
?>
<html>
<head>
    <?php
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
   ?>

</head>
<body>

<section id="assignment-form">

    <form  id="examination-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE EXAMINATION</legend>

            <span class="error-log grid-fill danger-glow" id="error-log"></span>

            <div class="kali-inputbox grid-fill">
                <span>Examination Title</span>
                <input type="text" name="EXAMINATION_TITLE" id="EXAMINATION_TITLE" placeholder="Enter Examination Title" value="" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Examination Year</span>
                <input type="number" name="EXAMINATION_YEAR" id="EXAMINATION_YEAR" placeholder="Enter Examination Year" value="" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="LET'S GO" class="kali-btn">
            </div>  
            
        </fieldset>
    </form>

</section>

</body>
</html>


<?php
