<?php 

    include_once '../SYSTEM/IMPORT/BACKEND/kali.php';

    if(isset($_POST['USERNAME']) && isset($_POST['PASSWORD'])){

        $datax = ['USERNAME'=>$_POST['USERNAME'],'PASSWORD'=>$_POST['PASSWORD']];
        $response;
        
        if($kali->clientLogin($datax)){
            $response = [ "ERROR"=> false,'MSG'=>'http://client.systemic.com/DASHBOARD/' ];
        }else{
            $response = [ "ERROR"=> true,'MSG'=>'INVALID CREDITIANLS' ];
        }
        
        $myJSON = json_encode($response);
        echo $myJSON;
        die;
    }

?>