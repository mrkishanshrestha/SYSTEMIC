<?php 

require_once '../SYSTEM/IMPORT/BACKEND/kali.php';

$SiteName = explode('.',$_SERVER['HTTP_HOST']);

    if(isset($_POST['USERNAME']) && isset($_POST['PASSWORD'])){

        $datax = ['USERNAME'=>$_POST['USERNAME'],'PASSWORD'=>$_POST['PASSWORD']];
        $response;
        
        if($kali->login($datax)){
            $response = [ "ERROR"=> false,'MSG'=>'http://'.$SiteName[0].'.systemic.com/DASHBOARD/' ];
        }else{
            $response = [ "ERROR"=> true,'MSG'=>'INVALID CREDITIANLS' ];
        }
        
        $myJSON = json_encode($response);
        echo $myJSON;
        die;
    }

?>