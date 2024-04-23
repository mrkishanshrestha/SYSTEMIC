<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="COURSE_ASSIGNMENT";
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

    $SQL='SELECT user.id,user.branch_refid,user.college_refid, branch.faculty_id_x
    FROM `user` user
    INNER JOIN branch branch on branch.id = user.branch_refid
    WHERE user.id=:user_refid';
    $DATA = $kali->kaliPull($SQL,['user_refid'=>$_SESSION['KOHOMAH']]);
    $FACULTY = [];

    $SQL='SELECT `id`,`first_name`,`middle_name`,`last_name` FROM `user` WHERE `authority_refid`=( SELECT `id` FROM `authority` WHERE `name`=:authority) && `college_refid`=:college_refid && `branch_refid`=:branch_refid';
    $TEACHERS = $kali->kaliPulls($SQL,['authority'=>'TEACHER','college_refid'=>$DATA['college_refid'],'branch_refid'=>$DATA['branch_refid']]);

?>
<section id="userCreate-form">

    <form  id="course_assign-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">ASSIGN COURSE</legend>

            <span class="error-log grid-fill danger-glow" id="course_assign-error-log"></span>


                                                                       
            <div class="kali-inputbox  grid-fill">
                <span>Select Faculty</span>
                <select name="FACULTY_ID" id="FACULTY_ID" required>
                    <option value="">Choose Any Faculty</option>
                    <?php

                        if($DATA){

                               $FACULTY_ID_S =  explode(',',$DATA['faculty_id_x']);

                                foreach( $FACULTY_ID_S as $FACULTY_ID){

                                    $SQL='SELECT `short_name`,`id` FROM `faculty` WHERE `id`=:id';
                                    $FACULTY_DATA = $kali->kaliPull($SQL,['id'=>$FACULTY_ID]);
                                    echo '<option value="'.$FACULTY_DATA['id'].'">'.$FACULTY_DATA['short_name'].'</option>';

                                }

                        }
                    ?>
                </select>

            </div>

                  
            <span class="kali-inputbox" id="basedon_data">
            </span>

                              
            <span class="kali-inputbox" id="COURSE_DATA">
            </span>

            
                                                                       
            <div class="kali-inputbox  grid-fill">
                <span>Select Teacher / Lecturer</span>
                <select name="TEACHER" id="TEACHER" required>
                    <option value="">Choose Any Teacher</option>
                    <?php

                        if($TEACHERS){

                            foreach($TEACHERS as $TEACHER){
                                echo '<option value="'.$TEACHER['id'].'">'.$TEACHER['first_name'].' '.$TEACHER['middle_name'].' '.$TEACHER['last_name'].'</option>';
                            }

                        }
                    ?>
                </select>

            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="ASSIGN NOW" class="kali-btn">
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