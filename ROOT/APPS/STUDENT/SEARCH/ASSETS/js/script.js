$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var FACULTY_REFID = $('#FACULTY').val();
        var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
        if( FACULTY_PERIOD == undefined ){
            FACULTY_PERIOD = "";
        }

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value,FACULTY_REFID: FACULTY_REFID, FACULTY_PERIOD:FACULTY_PERIOD});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();
            console.log(jsonData);

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['STUDEasdasNT PHOTO','STUDENT DOCUMENT','QR','USERNAME','ROLL NO','FACULTY','FACULTY DURATION','FIRST NAME','MIDDLE NAME','LAST NAME','CONTACT NUMBER','GURDIAN NUMBER','EMAIL','ADDRESS','DESCRIPTION'],ID:'STUDENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                    var SNcounter=1;
                    jsonData.forEach(element => {
                        
                        user_profile_picture_dir = "http://www.systemic.com/ROOT/DATA/USER_DATA/"+element.id+'/'+element.profile_picture_id;
                        document_dir = "http://www.systemic.com/ROOT/DATA/USER_DATA/"+element.id+'/'+element.document_id;
                        
                        var dbclickCode = `ondblclick="juju.changeDash('https://www.systemic.com/ROOT/APPS/PERFORMANCE_EVALUATOR/MAIN/king.php?USER_REFID=`+element.id+`');"`;

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['USER_PROFILE_PICTURE','USER_DOCUMENT','QR'+SNcounter,'USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION','FIRST_NAME','MIDDLE_NAME','LAST_NAME','CONTACT_NUMBER','GURDIAN_NUMBER','EMAIL','ADDRESS'],
                            CONTENT:[
                                '<img '+dbclickCode+' src="'+user_profile_picture_dir+'">','<img src="'+document_dir+'">','<canvas style="width: 150px;" id="QR-DATA-'+SNcounter+'"></canvas>',element.username,element.roll_no,element.faculty_name,element.faculty_period+' ('+element.faculty_based_on+' )',element.first_name,element.middle_name,element.last_name,element.contact_number,element.gurdian_number,element.email,element.address
                            ],
                            DONT_SHOW:['USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION'],
                            COUNTER:SNcounter
                        });
                        var qrdata = 'username is - '+element.username+' First NAme is - '+element.first_name;
                        juju.qr(qrdata,'QR-DATA-'+SNcounter);
                        SNcounter++;
                    });
                    
                    }).catch((data)=>{
                        alert('error in making table');
                    });

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
            juju.bootModal('close','STUDENT_TABLE_MODAL');
            $('#SEARCH_BOX').val($('#SEARCH_BOX').val());
            $('#SEARCH_BOX').focus();
        }

    });
}


function hello(){
    
    var FACULTY = $('#FACULTY').val();
        
    var jackxData = juju.sendJackx({
        URL:'getDuration.php',
        DATA:{'FACULTY':FACULTY,'SELECT_OPTION':true}
    });
    
    jackxData.done(function(data){  
        
        $('#FACULTY_DURATION').empty();
    
        data = JSON.parse(data);
        console.log(data);
        if(data.ERROR){
            juju.fireError({
                MSG:data.MSG,
                TARGET:data.TARGET,
                ERROR_LOG_ID:'error-log',
            });
    
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
    
            
        }else{
    
            $('#FACULTY_DURATION').empty();
    
            var periods = data.periods;
            var options="";
            var selected="";
            for(var i = 1; i<=periods; i++){
                if(i == 1){selected="selected";}else{selected="";}
                options=options+`<option value="`+i+`" `+selected+`>`+i+`</option>`;
            }
    
            var html = `<span>Faculty `+data.based_on+` Periods</span>
            <select name="FACULTY_PERIOD" id="FACULTY_PERIOD" required>
                <option value="" selected>Choose Faculty Periods</option>
                `+options+`
            </select>`;
    
            $('#FACULTY_DURATION').append(html);
        }
    
    });
    
    }
    
                
