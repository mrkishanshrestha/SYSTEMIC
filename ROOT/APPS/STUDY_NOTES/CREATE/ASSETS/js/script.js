$(document).ready(function(){
    
    $("body").on('keyup', "#CONTACT_NUMBER, #GURDIAN_NUMBER, #EMAIL", function(){

        juju.checkDuplicate({
            DATA:{
                ID:this.id,
                VALUE:this.value
            },
            URL:'handler.php',
            ERROR_LOG_ID:'student-create-error-log',
        });
    
    });  

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

//data on submit
document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('study-note-form').addEventListener("submit", function(event) { 

        event.preventDefault();

            var jackxData = juju.sendJackx({
                URL:'upload.php',
                FORM:this,
                FILES:['DOCUMENT']
            });

            
            jackxData.done(function(data){  
                data = JSON.parse(data);
                console.log(data);
                if(data.ERROR){
                    juju.fireError({
                        MSG:data.MSG,
                        TARGET:data.TARGET,
                        ERROR_LOG_ID:'study-note-error-log',
                    });

                    juju.alerty({
                        status:'danger',
                        msg:data.MSG,
                        title:'ERROR',
                        position:'top_right'
                    });

                }else{
                    alert('SUCESSS '+data.MSG);
                    juju.alerty({
                        status:'success',
                        msg:'Data Added Sucessfully',
                        title:'Hurray',
                        position:'top_right'
                    });
                    document.getElementById("study-note-form").reset();
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

            var htmldata = `
                <span>Documents (Syllabus Pdf)</span>
                <input type="file" name="DOCUMENT" id="DOCUMENT" accept="application/pdf," multiple="" required="">
                `;
    
            $('#FACULTY_COURSE').append(html);
            $('#DOC_DATA').append(htmldata);
        }
    
    });
    
    }
    
    








































    function uploadNow(){

            event.preventDefault();

            var BRANCH_ID = $('#BRANCH').val();
            var FACULTY = $('#FACULTY').val();
            var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
            var COURSE = $('#COURSE').val();


            if(COURSE=="" || COURSE ==undefined || COURSE==null){
                alert('select Course');
                $("#searchtable").empty();
                return false;
            }

            var jackxData = juju.sendJackx({
                URL:'loadStudents.php',
                DATA:{'BRANCH_ID':BRANCH_ID,'FACULTY_SHORT_NAME':FACULTY,'FACULTY_PERIOD':FACULTY_PERIOD,'COURSE':COURSE,'SEARCH':true}
            });

            var jackxData = juju.sendJackx({
                URL:'process.php',
                FORM:this,
                FILES:['COURSE_DOCUMENT']
            });
            

            
        jackxData.done(function(data){  
           
                if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

                jsonData=JSON.parse(data);
                $("#searchtable").empty();
    
                if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }
    
                var result = [];
    
                    juju.makeKaliTable({HEAD:['STUDENT PHOTO','USERNAME','ROLL NO','FIRST NAME','MIDDLE NAME','LAST NAME','CONTACT NUMBER','PRESENT','ABSENT','STATUS'],ID:'STUDENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                    
                        var SNcounter=1;
                        jsonData.forEach(element => {
                            
                            user_profile_picture_dir = "http://systemic.com/CLIENTS/COLLEGES/"+element.collegeDomain+"/STUDENT/"+element.roll_no+'/'+element.profile_picture_id;
                           
                            var attenStatus="PENDING";
                            if(element.ATTENDANCE_STATUS!=undefined){
                                attenStatus = element.ATTENDANCE_STATUS;
                            }

                            juju.addTableContent({
                                DATA:data,
                                DB_TUPLE_ID:element.id,
                                CONTENT_ID:['USER_PROFILE_PICTURE','USER_DOCUMENT','USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION','FIRST_NAME','MIDDLE_NAME','LAST_NAME','CONTACT_NUMBER','PRESENT','ABSENT'],
                                CONTENT:[
                                    '<img src="'+user_profile_picture_dir+'">',element.username,element.roll_no,element.first_name,element.middle_name,element.last_name,element.contact_number,'<button onclick="presentStudent('+element.id+','+SNcounter+');">PRESENT</button>','<button onclick="absentStudent('+element.id+','+SNcounter+');">ABSENT</button>','<span id="status-'+SNcounter+'" >'+attenStatus+'</span>'
                                ],
                                DONT_SHOW:['USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION'],
                                COUNTER:SNcounter
                            });
                            SNcounter++;
                        });
                        
                        }).catch((data)=>{
                            alert('error in making table');
                        });
    
           
 
        
        });
            



}   



