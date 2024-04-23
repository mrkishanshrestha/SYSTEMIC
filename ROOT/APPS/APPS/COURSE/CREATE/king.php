<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $appTitle="COURSE";
    $kali->whoHasAccess(['KING']);
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

<?php
    $SQL_FACULTY='SELECT `name`,`short_name` FROM `faculty`';
    $FACULTY = $kali->kaliPulls($SQL_FACULTY,[]);
?>

<section id="courseCreate-form">

    <form  id="course-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE <?php echo $appTitle; ?></legend>

            <span class="error-log grid-fill danger-glow" id="course-create-form-error-log"></span>
                                                
            <div class="kali-inputbox">
                <span>Faculty</span>
                <select name="FACULTY" id="FACULTY" required>
                    <option value="" selected>Choose Faculty</option>
                    <?php
                    foreach($FACULTY as $FAC){
                        echo '<option value="'.$FAC['name'].'" >'.$FAC['name'].' ('.$FAC['short_name'].')'.'</option>';
                    }
                    ?>
                </select>
                
            </div>

            <div class="kali-inputbox" id="basedon_data">
                <span>Faculty Periods</span>
                <select name="FACULTY_PERIOD" id="FACULTY_PERIOD" required>
                    <option value="" selected>Choose Faculty Periods</option>
                </select>
            </div>
                                       

            <div class="kali-inputbox">
                <span>Course Name</span>
                <input type="text" name="COURSE_NAME" id="COURSE_NAME" placeholder="EG: Scripting Language" value="" required>
            </div>
                     
            <div class="kali-inputbox">
                <span>Course Code</span>
                <input type="text" name="COURSE_CODE" id="COURSE_CODE" placeholder="EG: CACS254" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Credit Hrs</span>
                <input type="text" name="CREDIT_HRS" id="CREDIT_HRS" placeholder="EG: 3" value="" required>
            </div>


            <div class="kali-inputbox">
                <span>Lecture Hrs</span>
                <input type="text" name="LECTURE_HRS" id="LECTURE_HRS" placeholder="EG: 3" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Tutorial Hrs</span>
                <input type="text" name="TUTORIAL_HRS" id="TUTORIAL_HRS" placeholder="EG: 3" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Lab Hrs</span>
                <input type="text" name="LAB_HRS" id="LAB_HRS" placeholder="EG: 3" value="" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Documents (Syllabus Pdf)</span>
                <input type="file" name="COURSE_DOCUMENT" id="COURSE_DOCUMENT" accept="application/pdf," multiple required>
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