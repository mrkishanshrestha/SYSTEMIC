<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';    
    $APPLICATION="BRANCH";
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

<?php
    $SQL_COLLEGES='SELECT `name`,`short_name` FROM `college` WHERE `user_refid`=:user_refid';
    $COLLEGES = $kali->kaliPulls($SQL_COLLEGES,['user_refid'=>$_SESSION['KOHOMAH']]);

    $SQL_FACULTY='SELECT `name`,`short_name` FROM `faculty`';
    $FACULTY = $kali->kaliPulls($SQL_FACULTY,[]);


?>

<section id="collegeCreate-form">

    <form  id="branch-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE <?php echo $APPLICATION; ?></legend>

            <span class="error-log grid-fill danger-glow" id="branch-create-form-error-log"></span>

                        
            <div class="kali-inputbox grid-fill">
                <span>Select Affilaiton</span>
                <select name="COLLEGE_NAME" id="COLLEGE_NAME" required>
                    <option value="" selected>Choose Colleges</option>
                <?php
                    foreach($COLLEGES as $COLLEGE){
                        echo '<option value="'.$COLLEGE['short_name'].'" >'.$COLLEGE['name'].' ('.$COLLEGE['short_name'].')'.'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="kali-inputbox">
                <span>Branch Name</span>
                <input type="text" name="BRANCH_NAME" id="BRANCH_NAME" placeholder="EG: ACHS KAMLADI BRANCH" value="" required>
            </div>
                  
            <div class="kali-inputbox">
                <span>Branch Location</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="EG: Kamladi, Dillibazar" value="" required>
            </div>
                        
            <div class="kali-inputbox">
                <span>Geo Location</span>
                <input type="text" name="GEO_LOCATION" id="GEO_LOCATION" placeholder="Enter Google Geo Location" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number" name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Contact Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>
                  
            <div class="kali-inputbox">
                <span>Phone Number</span>
                <input type="number" name="PHONE_NUMBER" id="PHONE_NUMBER" placeholder="Enter Phone Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

            <div class="kali-checkbox grid-fill" id="FACULTY">
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