$(document).ready(function(){
    
    juju.alerty({
        status:'success',
        title:'Hurray',
        msg:'Page Loaded',
        position:'top_right'
    });

    $('#APPLICATION_NAME').keyup(function(event){
        console.log(`keyup  : `+this.value);
        errorCheck({APPLICATION_NAME:this.value});
    });

    
    function errorCheck(data){
        console.log(`errorCheck  :  `+data);
        var dataLookup = juju.dataLookup({
            URL:'handler.php',
            DATA:data,
            ERROR_LOG_ID:'application-create-error-log',
        });
    }

});

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('application-create-form').addEventListener("submit", function(event) { 

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
                        ERROR_LOG_ID:'application-create-error-log',
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
                    document.getElementById("application-create-form").reset();
                }
            });

        });

});



function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
