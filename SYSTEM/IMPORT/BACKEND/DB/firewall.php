<?php 

require_once 'helper.php';

class firewall extends helper{
    
    function __construct($firewall_state) {
        $this->uriCheck();
    }
    
    // This Login Function is used for sub domain client website for logging in*
   /* 
   function login($datax){
        try{

            $domainc = explode('.',$_SERVER['HTTP_HOST']);
            $domainc =$domainc[0];

            $SQL = 'SELECT client.id, client.username, client.first_name FROM `client`
             INNER JOIN `user_security` as us ON us.user_id = client.id
             INNER JOIN `college` as colle ON colle.user_id = client.id && colle.domain_cname=:domain_cname
             WHERE us.password = :password && client.username=:username';    
            $result = $this->kaliPull($SQL,
            ['password'=>$datax['PASSWORD'],'username'=>$datax['USERNAME'],'domain_cname'=>$domainc]);

            if($result==NULL){

                $SQL = 'SELECT user.id, user.post, user.username FROM `user`
                        INNER JOIN `user_security` as us ON us.user_id = user.id
                        WHERE us.password = :password && user.username=:username && user.access_to=:access_to';
                $result = $this->kaliPull($SQL,
                ['password'=>$datax['PASSWORD'],'username'=>$datax['USERNAME'],'access_to'=>$domainc]);
                if($result){
                    $_SESSION['MY_POST']=strtoupper($result['post']);
                }else{

                    $SQL2 = 'SELECT student.id, student.username, student.email FROM `student`
                    INNER JOIN `user_security` as us ON us.user_id = student.id
                    WHERE us.password = :password AND (student.username=:username || student.email=:username) AND student.access_to=:access_to';
                    $result = $this->kaliPull($SQL2,
                    ['password'=>$datax['PASSWORD'],'username'=>$datax['USERNAME'],'access_to'=>$domainc]);
                    if($result){
                        $_SESSION['MY_POST']='STUDENT';
                    }else {
                        return false;
                    }

                }
            }else{
                $_SESSION['MY_POST']='CLIENT';
            }

            $_SESSION['LOGGED_IN']='XA';
            $_SESSION['KOHOMAH']=$result['id'];
            $_SESSION['USERKONAM']=$result['username'];
            $_SESSION['WELCOME_SOUND_PLAYED']=false;
            return true;
            
        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }
    }
   
    // this login function is used to login in systemic.com only for client and kingdescdescription
    function systemicLogin($datax){
      try{
            if(($datax['USERNAME']=='KING') && ($datax['PASSWORD']=='hello2121') ){
                $_SESSION['LOGGED_IN']='XA';
                $_SESSION['USERKONAM']='KING';
                $_SESSION['KOHOMAH']='KING';
                $_SESSION['MY_POST']='KING';
                $_SESSION['WELCOME_SOUND_PLAYED']=false;
                return true;
            }
            else{
                $SQL = 'SELECT `id`, `username`, `first_name`, `contact_number`, `phone_number`, `address`, `email`, `document_id`, `profile_picture_id`, `description`, `edate` FROM `client` WHERE
                `username`= :username';    
                $result = $this->kaliPull($SQL,['username'=>$datax['USERNAME']]);

                if($result!=NULL){
                    $SQL = 'SELECT `id`, `user_id`, `password` FROM `user_security` WHERE
                    `user_id`= :user_id';    
                    $result2 = $this->kaliPull($SQL,['user_id'=>$result['id']]);

                    if(($datax['PASSWORD']==$result2['password'])){
                        $_SESSION['LOGGED_IN']='XA';
                        $_SESSION['KOHOMAH']=$result['id'];
                        $_SESSION['USERKONAM']=$result['username'];
                        $_SESSION['MY_POST']='CLIENT';
                        $_SESSION['WELCOME_SOUND_PLAYED']=false;
                        return true;
                    }
                }
                return false;
            }
            
            return false;

        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }
    }

    */


    // systemic 2.0

