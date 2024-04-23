$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            juju.makeKaliTable({HEAD:['FACULTY','FACULTY PERIOD','BASED ON','COURSE NAME','COURSE CODE','CREDIT HRS','LECTURE HRS','TUTORIAL HRS','LAB HRS','DOCUMENTS'],ID:'COURSE_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                var SNcounter=1;
                jsonData.forEach(element => {

                    var linkHtml = "";
                    myPdfs = element.course_document;
                    myPdfs = myPdfs.split(',');
                    myPdfs.forEach(filename => {
                        pdfDirectory = "http://systemic.com/ROOT/DATA/APP_DATA/COURSE/"+element.course_name+'/'+filename;
                        linkHtml += `<a href="`+pdfDirectory+`">`+filename+`</a>`;
                    });
                    //pdfDirectory = "http://systemic.com/ROOT/DATA/APP_DATA/COURSE/"+element.course_name+'/'+element.course_document;
                   

                    juju.addTableContent({
                        DATA:data,
                        DB_TUPLE_ID:element.id,
                        CONTENT_ID:['FACULTY','FACULTY_PERIOD','BASED_ON','COURSE_NAME','COURSE_CODE','CREDIT_HRS','LECTURE_HRS','TUTORIAL_HRS','LAB_HRS','DOCUMENTS'],
                        CONTENT:[
                            element.faculty,element.faculty_period,element.based_on,element.course_name,element.course_code,element.credit_hrs,element.lecture_hrs,element.tutorial_hrs,element.lab_hrs,linkHtml
                        ],
                        EXTRA:{FACULTY:['SELECT_OPTION',['SEMESTER','YEARLY']]},
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
 