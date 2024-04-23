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
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
   ?>

</head>
<body>

<?php
    $SQL='SELECT `id`,`name`,`short_name` FROM `college` WHERE `user_refid`=:user_refid';
    $COLLEGE_DATA = $kali->kaliPulls($SQL,['user_refid'=>$_SESSION['KOHOMAH']]);
?>
<section id="userCreate-form">

    <form  id="user-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE USER</legend>

            <span class="error-log grid-fill danger-glow" id="user-create-error-log"></span>


            <div class="kali-inputbox  grid-fill">
                <span>Select College</span>
                <select name="COLLEGE_REFID" id="COLLEGE_REFID" required>
                    <option value="">Choose Any One College</option>
                    <?php
                        foreach($COLLEGE_DATA as $data){
                            echo '<option value="'.$data['id'].'">'.$data['name'].' ( '.$data['short_name'].' )'.'</option>';
                        }
                    ?>
                </select>
            </div>  

            <div class="kali-inputbox  grid-fill"  id="faculty_data">
                <span>Select Faculty</span>
                <select name="FACULTY_REFID" id="FACULTY_REFID" required>
                    <option value="">Choose Any One Faculty</option>
                </select>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Faculty Full Amount</span>
                <input type="number" name="AMOUNT" id="AMOUNT" placeholder="Enter Amount" value="" required>
            </div>

  
            <div class="kali-inputbox grid-fill">
                <span>Admission Fee</span>
                <input type="text" name="ADMISSION_FEE" id="ADMISSION_FEE" placeholder="Enter Admission Fee" value="" required>
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