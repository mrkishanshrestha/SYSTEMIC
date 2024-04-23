<?php 

    include_once 'SYSTEM/IMPORT/BACKEND/kali.php';

    $GLOBALS['kali'] = &$kali;

    try {
            $rData=[];
            $rData["ERROR"] = "FALSE";

            if(isset($_POST["UCASE"])){

                switch($_POST["UCASE"]){

                    case 'USER_DATA':
                            $USER_REFID = "";
                            if(!isset($_POST["USER_REFID"])){
                                $rData=['ERROR'=>'TRUE','MSG'=>"USER_REFID NOT SENT IN BACKEND."];
                            }else{
                                $USER_REFID = $_POST["USER_REFID"]; 
                                $rData=$kali->getUserInfo("ALL",$USER_REFID);
                            }
                            break;

            
                    case 'STUDENT_DATA':
                        $rData = userData($_POST["S_CASE"]);
                        break;

                    case 'USER_SEARCH':
                            $rData = userSearch($_POST);
                            break;

                    default:
                            $rData=['ERROR'=>'TRUE','MSG'=>'DATA SEND ERROR IN SERVER.'];
                            break;
                }
                
            }else{       
                $rData = ['ERROR'=>'TRUE','MSG'=>'INVALID UCASE SENT IN ANDROID API'];
            }

            $kali->kaliReply($rData);


    } catch (Exception $e) {
        $rData["ERROR"] = true;
        $rData["MSG"] = "An error occurred: " . $e->getMessage();
        $kali->kaliReply($rData);
    }


    function userSearch($aData){
        $SQL='SELECT *,(SELECT `name` FROM `authority` WHERE `id`=user.authority_refid) as authority FROM `user` WHERE ( `first_name` LIKE :name || `last_name` LIKE :name || `contact_number` LIKE :name ) and `authority_refid`!="king2121" ';
        $rData = $GLOBALS['kali']->kaliPulls($SQL,['name'=>'%'.$aData['SEARCH_DATA'].'%']);
        if(!$rData){
            $rData = ['ERROR'=>'TRUE','MSG'=>'NO USER FOUND'];
        }
        return $rData;
    }

    function getTotalDue(){

        
    }

    function userData($scase){

        switch($_POST["UCASE"]){

            case 'TOTAL_DUE':
                    $USER_REFID = "";
                    if(!isset($_POST["USER_REFID"])){
                        $rData=['ERROR'=>'TRUE','MSG'=>"USER_REFID NOT SENT IN BACKEND."];
                    }else{
                        $USER_REFID = $_POST["USER_REFID"]; 
                        return getBalance($USER_REFID);
                    }
                    break;

            default:
            break;

        }

    }


?>