    function login($datax){

        $username = $datax['USERNAME'];
        $password = $datax['PASSWORD'];
        $rData = ['STATUS'=>'FALSE','2FA'=>'FALSE'];
       
        $SelectSQL = 'SELECT `id`,`username`,`authority_refid`, (SELECT `name` FROM `authority` WHERE `id`=user.authority_refid ) as authority_name FROM `user` user WHERE ( `username`=:username OR `email`=:email )';
        $result = $this->kaliPull($SelectSQL, ['username'=>$username,'email'=>$username]);
        if($result){
            $SelectSQL = 'SELECT `id`,`password`,`2FA` FROM `user_security` WHERE `user_refid`=:user_refid';
            $result2 = $this->kaliPull($SelectSQL,['user_refid'=>$result['id']]);
            if($result2){
                if($this->verifyPassword($password,$result2['password'])){
                    
                    $rData['STATUS']="TRUE";
                    $_SESSION['KOHOMAH']=$result['id'];
                    $_SESSION['WELCOME_SOUND_PLAYED']=false;
                    $_SESSION['USERKONAM']=$result['username'];
                    $_SESSION['MY_AUTHORITY'] = $result['authority_name'];
                    setcookie ("USERNAME","");
                    setcookie ("PASSWORD","");
                    setcookie ("USERNAME",$username,time()+ 3600);
                    setcookie ("PASSWORD",$password,time()+ 3600);

                    if($result2['2FA']=="EMAIL"){
                        $rData['2FA']="EMAIL";
                        $_SESSION['2FA']='EMAIL';
                    }else if($result2['2FA']=="APP"){
                        $rData['2FA']="APP";
                        $_SESSION['2FA']='APP';
                    }else{
                        $_SESSION['LOGGED_IN']='XA';
                        setcookie ("LOGGED_IN","XA",time()+ 3600);
                        $rData = [ "ERROR"=> false,'MSG'=>'https://www.systemic.com/DASHBOARD' ];
                        $this->kaliReply($rData);
                    }

                }else{
                    $this->kaliReply(["ERROR"=> true,'MSG'=>'INVALID CREDENTIALS' ]);
                }
            }else{
                $this->kaliReply(["ERROR"=> true,'MSG'=>'INVALID CREDENTIALS' ]);
            }
        }else{
            $this->kaliReply(["ERROR"=> true,'MSG'=>'INVALID CREDENTIALS' ]);
        }
        return $rData;
    }

    function sendOTPCode($user_refid,$method,$otp_case){

        $opt_code = $this->makeId();
        $siteName = $this->getSite();
        $rdata=[];

        $SQL = 'SELECT `id`,`first_name`,`email` FROM `user` WHERE (`id`=:id || `email`=:id)';
        $result = $this->kaliPull($SQL, ['id'=>$user_refid]);
        if($result){

            $SQL = 'SELECT `id`,`otp_code` FROM `otp` WHERE `otp_owner_id`=:otp_owner_id && `otp_case`=:otp_case';
            $BIND = ['otp_owner_id'=>$result['id'],'otp_case'=>$otp_case];
            $result22 = $this->kaliPull($SQL,$BIND);
            if($result22){
                if($method == "EMAIL"){
                    /* PATHAI SAKEY PAXI FERI KINA PATHAIRAKH NEY !!
                    if(mail($result['email'],$siteName.' - Two Factor Authentication','Hello '.$result['first_name'].', Your Two-Factor Verification OTP is '.$result22['otp_code'],"From:mr.kishanshrestha@gmail.com")){
                        $rdata=['ERROR'=>false,'MSG'=>'Login OTP Send To Your Mail'];
                      }else{
                        $rdata=['ERROR'=>true,'MSG'=>'Sending Mail Failed'];
                      }
                    */
                }else{
                    $rdata=['ERROR'=>false,'MSG'=>'Login With Your OTP Code.'];
                }
                
                return $rdata;
            }

            $my_expiry_date = date("Y-m-d H:i:s", strtotime("+1 hours"));
            $SQL5 = 'INSERT INTO `otp`(`id`, `otp_code`, `otp_owner_id`,`otp_case`,`expiry_date`) VALUES (:id, :otp_code, :otp_owner_id, :otp_case, :expiry_date ) ';
            $PUSH_DATA5 = [
              'id'=>$this->makeId(),
              'otp_code'=>$opt_code,
              'otp_owner_id'=>$result['id'],
              'otp_case'=>$otp_case,
              'expiry_date'=>$my_expiry_date
            ];
            $this->kaliPush($SQL5,$PUSH_DATA5);

            if($method == "EMAIL"){
                if(mail($result['email'],$siteName.' - Two Factor Authentication','Hello '.$result['first_name'].', Your Two-Factor Verification OTP is '.$opt_code,"From:mr.kishanshrestha@gmail.com")){
                    $rdata=['ERROR'=>false,'MSG'=>'Login OTP Send To Your Mail'];
                }else{
                  $rdata=['ERROR'=>true,'MSG'=>'Sending Mail Failed'];
                }
            }else{
                $rdata=['ERROR'=>false,'MSG'=>'Login With Your OTP Code.'];
            }
            
            return $rdata;
        }else{
            die('Server Error Verification Email OTP');
        }

    }

