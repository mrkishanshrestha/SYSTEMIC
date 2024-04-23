<?php 

require_once 'DB/connectar.php';
require_once 'DB/firewall.php';

class kali extends firewall{

    public $domain;
    private $site;
    private $companyName;


    function __construct($firewall){
        session_start();
        $this->setup();
        parent::__construct($firewall);
        $this->sanitize();
        /*print_r($_SESSION);
        if($_SESSION['SITE']=='client'){
            $_SESSION['hello']="world";
        }
        die;*/
    }

    function setup(){
        $this->companyName = "SYSTEMIC";
        $this->domain = 'https://kishan.vantageloaf.work';
        $this->site = explode('.',$_SERVER['SERVER_NAME'])[0];
        $_SESSION['SITE'] = $this->site;
        /*header('Access-Control-Allow-Origin: *');*/
    }
/*
    function oldlogin($datax){

        try{

            $SQL = 'SELECT `id`, `username`, `name`, `contact_number`, `phone_number`, `address`, `email`,`post`, `document_id`, `status`, `description`, `edate` FROM `user` WHERE
            `username`= :username';    
            $result = $this->kaliPull($SQL,['username'=>$datax['USERNAME']]);

            if($result!=NULL){

                if(!$this->checkLogin($result['post'])){return false;}
                
                $SQL = 'SELECT `id`, `user_id`, `password` FROM `user_security` WHERE `user_id`= :user_id';
                $result2 = $this->kaliPull($SQL,['user_id'=>$result['id']]);
                if($result2!="" && ($datax['PASSWORD']==$result2['password'])){
                    $_SESSION['LOGGED_IN']='XA';
                    $_SESSION['KOHOMAH']=$result2['user_id'];
                    $_SESSION['USERKONAM']=$result['username'];
                    $_SESSION['WELCOME_SOUND_PLAYED']=false;
                    return true;
                }
                return false;
            }

            return false;

        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }
    }
*/
    function getCode($URL,$SELF_DOMAIN=false){
        try{
            if($SELF_DOMAIN){
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                ); 
                $URL = $this->domain.'/'.$URL;
                $content = file_get_contents($URL, false, stream_context_create($arrContextOptions));
            }else{
                $content = file_get_contents($URL);
            }
            echo $content;
            return true;
        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }
    }

    function uploadFIle($data){
        try{
            
            $MY_FILE=[];

            if(is_array($data['FILE']['name'])){

                $MY_RETURN=[];
    
                for($i=0;$i<count($data['FILE']['name']);$i++){
                    $MY_FILE['NAME'] = $data['FILE']['name'][$i];
                    $MY_FILE['SIZE'] = $data['FILE']['size'][$i];
                    $MY_FILE['TMP_NAME'] = $data['FILE']['tmp_name'][$i];
                    $MY_FILE['TYPE'] = $data['FILE']['type'][$i];
                    $MY_FILE['EXTENSION']=pathinfo($MY_FILE['NAME'], PATHINFO_EXTENSION);
                    $MY_FILE['NEW_FILE_NAME'] = mt_rand().'_'.$MY_FILE['NAME'];
                    
                    $result = $this->upload($MY_FILE,$data);
                    if(!$result['ERROR']){
                        array_push($MY_RETURN,$result['FILE_NAME']);
                    }else{
                        return $result;
                    }
                }

                return $MY_RETURN = ['ERROR'=>false,'FILE_NAME'=>implode(',',$MY_RETURN)];
    
            }else{
                $MY_FILE['NAME'] = $data['FILE']['name'];
                $MY_FILE['SIZE'] = $data['FILE']['size'];
                $MY_FILE['TMP_NAME'] = $data['FILE']['tmp_name'];
                $MY_FILE['TYPE'] = $data['FILE']['type'];
                $MY_FILE['EXTENSION']=pathinfo($MY_FILE['NAME'], PATHINFO_EXTENSION);
                $MY_FILE['NEW_FILE_NAME'] = mt_rand().'_'.$MY_FILE['NAME'];
    
                return $this->upload($MY_FILE,$data);
            }

        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }
    }

    function upload($MY_FILE,$data){
        try{
            
        if(!isset($data['TYPE'])){
           return $STATUS=['ERROR'=>true,'MSG'=>"File Type Not Defined In B-END"];
        }

        $STATUS = ['ERROR'=>false];

        $uploads_dir = $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/ROOT/DATA/USER_DATA/';

        $extensions_allowed= array("jpeg","jpg",'png');
        
        if($data['TYPE']=='IMAGE'){
            $extensions_allowed= array("jpeg","jpg",'png');
        }elseif ($data['TYPE'] == "PDF") {
            $extensions_allowed= array('pdf');
        }

        if(!in_array($MY_FILE['EXTENSION'],$extensions_allowed)){
            $STATUS=['ERROR'=>true,'MSG'=>"extension not allowed, please choose a JPEG or PNG file."];
        }

        if ($MY_FILE['SIZE'] > 100000000000) { 
            $STATUS=['ERROR'=>true,'MSG'=>"File too large!"];
        }

        if($data['DIR']=='SYSTEM'){
            $uploads_dir = 'D:/CODE/DEPLOY/SYSTEMIC/ROOT/DATA/USER_DATA/';
            $uploads_dir.=(isset($data['FOLDER']))?$data['FOLDER']:$_SESSION['USERKONAM'];
        }else{
            $uploads_dir = 'D:/CODE/DEPLOY/SYSTEMIC/'.strtoupper($data['DIR']);
            if(isset($data['FOLDER'])){ $uploads_dir.='/'.$data['FOLDER']; };
        }

        if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777,true);
        } 

        $uploads_dir.='/'.$MY_FILE['NEW_FILE_NAME'];
        
        if(empty($STATUS['ERROR']) && $MY_FILE['EXTENSION'] == "pdf" ) {
            if(move_uploaded_file($MY_FILE['TMP_NAME'],$uploads_dir)){
                $STATUS['FILE_NAME']= $MY_FILE['NEW_FILE_NAME'];
                return $STATUS;
            }else{
                $STATUS=['ERROR'=>true,'MSG'=>"Something Went Wrong Try Again."];
            }
        }
        
        if(empty($STATUS['ERROR'])) {
            $this->compressImage($MY_FILE['TMP_NAME'],$uploads_dir,70);
            /*move_uploaded_file($file_tmp,$uploads_dir);*/
            $STATUS['FILE_NAME']= $MY_FILE['NEW_FILE_NAME'];
            return $STATUS;
        }

        return $STATUS;

        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }

    }

    function compressImage($source, $destination, $quality) {

        $info = getimagesize($source);
    
        if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);
    
        elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);
    
        elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);
        
        imagejpeg($image, $destination, $quality);
    }

    function sysInfo($INFO){

        switch($INFO){

            case 'COMPANY_NAME':
                return 'SYSTEMIC';
                break;

            case 'COMPANY_LOGO':
                return $this->domain.'/SYSTEM/IMPORT/SITE_DATA/LOGO/logo.png';
                break;
                
                
            case 'SITE_BACKGROUND':
                $SiteName = explode('.',$_SERVER['HTTP_HOST']);
                $data = $this->kaliPull('SELECT `college_background_image` FROM `college` WHERE `domain_cname`=:domain_cname',['domain_cname'=>$SiteName[0]]);
                return $dir = $this->domain.'/CLIENTS/COLLEGES/'.strtoupper($SiteName[0]).'/IMG/'.$data['college_background_image'];
                break;


            case 'COMPANY_DOMAIN':
                return 'https://kishan.vantageloaf.work';
                break;

            default:
                return false;
                break;
        }
        

    }

    function kaliReply($datax){
        $myJSON = json_encode($datax);
        echo $myJSON;
        die;
    }
   
    function makeId($limit=16){
        /*return (time().mt_rand(20,1000))*2;*/
        $values = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
        $count = strlen($values);
        $count--;
        $key=NULL;
            for($x=1;$x<=$limit;$x++){
                $rand_var = rand(0,$count);
                $key .= substr($values,$rand_var,1);
            }
        return strtolower($key);
    }

    function link($DATA,$FILE_TYPE = null){

        try{
            if(isset($FILE_TYPE)){
                if($FILE_TYPE == 'JS'){
                    echo '<script src="'.$this->domain.'/'.$DATA.'"></script> ';
                    return true;
                }else if($FILE_TYPE == 'CSS'){
                    echo '<link rel="stylesheet" href="'.$this->domain.'/'.$DATA.'">';
                    return true;
                }
            }

            switch($DATA){

                case 'KALI_FORM':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/KALI_FORM/design.css">';
                    break;

                case 'KALI_HEADER':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/KALI_HEADER/design.css">';
                    break;

                case 'CIRCLE_BAR':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/CIRCLE_BAR/design.css">
                            <script src="'.$this->domain.'/ROOT/CORE/CIRCLE_BAR/script.js"></script>';
                    break;

                case 'SPEED_BAR':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/SPEED_BAR/design.css">
                            <script src="'.$this->domain.'/ROOT/CORE/SPEED_BAR/script.js"></script>';
                    break;

                case 'BAR_GRAPH':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/BAR_GRAPH/design.css">
                            <script src="'.$this->domain.'/ROOT/CORE/BAR_GRAPH/script.js"></script>';
                    break;

                case 'GLOBAL_SCRIPT':
                    echo '<script src="'.$this->domain.'/SYSTEM/IMPORT/FRONTEND/global_script.js"></script> ';
                    break;

                case 'GLOBAL_DESIGN':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/SYSTEM/IMPORT/FRONTEND/global_design.css">';
                    break;

                case 'FONT_AWESOME':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/SYSTEM/IMPORT/FONT_AWESOME/css/all.css">';
                    break;

                case 'JQUERY':
                    echo '<script src="'.$this->domain.'/SYSTEM/IMPORT/JQUERY/jquery.min.js"></script>
                    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
                    <link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">';
                    break;
                    
                case 'ICONIC_CARD':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/ICONIC_CARD/design.css">';
                    break;

                                        
                case 'KALI_TABLE':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/KALI_TABLE/design.css">';
                    break;

                                                            
                case 'QR':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/QR/design.css">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
                    <link rel="stylesheet" href="'.$this->domain.'/ROOT/CORE/QR/script.css">';
                    break;
                 
                 
                                        
                case 'BOOTSTRAP':
                    echo '<link rel="stylesheet" href="'.$this->domain.'/SYSTEM/IMPORT/BOOTSTRAP/bootstrap.min.css">
                          <script src="'.$this->domain.'/SYSTEM/IMPORT/BOOTSTRAP/bootstrap.min.js"></script>';
                    break;
                    
                        
                case 'ASSETS':
                    echo '<link rel="stylesheet" href="ASSETS/CSS/design.css">
                        <script src="ASSETS/JS/script.js"></script>';
                    break;
                    
                default:
                    echo 'linkind file error';
                    break;
            }

        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }

    }

    function makeSideBar($dataX){

    /*$this->link('FONT_AWESOME');*/
    $this->link('ROOT/CORE/NAVBAR/SIDENAV/script.js','JS');
    $this->link('ROOT/CORE/NAVBAR/SIDENAV/design.css','CSS');

      echo "
        <nav class='sidebar close'>
            <header>
                <div class='image-text'>
                    <a href='king.php'>
                    <span class='image'>
                        <img src='".$this->sysInfo('COMPANY_LOGO')."'  alt=''>
                    </span>
                    </a>
                    <div class='text logo-text'>
                        <span class='name'>".strtoupper($this->getSite())."</span>
                        <span class='profession'>Make Better System</span>
                    </div>
                </div>

                <i class='fa-solid fa-chevron-right toggle'></i>
            </header>

            <div class='menu-bar'>
                <div class='menu'>

                    <ul class='menu-links'>
                    ";

                foreach($dataX as $data){
                    
                    /* application_name,user_is==default(kohoma) */
                    if(!$this->checkPrivilege($data['APP_NAME'],'DASH')){
                        continue;
                    }
                    /*if( isset($data['RIGHTS']) && !in_array($_SESSION['MY_AUTHORITY'],$data['RIGHTS']) ){
                        continue;
                    }*/
                    if( $data!=null && $data['PLACE']=='BODY'){
                        echo "
                        <li class='nav-link' onclick='changeDash(\"".$data['LINK']."\");'>
                            <a>
                                <i class='bx ".$data['ICON']." icon' ></i>
                                <span class='text nav-text'>".$data['TITLE']."</span>
                            </a>
                        </li>";
                    }
                }
                echo"
                    </ul>
                </div>



                <div class='bottom-content'> ";

                    foreach($dataX as $data){

                        /*
                        if( isset($data['RIGHTS']) && (!in_array($_SESSION['MY_AUTHORITY'],$data['RIGHTS'])) ){
                            continue;
                        }
                        */
                        if( $data!=null &&  $data['PLACE']=='FOOT'){

                            if( ($data['APP_NAME']=="PROFILE" ) || $data['APP_NAME']=="LOGOUT" ){
                            }else{
                                if(!$this->checkPrivilege($data['APP_NAME'],'DASH')){
                                    continue;
                                }
                            }

                            if($data['APP_NAME']=="LOGOUT"){
                                $click ="";
                                $href = "href=".$data['LINK']." ";
                            }else{
                                $click = "onclick='changeDash(\"".$data['LINK']."\");'";
                                $href ="";
                            }
                            echo"
                                <li class='nav-link' ".$click.">
                                    <a ".$href." >
                                    <i class=' ".$data['ICON']." icon'></i>
                                        <span class='text nav-text'>".$data['TITLE']."</span>
                                    </a>
                                </li>";
                        }
                    }
                    
                    echo"
                </div>



            </div>
        </nav>";
    }

    function checkPrivilege($appName , $rights, $userid = null){
        if($userid==null){$userid=$_SESSION['KOHOMAH'];}

        if($_SESSION['MY_AUTHORITY']=='KING'){
            return true;
        }

        $sql = 'SELECT  `id` FROM `application_manifest` WHERE `name`=:name';
        $app_data = $this->kaliPull($sql,['name'=>$appName]);
        if(!$app_data){
            return false;
            $this->kaliReply(['ERROR'=>true,'MSG'=>'Invalid Application Name','TARGET'=>[]]);
        }

        $sql = 'SELECT privilege.rights_x FROM `privilege` privilege
        INNER JOIN `user` user
        WHERE 
        user.id = :userid && user.authority_refid = privilege.authority_refid &&
        privilege.application_refid = (SELECT `id` FROM `application_manifest` WHERE `name`=:appname)';
        $privilege_data = $this->kaliPull($sql,['userid'=>$userid,'appname'=>$appName]);
        if($privilege_data){
            $app_rights = explode(',',$privilege_data['rights_x']);
            if(in_array($rights,$app_rights)){
                return true;
            }
            return false;
        }else{
            return false;
        }


    }



    function insert($data){

        $SiteName = explode('.',$_SERVER["HTTP_HOST"]);
        $logoutCode = $this->domain."/logout.php";
        if($SiteName[0]="systemic"){
            $logoutCode = $this->domain."/logout.php";
        }

        switch($data){

            case 'KALI_HEADER':
                
                echo'<div class="header-wrapper">

                            <div class="kali_navbar">

                            <div class="kali_navbar_left">
                                <div class="logo">
                                <a href="#"></a>
                                </div>
                            </div>

                            <div class="kali_navbar_center">
                                <div>
                                 <a class="site-title" href="king.php">'.strtoupper($this->getUserInfo('COLLEGE_NAME')).'</a>
                                </div>
                            </div>


                            <div class="kali_navbar_right">

                            <div>
                                <i class="fa-solid fa-arrow-left iconic-card-icon" onclick="history.go(-1);"></i>
                                <i class="fa-solid fa-arrow-rotate-right iconic-card-icon" onclick="document.getElementById(\'dash-frame\').contentWindow.location.reload();"></i>
                             </div>

                                <div class="notifications">
                                    
                                <div class="kali_navbar_icon">
                                        <i class="far fa-bell"></i>
                                </div>
                                
                                <div class="notification_conatiner">

                                        <div class="notification-card">
                                            <div class="notification_icon">
                                                <i class="far fa-bell"></i>
                                            </div>
                                            <div class="notify_data">
                                                <div class="title"> 
                                                    Friend Request
                                                </div>
                                                <div class="sub_title">
                                                    Aayush Manadhar Has Sent You a Friend Request
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="notification-card">
                                            <div class="notification_icon">
                                                <i class="far fa-bell"></i>
                                            </div>
                                            <div class="notify_data">
                                                <div class="title"> 
                                                    Friend Request
                                                </div>
                                                <div class="sub_title">
                                                    Aayush Manadhar Accepted Your Friend Request
                                                </div>
                                            </div>
                                        </div> 


                                        <div class="notification-card">
                                            <div class="notification_icon">
                                                <i class="far fa-bell"></i>
                                            </div>
                                            <div class="notify_data">
                                                <div class="title"> 
                                                    Friend Request
                                                </div>
                                                <div class="sub_title">
                                                    Aayush Manadhar Accepted Your Friend Request
                                                </div>
                                            </div>
                                        </div> 


                                        <div class="show_all">
                                            <p class="link">Show All Activities</p>
                                        </div> 

                                </div>
                                
                                </div>


                                <div class="profile">
                                <div class="kali_navbar_icon">
                                    <img src="'.$this->getUserInfo('PROFILE_PICTURE').'" alt="profile_pic">
                                    <span class="name">'.$_SESSION['USERKONAM'].'</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>

                                <div class="profile_dd">
                                    <ul class="profile_ul">
                                    <li class="profile_li"><a class="profile" href="#"><span class="picon"><i class="fas fa-user-alt"></i>
                                        </span>Profile</a>
                                    </li>
                                    <li>
                                        <div class="btn">My Account</div>
                                    </li>
                                    <li><a class="settings" href="#"><span class="picon"><i class="fas fa-cog"></i></span>Settings</a></li>
                                    <li><a class="logout" href="'.$logoutCode.'"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
                                    </ul>
                                </div>
                                </div>

                            </div>
                            </div>

                            <div class="popup">
                            <div class="shadow"></div>
                            <div class="inner_popup">
                                <div class="notification_conatiner">

                                    <p>All Notifications</p>
                                    <p class="close"><i class="fas fa-times" aria-hidden="true"></i></p>
                                    
                                </div>
                            </div>
                            </div>
                    </div>';
            break;

            default:
                die('invlaid');
                break;
        }

    }

    function dataCheck($data){

        if(!isset($data['CASE'])){
            $this->kaliReply(['ERROR'=>true,'MSG'=>'Case Is Not Set In dataCheck Function']);
        }

        if(!isset($data['DATA'])){
            $this->kaliReply(['ERROR'=>true,'MSG'=>'Data Is Not Set In dataCheck Function']);
        }

        if(!isset($_POST[$data['DATA']])){ 
            $this->kaliReply(['ERROR'=>true,'MSG'=>$data['DATA'].' Data Not Sent ! Data Required ! Empty Not Allowed !','TARGET'=>[$data['DATA']]]);
        }
        
        array_key_exists($data['DATA'], $_POST) ? $_POST[$data['DATA']] : null;
        $postData = $_POST[$data['DATA']];

        if($postData=="" && !isset($data['NOTREQUIRED'])){
            $this->kaliReply(['ERROR'=>true,'MSG'=>'Value Required ! Empty Not Allowed !','TARGET'=>[$data['DATA']]]);
        }

        if(isset($data['CHARACTER'])){

            switch($data['CHARACTER']){

                case 'LOWER':
                    $postData=strtolower($postData);
                break;
                
                case 'UPPER':
                    $postData=strtoupper($postData);
                break;

                case 'CAMEL':
                    $postData=ucwords(strtolower($postData));
                break;

                default:
                    $this->kaliReply(['ERROR'=>true,'MSG'=>'invalid Character Type','TARGET'=>[$data['DATA']]]);
                break;
            }

        }

        switch($data['CASE']){

            case 'NUMBER':
                if(!is_numeric($postData)){
                    $this->kaliReply(['ERROR'=>true,'MSG'=>'This Data Must Be An Number','TARGET'=>[$data['DATA']]]);
                }
            break;
            
            case 'STRING':
                if(!is_string($postData)){
                    $this->kaliReply(['ERROR'=>true,'MSG'=>'This Data Must Be An String','TARGET'=>[$data['DATA']]]);
                }
            break;
                        
            case 'ARRAY':
                if(gettype($postData)!="array"){
                    $this->kaliReply(['ERROR'=>true,'MSG'=>'This Data Must Be An Array','TARGET'=>[$data['DATA']]]);
                }
            break;

            default:
                die("Invlaid Case Sent In data Check");
        }


        return $postData;
    }

    function getSite(){
         return $this->companyName;
        }

    
    function getAuthority($data){
        
        $sql = 'SELECT  `name` FROM `authority` WHERE `id`=:id';
        $result = $this->kaliPull($sql,['id'=>$data]);
        if($data){
                return $result;
        }else{
            die('ERROR IN GETTING AUTHOITIES getAuthority()');
        }

        return $AUTHORITY;

          


    }
    




    }

$fire=true;
if(isset($firewall)){$fire = ($firewall)?true:false;}
$kali = new kali($fire);
?>