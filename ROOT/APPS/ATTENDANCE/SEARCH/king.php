<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="ATTENDANCE";
    $kali->checkAccess($APPLICATION,'VIEW');
?>
<html>
<head>
    <?php
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('KALI_TABLE');
        $kali->link('FONT_AWESOME');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
   ?>

</head>
<body>


<section id="studentCreate-form">

    <form  id="student-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">View Attendance Report</legend>

            <span class="error-log grid-fill danger-glow" id="student-create-error-log"></span>

                                                           
            <div class="kali-inputbox">
                <span>Pick a Start Date</span>
                <input type="date" id="START_DATE"/>
            </div>
                
            <div class="kali-inputbox">
                <span>Pick a End Date</span>
                <input type="date" id="END_DATE"/>
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <button class="btn kali-btn" onclick="getReport('<?php echo $_GET['COURSE_REFID'];?>');">Get Report</button>
            </div>  

        </fieldset>
    </form>

</section>


    <span style="font-size: 2rem;" id="selected-date"></span>


    <span id="searchtable"></span>

    <div id="bts_modal_container"></div>



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