    function verifyOTPCode($user_refid,$otp_case,$otp_code){

        $USER_REFID = "";
        $SQL = 'SELECT `id`,`first_name`,`email`  FROM `user` WHERE (`id`=:id || `email`=:id)';
        $BIND = ['id'=>$user_refid];
        $result = $this->kaliPull($SQL,$BIND);
        if($result){

        $USER_REFID = $result['id'];

        $SQL = 'SELECT `id`, `otp_code`, `otp_owner_id` FROM `otp` WHERE `otp_owner_id`=:otp_owner_id AND `otp_case`=:otp_case';
        $BIND = ['otp_owner_id'=>$result['id'],'otp_case'=>$otp_case];
        $otp_result = $this->kaliPull($SQL,$BIND);
        if($otp_result){

            if($otp_result['otp_code']==$otp_code){

                $siteName = $this->getSite();

                $SQL4 = 'DELETE FROM `otp` WHERE `id`=:id ';
                $PUSH_DATA4 = [
                'id'=>$otp_result['id'],
                ];

                if($otp_case == "PASSWORD_RESET"){

                    $NEWPASSWORD = $this->makeId();
                    $NEW_HASHED_PASSWORD = $this->hashPassword($NEWPASSWORD);

                    $SQL3 = 'UPDATE `user_security` SET `password`=:password WHERE `user_refid`=:user_refid ';
                    $PUSH_DATA3 = [
                    'user_refid'=>$USER_REFID,
                    'password'=>$NEW_HASHED_PASSWORD,
                    ];

                    $this->kaliPush($SQL3,$PUSH_DATA3);
                    
                    if(mail($result['email'],$siteName.' New Password','Hello, Your New Password is '.$NEWPASSWORD,"From:mr.kishanshrestha@gmail.com")){
                        $rData = ['ERROR'=>false,'MSG'=>'Your New Password Has Been Sent To Your Email'];
                    }else{
                        $rData = ['ERROR'=>true,'MSG'=>'Sending Mail Failed'];
                    }
                }
                else if($otp_case == "LOGIN"){
                    $_SESSION['LOGGED_IN']='XA';
                    setcookie ("LOGGED_IN","XA",time()+ 3600);
                    $rData = [ "ERROR"=> false,'MSG'=>'https://www.systemic.com/DASHBOARD' ];
                }

                
                $this->kaliDel($SQL4,$PUSH_DATA4);
                $this->kaliReply($rData);

            }else{
                $rData = ['ERROR'=>true,'MSG'=>'Invalid OTP Try Again'];
            }
            
        }else{
            $rData = ['ERROR'=>true,'MSG'=>'Invalid OTP Try Again'];
        }


        }else{
            $rData = ['ERROR'=>true,'MSG'=>'Invalid User.'];
        }

        $this->kaliReply($rData);
        die;

    }

    /*function checkPrivilege($datax){

        $application_id = "";
        $authority = "";
        $collge_id = "";

        $selectSQL = 'SELECT `id`, (SELECT `name` FROM `authority` WHERE `id`= user.id) as AUTHORITY FROM `user` as user WHERE `id` = :id';
        $result = $this->kaliPull($SelectSQL, ['id'=>$_SESSION['KOHOMAH']]);
        if($result){
            if($result['AUTHORITY'] == "KING"){
                return true;
            }else{
                return false;
            }
        }


    }
*/
    function checkMyAutho($data){
        if($_SESSION['MY_AUTHORITY']==$data){
            return true;
        }
        return false;
    }




    function isNotLoggedIn($REDIRECT_TO = NULL){
        
        if(!isset($_SESSION['LOGGED_IN']) || ($_SESSION['LOGGED_IN']=='XAINA')){
            if($REDIRECT_TO!=NULL){
                header("Location:".$REDIRECT_TO);
            }
            return true;
        }
        return false;
    }

    function isLoggedIn($REDIRECT_TO = NULL,$home=false){
        
        if(isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN']=='XA')){
            if(isset($REDIRECT_TO)){
                header("Location:".$REDIRECT_TO);
            }
            return true;
        }else{
            if(isset($_COOKIE['USERNAME']) && isset($_COOKIE['PASSWORD'])){
                $this->login(['USERNAME'=>$_COOKIE['USERNAME'],'PASSWORD'=>$_COOKIE['PASSWORD']]);
            }
            if(!$home && $_SERVER['REQUEST_METHOD']!="POST"){
                header("Location:https://www.systemic.com");
            }
        }
    }    

