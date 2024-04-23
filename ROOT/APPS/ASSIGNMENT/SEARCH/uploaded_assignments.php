<?php
    include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION = "ASSIGNMENT";
    $kali->checkAccess($APPLICATION,'SEARCH');

    $sql = 'SELECT `mark`, `title`,`description` FROM `assignment` WHERE `id`=:ASSIGNMENT_REFID ';
    $data = $kali->kaliPull($sql,['ASSIGNMENT_REFID'=>$_GET['ASSIGNMENT_REFID']]);
    if(!$data){
      $kali->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Assignment','TARGET'=>['ASSIGNMENT_REFID']]);
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

<h1> Assignment : <?php echo $data['title']; ?></h1>
<h2> Marks : <?php echo $data['mark']; ?></h2>
<h1> Uploaded Assignment Search  </h1>

<span id="searchtable"></span>
<div id="bts_modal_container"></div>

<script>

    function giveMarks(DB_TUPLE_ID){
        
        var ModalId = 'ASSIGNMENT_TABLE_MODAL';
        var AutoForm =`    
        <form  id="assignment-marking-form" onsubmit="hello(); return false;" method="post" enctype = "multipart/form-data">
            <fieldset class="kali-form">
                <legend class="kali-formLegend">GRADE THIS ASSIGNMENT</legend>

                <span class="error-log grid-fill danger-glow" id="error-log"></span>

                <input type="text" style="visibility:hidden;" name="ASSIGNMENT_RECORD_REFID" id="ASSIGNMENT_RECORD_REFID" value="`+DB_TUPLE_ID+`" required>

                <div class="kali-inputbox grid-fill">
                    <span>Assignment Marks</span>
                    <input type="number" name="ASSIGNMENT_MARKS" id="ASSIGNMENT_MARKS" placeholder="Enter Assignment Marks" value="" required>
                </div>

                <div class="kali-inputbox grid-fill">
                    <span>Assignment Description</span>
                    <input type="text" name="ASSIGNMENT_REMARKS" id="ASSIGNMENT_REMARKS" placeholder="Enter Assignment Remarks" value="" required>
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


        function loadAssignments(ASSIGNMENT_REFID,COURSE_REFID) {

            var today = new Date();
            var current_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            var uploadTitle = "";
            var uploadBtn = "";
                           

            var jackxData = juju.postJackx('getUploadedAssignments.php',{ASSIGNMENT_REFID: ASSIGNMENT_REFID,COURSE_REFID:COURSE_REFID});

            jackxData.done(function(data){

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['STUDENT NAME','STATUS','ASSIGNMENT','MARK OBTAINED','SUBMITTED DATE','DAYS DIFFER',uploadTitle],ID:'ASSIGNMENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                    var SNcounter=1;
                    jsonData.forEach(element => {

     
                        if(element.due_date == null){
                            element.due_date = "Empty";
                        }
                        if(element.mark_obtained == null){
                            element.mark_obtained = "0";
                        }
                       
                        if(element.submit_status == null){
                            element.submit_status = "NOT SUBMITTED";
                        }
                        if(element.submited_date == null){
                            element.submited_date = "-----";
                        }
                        if(element.id == null){
                            element.id = "---";
                            uploadTitle = "";
                            uploadBtn = "";
                        }else{
                            uploadTitle = "MARKING";
                            uploadBtn = `<button id="markingBtn" onclick="giveMarks('`+element.id+`');" >MARKING</button>`;
                        }


                        if(element.submit_status != "NOT SUBMITTED"){
                            statusStyle = "background:yellow;color:black;";
                        }
                        
                        if(element.mark_obtained != "0"){
                            statusStyle='background:green;color:white;';
                        }

                        
                        var linkHtml = "";
                        if(element.assignment_files_x == null){
                            element.assignment_files_x = "Empty";
                            linkHtml = "<div style='background:red;color:white;'>Empty</div>";
                        }else{
                            myPdfs = element.assignment_files_x;
                            myPdfs = myPdfs.split(',');
                            myPdfs.forEach(filename => {
                                pdfDirectory = "https://www.systemic.com/ROOT/DATA/USER_DATA/"+element.user_refid+"/ASSIGNMENT/"+element.assignmnet_refid+'/'+filename;
                                linkHtml += `<a style="`+statusStyle+`" href="`+pdfDirectory+`">`+filename+`</a>`;
                            });
                            //pdfDirectory = "http://systemic.com/ROOT/DATA/APP_DATA/COURSE/"+element.course_name+'/'+element.course_document;

                        }

                        // To set two dates to two variables
                        var date1 = new Date(element.submited_date);
                        var date2 = new Date(element.due_date);
                        
                        // To calculate the time difference of two dates
                        var Difference_In_Time = date2.getTime() - date1.getTime();
                        
                        // To calculate the no. of days between two dates
                        var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                        
                        var remaining_days= parseInt(Difference_In_Days);

                        if(isNaN(remaining_days)){
                            remaining_days="----";
                        }

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.user_refid,
                            CONTENT_ID:['STUDENT_NAME','STATUS','SUBMITTED_DATE','ASSIGNMENT','MARK_OBTAINED','DAYS_DIFFER',uploadTitle],
                            CONTENT:[
                                element.fullname,element.submit_status,linkHtml,element.mark_obtained,element.submited_date,remaining_days,uploadBtn
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

        loadAssignments('<?php echo $_GET['ASSIGNMENT_REFID']; ?>','<?php echo $_GET['COURSE_REFID']; ?>');

        
        $('#ASSIGNMENT_TABLE_MODAL').on('hidden.bs.modal', function () {
                    $('#bts_modal_container').empty();
        });

    });/* ON READY */

    function hello(){

        event.preventDefault();

        const formObj = document.getElementById('assignment-marking-form');

        var jackxData = juju.sendJackx({
            URL:'uploadAssignmentGrading.php',
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
                juju.bootModal('close','ASSIGNMENT_TABLE_MODAL');
                document.getElementById('classroom-iframe').contentWindow.location.reload();

            }
        });


    }


</script>



</body>
</html>
