$(document).ready(function(){


    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            juju.makeKaliTable({HEAD:['NAME','RIGHTS'],ID:'USER_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                var SNcounter=1;
                jsonData.forEach(element => {
               
                    juju.addTableContent({
                        DATA:data,
                        DB_TUPLE_ID:element.id,
                        CONTENT_ID:['NAME','RIGHTS'],
                        CONTENT:[
                            element.name,element.rights_x
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