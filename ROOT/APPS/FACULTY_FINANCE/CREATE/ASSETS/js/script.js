$(document).ready(function(){

    
});

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('user-create-form').addEventListener("submit", function(event) { 

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
                        ERROR_LOG_ID:'user-create-error-log',
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
                    document.getElementById("user-create-form").reset();
                }
            });

        });

    $('#COLLEGE_REFID').change(function(event){
    
        var COLLEGE = $('#COLLEGE_REFID').val();

        var jackxData = juju.sendJackx({
            URL:'handler.php',
            DATA:{'COLLEGE_REFID':COLLEGE,'SELECT_OPTION':true}
        });

        jackxData.done(function(data){  
            data = JSON.parse(data);
            if(data.ERROR){
                juju.fireError({
                    MSG:data.MSG,
                    TARGET:data.TARGET,
                    ERROR_LOG_ID:'error-log',
                });

                $('#faculty_data').empty();
                
                juju.alerty({
                    status:'danger',
                    msg:data.MSG,
                    title:'ERROR',
                    position:'top_right'
                });

            }else{
                $('#faculty_data').empty();

                var options="";
                data.forEach(element => {
                    options=options+`<option value="`+element.id+`">`+element.name+`</option>`;
                });

                var html = `<span>Choose Faculty</span>
                <select name="FACULTY_REFID" id="FACULTY_REFID" required>
                    <option value="" selected>Choose Franch</option>
                    `+options+`
                </select>`;
                $('#faculty_data').append(html);
            }
        });

    });



});


/*
function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
*/