<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="USER";
    $kali->checkAccess($APPLICATION,'CREATE');

    $authority = getAuthority();
    $GLOBALS['kali'] = &$kali;

    $sql = 'SELECT `id`,`name` FROM `college` WHERE `user_refid`=:user_refid ';
    $colleges = $GLOBALS['kali']->kaliPulls($sql,['user_refid'=>$_SESSION['KOHOMAH']]);

?>
<html>
<head>
    <?php
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
   ?>

</head>
<body>

<section id="userCreate-form">

    <form  id="user-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE USER</legend>

            <span class="error-log grid-fill danger-glow" id="error-log"></span>

            <?php if($_SESSION['MY_AUTHORITY']=="CLIENT"){?>
                <div class="kali-inputbox  grid-fill">
                    <span>College</span>
                    <select name="COLLEGE" id="COLLEGE" required>
                        <?php
                            foreach($colleges as $college){
                                echo '<option value="'.$college['id'].'" selected>'.$college['name'].'</option>';
                            }
                        ?>
                        <option value="" selected>Choose College</option>
                    </select>
                </div>

                <div class="kali-inputbox grid-fill" id="branch_data">
                    <span>Branch</span>
                    <select name="BRANCH" id="BRANCH" required>
                        <option value="" selected>Choose Branch</option>
                    </select>
                </div>
            <?php } ?>

            <div class="kali-inputbox  grid-fill">
                <span>User Post</span>
                <select name="AUTHORITY" id="AUTHORITY" required>
                    <?php
                        foreach($authority as $aut){
                            echo '<option value="'.$aut.'" selected>'.$aut.'</option>';
                        }
                    ?>
                    <option value="" selected>Choose Post</option>
                </select>
            </div>

  
            <div class="kali-inputbox grid-fill">
                <span>User Name</span>
                <input type="text" name="USERNAME" id="USERNAME" placeholder="Enter User Name" value="" required>
            </div>

  
            <div class="kali-inputbox">
                <span>First Name</span>
                <input type="text" name="FIRST_NAME" id="FIRST_NAME" placeholder="Enter First Name" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Middle Name</span>
                <input type="text" name="MIDDLE_NAME" id="MIDDLE_NAME" placeholder="Enter Middle Name" value="" >
            </div>
           
            <div class="kali-inputbox">
                <span>Last Name</span>
                <input type="text" name="LAST_NAME" id="LAST_NAME" placeholder="Enter Last Name" value="" required>
            </div>
           
                        
            <div class="kali-inputbox">
                <span>Email</span>
                <input type="email" name="EMAIL" id="EMAIL" placeholder="Enter Email" value="" required>
            </div>
            
            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number" name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Contact Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

            <div class="kali-inputbox">
                <span>Secondary Phone Number</span>
                <input type="number" name="PHONE_NUMBER" id="PHONE_NUMBER"  placeholder="Enter Phone Number" value="" maxlength=10 required>
            </div>
           
            <div class="kali-inputbox">
                <span>Address</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="Enter Address" value="" required>
            </div>

            <div class="kali-inputbox">
                <span>Profile Image</span>
                <input type="file" name="USER_PROFILE_PICTURE" id="USER_PROFILE_PICTURE" required>
            </div>

            <div class="kali-inputbox">
                <span>Documents (Image File)</span>
                <input type="file" name="USER_DOCUMENT" id="USER_DOCUMENT" required>
            </div>

            <div class="kali-inputbox grid-fill">
                <span>Description</span>
                <input type="text"  style="width: 40vw;" name="DESCRIPTION" id="DESCRIPTION" placeholder="Enter Description" value="" required>
            </div>

            
            <!--
            <div class="kali-checkbox grid-fill">

                <span>Can Login To: </span>

                <div class="kali-checkbox-options">

                        <div class="kali-checkbox-option-data">
                            <input class="kali-checkbox-data" name="ACCESS_TO[]"  type="checkbox" value="ACHS" id="ACHS"  >
                            <label  for="ACHS">ACHS</label>
                        </div>

                        <div class="kali-checkbox-option-data">
                            <input class="kali-checkbox-data" name="ACCESS_TO[]" type="checkbox" value="IIMS" id="IIMS">
                            <label for="IIMS">IIMS</label>
                        </div>

                </div>
            </div>

            -->
             
             
              </div>


            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="LET'S GO" class="kali-btn">
            </div>  
        </fieldset>
    </form>

</section>

</body>
</html>

<?php
/*
    if(mail('kishanshresth21@gmail.com','hello world','kishan is great',"From:shresthabishal68@gmail.com")){
        die('sucess');
    }else{
        die('failed');
    }
*/
?>


<?php

    
function getAuthority($data=null){

    $AUTHORITY = [];

    $sql = 'SELECT  `name` FROM `authority` ';
    $data = $GLOBALS['kali']->kaliPulls($sql,[]);
    if($data){

        if($data == "ALL"){
            return $data;
        }

        switch($_SESSION['MY_AUTHORITY']){

            case 'CLIENT':
                $AUTHORITY = ['ADMIN','COORDINATOR','FINANCIAL_ACC','RECEPTIONIST','SUPERVISIOR','TEACHER','OTHERS'];
            break;

            case 'ADMIN':
                $AUTHORITY = ['COORDINATOR','FINANCIAL_ACC','RECEPTIONIST','SUPERVISIOR','TEACHER','OTHERS'];
            break;

            case 'COORDINATOR':
                $AUTHORITY = ['RECEPTIONIST','TEACHER','OTHERS'];
            break;

            case 'RECEPTIONIST':
                $AUTHORITY = ['OTHERS'];
            break;

            default:
            die("Invalid Data");
            break;

        }
    return $AUTHORITY;

    }else{
        die('ERROR IN GETTING AUTHOITIES getAuthority()');
    }

}


?>