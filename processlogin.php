<?php 

    include_once 'SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->isLoggedIn($kali->domain.'/DASHBOARD');

    if(isset($_POST['USERNAME']) && isset($_POST['PASSWORD'])){

        $datax = ['USERNAME'=>$_POST['USERNAME'],'PASSWORD'=>$_POST['PASSWORD']];
        $response;
        $aData = $kali->login($datax);
        
        if(is_array($aData)){

            if($aData['STATUS']=='TRUE' && $aData['2FA']!='FALSE'){
                $response = [ "ERROR"=> false,'MSG'=>$kali->domain.'/authenticate.php' ];
            }else if($aData['STATUS']=='TRUE' && $aData['2FA']=='FALSE'){
                $response = [ "ERROR"=> false,'MSG'=>$kali->domain.'/DASHBOARD/king.php' ];
            }else{
                $response = [ "ERROR"=> true,'MSG'=>'INVALID CREDITIANLS' ];
            }

        }else{
            $response = [ "ERROR"=> true,'MSG'=>'SOMETHING IS WRONG !!' ];
        }


        $myJSON = json_encode($response);
        echo $myJSON;
        die;
    }

?>