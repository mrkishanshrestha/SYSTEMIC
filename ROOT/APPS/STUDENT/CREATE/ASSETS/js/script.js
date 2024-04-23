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
        var selected="";
        for(var i = 1; i<=periods; i++){
            if(i == 1){selected="selected";}else{selected="";}
            options=options+`<option value="`+i+`" `+selected+`>`+i+`</option>`;
        }

        var html = `<span>Faculty `+data.based_on+` Periods</span>
        <select name="FACULTY_PERIOD" id="FACULTY_PERIOD" required>
            <option value="" selected>Choose Faculty Periods</option>
            `+options+`
        </select>`;

        $('#FACULTY_DURATION').append(html);
    }

});

}



/*
function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
*/