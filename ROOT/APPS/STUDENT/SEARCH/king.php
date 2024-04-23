<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="STUDENT";
    $kali->checkAccess($APPLICATION,'SEARCH');
    $kali->link('JQUERY');
    $kali->link('');
    $kali->link('GLOBAL_DESIGN');
    $kali->link('GLOBAL_SCRIPT');
    $kali->link('KALI_FORM');
    $kali->link('ASSETS');
    $kali->link('KALI_TABLE');
    $kali->link('FONT_AWESOME');
    $kali->link('BOOTSTRAP');
    $kali->link('QR');
?>
<body>

<?php
    $SQL_FACULTY='SELECT college.faculty_id_x FROM `college` college
     INNER JOIN `branch` branch ON 
    branch.college_refid = college.id
    WHERE branch.id=(SELECT `branch_refid` FROM `user` WHERE `id`=:id)';
    $FACULTY = $kali->kaliPull($SQL_FACULTY,['id'=>$_SESSION['KOHOMAH']]);
    $FACULTY = explode(',',$FACULTY['faculty_id_x']);
?>


<form  id="student-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend"> SEARCH STUDENTS</legend>

            <span class="error-log grid-fill danger-glow" id="error-log"></span>

                  

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

            <span class="kali-inputbox" id="FACULTY_DURATION"></span>

        </div>



	<div class="kali-inputbox  grid-fill">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

</fieldset>
</form>


    <span id="searchtable"></span>

    <div id="bts_modal_container"></div>
    


</body>

    
<canvas id="qr-code"></canvas>



        
		<script>



		</script>
