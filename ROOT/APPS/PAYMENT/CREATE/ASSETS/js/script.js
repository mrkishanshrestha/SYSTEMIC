$(document).ready(function(){

    $('#SEARCH_BOX').on('keyup focusin change', function(event) {

        var FACULTY_REFID = $('#FACULTY').val();
        const MY_AUTHORITY = $('#MY_AUTHORITY').val();
        var FACULTY_PERIOD = $('#FACULTY_PERIOD').val();
        if( FACULTY_PERIOD == undefined ){
            FACULTY_PERIOD = "";
        }
        if( FACULTY_REFID == undefined ){
            FACULTY_REFID = "";
        }

        var jackxData = juju.postJackx('process.php',{SEARCH_DATA: this.value,FACULTY_REFID: FACULTY_REFID, FACULTY_PERIOD:FACULTY_PERIOD});

        jackxData.done(function(data){

            if(data=='""' || data=="null"){$("#searchtable").empty();
            $("#statementSearhTable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#searchtable").empty();
            $("#statementSearhTable").empty();
            console.log(jsonData);

            if(jsonData.ERROR){ $('#searchtable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

                juju.makeKaliTable({HEAD:['STUDENT PHOTO','STUDENT DOCUMENT','QR','USERNAME','ROLL NO','FACULTY','FACULTY DURATION','FIRST NAME','MIDDLE NAME','LAST NAME','STATEMENT','BALANCE','PAY IN','PAY OUT'],ID:'STUDENT_TABLE',APPEND:'searchtable'}).then((data)=>{
                
                    var SNcounter=1;
                    jsonData.forEach(element => {
                        
                        user_profile_picture_dir = "http://www.systemic.com/ROOT/DATA/USER_DATA/"+element.user_refid+'/'+element.profile_picture_id;
                        document_dir = "http://www.systemic.com/ROOT/DATA/USER_DATA/"+element.id+'/'+element.document_id;
                        
                        var statementBtn = `<button class="kali-table-btn" onclick="getStatement('`+element.id+`');">Get Statement</button>`;
                        var payInBtn=payOutBtn="";
                        if(MY_AUTHORITY == "STUDENT"){

                        }else{
                            var payOutBtn = '<button style="background:red;color:white;" onclick="paymentOut('+element.id+');">PAY OUT</button>';
                            var payInBtn = '<button style="background:green;color:white;" onclick="paymentIn('+element.id+');">PAY IN</button>';
                        }

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.user_refid,
                            CONTENT_ID:['USER_PROFILE_PICTURE','USER_DOCUMENT','QR'+SNcounter,'USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION','FIRST_NAME','MIDDLE_NAME','LAST_NAME','STATEMENT','BALANCE','PAY_IN','PAY_OUT'],
                            CONTENT:[
                                '<img src="'+user_profile_picture_dir+'">','<img src="'+document_dir+'">','<canvas style="width: 150px;" id="QR-DATA-'+SNcounter+'"></canvas>',element.username,element.roll_no,element.faculty_name,element.faculty_period+' ('+element.faculty_based_on+' )',element.first_name,element.middle_name,element.last_name,statementBtn,element.BALANCE,payInBtn,payOutBtn
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




function getStatement(DB_TUPLE_ID){

    event.preventDefault();
    var jackxData = juju.sendJackx({
        URL:'getStatement.php',
        DATA:{'DB_TUPLE_ID':DB_TUPLE_ID,'SEARCH':true}
    });

    jackxData.done(function(data){  
    
            if(data=='""' || data=="null"){$("#statementSearhTable").empty();return true;}

            jsonData=JSON.parse(data);
            $("#statementSearhTable").empty();

            if(jsonData.ERROR){ $('#statementSearhTable').append(`<h1 style="color:red;">`+jsonData.MSG+`</h1>`); return true; }

            var result = [];


                juju.makeKaliTable({OPTIONS:false,HEAD:['ENTRY DATE','DEBIT AMOUNT','CREDIT AMOUNT','DESCRIPTION'],ID:'STUDENT_STATEMENT_TABLE',APPEND:'statementSearhTable'}).then((data)=>{
                
                    var SNcounter=1;
                    var TOTAL_BALACE_AMOUNT=0;
                    var TOTAL_DEBIT_AMOUNT=0;
                    var TOTAL_CREDIT_AMOUNT=0;
                    var USERNAME="";
                    jsonData.forEach(element => {

                        juju.addTableContent({
                            DATA:data,
                            DB_TUPLE_ID:element.id,
                            CONTENT_ID:['ENTRY_DATE','DEBIT_AMOUNT','CREDIT_AMOUNT','DESCRIPTION'],
                            CONTENT:[
                                element.entry_date,element.debit_amount,element.credit_amount,element.description
                            ],
                            DONT_SHOW:['USERNAME','ROLL_NO','FACULTY','FACULTY_DURATION'],
                            COUNTER:SNcounter
                        });
                        
                        TOTAL_BALACE_AMOUNT=element.TOTAL_BALANCE;
                        TOTAL_DEBIT_AMOUNT=element.TOTAL_DEBIT;
                        TOTAL_CREDIT_AMOUNT=element.TOTAL_CREDIT;
                        USERNAME=element.fullname;
                        SNcounter++;
                    });

                    
                    $('#statementSearhTable').append(`
                    <hr/><h3 style="color:black;">Total Debit Balance is Rs.`+TOTAL_DEBIT_AMOUNT+`</h3><hr/><br/>
                        <h3 style="color:black;">Total Credit Balance is Rs.`+TOTAL_CREDIT_AMOUNT+`</h3><hr/><br/>
                        <h3 style="color:black;">Total Balance is Rs.`+TOTAL_BALACE_AMOUNT+`</h3><hr/><br/>
                        <div class="kali-inputbox kali-inputbtn">
                            <button class="kali-btn" id="data-loader-btn" onclick="printDiv('statementSearhTable','`+USERNAME+`');">Print Statement</button>
                        </div> 
                    
                    `); 
                    
                    }).catch((data)=>{
                        alert('error in making table');
                    });

    });


}


function printDiv(printId,title=""){
    event.preventDefault();
        var divContents = document.getElementById(printId).innerHTML;
        var a = window.open('', '', 'height=1500, width=1500');
        a.document.write('<html>');
        a.document.write('<body>');
        a.document.write(`<h1>Financial Statement Of `+title+`</h1>`);
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
}









var html = `    
<form method="post" enctype = "multipart/form-data">
    <fieldset class="kali-form">
        <legend class="kali-formLegend">FINANCIAL PAYMENTS</legend>
            <span class="error-log grid-fill danger-glow" id="student-create-error-log"></span>
            
            <div class="kali-inputbox">
                <span>Amount</span>
                <input type="number" name="PAYMENT_AMOUNT" id="PAYMENT_AMOUNT" placeholder="Enter Amount" required>
            </div>
  
            <div class="kali-inputbox">
                <span>Description</span>
                <input type="text" name="PAYMENT_DESCRIPTION" id="PAYMENT_DESCRIPTION" placeholder="Enter Description" required>
            </div>

    </fieldset>
</form>`;



function paymentIn(DB_TUPLE_ID){

    juju.makeModal({
        APPEND_TO:'bts_modal_container',
        TITLE:'PAYMENT IN',
        MODAL_ID_NAME: 'PAYMENT_MODAL',
        BODY:html,
        FUNCTION:`payIn(`+DB_TUPLE_ID+`);`,
    });
    juju.bootModal('show','PAYMENT_MODAL');
}

function paymentOut(DB_TUPLE_ID){

    juju.makeModal({
        APPEND_TO:'bts_modal_container',
        TITLE:'PAYMENT OUT',
        MODAL_ID_NAME: 'PAYMENT_MODAL',
        BODY:html,
        FUNCTION:`payOut(`+DB_TUPLE_ID+`);`,
    });
    juju.bootModal('show','PAYMENT_MODAL');

}


function payIn(DB_TUPLE_ID){

    var data = {
        ATTR:['PAYMENT_AMOUNT','PAYMENT_DESCRIPTION'],
    };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'paymentIn.php',
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
            juju.bootModal('close','PAYMENT_MODAL');
            $('#data-loader-btn').click();
        }

    });
        
    $('#PAYMENT_MODAL').on('hidden.bs.modal', function () {
        $('#bts_modal_container').empty();
    });

}


function payOut(DB_TUPLE_ID){

    var data = {
        ATTR:['PAYMENT_AMOUNT','PAYMENT_DESCRIPTION'],
    };

    var jsonDataCollection = juju.jDataGather(data,true);
    jsonDataCollection.UPDATE='JACKX_UPDATE';
    jsonDataCollection.DB_TUPLE_ID=DB_TUPLE_ID;

    var jackxData = juju.sendJackx({
        URL:'paymentOut.php',
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
            juju.bootModal('close','PAYMENT_MODAL');
            $('#data-loader-btn').click();

        }

        
        $('#PAYMENT_MODAL').on('hidden.bs.modal', function () {
            $('#bts_modal_container').empty();
        });
    

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
    
                
