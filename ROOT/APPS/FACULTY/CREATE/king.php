<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->whoHasAccess(['KING']);
    $appTitle="FACULTY";
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

<section id="collegeCreate-form">

    <form  id="faculty-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE <?php echo $appTitle; ?></legend>

            <span class="error-log grid-fill danger-glow" id="faculty-create-form-error-log"></span>

            <div class="kali-inputbox">
                <span>Faculty Full Name</span>
                <input type="text" name="FACULTY_NAME" id="FACULTY_NAME" placeholder="EG: Bachlores In Computer Application" value="" required>
            </div>
                     
            <div class="kali-inputbox">
                <span>Faculty Short Name</span>
                <input type="text" name="FACULTY_SHORT_NAME" id="FACULTY_SHORT_NAME" placeholder="EG: BCA" value="" required>
            </div>

                                    
            <div class="kali-inputbox">
                <span>Select Based On</span>
                <select name="BASED_ON" id="BASED_ON" required>
                    <option value="" selected>Choose Faculty Periods</option>
                    <option value="YEARLY" >YEARLY</option>
                    <option value="SEMESTER" >SEMESTER</option>
                </select>
            </div>

            <div class="kali-inputbox">
                <span>No Of Periods</span>
                <input type="number"  style="width: 40vw;" name="NO_OF_PERIODS" id="NO_OF_PERIODS" placeholder="Eg: 8 (semester)" value="" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Description</span>
                <input type="text"  style="width: 40vw;" name="DESCRIPTION" id="DESCRIPTION" placeholder="Enter Cmane Eg : HAWA TAWA TADA" value="" required>
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
/*
    if(mail('kishanshresth21@gmail.com','hello world','kishan is great',"From:shresthabishal68@gmail.com")){
        die('sucess');
    }else{
        die('failed');
    }
*/
?>