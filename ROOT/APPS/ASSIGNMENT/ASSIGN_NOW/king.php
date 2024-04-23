<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="ASSIGNMENT";
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

    <form  id="assignment-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE ASSIGNMENT</legend>

            <span class="error-log grid-fill danger-glow" id="error-log"></span>

            <input type="text" style="visibility:hidden;" name="COURSE_REFID" id="COURSE_REFID" placeholder="Enter Assignment Title" value="<?php echo $_GET['COURSE_REFID'];?>" required>

            <div class="kali-inputbox grid-fill">
                <span>Assignment Title</span>
                <input type="text" name="ASSIGNMENT_TITLE" id="ASSIGNMENT_TITLE" placeholder="Enter Assignment Title" value="" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Documents (Syllabus Pdf)</span>
                <input type="file" name="ASSIGNMENT_DOCUMENT" id="ASSIGNMENT_DOCUMENT" accept="application/pdf," multiple required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Assignment Marks</span>
                <input type="number" name="ASSIGNMENT_MARK" id="ASSIGNMENT_MARK" placeholder="Enter Assignment Mark" value="" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Description</span>
                <input type="text" name="ASSIGNMENT_DESCRIPTION" id="ASSIGNMENT_DESCRIPTION" placeholder="Enter Assignment Description" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Submission Due Date</span>
                <input type="date" name="DUE_DATE" id="DUE_DATE" placeholder="Enter Submission Due Date" required>
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
