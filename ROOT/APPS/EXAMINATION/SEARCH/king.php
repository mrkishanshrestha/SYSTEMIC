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

<h1> Examination Search  </h1>

<span id="searchtable"></span>
<div id="bts_modal_container"></div>

<script>

    function openFileUpload(DB_TUPLE_ID,COURSE_REFID){
        
        var ModalId = 'EXAMINATION_TABLE_MODAL';
        var AutoForm =`    
        <form  id="examination-upload-form" onsubmit="hello(); return false;" method="post" enctype = "multipart/form-data">
            <fieldset class="kali-form">
                <legend class="kali-formLegend">UPLOAD EXAMINATION</legend>

                <span class="error-log grid-fill danger-glow" id="error-log"></span>

                <input type="text" style="visibility:hidden;" name="EXAMINATION_REFID" id="EXAMINATION_REFID" placeholder="Enter Examination Title" value="`+DB_TUPLE_ID+`" required>
                <input type="text" style="visibility:hidden;" name="COURSE_REFID" id="COURSE_REFID" placeholder="Enter Examination Title" value="`+COURSE_REFID+`" required>

                <div class="kali-inputbox grid-fill">
                    <span>Documents (Pdf)</span>
                    <input type="file" name="EXAMINATION_DOCUMENT" id="EXAMINATION_DOCUMENT" accept="application/pdf," multiple required>
                </div>

                <div class="kali-inputbox grid-fill">
                    <span>Examination Full Marks</span>
                    <input type="number" name="EXAMINATION_FULL_MARKS" id="EXAMINATION_FULL_MARKS" placeholder="Enter Examination Full Marks" value="" required>
                </div>

                <div class="kali-inputbox grid-fill">
                    <span>Examination Pass Marks</span>
                    <input type="number" name="EXAMINATION_PASS_MARKS" id="EXAMINATION_PASS_MARKS" placeholder="Enter Examination Pass Marks" value="" required>
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


        function loadExaminations(COURSE_REFID,AUTHORITY) {

            var today = new Date();
            var current_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            var uploadTitle = "";
            var uploadBtn = "";

            var jackxData = juju.postJackx('process.php',{COURSE_REFID: COURSE_REFID});

            jackxData.done(function(data){

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['TITLE','YEAR','','REPORT','VIEW'],ID:'EXAMINATION_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                    var SNcounter=1;
                    jsonData.forEach(element => {

                        if(AUTHORITY != "STUDENT"){ 
                            uploadTitle = "UPLOAD";
                            uploadBtn = `<button id="examinationUploadBtn" onclick="openFileUpload('`+element.id+`','`+COURSE_REFID+`');" >UPLOAD</button>`;
                        }
                                      
                        viewTitle = "VIEW";
                        viewBtn = `<button id="examinationViewBtn" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/EXAMINATION/SEARCH/report.php?EXAMINATION_REFID=`+element.id+`&COURSE_REFID=`+COURSE_REFID+`&TITLE=`+element.title+`&YEAR=`+element.year+`');" >VIEW</button>`;
                    
                        reportTitle = "REPORT";
                        reportBtn = `<button id="examinationReportBtn" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/EXAMINATION/SEARCH/overall_report.php?EXAMINATION_REFID=`+element.id+`&COURSE_REFID=`+COURSE_REFID+`');" >REPORT</button>`;
                    


                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['TITLE','YEAR',uploadTitle,reportTitle,viewTitle],
                            CONTENT:[
                                element.title,element.year,uploadBtn,reportBtn,viewBtn
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

        loadExaminations('<?php echo $_GET['COURSE_REFID']; ?>','<?php echo $_SESSION['MY_AUTHORITY']; ?>');

        
        $('#EXAMINATION_TABLE_MODAL').on('hidden.bs.modal', function () {
                    $('#bts_modal_container').empty();
        });

    });/* ON READY */

    function hello(){

        event.preventDefault();

        const formObj = document.getElementById('examination-upload-form');

        var jackxData = juju.sendJackx({
            URL:'uploadExamination.php',
            FORM:formObj,
            FILES:['EXAMINATION_DOCUMENT']
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
                document.getElementById("assignment-upload-form").reset();
                juju.bootModal('close','EXAMINATION_TABLE_MODAL');
                document.getElementById('classroom-iframe').contentWindow.location.reload();

            }
        });


    }


</script>



</body>
</html>
