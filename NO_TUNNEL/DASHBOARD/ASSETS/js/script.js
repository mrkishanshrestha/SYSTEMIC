document.addEventListener("DOMContentLoaded", function(event) { 

    juju.alerty({
        sound:true,
		position:"bottom_right",
		style: "success",
		title: "Welcome",
        content: "Welcome To Dashboard",
    });

    document.getElementById('mail-form').addEventListener("submit", function(event) { 

        event.preventDefault();

        juju.sendJackx("sendMail.php").then(function(data){
            if(data.ERROR){
                juju.fireError('login-error-log',data.MSG,['USERNAME','PASSWORD']);
            }else{
                 window.location.replace(data.MSG);
            }
        }).catch(function(errorData){
            alert('catch errorData data from juju' + errorData);
            console.log('catch errorData data from juju', errorData);
        });
       
    });



});

    


