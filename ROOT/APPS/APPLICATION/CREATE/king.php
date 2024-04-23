<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    //$kali->whoHasAccess(['KING']);
    $APPLICATION="APPLICATION";
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

<section id="application-form">

    <form  id="application-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE <?php echo $APPLICATION; ?></legend>

            <span class="error-log grid-fill danger-glow" id="application-create-error-log"></span>
  
            <div class="kali-inputbox grid-fill">
                <span>Application Name</span>
                <input type="text" name="APPLICATION_NAME" id="APPLICATION_NAME" placeholder="Enter Application Name" value="" required>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="LET'S GO" class="btn kali-btn">
            </div>  
        </fieldset>
    </form>

</section>

</body>
</html>

<?php
/*
    if(mail('kishanshresth21@gmail.com','hello world','kishan is great',"From:shresthabishal68@gmail.com")){
        die('sucess');
    }else{
        die('failed');
    }
*/
?>