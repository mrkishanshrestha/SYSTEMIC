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

    $(document).ready(function(){

        function loadReportCard(USER_REFID,EXAMINATION_REFID,COURSE_REFID,AUTHORITY) {

            var today = new Date();
            var current_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

            var jackxData = juju.postJackx('processReportCard.php',{USER_REFID: USER_REFID,EXAMINATION_REFID: EXAMINATION_REFID,COURSE_REFID:COURSE_REFID});

            jackxData.done(function(data){

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['STUDENT NAME','FM','PM','OBTAINED','REMARKS','STATUS'],ID:'EXAMINATION_REPORT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                    var SNcounter=1;
                    var totalFullMarks = 0;
                    var totalObtainedMarks = 0;

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

                        totalFullMarks += parseInt(element.full_marks)
                        totalObtainedMarks += parseInt(element.obtained_marks)
                  

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['STUDENT_NAME','STATUS','REPORT'],
                            CONTENT:[
                                element.course_name,element.full_marks,element.pass_marks,element.obtained_marks,element.remarks,element.status
                            ],
                            COUNTER:SNcounter
                        });
                        SNcounter++;
                    });

                    var percentageObtained = (totalObtainedMarks / totalFullMarks)*100;

                    $('#searchtable').append(`
                    <hr/><h3 style="color:black;">Total Percentage : `+percentageObtained+`%</h3><hr/><br/>
                    `); 

                    }).catch((data)=>{
                        alert('error in making table');
                    });

            });

        } /* FUNCTION LOAD ASSIGNENT */

        loadReportCard('<?php echo $_GET['USER_REFID']; ?>','<?php echo $_GET['EXAMINATION_REFID']; ?>','<?php echo $_GET['COURSE_REFID']; ?>','<?php echo $_SESSION['MY_AUTHORITY']; ?>');

        
        $('#EXAMINATION_TABLE_MODAL').on('hidden.bs.modal', function () {
                    $('#bts_modal_container').empty();
        });

    });/* ON READY */



</script>



</body>
</html>
