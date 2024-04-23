$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            juju.makeKaliTable({HEAD:['LOGO','BACKGROUND','COLLEGE NAME','SHORT NAME','ADDRESS','GEO LOCATION','CONTACT NUMBER','PHONE NUMBER','EMAIL','AFFILIATION','DESCRIPTION','DOMAIN CNAME','FACULTIES'],ID:'COLLEGE_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                var SNcounter=1;
                jsonData.forEach(element => {

                    var logo_dir = "http://www.systemic.com/ROOT/DATA/COLLEGE_DATA/"+element.id+'/'+element.college_logo;
                    var background_dir = "http://www.systemic.com/ROOT/DATA/COLLEGE_DATA/"+element.id+'/'+element.college_background_image;
                    
                    var getFaculty = juju.postJackx('getFaculty.php',{SEARCH_DATA: 'NONE'});

                    getFaculty.done(function(facultyData){

                        facultyData=JSON.parse(facultyData);

                        var currentFaculty = (element.faculty_short_name).toString();
                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['LOGO','BACKGROUND','COLLEGE_NAME','SHORT_NAME','ADDRESS','GEO_LOCATION','CONTACT_NUMBER','PHONE_NUMBER','EMAIL','AFFILIATION','DESCRIPTION','DOMAIN_CNAME','FACULTY_ARRAY'],
                            CONTENT:[
                                '<img src="'+logo_dir+'">','<img src="'+background_dir+'">',element.name,element.short_name,element.address,element.geo_location,element.contact_number,element.phone_number,element.email,element.affiliation,element.description,element.domain_cname,currentFaculty
                            ],
                            EXTRA:{
                                AFFILIATION:['SELECT_OPTION',['TU','PU','KU']],
                                FACULTY_ARRAY:['CHECKBOX',facultyData]
                            },
                            COUNTER:SNcounter
                        });
                        SNcounter++;

                    });

                   
                });
                
                }).catch((data)=>{
                    alert('error in making table');
                });

        });


    });


    $("body").on('keyup', "#COLLEGE_NAME, #SHORT_NAME, #CONTACT_NUMBER, #PHONE_NUMBER, #EMAIL, #DOMAIN_CNAME", function(){

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
    

});


function updateTuple(TableTupleSn,DB_TUPLE_ID){

    var data = {
        ATTR:['COLLEGE_NAME','SHORT_NAME','ADDRESS','GEO_LOCATION','CONTACT_NUMBER','PHONE_NUMBER','EMAIL','AFFILIATION','DESCRIPTION','DOMAIN_CNAME','FACULTY_ARRAY']
     };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'update.php',
        DATA: jsonDataCollection,
        FILES:['LOGO','BACKGROUND']
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
            juju.bootModal('close','COLLEGE_TABLE_MODAL');
            $('#SEARCH_BOX').val($('#SEARCH_BOX').val());
            $('#SEARCH_BOX').focus();
        }

    });
}



