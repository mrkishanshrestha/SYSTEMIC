<?php 

    include_once 'SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->isLoggedIn('https://www.systemic.com/DASHBOARD');

    if(isset($_POST['USERNAME']) && isset($_POST['PASSWORD'])){

        $datax = ['USERNAME'=>$_POST['USERNAME'],'PASSWORD'=>$_POST['PASSWORD']];
        $response;
        $aData = $kali->androidLogin($datax);
        
        if(is_array($aData)){

            if($aData['STATUS']=='TRUE' && $aData['2FA']!='FALSE'){
                $aData['ERROR']= "false";
                $aData['MSG']= 'https://www.systemic.com/authenticate.php' ;
            }else if($aData['STATUS']=='TRUE' && $aData['2FA']=='FALSE'){
                $aData['ERROR']= "false";
                $aData['MSG']= 'https://www.systemic.com/authenticate.php' ;
            }else{
                $aData = [ "ERROR"=> true,'MSG'=>'INVALID CREDITIANLS' ];
            }

        }else{
            $aData = [ "ERROR"=> true,'MSG'=>'SOMETHING IS WRONG !!' ];
        }

        $myJSON = json_encode($aData);
        echo $myJSON;
        die;
    }

?>