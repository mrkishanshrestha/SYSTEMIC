$(document).ready(function(){
    
    $("body").on('keyup', "#USERNAME, #CONTACT_NUMBER, #PHONE_NUMBER, #EMAIL", function(){

        juju.checkDuplicate({
            DATA:{
                ID:this.id,
                VALUE:this.value
            },
            URL:'handler.php',
            ERROR_LOG_ID:'error-log',
        });
    
    });  

    $('#COLLEGE').change(function(event){
        
        var COLLEGE = $('#COLLEGE').val();

        var jackxData = juju.sendJackx({
            URL:'handler.php',
            DATA:{'COLLEGE':COLLEGE,'SELECT_OPTION':true}
        });

        jackxData.done(function(data){  
            data = JSON.parse(data);
            if(data.ERROR){
                juju.fireError({
                    MSG:data.MSG,
                    TARGET:data.TARGET,
                    ERROR_LOG_ID:'error-log',
                });

                $('#branch_data').empty();
                
                juju.alerty({
                    status:'danger',
                    msg:data.MSG,
                    title:'ERROR',
                    position:'top_right'
                });

            }else{
                $('#branch_data').empty();

                var options="";
                data.forEach(element => {
                    options=options+`<option value="`+element.id+`">`+element.name+`</option>`;
                });


                var html = `<span>Branch</span>
                <select name="BRANCH" id="BRANCH" required>
                    <option value="" selected>Choose Branch</option>
                    `+options+`
                </select>`;
                $('#branch_data').append(html);
            }
        });

    });
    
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

});


/*
function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
*/