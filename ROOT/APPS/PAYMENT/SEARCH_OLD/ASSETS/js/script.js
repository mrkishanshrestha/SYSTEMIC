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
    

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        event.preventDefault();
        console.log('loading students');
        $('#statementSearhTable').empty();

        var BRANCH_ID = $('#BRANCH').val();
        var FACULTY = $('#FACULTY').val();
        var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
        var COURSE = $('#COURSE').val();
        var SEARCH_BOX = $('#SEARCH_BOX').val();

        if(SEARCH_BOX=="" || SEARCH_BOX == null){
            $("#searchtable").empty();return true;
        }

        var jackxData = juju.sendJackx({
            URL:'loadStudents.php',
            DATA:{'SEARCH_BOX':SEARCH_BOX,'BRANCH_ID':BRANCH_ID,'FACULTY_SHORT_NAME':FACULTY,'FACULTY_PERIOD':FACULTY_PERIOD,'COURSE':COURSE,'SEARCH':true}
        });
        

        
    jackxData.done(function(data){  
       
            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            var result = [];

                juju.makeKaliTable({OPTIONS:false,HEAD:['STUDENT PHOTO','USERNAME','ROLL NO','FIRST NAME','MIDDLE NAME','LAST NAME','GET STATEMENT'],ID:'STUDENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                
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
                            CONTENT_ID:['USER_PROFILE_PICTURE','USER_DOCUMENT','USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION','FIRST_NAME','MIDDLE_NAME','LAST_NAME','GET_STATEMENT'],
                            CONTENT:[
                                '<img src="'+user_profile_picture_dir+'">',element.username,element.roll_no,element.first_name,element.middle_name,element.last_name,'<button class="kali-table-btn" onclick="getStatement('+element.id+');">Get Statement</button>'
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


    });

});

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('student-create-form').addEventListener("submit", function(event) { 

        event.preventDefault();

            var jackxData = juju.sendJackx({
                URL:'process.php',
                FORM:this
            });

            jackxData.done(function(data){  
                data = JSON.parse(data);
                console.log(data);
                if(data.ERROR){
                    juju.fireError({
                        MSG:data.MSG,
                        TARGET:data.TARGET,
                        ERROR_LOG_ID:'student-create-error-log',
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
                    document.getElementById("student-create-form").reset();
                }
            });

        });

});

function printDiv(printId){
    event.preventDefault();
        var divContents = document.getElementById(printId).innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<body>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
}

function getStatement(DB_TUPLE_ID){

    event.preventDefault();
    var jackxData = juju.sendJackx({
        URL:'getStatement.php',
        DATA:{'DB_TUPLE_ID':DB_TUPLE_ID,'SEARCH':true}
    });
    

    
jackxData.done(function(data){  
   
        if(data=='""' || data=="null"){$("#statementSearhTable").empty();return true;}

        jsonData=JSON.parse(data);
        $("#statementSearhTable").empty();

        if(jsonData.ERROR){ $('#statementSearhTable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

        var result = [];

            juju.makeKaliTable({OPTIONS:false,HEAD:['DEBIT AMOUNT','CREDIT AMOUNT','DESCRIPTION','ENTRY DATE'],ID:'STUDENT_STATEMENT_TABLE',APPEND:'statementSearhTable'}).then((data)=>{
            
                var SNcounter=1;
                var TOTAL_BALACE_AMOUNT=0;
                var TOTAL_DEBIT_AMOUNT=0;
                var TOTAL_CREDIT_AMOUNT=0;
                jsonData.forEach(element => {
                    
                    juju.addTableContent({
                        DATA:data,
                        DB_TUPLE_ID:element.id,
                        CONTENT_ID:['ENTRY_DATE','DEBIT_AMOUNT','CREDIT_AMOUNT','DESCRIPTION'],
                        CONTENT:[
                            element.entry_date,element.debit_amount,element.credit_amount,element.description
                        ],
                        DONT_SHOW:['USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION'],
                        COUNTER:SNcounter
                    });
                    
                    TOTAL_BALACE_AMOUNT=element.TOTAL_BALANCE;
                    TOTAL_DEBIT_AMOUNT=element.TOTAL_DEBIT;
                    TOTAL_CREDIT_AMOUNT=element.TOTAL_CREDIT;
                    SNcounter++;
                });

                
                $('#statementSearhTable').append(`
                    <h1 style="color:white;">Total Debit Balance is Rs.`+TOTAL_DEBIT_AMOUNT+`</h1><br/>
                    <h1 style="color:white;">Total Credit Balance is Rs.`+TOTAL_CREDIT_AMOUNT+`</h1><br/>
                    <h1 style="color:white;">Total Balance is Rs.`+TOTAL_BALACE_AMOUNT+`</h1><br/>
                
                `); 
                
                }).catch((data)=>{
                    alert('error in making table');
                });

   


});




}

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

    
    if(FACULTY_PERIOD==""){
        $('#STUDENT_SEARCH_SPAN').hide();
        return false;
    }else{
        $('#STUDENT_SEARCH_SPAN').show();
        return true;
    }
        
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