    function logOut(){
        
        $SiteName = explode('.',$_SERVER['HTTP_HOST']);
        session_destroy();
        setcookie ("USERNAME","");
        setcookie ("PASSWORD","");
        setcookie ("LOGGED_IN","");
        $_SESSION = [];
        if($SiteName[0]=='systemic'){
            header("Location: https://www.systemic.com");
        }else{
            header("Location: https://".$SiteName[0].".systemic.com");
        }
    }
      
    function uriCheck(){
      if(strpos($_SERVER["REQUEST_URI"], "process") !== false){
          if($_SERVER['REQUEST_METHOD']!="POST") {
              header('Location: https://www.systemic.com');
          }
      }
    }

    function sanitize(){

        $totalPostCount = count(array_keys($_POST));
        for($i=0;$i<$totalPostCount;$i++){
            if(is_array($_POST[array_keys($_POST)[$i]])){
                continue;
            }
            $postName = array_keys($_POST)[$i];
            $postyData = $_POST[$postName];
            $sanitizedData = trim($_POST[$postName]);
            $sanitizedData = htmlspecialchars($sanitizedData, ENT_QUOTES);
            $sanitizedData = filter_var($sanitizedData, FILTER_SANITIZE_STRING);
            $_POST[$postName] = $sanitizedData;
        }
        return $_POST;
        
    //purano method
      foreach(array_keys($_POST) as $postData){
        $sanitizedData = trim($_POST[$postData]);
        $sanitizedData = htmlspecialchars($sanitizedData, ENT_QUOTES);
        $sanitizedData = filter_var($sanitizedData, FILTER_SANITIZE_STRING);
        $_POST[$postData] = $sanitizedData;
      }
      return $_POST;
    }

    function checkLogin(){

        $domainc = explode('.',$_SERVER['HTTP_HOST']);
        $domainc =$domainc[0];

        $SQL = 'SELECT user.id, user.post, user.username FROM `user`
        INNER JOIN `user_security` as us ON us.user_id = user.id
        WHERE user.username=:username && user.access_to=:access_to';
        $result = $this->kaliPull($SQL,
        ['username'=>$_SESSION['KOHOMAH'],'access_to'=>$domainc]);
        if(!$result){
            $this->logOut();
        }
        
    }


    function checkAccess($app,$rights,$bool=false){
        if(!$this->checkPrivilege($app,$rights) ) {
            if(!$bool){
            echo '<h1 style="color:red;">You Are Not Authorized To Get Here !</h1>';
            die;  
            }else{return false;}  
        }
        return true;
    }

    function whoHasAccess($data){
      if(!in_array($_SESSION['MY_AUTHORITY'],$data)){
          echo '<h1 style="color:red;">CHANGE FUNCTION. You Are Not Authorized To Get Here !</h1>';
          die;

      }
      return true;
    }

    function isUser($data){
        if(!in_array($_SESSION['MY_AUTHORITY'],$data)){
          return false;
      }
      return true;
    }


