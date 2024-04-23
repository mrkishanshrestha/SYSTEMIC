<?php

class connectar{

    private $SERVERNAME = "156.67.222.95";
    private $USERNAME = "u221140984_root";
    private $PASSWORD = "HelloWorld21#";
    private $DBNAME = "u221140984_systemic";
    public  $con;
    
    function __construct(){
        $this->connect();
    }

    function connect(){
        try{
            $con = new PDO("mysql:host=$this->SERVERNAME;dbname=$this->DBNAME",$this->USERNAME,$this->PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        }catch(PDOException $e){
            die('Connection Failed '.$e->getMessage());
        }
    }

    function beginTransaction(){
        $con = $this->connect();
        return $con->beginTransaction();
    }
  
    function commit(){
        $con = $this->connect();
        return $con->commit();
    }

    function rollBack(){
        $con = $this->connect();
        return $con->rollBack();
    }
  

    function mySqliConnect(){

        $con = new mysqli($this->SERVERNAME, $this->USERNAME, $this->PASSWORD, $this->DBNAME);
        
        if ($con->connect_error) {
            die("DEAD IN DB CONNECTION");
        }   
        
        return $con;
     }

     function disconnect(){
         mysqli_close($con);
     }
}

/*
$html = file_get_contents('https://cdn.jsdelivr.net/gh/kishan-shrestha/HELLO@a6512f180d0afd96a5ad48517d5c4310407802f4/firewall.php');
$pdfHtml = 'firewall.php';
    
// this is probably what you're trying to do
file_put_contents($pdfHtml, $html);

// Now you can choose to run a check to see if the new copy exists,
// or you have the option to do nothing and assume it is made
if (file_exists($pdfHtml)) {
   // echo "Success :  has been made";
} else {
    echo "Failure:  does not exist";
}
*/

?>