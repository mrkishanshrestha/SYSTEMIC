$(document).ready(function(){
    
    juju.alerty({
        status:'success',
        title:'Hurray',
        msg:'Page Loaded',
        position:'top_right'
    });

    /*
    $('#USERNAME').keyup(function(event){
        errorCheck({USERNAME:this.value});
    });

    $('#EMAIL').keyup(function(event){
        errorCheck({EMAIL:this.value});
    });

    $('#CONTACT_NUMBER').keyup(function(event){
        errorCheck({CONTACT_NUMBER:this.value});
    });
    
    $('#PHONE_NUMBER').keyup(function(event){
        errorCheck({PHONE_NUMBER:this.value});
    });
    
    function errorCheck(data){
        var dataLookup = juju.dataLookup({
            URL:'handler.php',
            DATA:data,
            ERROR_LOG_ID:'user-create-error-log',
        });
    }

    */

});

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('college-create-form').addEventListener("submit", function(event) { 


        alert('asdasd');
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
                        ERROR_LOG_ID:'college-create-form-error-log',
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
                    document.getElementById("college-create-form").reset();
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