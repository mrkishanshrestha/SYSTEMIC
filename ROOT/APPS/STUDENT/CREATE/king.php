<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    //$kali->whoHasAccess(['CLIENT']);
    $APPLICATION="STUDENT";
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
    $SQL_FACULTY='SELECT branch.faculty_id_x FROM `branch` branch
    WHERE branch.id=(SELECT `branch_refid` FROM `user` WHERE `id`=:id)';
    $FACULTY = $kali->kaliPull($SQL_FACULTY,['id'=>$_SESSION['KOHOMAH']]);
    $FACULTY = explode(',',$FACULTY['faculty_id_x']);
?>

<section id="student-form">

    <form  id="student-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend"><?php echo $kali->getUserInfo('COLLEGE_NAME');?> <br> CREATE STUDENTS</legend>

            <span class="error-log grid-fill danger-glow" id="student-create-error-log"></span>

                                                           
            <div class="kali-inputbox  grid-fill">
                <span>Select Faculty</span>
                <select name="FACULTY" id="FACULTY" onchange="hello();" required>
                    <?php
                        foreach($FACULTY as $FACULTY_REFID){
                            $SQL_FACULTY='SELECT `name`,`short_name` FROM `faculty` WHERE `id`=:id';
                           $FACULTY_NAME = $kali->kaliPull($SQL_FACULTY,['id'=>$FACULTY_REFID]);
                            echo '<option value="'.$FACULTY_REFID.'">'.$FACULTY_NAME['name'].' ( '.$FACULTY_NAME['short_name'].' )'.'</option>';
                        }
                    ?>
                    <option value="" selected>Choose Any One Faculty</option>
                </select>

            </div>

            <span class="kali-inputbox" id="FACULTY_DURATION">
            </span>

            <div class="kali-inputbox">
                <span>First Name</span>
                <input type="text" name="FIRST_NAME" id="FIRST_NAME" placeholder="Enter First Name" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Middle Name</span>
                <input type="text" name="MIDDLE_NAME" id="MIDDLE_NAME" placeholder="Enter Middle Name" value="" >
            </div>
           
            <div class="kali-inputbox">
                <span>Last Name</span>
                <input type="text" name="LAST_NAME" id="LAST_NAME" placeholder="Enter Last Name" value="" required>
            </div>
           
                        
            <div class="kali-inputbox">
                <span>Email</span>
                <input type="email" name="EMAIL" id="EMAIL" placeholder="Enter Email" value="" required>
            </div>
            
            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number" name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Contact Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

            <div class="kali-inputbox">
                <span>Gurdian Number</span>
                <input type="number" name="GURDIAN_NUMBER" id="GURDIAN_NUMBER"  placeholder="Enter Phone Number" value="" maxlength=10 required>
            </div>
           
            <div class="kali-inputbox">
                <span>Address</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="Enter Address" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Profile Image</span>
                <input type="file" name="USER_PROFILE_PICTURE" id="USER_PROFILE_PICTURE" required>
            </div>

            <div class="kali-inputbox">
                <span>Documents (Image File)</span>
                <input type="file" name="USER_DOCUMENT" id="USER_DOCUMENT" required>
            </div>

            <!--
            <div class="kali-checkbox grid-fill">

                <span>Can Login To: </span>

                <div class="kali-checkbox-options">

                        <div class="kali-checkbox-option-data">
                            <input class="kali-checkbox-data" name="ACCESS_TO[]"  type="checkbox" value="ACHS" id="ACHS"  >
                            <label  for="ACHS">ACHS</label>
                        </div>

                        <div class="kali-checkbox-option-data">
                            <input class="kali-checkbox-data" name="ACCESS_TO[]" type="checkbox" value="IIMS" id="IIMS">
                            <label for="IIMS">IIMS</label>
                        </div>

                </div>
            </div>

            -->
             
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