<?php
/*
$hello = array(
    "Users"=>array(
        array("name"=>"Kishan"),
        array("name"=>"Ekin"),
        array("name"=>"Aayush")
    )
);
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if($_POST["username"]=="kishan"){
        $hello = array("name"=>'KisHan ShrEstha',"status_code"=>200,"error"=>"false");
        echo json_encode($hello);
    }else{
        $hello = array("name"=>'HOLA',"status_code"=>200,"error"=>"false");
        echo json_encode($hello);
    }
}else{
    $hello = array("name"=>'HOLA AMIGO',"status_code"=>200,"error"=>"false");
    echo json_encode($hello);
}


?>