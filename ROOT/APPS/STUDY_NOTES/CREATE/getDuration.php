
<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';

    try{

 
        if(isset($_POST['SELECT_OPTION'])){
            $sql = 'SELECT `periods`,`based_on` FROM `faculty` WHERE `short_name`=:short_name';
            $data = $kali->kaliPull($sql,['short_name'=>$_POST['FACULTY']]);
            if($data){
                $kali->kaliReply($data);
            }else{
                $kali->kaliReply(['ERROR'=>true,'MSG'=>'Data Not Found '.$_POST['FACULTY'],'TARGET'=>['FACULTY']]);
            }
        }

    }catch(Exception $e){
        die('Error Caught '.$e->getMessage());
    }
?>





