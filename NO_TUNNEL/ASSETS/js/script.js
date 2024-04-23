document.addEventListener("DOMContentLoaded", function(event) { 



    document.getElementById('login-form').addEventListener("submit", function(event) { 

        event.preventDefault();
        
        var sendData = juju.sendJackx({
            URL:"processlogin.php",
            FORM:this
        });

        sendData.done(function(data){
            data = JSON.parse(data);
            if(data.ERROR){
                juju.fireError({
                    TARGET:['USERNAME','PASSWORD'],
                    ERROR_LOG_ID:'login-error-log',
                    MSG:data.MSG
                });
                juju.speak('INVALID_CREDENTIALS');
            }else{
                window.location.replace(data.MSG);
            }
        });

        sendData.fail(function(data){
            alert('catch errorData data from juju' + errorData);
            console.log('catch errorData data from juju', errorData);
        });


        /*juju.sendJackx("login-form","processlogin.php").then(function(data){
            if(data.ERROR){
                juju.fireError('login-error-log',data.MSG,['USERNAME','PASSWORD']);
            }else{
                window.location.replace(data.MSG);
            }
        }).catch(function(errorData){
            alert('catch errorData data from juju' + errorData);
            console.log('catch errorData data from juju', errorData);
        });*/
       
    })

});


function playAboutUs(){

    juju.speak('ABOUT_US');
}


function openSignup(thisObj){
    alert('opening sign up form');
    event.preventDefault();

    style="display:none;" ;
    
} 