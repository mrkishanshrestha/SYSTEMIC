<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="ATTENDANCE";
    $kali->checkAccess($APPLICATION,'CREATE');
?>
<html>
<head>
    <?php
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('KALI_TABLE');
        $kali->link('FONT_AWESOME');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
   ?>

</head>
<body>

<style>
.absent-status {    
    border: 2px solid red;
    background: #ff0606;
    color: white;
    padding: 8px;
}
.present-status {    
    border: 2px solid green;
    background: green;
    color: white;
    padding: 8px;
}
    </style>


    <span id="searchtable"></span>

    <div id="bts_modal_container"></div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) { 

        loadStudents('<?php echo $_SESSION['KOHOMAH']?>','<?php echo $_GET['COURSE_REFID']; ?>');

        function loadStudents(USER_REFID,COURSE_REFID){
            event.preventDefault();
            console.log(USER_REFID+' loading students '+COURSE_REFID);

            var jackxData = juju.sendJackx({
                URL:'loadStudents.php',
                DATA:{'USER_REFID':USER_REFID,'COURSE_REFID':COURSE_REFID,'SEARCH':true}
            });

            jackxData.done(function(data){  

                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();

                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                var result = [];

                    juju.makeKaliTable({HEAD:['PHOTO','USERNAME','ROLL NO','FIRST NAME','MIDDLE NAME','LAST NAME','PRESENT','ABSENT','STATUS'],ID:'STUDENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                        var SNcounter=1;
                        jsonData.forEach(element => {
                            
                            user_profile_picture_dir = "https://www.systemic.com/ROOT/DATA/USER_DATA/"+element.user_refid+'/'+element.profile_picture_id;
                        
                            var attenStatus="PENDING";
                            var attenStatusCss = "";
                            if(element.ATTENDANCE_STATUS!=undefined){
                                if(element.ATTENDANCE_STATUS=="PRESENT"){
                                    attenStatus = element.ATTENDANCE_STATUS;
                                    attenStatusCss='present-status';
                                }else if(element.ATTENDANCE_STATUS=="ABSENT"){
                                    attenStatus = element.ATTENDANCE_STATUS;
                                    attenStatusCss='absent-status';
                                }
                            }

                            juju.addTableContent({
                                DATA:data,
                                DB_TUPLE_ID:element.user_refid,
                                CONTENT_ID:['USER_PROFILE_PICTURE','USERNAME','ROLL_NO','FIRST_NAME','MIDDLE_NAME','LAST_NAME','PRESENT','ABSENT'],
                                CONTENT:[
                                    '<img src="'+user_profile_picture_dir+'">',element.username,element.roll_no,element.first_name,element.middle_name,element.last_name,'<i class="fa-solid fa-check fa-xl" style="font-size:4rem;color: #00ff62;" onclick="presentStudent(\''+element.user_refid+'\',\''+element.course_refid+'\','+SNcounter+');"></i>','<i class="fa-solid fa-xmark" style="font-size:4rem; color: #ff0000;" onclick="absentStudent(\''+element.user_refid+'\',\''+element.course_refid+'\','+SNcounter+');"></i>','<span class="'+attenStatusCss+'" id="status-'+SNcounter+'" >'+attenStatus+'</span>'
                                ],
                                DONT_SHOW:[],
                                COUNTER:SNcounter
                            });
                            SNcounter++;
                        });
                        
                        }).catch((data)=>{
                            alert('error in making table');
                        });




            });




            }   

    
    });
</script>

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