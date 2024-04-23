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


function resetPassword(){

    event.preventDefault();

    $('#resetSection-form').toggle();

}

function processReset(){

    event.preventDefault();

    var email = $('#RESET_EMAIL').val();
    console.log(email);

    var jackxData = juju.postJackx('resetProcess.php',{SEARCH_DATA: email});
    
        jackxData.done(function(data){  
            
            data = JSON.parse(data);
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
                    title:'SUCCESS',
                    position:'top_right'
                });
                $('#resetSection-form').hide();
                $('#otpSection-form').show();
            }

        });



}


function validateOTP(){

    event.preventDefault();

    var email = $('#RESET_EMAIL').val();
    var otp = $('#OTP').val();

    
    var jackxData = juju.postJackx('validateOtp.php',{SEARCH_DATA: true,EMAIL:email,OTP:otp});

    jackxData.done(function(data){  
            
        data = JSON.parse(data);
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
                title:'SUCCESS',
                position:'top_right'
            });

            $('#otpSection-form').hide();
        }

    });

   

}