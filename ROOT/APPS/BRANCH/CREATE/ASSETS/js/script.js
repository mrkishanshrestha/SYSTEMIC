$(document).ready(function(){
    
    $("body").on('keyup', "#CONTACT_NUMBER, #PHONE_NUMBER", function(){

        juju.checkDuplicate({
            DATA:{
                ID:this.id,
                VALUE:this.value
            },
            URL:'handler.php',
            ERROR_LOG_ID:'branch-create-form-error-log',
        });
    
    }); 
    
    //oncollehe change get faculty as per college
    $('#COLLEGE_NAME').change(function(event){

        var COLLEGE_NAME = $('#COLLEGE_NAME').val();

        var jackxData = juju.sendJackx({
            URL:'getColleges.php',
            DATA:{'COLLEGE_SHORT_NAME':COLLEGE_NAME,'SELECT_OPTION':true}
        });

        jackxData.done(function(data){  
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


                $('#FACULTY').empty();
                var options="";
                data.forEach(element => {

                options += `<div class="kali-checkbox-option-data">
                    <input class="kali-checkbox-data" name="FACULTY_ARRAY[]"  type="checkbox" value="`+element+`" id="`+element+`"  >
                    <label  for="`+element+`">`+element+`</label>
                </div>`;
                });


                var html = `<div class="kali-checkbox">
                                    <div class="kali-checkbox-options">
                                    <span>Faculties Available:</span>`+
                                    options+
                                    `
                                </div>
                            </div>`;

                $('#FACULTY').append(html);
            }

        });

    });

    
});

document.addEventListener("DOMContentLoaded", function(event) { 

    document.getElementById('branch-create-form').addEventListener("submit", function(event) { 

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
                        ERROR_LOG_ID:'branch-create-form-error-log',
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
                    document.getElementById("branch-create-form").reset();
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