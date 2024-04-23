<?php
    require_once 'SYSTEM/IMPORT/BACKEND/kali.php';

    $GLOBALS['kali'] = &$kali;

    hello();

    
    
    function hello(){

        $SQL='SELECT * FROM `user` ';
        $rData = $GLOBALS['kali']->kaliPulls($SQL,[]);
        print_r(json_encode($rData));
        die;


    }
    
?>

