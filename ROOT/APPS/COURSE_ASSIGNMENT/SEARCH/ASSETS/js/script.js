$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            var Faculty = "";

            var getFaculty = juju.postJackx('getFaculty.php',{SEARCH_DATA:'NONE'});

            getFaculty.done(function(data2){

                data2=JSON.parse(data2);
                Faculty = data2;

                juju.makeKaliTable({HEAD:['FACULTY','PERIOD','COURSE','ASSIGNED TO'],ID:'FACULTY_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                    var SNcounter=1;
                    jsonData.forEach(element => {

                        var username = element.userdetail;
                        if(element.userdetail==null){
                            username = "Not Assigned";
                        }
       
                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['FACULTY','PERIOD','COURSE','ASSIGNED_TO'],
                            CONTENT:[
                                element.faculty_shortname,element.faculty_period,element.course_name,username
                            ],
                            COUNTER:SNcounter
                        });
                        SNcounter++;
                    });
                    
                    }).catch((data)=>{
                        alert('error in making table');
                    });

            });

        });

    });
          
    $("body").on('keyup', "#CONTACT_NUMBER, #PHONE_NUMBER, #EMAIL", function(){

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
        ATTR:['FACULTY','AMOUNT','ADMISSION_FEE'],
    };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'update.php',
        DATA: jsonDataCollection,
    });

    jackxData.done(function(data){  

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

function deleteOnModal(TABLE_ID,TABLE_SN,DB_TUPLE_ID){

    if(confirm("Are You Sure You Want To Delete This Data ?")){
 
         var jackxData = juju.sendJackx({
             URL:'delete.php',
             DATA: {DELETE:'JACKX_DELETE',DB_TUPLE_ID:DB_TUPLE_ID},
         });
 
         jackxData.done(function(data){  
 
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
 
                 $('#SEARCH_BOX').val($('#SEARCH_BOX').val());
                 $('#SEARCH_BOX').focus();
             }
 
         });
 
    }
 
 
 }
 