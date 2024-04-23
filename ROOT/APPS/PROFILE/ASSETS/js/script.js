
$(document).ready(function(){
    
    $("body").on('keyup', "#FACULTY_NAME, #FACULTY_SHORT_NAME", function(){
    
        juju.checkDuplicate({
            DATA:{
                ID:this.id,
                VALUE:this.value
            },
            URL:'handler.php',
            ERROR_LOG_ID:'faculty-create-form-error-log'
        });
    
    });  
    
});
    

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('profile-update-form').addEventListener("submit", function(event) { 

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
                        ERROR_LOG_ID:'error-log',
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
                    document.getElementById('dash-frame').contentWindow.location.reload();
                    document.getElementById("profile-update-form").reset();
                }
            });

        });

});
