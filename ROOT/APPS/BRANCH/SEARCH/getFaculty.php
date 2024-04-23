<?php 

include_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
$APPLICATION="BRANCH";
$kali->checkAccess($APPLICATION,'VIEW');

try{

    if(isset($_POST['SEARCH_DATA'])){

        $fACULTY = [];
        $sql = 'SELECT `faculty_id_x` FROM `college` WHERE `id`=:id';
        $data = $kali->kaliPull($sql,['id'=>$_POST['SEARCH_DATA']]);
        if($data){

            $faculty_id_x = explode(',',$data['faculty_id_x']);
            $FACULTY_ARRAY=[];
            foreach($faculty_id_x as $faculty_id){
                $SQL2 = 'SELECT `short_name` FROM `faculty` WHERE `id`=:id';
                $BIND2 = ['id'=>$faculty_id ];
                $result2 = $kali->kaliPull($SQL2,$BIND2);
                array_push($FACULTY_ARRAY,$result2['short_name']);
            }
            
            $kali->kaliReply($FACULTY_ARRAY);
        }
    }

}catch(Exception $e){
    die('Error Caught '.$e->getMessage());
}   
