<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "EXAMINATION";
    $kali->checkAccess($APPLICATION,'SEARCH');

    $sql = 'SELECT *,(SELECT `title` FROM `examination` WHERE `id`=:EXAMINATION_REFID) as exam_title,
    (SELECT `year` FROM `examination` WHERE `id`=:EXAMINATION_REFID) as exam_year
     FROM `examination_details`  WHERE `examination_refid`=:EXAMINATION_REFID';
    $data = $kali->kaliPull($sql,['EXAMINATION_REFID'=>$_GET['EXAMINATION_REFID']]);
    if(!$data){
      //$kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid EXAMINATION','TARGET'=>['EXAMINATION_REFID']]);
      echo '<h1 style="color:red;">No Examination Published Till Now </h1>';
      die;
    }

?>
<html>
<head>

    <?php
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('FONT_AWESOME');
        $kali->link('BOOTSTRAP');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('KALI_FORM');
        $kali->link('KALI_TABLE');
    ?>

</head>
<body>

<h1> <?php echo $data['exam_title'].'  '.$data['exam_year']; ?></h1>

<span id="searchtable"></span>
<div id="bts_modal_container"></div>

<script>

    function giveMarks(DB_TUPLE_ID,USER_REFID){
        
        var ModalId = 'EXAMINATION_TABLE_MODAL';
        var AutoForm =`    
        <form  id="assignment-marking-form" onsubmit="hello(); return false;" method="post" enctype = "multipart/form-data">
            <fieldset class="kali-form">
                <legend class="kali-formLegend">GRADE THIS EXAMINATION</legend>

                <span class="error-log grid-fill danger-glow" id="error-log"></span>

                <input type="text" style="visibility:hidden;" name="EXAMINATION_DEATILS_REFID" id="EXAMINATION_DEATILS_REFID" value="`+DB_TUPLE_ID+`" required>
                <input type="text" style="visibility:hidden;" name="USER_REFID" id="USER_REFID" value="`+USER_REFID+`" required>

                <div class="kali-inputbox grid-fill">
                    <span>Examination Marks</span>
                    <input type="number" name="EXAMINATION_MARKS" id="EXAMINATION_MARKS" placeholder="Enter Examination Marks" value="" required>
                </div>

                <div class="kali-inputbox grid-fill">
                    <span>Examination Remarks</span>
                    <input type="text" name="EXAMINATION_REMARKS" id="EXAMINATION_REMARKS" placeholder="Enter Examination Remarks" value="" required>
                </div>

                <div class="kali-inputbox kali-inputbtn">
                    <input type="submit" name="SUBMIT" value="LET'S GO" class="kali-btn">
                </div>  
            </fieldset>
        </form>
        
        `;

        juju.makeModal({
            APPEND_TO:'bts_modal_container',
            TITLE:'DATA EDITOR',
            MODAL_ID_NAME: ModalId,
            BODY:AutoForm,
            FUNCTION:`uploadExamination(`+DB_TUPLE_ID+`);`,
        });

        juju.bootModal('show',ModalId);

        $('#'+ModalId).on('hidden.bs.modal', function () {
            $('#bts_modal_container').empty();
        });

    }


    $(document).ready(function(){


        function loadExaminations(EXAMINATION_REFID,COURSE_REFID,AUTHORITY,EXAM_TITLE,YEAR) {

            var today = new Date();
            var current_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            var uploadTitle = "";
            var uploadBtn = "";

            var jackxData = juju.postJackx('getStudents.php',{EXAMINATION_REFID: EXAMINATION_REFID,COURSE_REFID:COURSE_REFID,EXAM_TITLE:EXAM_TITLE,YEAR:YEAR});

            jackxData.done(function(data){

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['STUDENT NAME','STATUS','MARK OBTAINED','REMARKS',uploadTitle],ID:'EXAMINATION_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                    var SNcounter=1;
                    jsonData.forEach(element => {

                        if(element.obtained_marks == null){
                            element.obtained_marks = "0";
                        }
                        if(element.status == null){
                            element.status = "----";
                        }
                        if(element.status == null){
                            element.status = "----";
                        }
                        if(element.remarks == null){
                            element.remarks = "----";
                        }

                        if(element.status == "FAIL"){
                            element.status = "<div style='background:red;color:white;'>FAIL</div>";
                        }
                        if(element.status == "PASS"){
                            element.status = "<div style='background:green;color:white;'>PASS</div>";
                        }


                        if(AUTHORITY=="TEACHER"){
                            uploadTitle = "MARKING";
                            uploadBtn = `<button id="markingBtn" onclick="giveMarks('`+element.id+`','`+element.user_refid+`');" >MARKING</button>`;
                        }

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['STUDENT_NAME','STATUS','MARK_OBTAINED','REMARKS',uploadTitle],
                            CONTENT:[
                                element.fullname,element.status,element.obtained_marks,element.remarks,uploadBtn
                            ],
                            COUNTER:SNcounter
                        });
                        SNcounter++;
                    });
                    
                    }).catch((data)=>{
                        alert('error in making table');
                    });

            });

        } /* FUNCTION LOAD ASSIGNENT */

        loadExaminations('<?php echo $_GET['EXAMINATION_REFID']; ?>','<?php echo $_GET['COURSE_REFID']; ?>','<?php echo $_SESSION['MY_AUTHORITY']; ?>','<?php echo $_GET['TITLE']; ?>','<?php echo $_GET['YEAR']; ?>',);

        
        $('#EXAMINATION_TABLE_MODAL').on('hidden.bs.modal', function () {
                    $('#bts_modal_container').empty();
        });

    });/* ON READY */

    function hello(){

        event.preventDefault();

        const formObj = document.getElementById('assignment-marking-form');

        var jackxData = juju.sendJackx({
            URL:'uploadExaminationGrading.php',
            FORM:formObj
        });

        jackxData.done(function(data){  
            data = JSON.parse(data);
            console.log(data);
            if(data.ERROR){
                juju.fireError({
                    MSG:data.MSG,
                    TARGET:data.TARGET,
                    ERROR_LOG_ID:'error-log',
                });

                juju.alerty({
                    status:'danger',
                    msg:data.MSG,
                    title:'ERROR',
                    position:'top_right'
                });

            }else{
                juju.alerty({
                    status:'success',
                    msg:'Data Added Sucessfully',
                    title:'Hurray',
                    position:'top_right'
                });
                document.getElementById("assignment-marking-form").reset();
                juju.bootModal('close','EXAMINATION_TABLE_MODAL');
                document.getElementById('classroom-iframe').contentWindow.location.reload();

            }
        });


    }


</script>



</body>
</html>
