$(document).ready(function(){

    $("body").on('keyup', "#COURSE_NAME, #COURSE_CODE", function(){
    
        juju.checkDuplicate({
            DATA:{
                ID:this.id,
                VALUE:this.value
            },
            URL:'handler.php',
            ERROR_LOG_ID:'course-create-form-error-log',
        });
    
    });  


    $('#FACULTY').change(function(event){
        
        var FACULTY = $('#FACULTY').val();

        var jackxData = juju.sendJackx({
            URL:'handler.php',
            DATA:{'FACULTY':FACULTY,'SELECT_OPTION':true}
        });

        jackxData.done(function(data){  
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
                $('#basedon_data').empty();
                var periods = data.periods;
                var options="";
                for(var i = 1; i<=periods; i++){
                    options=options+`<option value="`+i+`">`+i+`</option>`;
                }

                var html = `<span>Faculty `+data.based_on+` Periods</span>
                <select name="FACULTY_PERIOD" id="FACULTY_PERIOD" required>
                    <option value="" selected>Choose Faculty Periods</option>
                    `+options+`
                </select>`;
                $('#basedon_data').append(html);
            }
        });

    });


});


//data on submit
document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('course-create-form').addEventListener("submit", function(event) { 

        event.preventDefault();

            var jackxData = juju.sendJackx({
                URL:'process.php',
                FORM:this,
                FILES:['COURSE_DOCUMENT']
            });

            jackxData.done(function(data){  
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
                    alert('SUCESSS '+data.MSG);
                    juju.alerty({
                        status:'success',
                        msg:'Data Added Sucessfully',
                        title:'Hurray',
                        position:'top_right'
                    });
                    document.getElementById("course-create-form").reset();
                }
            });

        });

});
