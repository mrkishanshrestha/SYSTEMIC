$(document).ready(function(){
    

        //oncollehe change get faculty as per college
        $('#BRANCH').change(function(event){

            var BRANCH_ID = $('#BRANCH').val();
    
            var jackxData = juju.sendJackx({
                URL:'getFaculty.php',
                DATA:{'BRANCH_ID':BRANCH_ID,'SELECT_OPTION':true}
            });
    
            jackxData.done(function(data){  
                
                $('#FACULTY_OPTION').empty();
    
                data = JSON.parse(data);
                console.log(data);
                if(data.ERROR){
                    juju.fireError({
                        MSG:data.MSG,
                        TARGET:data.TARGET,
                        ERROR_LOG_ID:'course-create-form-error-log',
                    });
    
                    juju.alerty({
                        status:'danger',
                        msg:data.MSG,
                        title:'ERROR',
                        position:'top_right'
                    });

                    
                }else{
    
                    $('#FACULTY_OPTION').empty();
                    var options="";
                    data.forEach(element => {
                        options=options+`<option value="`+element+`">`+element+`</option>`;
                    });
    
                    var html = `<span>Faculty</span>
                    <select name="FACULTY" id="FACULTY" onchange="hello();" required>
                        <option value="" selected>Choose Faculty</option>
                        `+options+`
                    </select>`;

                    $('#FACULTY_OPTION').append(html);
                }
    
            });
    
        });
    
    
});


function hello(){
    
    var FACULTY = $('#FACULTY').val();
        
    var jackxData = juju.sendJackx({
        URL:'getDuration.php',
        DATA:{'FACULTY':FACULTY,'SELECT_OPTION':true}
    });
    
    jackxData.done(function(data){  
        
        $('#FACULTY_DURATION').empty();
    
        data = JSON.parse(data);
        console.log(data);
        if(data.ERROR){
            juju.fireError({
                MSG:data.MSG,
                TARGET:data.TARGET,
                ERROR_LOG_ID:'course-create-form-error-log',
            });
    
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
    
            
        }else{
    
            $('#FACULTY_DURATION').empty();
    
            var periods = data.periods;
            var options="";
            for(var i = 1; i<=periods; i++){
                options=options+`<option value="`+i+`">`+i+`</option>`;
            }
    
            var html = `<span>Faculty `+data.based_on+` Periods</span>
            <select name="FACULTY_PERIOD" id="FACULTY_PERIOD" onchange="getCourse();"required>
                <option value="" selected>Choose Faculty Periods</option>
                `+options+`
            </select>`;
    
            $('#FACULTY_DURATION').append(html);
        }
    
    });
    
    }
    
    


    function getCourse(){
    
        var FACULTY = $('#FACULTY').val();
        var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
            
        var jackxData = juju.sendJackx({
            URL:'getCourse.php',
            DATA:{'FACULTY':FACULTY,'FACULTY_PERIOD':FACULTY_PERIOD,'SELECT_OPTION':true}
        });
        
        jackxData.done(function(data){  
            
            $('#FACULTY_COURSE').empty();
        
            data = JSON.parse(data);
            console.log(data);
            if(data.ERROR){
                juju.fireError({
                    MSG:data.MSG,
                    TARGET:data.TARGET,
                    ERROR_LOG_ID:'course-create-form-error-log',
                });
        
                juju.alerty({
                    status:'danger',
                    msg:data.MSG,
                    title:'ERROR',
                    position:'top_right'
                });
        
                
            }else{
        
                $('#FACULTY_COURSE').empty();
        
                var options="";
                data.forEach(element => {
                    options=options+`<option value="`+element.course_code+`">`+element.course_name+`</option>`;
                });

        
                var html = `<span>Faculty Course</span>
                <select name="COURSE" id="COURSE"required>
                    <option value="" selected>Choose Faculty Course</option>
                    `+options+`
                </select>`;
        
                $('#FACULTY_COURSE').append(html);
            }
        
        });
        
        }
        
        


    function loadNotes(){

            event.preventDefault();
            console.log('loading loadNotes');

            var BRANCH_ID = $('#BRANCH').val();
            var FACULTY = $('#FACULTY').val();
            var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
            var COURSE = $('#COURSE').val();

            var jackxData = juju.sendJackx({
                URL:'loadNotes.php',
                DATA:{'BRANCH_ID':BRANCH_ID,'FACULTY_SHORT_NAME':FACULTY,'FACULTY_PERIOD':FACULTY_PERIOD,'COURSE':COURSE,'SEARCH':true}
            });
            

            
        jackxData.done(function(data){  
           
                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();
    
                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }
    
                var result = [];
    
                    juju.makeKaliTable({HEAD:['COURSE CODE','COURSE NAME','DOCUMENTS'],ID:'STUDY_NOTES_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                        var SNcounter=1;
                        jsonData.forEach(element => {
                            
                            var linkHtml = "";
                            myPdfs = element.document;
                            myPdfs = myPdfs.split(',');
                            myPdfs.forEach(filename => {
                                pdfDirectory = "http://systemic.com/CLIENTS/COLLEGES/APP_DATA/STUDY_NOTES/"+element.course_code+'/'+filename;
                                linkHtml += `<a href="`+pdfDirectory+`">`+filename+`</a>`;
                            });


                            juju.addTableContent({
                                DATA:data,
                                DB_TUPLE_ID:element.id,
                                CONTENT_ID:['COURSE_CODE','COURSE_NAME','USERNAME','DOCUMENTS'],
                                CONTENT:[
                                    element.course_code,element.course_name,linkHtml
                                ],
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
            juju.alerty({
                status:'success',
                msg:data.MSG,
                title:'PRESENT',
                position:'top_right'
            });
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
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ABSENT',
                position:'top_right'
            });
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