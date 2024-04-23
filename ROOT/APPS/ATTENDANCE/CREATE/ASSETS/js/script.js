
function presentStudent(USER_REFID,COURSE_REFID,table_sn){

    var jackxData = juju.sendJackx({
        URL:'attendance.php',
        DATA:{'USER_REFID':USER_REFID,'COURSE_REFID':COURSE_REFID,'STATUS':'PRESENT','ATTENDANCE':true}
    });
    
    jackxData.done(function(data){  
        data = JSON.parse(data);
        console.log(data);
        if(data.ERROR){
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
        }else{
            /*juju.alerty({
                status:'success',
                msg:data.MSG,
                title:'PRESENT',
                position:'top_right'
            });*/
            document.getElementById('status-'+table_sn).innerHTML = "PRESENT";
            document.getElementById('status-'+table_sn).className = "present-status";
        }
    });

}
            
 
function absentStudent(USER_REFID,COURSE_REFID,table_sn){
    
    var jackxData = juju.sendJackx({
        URL:'attendance.php',
        DATA:{'USER_REFID':USER_REFID,'COURSE_REFID':COURSE_REFID,'STATUS':'ABSENT','ATTENDANCE':true}
    });
    
    jackxData.done(function(data){  
        data = JSON.parse(data);
        console.log(data);
        if(data.ERROR){
            juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ERROR',
                position:'top_right'
            });
        }else{
            /*juju.alerty({
                status:'danger',
                msg:data.MSG,
                title:'ABSENT',
                position:'top_right'
            });*/
            document.getElementById('status-'+table_sn).innerHTML = "ABSENT";
            document.getElementById('status-'+table_sn).className = "absent-status";
        }
    });

}
            
 


/*
function search(SELFI){
    var data= "SEARCH_DATA="+SELFI.value;
    juju.sendJackx(null,'../SEARCH/king.php',data);
}
*/