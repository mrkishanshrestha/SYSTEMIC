<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="PAYMENT";
    $kali->checkAccess($APPLICATION,'SEARCH');
    $kali->link('JQUERY');
    $kali->link('GLOBAL_DESIGN');
    $kali->link('GLOBAL_SCRIPT');
    $kali->link('KALI_FORM');
    $kali->link('ASSETS');
    $kali->link('KALI_TABLE');
    $kali->link('FONT_AWESOME');
    $kali->link('BOOTSTRAP');
    $kali->link('QR');
?>
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>

<body>

<input type="text" id="MY_AUTHORITY" value="<?php echo $_SESSION['MY_AUTHORITY'];?>" >

<?php
    $SQL_FACULTY='SELECT college.faculty_id_x FROM `college` college
     INNER JOIN `branch` branch ON 
    branch.college_refid = college.id
    WHERE branch.id=(SELECT `branch_refid` FROM `user` WHERE `id`=:id)';
    $FACULTY = $kali->kaliPull($SQL_FACULTY,['id'=>$_SESSION['KOHOMAH']]);
    $FACULTY = explode(',',$FACULTY['faculty_id_x']);
?>

<?php if($_SESSION['MY_AUTHORITY']!="STUDENT"){ ?>

<form  id="student-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend"> SEARCH STUDENTS</legend>

            <span class="error-log grid-fill danger-glow" id="error-log"></span>

            
                <div class="kali-inputbox  grid-fill">
                    <span>Select Faculty</span>
                    <select name="FACULTY" id="FACULTY" onchange="hello();" required>
                        <?php
                            foreach($FACULTY as $FACULTY_REFID){
                                $SQL_FACULTY='SELECT `name`,`short_name` FROM `faculty` WHERE `id`=:id';
                            $FACULTY_NAME = $kali->kaliPull($SQL_FACULTY,['id'=>$FACULTY_REFID]);
                                echo '<option value="'.$FACULTY_REFID.'">'.$FACULTY_NAME['name'].' ( '.$FACULTY_NAME['short_name'].' )'.'</option>';
                            }
                        ?>
                        <option value="" selected>Choose Any One Faculty</option>
                    </select>

            <span class="kali-inputbox" id="FACULTY_DURATION"></span>

        </div>

	<div class="kali-inputbox  grid-fill">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>
              
</fieldset>
</form>

<?php }else{?>

    <div class="kali-inputbox  grid-fill">
		<input type="search" style="color: snow;" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

    <script>
        $(document).ready(function(){
            $('#SEARCH_BOX').val('<?php echo $_SESSION['KOHOMAH'];?>').focus();
        });
    </script>
    
<?php }?>


<?php
if($_SESSION['MY_AUTHORITY']=="STUDENT"){
?>
<button id="payment-button">Pay with Khalti</button>
<?php
}?>

<script>
        var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_b1da8bffe03d46e9b9068f2f2f1fbe13",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    // hit merchant api for initiating verfication
                    console.log(payload);
                    verifyPayment(payload);
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            let payingAmount = prompt("Enter Your Amount", "0");
            if (payingAmount != null) {
                payingAmount = payingAmount*100;
            }
            checkout.show({amount: payingAmount});
            // minimum transaction amount must be 10, i.e 1000 in paisa.
            
        }
</script>


    <span id="searchtable"></span>
    
    <span id="statementSearhTable"></span><br/><br/>

    <div id="bts_modal_container"></div>
    


</body>

    
<canvas id="qr-code"></canvas>

<script>

    function verifyPayment(payload){
        $.ajax({
            url: "khaltiVerification.php",
            type:"POST",
            data: payload,
            dataType: 'json',
            sucess : function(response){ console.log(`sucess : `);console.log(response); processPayment(payload);},
            error : function(response){ console.log('error : ');console.log(response); processPayment(payload);}

        });
    }

    function processPayment(payload){

            var jsonDataCollection = payload;
            jsonDataCollection.UPDATE='JACKX_UPDATE';

            var jackxData = juju.sendJackx({
                URL:'khaltiPayIn.php',
                DATA: jsonDataCollection,
            });

            jackxData.done(function(data){  

                data=JSON.parse(data);
                if(data.ERROR){
                    juju.alerty({
                        status:'danger',
                        msg:data.MSG,
                        title:'ERROR',
                        position:'top_right'
                    });
                    juju.fireError({
                        TARGET:data.TARGET,
                        MSG:data.MSG
                    });
                }else{
                    juju.alerty({
                        status:'success',
                        msg:data.MSG,
                        title:'Hurray',
                        position:'top_right'
                    });
                }
                $('#SEARCH_BOX').focus();

            });
                

    }

</script>