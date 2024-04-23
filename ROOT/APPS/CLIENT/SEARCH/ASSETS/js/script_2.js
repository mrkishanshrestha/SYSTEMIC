$(document).ready(function(){
    

$("body").on('keyup', "#USERNAME, #FIRST_NAME, #LAST_NAME, #CONTACT_NUMBER, #SECONDARY_NUMBER, #EMAIL", function(){

    juju.checkDuplicate({
        DATA:{
            ID:this.id,
            VALUE:this.value
        },
        URL:'handler.php',
        ERROR_LOG_ID:'autoForm-error-log'
    });

});  

});

function updateTuple(TableTupleSn,DB_TUPLE_ID){

    var data = {
            ATTR:['USERNAME','FIRST_NAME','MIDDLE_NAME','LAST_NAME','CONTACT_NUMBER','SECONDARY_NUMBER','ADDRESS','EMAIL','COLLEGE_LIMIT','BRANCH_LIMIT','DESCRIPTION']
         };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;
    

    var jackxData = juju.sendJackx({
        URL:'update.php',
        DATA: jsonDataCollection,
        FILES:['PROFILE_PICTURE']
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
