$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            juju.makeKaliTable({HEAD:['FACULTY NAME','FACULTY SHORTNAME','BASED ON','NO OF PERIODS','DESCRIPTION'],ID:'FACULTY_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                var SNcounter=1;
                jsonData.forEach(element => {
  
                    juju.addTableContent({
                        DATA:data,
                        DB_TUPLE_ID:element.id,
                        CONTENT_ID:['FACULTY_NAME','FACULTY_SHORT_NAME','BASED_ON','NO_OF_PERIODS','DESCRIPTION'],
                        CONTENT:[
                            element.name,element.short_name,element.based_on,element.periods,element.description
                        ],
                        EXTRA:{BASED_ON:['SELECT_OPTION',['SEMESTER','YEARLY']]},
                        COUNTER:SNcounter
                    });
                    SNcounter++;
                });
                
                }).catch((data)=>{
                    alert('error in making table');
                });

        });


    });
    
    $("body").on('keyup', "#FACULTY_NAME, #FACULTY_SHORT_NAME", function(){
    
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
        ATTR:['FACULTY_NAME','FACULTY_SHORT_NAME','BASED_ON','NO_OF_PERIODS','DESCRIPTION']
     };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'update.php',
        DATA: jsonDataCollection
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
            juju.bootModal('close','FACULTY_TABLE_MODAL');
            $('#SEARCH_BOX').val($('#SEARCH_BOX').val());
            $('#SEARCH_BOX').focus();
        }

    });
}