    function androidLogin($datax){

        $username = $datax['USERNAME'];
        $password = $datax['PASSWORD'];
        $rData = [
            'STATUS'=>"false",
            '2FA'=>'FALSE',
            "FULL_NAME"=>"KING",
            "EMAIL"=>"kishan@gmail.com",
            "USER_REFID"=>"KING",
            "AUTHORITY"=>'KING',
            "PROFILE_PICTURE"=>'KING',
            "MSG"=>"LOGIN SCCUESS",
            "ERROR"=>"false"
    ];
       
        $SelectSQL = 'SELECT `id`,`username`, user.profile_picture_id, user.email, user.first_name, user.middle_name, user.last_name,`authority_refid`, (SELECT `name` FROM `authority` WHERE `id`=user.authority_refid ) as authority_name FROM `user` user WHERE ( `username`=:username OR `email`=:email )';
        $result = $this->kaliPull($SelectSQL, ['username'=>$username,'email'=>$username]);
        if($result){
            $SelectSQL = 'SELECT `id`,`password`,`2FA` FROM `user_security` WHERE `user_refid`=:user_refid';
            $result2 = $this->kaliPull($SelectSQL,['user_refid'=>$result['id']]);
            if($result2){
                if($this->verifyPassword($password,$result2['password'])){
                    
                    $rData['STATUS']="TRUE";
                    $_SESSION['KOHOMAH']=$result['id'];
                    $_SESSION['WELCOME_SOUND_PLAYED']=false;
                    $_SESSION['USERKONAM']=$result['username'];
                    $_SESSION['MY_AUTHORITY'] = $result['authority_name'];
                    setcookie ("USERNAME","");
                    setcookie ("PASSWORD","");
                    setcookie ("USERNAME",$username,time()+ 3600);
                    setcookie ("PASSWORD",$password,time()+ 3600);

                    if($result2['2FA']=="EMAIL"){
                        $rData['2FA']="EMAIL";
                        $_SESSION['2FA']='EMAIL';
                    }else if($result2['2FA']=="APP"){
                        $rData['2FA']="APP";
                        $_SESSION['2FA']='APP';
                    }else{
                        $_SESSION['LOGGED_IN']='XA';
                        setcookie ("LOGGED_IN","XA",time()+ 3600);
                        $rData = [ 
                            "ERROR"=> false,
                            'MSG'=>'https://www.systemic.com/DASHBOARD',
                            '2FA'=>'FALSE',
                            "FULL_NAME"=>$result['first_name'].' '.$result['last_name'],
                            "KOHOMAH"=>$result['id'],
                            "AUTHORITY"=>$result['authority_name'],
                            "EMAIL"=>$result['email'],
                            "PROFILE_PICTURE"=>$result['profile_picture_id'],
                            "MSG"=>"LOGIN SCCUESS",
                        ];

                        $this->kaliReply($rData);
                    }

                }else{
                    $this->kaliReply(["ERROR"=> true,'MSG'=>'INVALID CREDENTIALS' ]);
                }
            }else{
                $this->kaliReply(["ERROR"=> true,'MSG'=>'INVALID CREDENTIALS' ]);
            }
        }else{
            $this->kaliReply(["ERROR"=> true,'MSG'=>'INVALID CREDENTIALS' ]);
        }
        return $rData;
    }



    /*function androidLogin($datax){
        try{

            $rData = [];

            //IF KING HO !!
            if(($datax['USERNAME']=='KING') && ($datax['PASSWORD']=='hello2121') ){
                $rData=[
                    "USERNAME"=>"KING",
                    "ROLE"=>'KING',
                    "STATUS"=>"ACTIVE",
                    "MSG"=>"LOGIN SCCUESS",
                    "ERROR"=>"FALSE"
                ];
            }
            else{
                // IF KING HOENA TARA CLIENT HO 
                $SQL = 'SELECT client.id, client.username, client.first_name, client.first_name FROM `client`
                INNER JOIN `user_security` as us ON us.user_id = client.id
                INNER JOIN `college` as colle ON colle.user_id = client.id
                WHERE us.password = :password && client.username=:username';    
                $result = $this->kaliPull($SQL,['password'=>$datax['PASSWORD'],'username'=>$datax['USERNAME']]);
                if($result==NULL){
                   $SQL = 'SELECT user.id, user.post, user.username, user.first_name, user.access_to FROM `user`
                           INNER JOIN `user_security` as us ON us.user_id = user.id
                           WHERE us.password = :password && user.username=:username';
                   $result = $this->kaliPull($SQL,['password'=>$datax['PASSWORD'],'username'=>$datax['USERNAME']]);
                   if($result){
                       $rData=[
                        'USERNAME'=>$datax['USERNAME'],
                        "FIRST_NAME"=>$result['first_name'],
                        "ROLE"=>strtoupper($result['post']),
                        "STATUS"=>"ACTIVE",
                        "MSG"=>"LOGIN SCCUESS",
                        "ERROR"=>"FALSE"
                    ];

                    }else{ 
                        $rData=["ERROR"=>"TRUE"];
                    }
               }else{
                $rData=['USERNAME'=>$datax['USERNAME'],"FIRST_NAME"=>$result['first_name'],"ROLE"=>'CLIENT',"STATUS"=>"ACTIVE","MSG"=>"LOGIN SCCUESS","ERROR"=>"FALSE"];
               }
            }
            
            return json_encode($rData);

        }catch(Exception $e){
            die("error caucght".$e->getMessage());
        }


    }*/

    function hashPassword($pass){
        return $pass;
        return password_hash($pass,PASSWORD_DEFAULT);
    }

    function verifyPassword($current_password,$hashed_password){
        if($current_password==$hashed_password){
            return true;
        }return false;
        return password_verify($current_password,$hashed_password);
    }
}

?>