<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
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

    <form  id="student-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">SEARCH STATEMENTS</legend>

            <span class="error-log grid-fill danger-glow" id="student-create-error-log"></span>

                                                           
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

            <span id="STUDENT_SEARCH_SPAN" class="grid-fill" style="display:none;">
                <div class="kali-inputbox">
                    <input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
                </div>
                <div class="kali-inputbox kali-inputbtn">
                    <button class="kali-btn" id="data-loader-btn" onclick="printDiv('statementSearhTable');">Print Statement</button>
                </div>  
            </span>





            
        </fieldset>
    </form>

</section>



    <span id="searchtable"></span>
    
    <span id="statementSearhTable"></span><br/><br/>

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