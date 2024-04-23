$(document).ready(function(){


    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            juju.makeKaliTable({HEAD:['USER PHOTO','USERNAME','FIRST NAME','MIDDLE NAME','LAST NAME','CONTACT NUMBER','SECONDARY NUMBER','ADDRESS','EMAIL','COLLEGE LIMIT','BRANCH LIMIT'],ID:'USER_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                var SNcounter=1;
                jsonData.forEach(element => {
                    
                    profile_picture_dir = "https://www.systemic.com/ROOT/DATA/USER_DATA/CLIENT/"+element.id+'/'+element.profile_picture_id;
                    
                    juju.addTableContent({
                        DATA:data,
                        DB_TUPLE_ID:element.id,
                        CONTENT_ID:['PROFILE_PICTURE','USERNAME','FIRST_NAME','MIDDLE_NAME','LAST_NAME','CONTACT_NUMBER','SECONDARY_NUMBER','ADDRESS','EMAIL','COLLEGE_LIMIT','BRANCH_LIMIT'],
                        CONTENT:[
                            '<img src="'+profile_picture_dir+'">',element.username,element.first_name,element.middle_name,element.last_name,element.contact_number,element.phone_number,element.address,element.email,element.college_limit,element.branch_limit
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