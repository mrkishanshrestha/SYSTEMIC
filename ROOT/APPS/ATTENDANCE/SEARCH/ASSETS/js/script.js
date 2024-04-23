$(document).ready(function(){


    
});

document.addEventListener("DOMContentLoaded", function(event) { 


});

function showDate(){
    $( "#ATTENDANCE_DATE" ).datepicker();
}

    function getReport(COURSE_REFID){


            event.preventDefault();
            console.log('loading students');

            var END_DATE = $('#END_DATE').val();
            var START_DATE = $('#START_DATE').val();
            console.log(END_DATE+'  '+START_DATE+' '+COURSE_REFID);

            if(START_DATE=="" && END_DATE==""){
                document.getElementById('selected-date').innerHTML = "Entire Report Till Now";
            }else{
            document.getElementById('selected-date').innerHTML = START_DATE+" -TO- "+END_DATE;
            }

            var jackxData = juju.sendJackx({
                URL:'getAttendanceReport.php',
                DATA:{'START_DATE':START_DATE,'END_DATE':END_DATE,'COURSE_REFID':COURSE_REFID,'SEARCH':true}
            });
            
        jackxData.done(function(data){  
           
                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();
    
                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }
    
                var result = [];
    
                    juju.makeKaliTable({OPTIONS:false,HEAD:['STUDENT PHOTO','USERNAME','ROLL NO','FIRST NAME','MIDDLE NAME','LAST NAME','ABSENT COUNT','PRESENT COUNT'],ID:'STUDENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                        var SNcounter=1;
                        jsonData.forEach(element => {
                            
                            user_profile_picture_dir = "https://www.systemic.com/ROOT/DATA/USER_DATA/"+element.user_refid+'/'+element.profile_picture_id;
                           
                            var attenStatus="PENDING";
                            if(element.ATTENDANCE_STATUS!=undefined){
                                attenStatus = element.ATTENDANCE_STATUS;
                            }

                            juju.addTableContent({
                                DATA:data,
                                DB_TUPLE_ID:element.user_refid,
                                CONTENT_ID:['USER_PROFILE_PICTURE','USER_DOCUMENT','USERNAME','ROLL_NO','FIRST_NAME','MIDDLE_NAME','LAST_NAME','ABSENT COUNT','PRESENT COUNT'],
                                CONTENT:[
                                    '<img src="'+user_profile_picture_dir+'">',element.username,element.roll_no,element.first_name,element.middle_name,element.last_name,element.ABSENT_COUNT,element.PRESENT_COUNT
                                ],
                                DONT_SHOW:['USERNAME','ROLL_NO'],
                                COUNTER:SNcounter
                            });
                            SNcounter++;
                        });
                        
                        }).catch((data)=>{
                            alert('error in making table');
                        });
        
        });
            



}   


function presentStudent(student_id,table_sn){


    
    var BRANCH_ID = $('#BRANCH').val();
    var FACULTY = $('#FACULTY').val();
    var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
    var COURSE = $('#COURSE').val();

    var jackxData = juju.sendJackx({
        URL:'attendance.php',
        DATA:{'STUDENT_ID':student_id,'BRANCH_ID':BRANCH_ID,'FACULTY':FACULTY,'FACULTY_PERIOD':FACULTY_PERIOD,'COURSE':COURSE,'STATUS':'PRESENT','ATTENDANCE':true}
    });
    
    jackxData.done(function(data){  
        data = JSON.parse(data);
        console.log(data);
        if(data.ERROR){
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
        }else{
            /*juju.alerty({
                status:'success',
                msg:data.MSG,
                title:'PRESENT',
                position:'top_right'
            });*/
            document.getElementById('status-'+table_sn).innerHTML = "PRESENT";
        }
    });

}
            
 
function absentStudent(student_id,table_sn){
    
    var BRANCH_ID = $('#BRANCH').val();
    var FACULTY = $('#FACULTY').val();
    var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
    var COURSE = $('#COURSE').val();

    var jackxData = juju.sendJackx({
        URL:'attendance.php',
        DATA:{'STUDENT_ID':student_id,'BRANCH_ID':BRANCH_ID,'FACULTY':FACULTY,'FACULTY_PERIOD':FACULTY_PERIOD,'COURSE':COURSE,'STATUS':'ABSENT','ATTENDANCE':true}
    });
    
    jackxData.done(function(data){  
        data = JSON.parse(data);
        console.log(data);
        if(data.ERROR){
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
        }else{
           /* juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ABSENT',
                position:'top_right'
            });*/
            document.getElementById('status-'+table_sn).innerHTML = "ABSENT";
        }
    });

}
            
 


/*
function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
*/