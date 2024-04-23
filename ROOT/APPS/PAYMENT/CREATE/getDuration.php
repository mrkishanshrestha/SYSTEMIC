
<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="PAYMENT";
$kali->checkAccess($APPLICATION,'VIEW');

    try{

        if(isset($_POST['SELECT_OPTION'])){
            $sql = 'SELECT `periods`,`based_on` FROM `faculty` WHERE `id`=:id';
            $data = $kali->kaliPull($sql,['id'=>$_POST['FACULTY']]);
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





