$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            var Authority = "";
            var result = [];
            var getAuthority = juju.postJackx('getAuthority.php',{SEARCH_DATA: data.authority_refid});
            getAuthority.done(function(data2){

                console.log(data2);
              /*  data2=JSON.parse(data2);
                Authority = data2;*/

                juju.makeKaliTable({HEAD:['USER PHOTO','USER DOCUMENT','POST','USERNAME','FIRST NAME','MIDDLE NAME','LAST NAME','CONTACT NUMBER','PHONE NUMBER','EMAIL','ADDRESS'],ID:'USER_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                    var SNcounter=1;
                    jsonData.forEach(element => {
                        
                        user_profile_picture_dir = "https://www.systemic.com/ROOT/DATA/USER_DATA/"+element.id+'/'+element.profile_picture_id;
                        document_dir = "https://www.systemic.com/ROOT/DATA/USER_DATA/"+element.id+'/'+element.document_id;
                        
                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['USER_PROFILE_PICTURE','USER_DOCUMENT','POST','USERNAME','FIRST_NAME','MIDDLE_NAME','LAST_NAME','CONTACT_NUMBER','PHONE_NUMBER','EMAIL','ADDRESS'],
                            CONTENT:[
                                '<img src="'+user_profile_picture_dir+'">','<img src="'+document_dir+'">',element.AUTHORITY,element.username,element.first_name,element.middle_name,element.last_name,element.contact_number,element.phone_number,element.email,element.address
                            ],
                            
                            COUNTER:SNcounter
                        });
                        /*EXTRA:{USER_POST:['SELECT_OPTION',['Authority']]},*/
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
        ATTR:['USERNAME','USER_POST','FIRST_NAME','MIDDLE_NAME','LAST_NAME','CONTACT_NUMBER','PHONE_NUMBER','EMAIL','ADDRESS','DESCRIPTION']
     };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'update.php',
        DATA: jsonDataCollection,
        FILES:['USER_PROFILE_PICTURE','USER_DOCUMENT']
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
            juju.bootModal('close','USER_TABLE_MODAL');
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
 