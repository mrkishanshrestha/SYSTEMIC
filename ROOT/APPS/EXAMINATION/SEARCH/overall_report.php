<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "EXAMINATION";
    $kali->checkAccess($APPLICATION,'SEARCH');
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


        function loadExaminations(EXAMINATION_REFID,COURSE_REFID,AUTHORITY) {

            var today = new Date();
            var current_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();


            var jackxData = juju.postJackx('getStudents.php',{EXAMINATION_REFID: EXAMINATION_REFID,COURSE_REFID:COURSE_REFID});

            jackxData.done(function(data){

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['STUDENT NAME','STATUS','REPORT'],ID:'EXAMINATION_REPORT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                    var SNcounter=1;
                    jsonData.forEach(element => {

                        if(element.status == "FAIL"){
                            element.status = "<div style='background:red;color:white;'>FAIL</div>";
                        }
                        if(element.status == "PASS"){
                            element.status = "<div style='background:green;color:white;'>PASS</div>";
                        }

                        if(element.status == null){
                            element.status = "----";
                        }
                        if(element.status == null){
                            element.status = "----";
                        }
                  
                        reportTitle = "REPORT";
                        reportBtn = `<button id="reportCardBtn" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/EXAMINATION/SEARCH/reportCard.php?EXAMINATION_REFID=`+element.exam_id+`&EXAMINATION_DETAIL_REFID=`+element.id+`&USER_REFID=`+element.user_refid+`&COURSE_REFID=`+COURSE_REFID+`');" >REPORT</button>`;
                    

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['STUDENT_NAME','STATUS','REPORT'],
                            CONTENT:[
                                element.fullname,element.status,reportBtn
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

        loadExaminations('<?php echo $_GET['EXAMINATION_REFID']; ?>','<?php echo $_GET['COURSE_REFID']; ?>','<?php echo $_SESSION['MY_AUTHORITY']; ?>');

        
        $('#EXAMINATION_TABLE_MODAL').on('hidden.bs.modal', function () {
                    $('#bts_modal_container').empty();
        });

    });/* ON READY */



</script>



</body>
</html>
