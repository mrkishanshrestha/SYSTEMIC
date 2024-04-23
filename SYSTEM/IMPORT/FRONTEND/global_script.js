class Jscript{

    constructor(){
    }

    playSound(url){
        var myPromise = new Promise((resolve, reject) => {
            const hah = new Audio(url);
            hah.play();
            hah.addEventListener('ended', (event) => {resolve();});
        });
        return myPromise;
    }

    sendJackx(thisObj){

        ////console.log('sendjacks =>  ',thisObj);

        if(thisObj.URL=='' || thisObj.URL==undefined || thisObj.URL==null){
            alert('Send Jackx URL not defined');
        }

        if(thisObj.DATA==null && thisObj.FORM==null){
            alert('Please Set Data Or Form In Jackx');
            return false;
        }

        var formData;

        if(thisObj.FORM!=null){
            formData = new FormData(thisObj.FORM);
            formData.append('JACKX', 'CHECKED');
        }

        ////console.log('DATA',thisObj.DATA);
        if(thisObj.DATA!=null){
            ////console.log('key',thisObj.DATA);
            if(thisObj.FORM==null){formData = new FormData();}
            for (const keyData in thisObj.DATA) {
                ////console.log('keyData =>  ',keyData);
                ////console.log('key',keyData);
                ////console.log('keyData',thisObj.DATA[keyData]);
                formData.append(keyData,thisObj.DATA[keyData]);
                ////console.log('data =>  ',thisObj.DATA[keyData]);
            }
            //console.log('final formdata =>  ',formData);
        }

                
        if(thisObj.FILES!=null){
            for(var i=0;i<thisObj.FILES.length;i++){
                var FILE_DATA = document.getElementById(thisObj.FILES[i]).files;
                //console.log(FILE_DATA); 
                for(var j=0;j<FILE_DATA.length;j++){
                    formData.append(thisObj.FILES[i]+'[]',FILE_DATA[j],FILE_DATA[j].name);
                }
            }
        }


        //console.log('key',formData);

        console.log('sendjackx   ;'+formData);
        return $.ajax({
            url: thisObj.URL,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            error:function(data){
                alert('Sorry '+data.statusText);
            },
        });
    }

    /**postJackx(url,data){
    $.post(url,data,function(aakoData){
        return aakoData;
    });
}*/

    postJackx(URL_TO_SEND,DATA_TO_SEND){
        return $.ajax({
            url: URL_TO_SEND,
            type: 'POST',
            data: DATA_TO_SEND,
            error:function(data){
                alert('Sorry '+data.statusText);
            },
        });
    }

    oldsendJackx(TARGET_FORM_ID=null,TARGET_PAGE,TARGET_DATA=null){


        return new Promise(function(resolve, reject) {
            event.preventDefault();
            var parma;
            if(TARGET_DATA==null){
                if(TARGET_FORM_ID==null || TARGET_FORM_ID==''){
                    alert('Send Jacks Error: Target Form Is Not Set !');
                    return false;
                }
                parma = $('#'+TARGET_FORM_ID).serialize();
            }else{
                parma = TARGET_DATA;
            }

            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", TARGET_PAGE, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.onreadystatechange = function() {
                if(xhttp.readyState == 4 && xhttp.status == 200){

                    //console.log( 'dgdgdf  ',xhttp.responseText);
                    
                    if(xhttp.responseText==""|| xhttp.responseText==null){
                        resolve('Nothing Found');
                    }else{
                        var replyingData = JSON.parse(xhttp.responseText);
                        resolve(replyingData);
                    }
                }else if(xhttp.status == 404){
                    resolve('File Not Found');
                }else if(xhttp.status == 403){
                    resolve('Not Authorized');
                }
            }
            xhttp.send(parma);
        });
    }

    getJackx(){
        alert('receiving  jackx');
    }

    fireError(thisObj){

        if(thisObj.ERROR_LOG_ID){
            document.getElementById(thisObj.ERROR_LOG_ID).style.display = "block";
            if(thisObj.ERROR_LOG_ID) document.getElementById(thisObj.ERROR_LOG_ID).innerHTML = thisObj.MSG;
        }

        if(thisObj.TARGET){
            thisObj.TARGET.forEach(function (VICTIM_ID) {
                    document.getElementById(VICTIM_ID).classList.add('danger-glow');
                    
                    if(thisObj.CLEAR_ON == 'keydown'){
                        document.getElementById(VICTIM_ID).setAttribute('onkeydown',"this.classList.remove('danger-glow');");
                    }
                    
                    if(thisObj.RES_CLEAR){
                        document.getElementById(VICTIM_ID).setAttribute('onkeydown',"this.classList.remove('danger-glow');document.getElementById('"+thisObj.ERROR_LOG_ID+"').style.display='none';");
                    }else{
                        if(thisObj.ERROR_LOG_ID){
                            setInterval(function () {
                                 document.getElementById(thisObj.ERROR_LOG_ID).style.display = "none";
                             }, 3000);
                        }
                    }
                });
            }
    }

     changeDash(newSrc) {
        javascript:document.location=newSrc;
    }

    linkFile(type,url,domain = false){

        if(domain){url='https://kishan.vantageloaf.work/'+url;}
        
        var element;

        if(type == "CSS" || type == "css"){
            type="link";
            element = document.createElement(type);
            element.type = 'text/css';
            element.rel = 'stylesheet';
            element.href = url;
        }
        else if(type == "JS" || type == "js" ){
            type="script";
            element = document.createElement(type);
            element.src = url;
        }
        else{
            alert('invlaid file type');
            return false;
        }
        
        document.head.appendChild(element);
    }

    alerty(thisObject) {
        
        if (!thisObject) thisObject = {}
        if (!thisObject.position) thisObject.position = "bottom_left";
        if (!thisObject.timeout) thisObject.timeout = 5000;
        if (!thisObject.maxAlerts) thisObject.maxAlerts = 10;
    
        const alertyContainer = document.getElementById("alerterContainer");

        /* creating notification container */
        if(alertyContainer==null){
            
        this.linkFile('CSS','SYSTEM/IMPORT/FRONTEND/TOOLS/ALERTY/alerty.css',true);
        const alerterContainer = document.createElement("div");
                    alerterContainer.id = "alerterContainer";
                    alerterContainer.className = thisObject.position;
           // document.body.appendChild(alerterContainer);
            document.body.insertBefore(alerterContainer, document.body.firstChild);
        }

        /* for counting notifications */
        const countAlerts = document.getElementsByClassName("alerty");

        const allowedParameters = !thisObject.status || ( thisObject.status != 'info' && thisObject.status != 'success' && thisObject.status != 'danger' && thisObject.status != 'warning'); 
    
        thisObject.status = allowedParameters ? 'info' : thisObject.status;
        
        thisObject.sound = !thisObject.sound ? false : true;

        if (!thisObject.title) {
            thisObject.title = 'Hey Hey ! Look Here.';
            thisObject.msg = 'Hey, Alertification Here !';
        } else {
            thisObject.title = thisObject.title;
            thisObject.msg = thisObject.msg;
        };

        if (countAlerts.length < thisObject.maxAlerts) {
            this.alertCreate(thisObject);
        };
    
    };
    
    alertCreate(thisObject){

        const alertSound = 'https://kishan.vantageloaf.work/SYSTEM/IMPORT/FRONTEND/TOOLS/ALERTY/notification.mp3';

        let alerty = document.createElement("div");
                alerty.className = "alerty";
                alerty.className += " alerty-" + thisObject.status;
                alerty.setAttribute("ondblclick", "this.remove();");
                 
        if (!thisObject.msg) {
            alerty.innerHTML = `<h3>${thisObject.title}</h3>`;
        } else {
            alerty.innerHTML = `<h3>${thisObject.title}</h3><p>${thisObject.msg}</p>`;
        };
                alerterContainer.appendChild(alerty);
        if (thisObject.sound) {
            const audio = new Audio(alertSound);
                  audio.play();
        }
        setTimeout(function () {
            alerty.classList.toggle("fadeOut");
        }, thisObject.timeout - 300);
        setTimeout(function () {
            alerterContainer.removeChild(alerty);
        }, thisObject.timeout);
    };

    dataLookup(thisObj){
        //this needs data == url, form, data to apend in json,
        console.log(`dataLookup   : `+thisObj);
        var lookUpJackx = this.sendJackx(thisObj);
        var ERROR_LOG_ID_DATA=false;
        if(thisObj.ERROR_LOG_ID){
            ERROR_LOG_ID_DATA=thisObj.ERROR_LOG_ID;
        }

        lookUpJackx.done(function(data){
            console.log(`lookUpJackx   : `+data);
            data = JSON.parse(data);
            if(data.ERROR){
                juju.fireError({
                    MSG:data.MSG,
                    TARGET:data.TARGET,
                    ERROR_LOG_ID:ERROR_LOG_ID_DATA,
                    RES_CLEAR:true
                });
                this.reset();
            }
        });

    }

    sayAboutUs(){
    }

    makeModal(data){

        var htmls="";
        try{

        if(data.MODAL_ID_NAME==undefined){
            alert('MODAL_ID_NAME IS NEEDED !');
            return false;
        }

        if(data.TITLE==undefined){
            alert('TITLE IS NEEDED !');
            return false;
        }

        if(data.BODY==undefined){
            alert('BODY IS NEEDED !');
            return false;
        }

        if(data.TYPE == 'FORM'){

            if(data.FACTION==undefined){            
                alert('FACTION IS NEEDED WHILE USING MODAL AS FORM !');
                return false;
            }
            if(data.FORM_ID==undefined){        
                alert('FORM_ID IS NEEDED WHILE USING MODAL AS FORM !');
                return false;
            }

            htmls = `
            <div  style="color:black;" class="modal fade" id="`+data.MODAL_ID_NAME+`" tabindex="-1" role="dialog" aria-labelledby="`+data.MODAL_ID_NAME+`Label">
            <div class="modal-dialog" role="document" style="width: 80%;">
                <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="`+data.MODAL_ID_NAME+`Label" style="color:black;">`+data.TITLE+`</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="`+data.FACTION+`" id="`+data.FORM_ID+`" method="POST">
                            `+data.BODY+`
                        <input type="submit" value="Lets Go !">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>`;

        }else{

            
        if(data.FUNCTION==undefined){
            alert('FUNCTION IS NEEDED !');
            return false;
        }

        htmls = `
            <div  style="color:black;" class="modal fade" id="`+data.MODAL_ID_NAME+`" tabindex="-1" role="dialog" aria-labelledby="`+data.MODAL_ID_NAME+`Label">
            <div class="modal-dialog" role="document" style="width: 80%;"   >
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="`+data.MODAL_ID_NAME+`Label" style="color:black;">`+data.TITLE+`</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                `+data.BODY+`
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="`+data.FUNCTION+`" class="btn btn-primary">Confirm</button>
                </div>
                </div>
            </div>
            </div>`;
        }
        
        //console.log('now ',htmls);

        $('#'+data.APPEND_TO).append(htmls);

    }catch(e){
        //console.error(e);
    }

    }

   speak(what){
        
        var speaker = new Promise((resolve, reject) => {

            switch(what){

                case 'ABOUT_US':
                    this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/ABOUT/about1.mp3')
                    .then(()=>{
                        this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/ABOUT/about2.mp3')
                        .then(()=>{
                            this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/ABOUT/about3.mp3')
                            .then(()=>{
                                this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/ABOUT/about4.mp3')
                                .then(()=>{
                                    this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/ABOUT/about5.mp3');
                                });
                            });
                        });
                    });
                    break;
        
                case 'INVALID_CREDENTIALS':
                    this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/InvalidCredentials.mp3').then(()=>{resolve();});
                    break;
        
                case 'TRY_AGAIN':
                    this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/tryAgain.mp3').then(()=>{resolve();});
                    break;
            
                case 'WELCOME':
                    this.playSound('https://kishan.vantageloaf.work/SYSTEM/IMPORT/SITE_DATA/SOUNDS/welcome.mp3').then(()=>{resolve();});
                    break;
                            
                default:
                    alert('K bolney bhaneko xaina');
                    break;

                }

        });

        return speaker;
       
    }

    bootModal(option,idname){

        switch (option){

            case 'show':
                case 'SHOW':
                    case 'OPEN':
                        case 'open':
                    $('#'+idname).modal('show');
                    break;

            case 'hide':
                case 'close':
                    case 'CLOSE':
                        case 'HIDE':
                    $('#'+idname).modal('hide');
                    break;

            default:
                alert('invalid option');
                break;

        }

    }

    jDataGather(data,json=false){
        var jData=[];
        data.ATTR.forEach(element => {
             //console.log(element);
             if(document.getElementById(element)==null || document.getElementById(element)==undefined){
                var dataArray = [];
                var counter = $('input[name="'+element+'[]"]:checked').length;
                var checkedData = $('input[name="'+element+'[]"]:checked');
                for(var i =0;i<counter;i++){
                    dataArray.push(checkedData[i].value);
                }
                console.log(typeof(dataArray));
                jData[element] = dataArray;
             }else if(data.COUNTER!=null){
                jData[element] =document.getElementById(element+'-'+data.COUNTER).value;
            }else{
                jData[element] =document.getElementById(element).value;
            }
        });

        if(json){
            jData = Object.assign({}, jData);
        }

        return jData;
    }

    makeWriteable(thisObj){
		var oldData = thisObj.value;
        thisObj.style.border = "2px solid var(--text-color)";
        var counterData = thisObj.id;
        const mycounterDataArray = counterData.split("-");
		
		thisObj.addEventListener('focusout', (event) => {
			if(oldData!=thisObj.value){
				document.getElementById(mycounterDataArray[1]).style.display = 'block';
			}
			if(thisObj.value==''){thisObj.value=oldData;}
		});

		thisObj.removeAttribute('readonly');
    }
    
    setSiteBackground(IdName,URL){
        document.getElementById(IdName).style.backgroundImage = "url('"+URL+"') ";
    }

    makeKaliTable(data){

        var header="";
        var tableHtml = "";
    
        let p = new Promise((resolve, reject)=> {
    
          tableHtml = `
          <table class="kali-table" id="`+data.ID+`">
            <tbody>
              <tr>
                <th>SN</th>
        `;
    
        var c =0;
          data.HEAD.forEach(element => {
            header += `<th>`+element+`</th>
            `;
            if(c==data.HEAD.length-1){
                if(data.OPTIONS!=false){
                    header += `<th>Option</th>
                    `;
                }
            }
            c++;
        });


        var tableOutput = tableHtml+header+`
           </tr>
          </tbody>
        </table>`;
    
        $('#'+data.APPEND).append(tableOutput);
        resolve(data);
    
      })
    
      return p;
    }
    
    addTableContent(data){
        
        //console.log('indide addTableContent',data.DATA.HEAD[0]);
        var tableContent="";
        var i = 0; 

        if(data.COUNTER==undefined){
            alert('COUNTER NOT SET ! YOU MUST SEND A COUNTER FOR MAKING TABLE');
            return false;
        }

        if(data.DB_TUPLE_ID==undefined){
            alert('DB TUPLE ID NOT SET TO ALLOCATE DB TUPLE! YOU MUST SEND A DB TUPLE ID FOR UPDATING AND DELETION !');
            return false;
        }

        
        data.CONTENT.forEach(element => {

        var option="";
        var ExtraData  = "No Data";

        if(element==''){element='---';}

        if(data.EXTRA!=undefined){

            //console.log('consoling extra',data.EXTRA);

            
            if(data.EXTRA[data.CONTENT_ID[i]]!=undefined){

                
            //console.log('consoling extra contents of post',data.EXTRA[data.CONTENT_ID[i]]);

                if(data.EXTRA[data.CONTENT_ID[i]][0]=="SELECT_OPTION"){

                    ExtraData = data.EXTRA[data.CONTENT_ID[i]][1].toString();
                    //console.log('ExtraData is s is i s',ExtraData);
                    ExtraData = ExtraData.toString();
                    //console.log('ExtraData To String',ExtraData);
                    ExtraData =  `data-extraDataType="SELECT_OPTION" data-extraData='`+ExtraData+`'`;
                }

                
                if(data.EXTRA[data.CONTENT_ID[i]][0]=="CHECKBOX"){

                    ExtraData = data.EXTRA[data.CONTENT_ID[i]][1].toString();
                    //console.log('ExtraData is s is i s',ExtraData);
                    ExtraData = ExtraData.toString();
                    //console.log('ExtraData To String',ExtraData);
                    ExtraData =  `data-extraDataType="CHECKBOX" data-extraData='`+ExtraData+`'`;
                }


            }


        }
       
        tableContent += `<td data-th="`+data.DATA.HEAD[i]+`" `+ExtraData+` data-tupleId="`+data.CONTENT_ID[i]+`" mytuple="`+data.COUNTER+`">`+element+option+`</td>`;

            if(i==data.CONTENT.length-1){
                if(data.DATA.OPTIONS!=false){
                    tableContent += `
                    <td data-th="Options">
                        <i class="fa-solid fa-pen-to-square" onclick="juju.editOnModal('`+data.DATA.ID+`',`+data.COUNTER+`,'`+data.DB_TUPLE_ID+`');"></i>
                        <i class="fa-solid fa-trash" onclick="deleteOnModal('`+data.DATA.ID+`',`+data.COUNTER+`,'`+data.DB_TUPLE_ID+`');"></i>
                    </td>`;
                }
            }

          i++;
        });
        
        $('#'+data.DATA.ID).append(`<tr><td data-th="SN">`+data.COUNTER+`</td>`+tableContent+`</tr>`);
    }

    editOnModal(TableId,TableTupleSn,DB_TUPLE_ID){

        console.log(TableId,TableTupleSn,DB_TUPLE_ID);

        var AutoForm = this.makeAutoForm({mytupleNo:TableTupleSn,TabId:TableId,DB_TUPLE_ID:DB_TUPLE_ID});
        var ModalId = TableId+'_MODAL';
        this.makeModal({
            APPEND_TO:'bts_modal_container',
            TITLE:'DATA EDITOR',
            MODAL_ID_NAME: ModalId,
            BODY:AutoForm,
            FUNCTION:`updateTuple(`+TableTupleSn+`,'`+DB_TUPLE_ID+`');`,
        });

        this.bootModal('show',ModalId);

        $('#'+ModalId).on('hidden.bs.modal', function () {
            $('#bts_modal_container').empty();
        });

    }

    makeAutoForm(data){

        var formBodyData="";
        var myDbId="";
        var myTab = document.getElementById(data.TabId);

        if(data.DB_TUPLE_ID!=undefined){
            myDbId = `<input type="text" value="`+data.DB_TUPLE_ID+`" id="DB_TUPLE_ID" style="display:none;">`;
        }
        var dataContent=`
        <form>
        <fieldset class="kali-form">
        <legend class="kali-formLegend">UPDATE</legend> 
        <span class="error-log grid-fill danger-glow" id="autoForm-error-log"></span>`+myDbId;

        // GET THE CELLS COLLECTION OF THE CURRENT ROW.
        var objCells = myTab.rows.item(data.mytupleNo).cells;

        // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
        
        for (var j = 1; j < objCells.length-1; j++) {

            formBodyData = objCells.item(j).innerHTML; 

            var a = document.createElement('div');
            a.innerHTML = ``+formBodyData+``;
            var objectTypeOfHtml = a.childNodes[0]['nodeName'];
            var thName = myTab.rows.item(0).cells.item(j).innerHTML;
            //var tupleInputId = thName.replace(/\s/g, '_');
            var tupleInputId = myTab.rows.item(data.mytupleNo).cells.item(j).dataset.tupleid;
            var extraDataType = myTab.rows.item(data.mytupleNo).cells.item(j).dataset.extradatatype;
            var extraData= myTab.rows.item(data.mytupleNo).cells.item(j).dataset.extradata;
            //console.log('extraDataType   ',extraDataType);
            //console.log('j j',j);
            //console.log('data.mytupleNo',data.mytupleNo);
            //console.log('tupleInputId',tupleInputId);
            
            if(objectTypeOfHtml=="IMG"){
                //currentSrc
                dataContent += `
                <div class="kali-inputbox">
                    <span>`+thName+` ( If Necessary )</span>
                    <input type="file" id="`+tupleInputId+`" name="`+tupleInputId+`" ">
                </div>`;
                continue;

            }else{
                if (a.childNodes[0].nodeType == 1){continue;}; 
            }

            if(extraDataType!=undefined){


                if(extraDataType=="SELECT_OPTION"){

                extraData = extraData.split(",");
                var selOption = ""; var selected="";

                extraData.forEach((element) => {
                    if(formBodyData==element){ selected = "selected";}else{selected=""}
                    selOption += `<option value="`+element+`" `+selected+` >`+element+`</option>`;
                  });

                dataContent += `<div class="kali-inputbox">
                                    <span>`+thName+`</span>
                                    <select name="`+tupleInputId+`" id="`+tupleInputId+`"required>`+
                                    selOption+
                                    `</select>
                                </div>`;
                continue;
                }
                
                if(extraDataType=="CHECKBOX"){

                    extraData = extraData.split(",");
                    var selOption = ""; var selected="";
                    var arrData = [];
    
                extraData.forEach((element) => {

                    console.log('callinf extraData foreach mainf');

                        console.log('formBodyData',formBodyData);

                        var hahadaa=formBodyData.split(',');
                        var ci = 0;
                        hahadaa.forEach(element2 => {

                            console.log('after slping',element2);
                            console.log('after hahadaa[ci]',hahadaa[ci]);

                            if(hahadaa[ci]==element2){ console.log('checked ',element2); arrData[element2] = true;}else{arrData[element2]=false;}
                            ci++;
                        });


                        console.log('arrData',arrData);
                        if(arrData[element]){ selected = "checked";}else{selected=""}

                        selOption += `<div class="kali-checkbox-option-data">
                                        <input class="kali-checkbox-data" name="`+tupleInputId+`[]"  type="checkbox" value="`+element+`" id="`+element+`" `+selected+` >
                                        <label  for="`+element+`">`+element+`</label>
                                    </div>`;

                    });
    
                    dataContent += `<div class="kali-checkbox">
                                        <div class="kali-checkbox-options">
                                        <span>`+thName+`</span>`+
                                        selOption+
                                        `
                                    </div>
                                </div>`;
                    continue;
                }

            }
            
            /*for (var c = a.childNodes, i = c.length; i--; ) {
                if (c[i].nodeType == 1){continue;}; 
            }*/


            if(formBodyData=='---'){formBodyData="";}

            if(Number(formBodyData)){
                dataContent += `
                <div class="kali-inputbox">
                    <span>`+thName+`</span>
                    <input type="text" id="`+tupleInputId+`" value="`+formBodyData+`">
                </div>`;

            }
            else{
                dataContent += `
                <div class="kali-inputbox">
                    <span>`+thName+`</span>
                    <input type="text" id="`+tupleInputId+`" value="`+formBodyData+`">
                </div>`;
            }

        }
        dataContent+=`</fieldset></form>`;
        return dataContent;
    
    }

    checkDuplicate(data){

        if(data.URL==undefined){data.URL="handler.php"; }

        if(data.DATA==undefined){alert("DATA IS NEEDED");return false;}

        if(data.ERROR_LOG_ID==undefined){data.ERROR_LOG_ID=undefined;}

        this.dataLookup({
            URL:'handler.php',
            DATA:data.DATA,
            ERROR_LOG_ID:data.ERROR_LOG_ID,
        });

    }


    qr(data,id){

        console.log(data+'  '+id);

        var qr;
        (function() {
                qr = new QRious({
                element: document.getElementById(id),
                size: 200,
                value: 'Systemic'
            });
        })();

        function generateQRCode(dataString) {
            var qrtext = dataString;
            qr.set({
                foreground: 'black',
                size: 200,
                value: qrtext
            });
        }

        generateQRCode(data);

    }


    chart(element)
    {
        var el = document.getElementById(element);
        var color=  el.getAttribute('data-color') ;

        if(el.getAttribute('data-percent')>0 && el.getAttribute('data-percent')<=30){
            color = "#ff0000";
        }
        if(el.getAttribute('data-percent')>30 && el.getAttribute('data-percent')<=60){
            color = "#ffd200";
        }
        if(el.getAttribute('data-percent')>60 && el.getAttribute('data-percent')<=100){
            color = "#009688";
        }
        if(el.getAttribute('data-percent')==0){
            color = "black";
        }

        var options = {
            percent:  el.getAttribute('data-percent') || 25,
            size: el.getAttribute('data-size') || 220,
            lineWidth: el.getAttribute('data-line') || 20,
            rotate: el.getAttribute('data-rotate') || 0,
        content: el.getAttribute('data-text') || "Skills",
        }

        var canvas = document.createElement('canvas');
        var span = document.createElement('span');
        span.textContent = options.content +" "+ options.percent+"%";
            
        if (typeof(G_vmlCanvasManager) !== 'undefined') {
            G_vmlCanvasManager.initElement(canvas);
        }

        var ctx = canvas.getContext('2d');
        canvas.width = canvas.height = options.size;

        el.appendChild(span);
        el.appendChild(canvas);

        ctx.translate(options.size / 2, options.size / 2); 
        ctx.rotate((-1 / 2 + options.rotate / 180) * Math.PI); 

        //imd = ctx.getImageData(0, 0, 240, 240);
        var radius = (options.size - options.lineWidth) / 2;

        var drawCircle = function(color, lineWidth, percent) {
        
                percent = Math.min(Math.max(0, percent || 1), 1);
                ctx.beginPath();
                ctx.arc(0, 0, radius, 0, Math.PI * 2 * percent, false);
                ctx.strokeStyle = color;
                ctx.lineCap = 'round'; 
                ctx.lineWidth = lineWidth;
                ctx.stroke();
        };

        drawCircle('#BFBFBF', options.lineWidth, 100 / 100);
        drawCircle(color, options.lineWidth, options.percent / 100);
    }



    createCircleBar(id,title,percentage,appendTo){
        var barHTML = `<div data-color='#009688' class='chart' id='`+id+`' data-percent="`+percentage+`" data-text="`+title+`"></div>`;
        document.getElementById(appendTo).innerHTML=barHTML;
        this.chart(id);
    }

    
}


var juju = new Jscript();
