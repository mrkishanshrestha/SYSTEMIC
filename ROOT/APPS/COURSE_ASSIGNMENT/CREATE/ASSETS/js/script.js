$(document).ready(function(){

    $('#FACULTY_ID').change(function(event){
        
        var FACULTY_ID = $('#FACULTY_ID').val();

        var jackxData = juju.sendJackx({
            URL:'getDuration.php',
            DATA:{'FACULTY_ID':FACULTY_ID,'SELECT_OPTION':true}
        });

        jackxData.done(function(data){  
            data = JSON.parse(data);
            console.log(data);
            if(data.ERROR){
                juju.fireError({
                    MSG:data.MSG,
                    TARGET:data.TARGET,
                    ERROR_LOG_ID:'course_assign-form-error-log',
                });

                juju.alerty({
                    status:'danger',
                    msg:data.MSG,
                    title:'ERROR',
                    position:'top_right'
                });

            }else{
                $('#basedon_data').empty();
                var periods = data.periods;
                var options="";
                for(var i = 1; i<=periods; i++){
                    options=options+`<option value="`+i+`">`+i+`</option>`;
                }

                var html = `<span>Faculty `+data.based_on+` Periods</span>
                <select name="FACULTY_PERIOD" id="FACULTY_PERIOD" onchange="getCourse();" required>
                    <option value="" selected>Choose Faculty Periods</option>
                    `+options+`
                </select>`;
                $('#basedon_data').append(html);
            }
        });

    });


    
});

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('course_assign-form').addEventListener("submit", function(event) { 

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
                        ERROR_LOG_ID:'course_assign-error-log',
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
                    document.getElementById("course_assign-form").reset();
                }
            });

        });

});

function getCourse(){

    
    
var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
var FACULTY_ID = $('#FACULTY_ID').val();

    
var jackxData = juju.sendJackx({
    URL:'getCourse.php',
    DATA:{'FACULTY_PERIOD':FACULTY_PERIOD,'FACULTY_ID':FACULTY_ID,'SELECT_OPTION':true}
});

jackxData.done(function(data){  
    
    $('#COURSE_DATA').empty();

    data = JSON.parse(data);
    console.log(data);
    if(data.ERROR){
        juju.fireError({
            MSG:data.MSG,
            TARGET:data.TARGET,
            ERROR_LOG_ID:'course_assign-error-log',
        });

        juju.alerty({
            status:'danger',
            msg:data.MSG,
            title:'ERROR',
            position:'top_right'
        });

        
    }else{

        $('#COURSE_DATA').empty();

        var options="";
        data.forEach(element => {
            options=options+`<option value="`+element.id+`">`+element.course_name+`</option>`;
        });

        var html = `<span>Faculty Course</span>
        <select name="COURSE_ID" id="COURSE_ID" required>
            <option value="" selected>Choose Faculty Course</option>
            `+options+`
        </select>`;

        $('#COURSE_DATA').append(html);
    }

});




}


/*
function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
*/