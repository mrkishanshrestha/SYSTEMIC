$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            juju.makeKaliTable({HEAD:['COLLEGE NAME','BRANCH NAME','ADDRESS','GEO LOCATION','CONTACT NUMBER','PHONE NUMBER','FACULTIES'],ID:'BRANCH_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                var SNcounter=1;
                jsonData.forEach(element => {
                    console.log(element);
                    var getFaculty = juju.postJackx('getFaculty.php',{SEARCH_DATA: element.college_refid});

                    getFaculty.done(function(facultyData){

                    var getColleges = juju.postJackx('getColleges.php',{SEARCH_DATA: element.college_refid});

                    getColleges.done(function(collegesData){

                        collegesData=JSON.parse(collegesData);

                        facultyData=JSON.parse(facultyData);

                        var currentFaculty = (element.faculty_short_name).toString();
                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['COLLEGE_NAME','BRANCH_NAME','ADDRESS','GEO_LOCATION','CONTACT_NUMBER','PHONE_NUMBER','FACULTY_ARRAY'],
                            CONTENT:[
                                element.college_name,element.branch_name,element.address,element.geo_location,element.contact_number,element.phone_number,currentFaculty
                            ],
                            EXTRA:{
                                FACULTY_ARRAY:['CHECKBOX',facultyData],
                                COLLEGE_NAME:['SELECT_OPTION',collegesData]
                            },
                            COUNTER:SNcounter
                        });
                        SNcounter++;

                    });

                });


                   
                });
                
                }).catch((data)=>{
                    alert('error in making table');
                });

        });


    });


    $("body").on('keyup', "#BRANCH_NAME", function(){

        juju.checkDuplicate({
            DATA:{
                ID:this.id,
                VALUE:this.value,
                DB_TUPLE_ID:$('#DB_TUPLE_ID').val(),
            },
            URL:'handler.php',
            ERROR_LOG_ID:'autoForm-error-log'
        });
    
    });  
    

        //oncollehe change get faculty as per college
        $('#COLLEGE_NAME').change(function(event){

            alert('as');

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


function updateTuple(TableTupleSn,DB_TUPLE_ID){

    var data = {
        ATTR:['COLLEGE_NAME','BRANCH_NAME','ADDRESS','GEO_LOCATION','CONTACT_NUMBER','PHONE_NUMBER','FACULTY_ARRAY'],
                            
    };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'update.php',
        DATA: jsonDataCollection,
    });

    jackxData.done(function(data){  
        console.log('jackxData',jackxData);
        data=JSON.parse(data);
        if(data.ERROR){
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
            juju.fireError({
                TARGET:data.TARGET,
                MSG:data.MSG
            });
        }else{
            juju.alerty({
                status:'success',
                msg:data.MSG,
                title:'Hurray',
                position:'top_right'
            });
            juju.bootModal('close','BRANCH_TABLE_MODAL');
            $('#SEARCH_BOX').val($('#SEARCH_BOX').val());
            $('#SEARCH_BOX').focus();
        }

    });
}



