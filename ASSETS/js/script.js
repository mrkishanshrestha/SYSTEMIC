document.addEventListener("DOMContentLoaded", function(event) { 

            if(document.getElementById('login-form')!=null){
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

        }

        if(document.getElementById('TWOFA-verification-form')!=null){
            document.getElementById('TWOFA-verification-form').addEventListener("submit", function(event) { 

                event.preventDefault();
                
                var sendData = juju.sendJackx({
                    URL:"verifyOTP.php",
                    FORM:this
                });
                
                sendData.done(function(data){
                    data = JSON.parse(data);
                    if(data.ERROR){
                        juju.fireError({
                            TARGET:['2FA_OTP_CODE'],
                            ERROR_LOG_ID:'2FA-verification-error-log',
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
            });
        }

});



function processReset(){

    event.preventDefault();

    var email = $('#RESET_EMAIL').val();

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

                $('#reset-password-form').hide();
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
            
        console.log(data);
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
            $('#user-login-form').show();
        }

    });

}

function playAboutUs(){

    juju.speak('ABOUT_US');
}