<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "ASSIGNMENT";
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

<h1> Assignment Search  </h1>

<span id="searchtable"></span>
<div id="bts_modal_container"></div>

<script>

    function openFileUpload(DB_TUPLE_ID){
        
        var ModalId = 'ASSIGNMENT_TABLE_MODAL';
        var AutoForm =`    
        <form  id="assignment-upload-form" onsubmit="hello(); return false;" method="post" enctype = "multipart/form-data">
            <fieldset class="kali-form">
                <legend class="kali-formLegend">UPLOAD ASSIGNMENT</legend>

                <span class="error-log grid-fill danger-glow" id="error-log"></span>

                <input type="text" style="visibility:hidden;" name="ASSIGNMENT_REFID" id="ASSIGNMENT_REFID" placeholder="Enter Assignment Title" value="`+DB_TUPLE_ID+`" required>

                <div class="kali-inputbox grid-fill">
                    <span>Documents (Pdf)</span>
                    <input type="file" name="ASSIGNMENT_DOCUMENT" id="ASSIGNMENT_DOCUMENT" accept="application/pdf," multiple required>
                </div>

                <div class="kali-inputbox grid-fill">
                    <span>Assignment Description</span>
                    <input type="text" name="ASSIGNMENT_DESCRIPTION" id="ASSIGNMENT_DESCRIPTION" placeholder="Enter Assignment Description" value="" required>
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
            FUNCTION:`uploadAssignment(`+DB_TUPLE_ID+`);`,
        });

        juju.bootModal('show',ModalId);

        $('#'+ModalId).on('hidden.bs.modal', function () {
            $('#bts_modal_container').empty();
        });

    }


    $(document).ready(function(){


        function loadAssignments(COURSE_REFID,AUTHORITY) {

            var today = new Date();
            var current_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            var uploadTitle = "";
                        var uploadBtn = "";
                        if(AUTHORITY == "STUDENT"){
                            uploadTitle = "UPLOAD";
                            uploadBtn = `<button id="assignmentUploadBtn" onclick="openFileUpload();" >UPLOAD</button>`;
                        }

            var jackxData = juju.postJackx('process.php',{COURSE_REFID: COURSE_REFID});

            jackxData.done(function(data){

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['TITLE','DESCRIPTION','DOCUMENTS','MARK','DUE DATE','REMAINING DAYS',uploadTitle],ID:'ASSIGNMENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                    var SNcounter=1;
                    jsonData.forEach(element => {

                        if(AUTHORITY == "STUDENT"){
                            uploadTitle = "UPLOAD";
                            uploadBtn = `<button id="assignmentUploadBtn" onclick="openFileUpload('`+element.id+`');" >UPLOAD</button>`;
                        }else{                         
                            uploadTitle = "VIEW";
                            uploadBtn = `<button id="assignmentViewBtn" onclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/ASSIGNMENT/SEARCH/uploaded_assignments.php?ASSIGNMENT_REFID=`+element.id+`&COURSE_REFID=`+COURSE_REFID+`');" >VIEW</button>`;
                        }

                        var linkHtml = "";
                        myPdfs = element.assignment_files_x;
                        myPdfs = myPdfs.split(',');
                        myPdfs.forEach(filename => {
                            pdfDirectory = "https://www.systemic.com/ROOT/DATA/APP_DATA/ASSIGNMENT/"+element.course_refid+'/'+element.id+'/'+filename;
                            linkHtml += `<a href="`+pdfDirectory+`">`+filename+`</a>`;
                        });
                        //pdfDirectory = "http://systemic.com/ROOT/DATA/APP_DATA/COURSE/"+element.course_name+'/'+element.course_document;
                    
                        // To set two dates to two variables
                        var date1 = new Date();
                        var date2 = new Date(element.due_date);
                        
                        // To calculate the time difference of two dates
                        var Difference_In_Time = date2.getTime() - date1.getTime();
                        
                        // To calculate the no. of days between two dates
                        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                        
                        var remaining_days= parseInt(Difference_In_Days);

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['TITLE','DESCRIPTION','DOCUMENTS','MARK','DUE_DATE','REMAINING_DAYS',uploadTitle],
                            CONTENT:[
                                element.title,element.description,linkHtml,element.mark,element.due_date,remaining_days,uploadBtn
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

        loadAssignments('<?php echo $_GET['COURSE_REFID']; ?>','<?php echo $_SESSION['MY_AUTHORITY']; ?>');

        
        $('#ASSIGNMENT_TABLE_MODAL').on('hidden.bs.modal', function () {
                    $('#bts_modal_container').empty();
        });

    });/* ON READY */

    function hello(){

        event.preventDefault();

        const formObj = document.getElementById('assignment-upload-form');

        var jackxData = juju.sendJackx({
            URL:'uploadAssignment.php',
            FORM:formObj,
            FILES:['ASSIGNMENT_DOCUMENT']
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
                juju.bootModal('close','ASSIGNMENT_TABLE_MODAL');
                document.getElementById('classroom-iframe').contentWindow.location.reload();

            }
        });


    }


</script>



</body>
</html>
