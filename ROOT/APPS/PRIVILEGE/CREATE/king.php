<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    //$kali->whoHasAccess(['KING']);
    $APPLICATION = "PRIVILEGE";
    $kali->checkAccess($APPLICATION,'CREATE');
    
    $sql = 'SELECT `id`,`name` FROM `college` WHERE `user_refid`=:user_refid ';
    $colleges = $GLOBALS['kali']->kaliPulls($sql,['user_refid'=>$_SESSION['KOHOMAH']]);

    $sql = 'SELECT `id`,`name`FROM `application_manifest` ORDER BY `name` ASC ';
    $applications = $GLOBALS['kali']->kaliPulls($sql,[]);
    
    if($_SESSION['MY_AUTHORITY']=='KING'){
        $sql = 'SELECT `id`,`name` FROM `authority` WHERE `name`=:name ORDER BY `name` ASC ';
        $authoritys = $GLOBALS['kali']->kaliPulls($sql,['name'=>'CLIENT']);
    }elseif($_SESSION['MY_AUTHORITY']=='CLIENT'){
        $sql = 'SELECT `id`,`name` FROM `authority` WHERE (`name`!=:name && `name`!=:name2) ORDER BY `name` ASC ';
        $authoritys = $GLOBALS['kali']->kaliPulls($sql,['name'=>'CLIENT','name2'=>'KING']);
    }else{
        $sql = 'SELECT `id`,`name` FROM `authority` WHERE (`name`!=:name1 && `name`!=:name2 && `name`!=:name3) ORDER BY `name` ASC ';
        $authoritys = $GLOBALS['kali']->kaliPulls($sql,['name1'=>$_SESSION['MY_AUTHORITY'],'name2'=>'CLIENT','name3'=>'KING']);
    }


    
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

    <form  id="privilege-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE <?php echo $APPLICATION; ?></legend>

            <span class="error-log grid-fill danger-glow" id="privilege-create-error-log"></span>

            <?php if($_SESSION['MY_AUTHORITY']=='CLIENT'){?>

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

            <?php }?>


            <div class="kali-inputbox  ">
                <span>AUTHORITY</span>
                <select name="AUTHORITY_NAME" id="AUTHORITY_NAME" required>
                    <?php
                        foreach($authoritys as $authority){
                            echo '<option value="'.$authority['id'].'" selected>'.$authority['name'].'</option>';
                        }
                    ?>
                    <option value="" selected>Choose authority</option>
                </select>
            </div>


            <div class="kali-inputbox">
                    <span>APPLICATION</span>
                    <select name="APPLICATION_NAME" id="APPLICATION_NAME" required>
                        <?php
                            foreach($applications as $app){
                                echo '<option value="'.$app['id'].'" selected>'.$app['name'].'</option>';
                            }
                        ?>
                        <option value="" selected>Choose Application</option>
                    </select>
            </div>

              
            <div class="kali-inputbox grid-fill">
                <span>RIGHTS</span>
                <input type="text" name="APPLICATION_RIGHTS" id="APPLICATION_RIGHTS" placeholder="Enter Rights Sperated By Commas. EG: CREATE,UPDATE" value="" >
            </div>

            <div class="kali-inputbox kali-inputbtn">
                <input type="submit" name="SUBMIT" value="LET'S GO" class="kali-btn">
            </div>  
        </fieldset>
    </form>

</section>

</body>
</html>
