<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    //$kali->whoHasAccess(['CLIENT']);
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

<?php
    $site = $kali->getSite();
    $SQL_BRANCH='SELECT branch.name as branch_name, branch.id as branch_id FROM `branch` branch INNER JOIN `college` as college ON college.id=branch.college_id WHERE college.domain_cname=:domain_cname';
    $BRANCH = $kali->kaliPulls($SQL_BRANCH,['domain_cname'=>$site]);
?>

<section id="studentCreate-form">

    <form  id="study-note-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE STUDENTS</legend>

            <span class="error-log grid-fill danger-glow" id="study-note-error-log"></span>

                                                           
            <div class="kali-inputbox  grid-fill">
                <span>Select Branch</span>
                <select name="BRANCH" id="BRANCH" required>
                    <option value="">Choose Any One Branch</option>
                    <?php
                        foreach($BRANCH as $BRA){
                            echo '<option value="'.$BRA['branch_id'].'">'.$BRA['branch_name'].'</option>';
                        }
                    ?>
                    <option value="">Choose Any One Branch</option>
                </select>

            </div>

            <span class="kali-inputbox" id="FACULTY_OPTION">
            </span>
         
            <span class="kali-inputbox" id="FACULTY_DURATION">
            </span>   

            <span class="kali-inputbox" id="FACULTY_COURSE">
            </span>

            <span class="kali-inputbox" id="DOC_DATA">
            </span>


            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="Upload" class="kali-btn">
            </div>  

            
        </fieldset>
    </form>

</section>



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