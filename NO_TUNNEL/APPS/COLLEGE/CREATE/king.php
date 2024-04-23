<?php
    require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $appTitle="COLLEGE";

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



<section id="collegeCreate-form">

    <form  id="college-create-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">CREATE <?php echo $appTitle; ?></legend>

            <span class="error-log grid-fill danger-glow" id="college-create-form-error-log"></span>

                        
            <div class="kali-inputbox grid-fill">
                <span>Select Affilaiton</span>
                <select name="COLLEGE_AFFILIATION" id="COLLEGE_AFFILIATION" required>
                    <option value="" selected>Choose Affilation</option>
                    <option value="TU" >TU ( Tribhuvan University )</option>
                    <option value="PU" >PU ( Pokhara University )</option>
                    <option value="KU" >KU ( Kathmandu University )</option>
                </select>
            </div>

  
            <div class="kali-inputbox">
                <span>College Full Name</span>
                <input type="text" name="COLLEGE_NAME" id="COLLEGE_NAME" placeholder="EG: Asian College Of Higher Studies" value="" required>
            </div>
                     
            <div class="kali-inputbox">
                <span>College Short Name</span>
                <input type="text" name="COLLEGE_SHORT_NAME" id="COLLEGE_SHORT_NAME" placeholder="EG: ACHS" value="" required>
            </div>
                    
            <div class="kali-inputbox">
                <span>Address</span>
                <input type="text" name="ADDRESS" id="ADDRESS" placeholder="Enter Address" value="" required>
            </div>
                                           
            <div class="kali-inputbox">
                <span>Geo Location</span>
                <input type="text" name="GEO_LOCATION" id="GEO_LOCATION" placeholder="Enter Google Geo Location" value="" required>
            </div>
                        
            <div class="kali-inputbox">
                <span>College Mailing Address (Email)</span>
                <input type="email" name="COLLEGE_EMAIL" id="COLLEGE_EMAIL" placeholder="Enter Email" value="" required>
            </div>
            
            <div class="kali-inputbox">
                <span>Contact Number</span>
                <input type="number" name="CONTACT_NUMBER" id="CONTACT_NUMBER" placeholder="Enter Contact Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

                                 
            <div class="kali-inputbox">
                <span>Phone Number</span>
                <input type="number" name="PHONE_NUMBER" id="PHONE_NUMBER" placeholder="Enter Phone Number" value=" "    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength=10 required>
            </div>

                        
            <div class="kali-inputbox">
                <span>Established Date</span>
                <input type="date" name="EST_DATE" id="EST_DATE" placeholder="Enter Established Date" value=" "    required>
            </div>
            
            <div class="kali-inputbox">
                <span>College Logo</span>
                <input type="file" name="COLLEGE_LOGO" id="COLLEGE_LOGO" required>
            </div>
      
            <div class="kali-inputbox">
                <span>College Main Image</span>
                <input type="file" name="COLLEGE_BACKGROUND_IMAGE" id="COLLEGE_BACKGROUND_IMAGE" required>
            </div>
            
            <div class="kali-inputbox">
                <span>Description</span>
                <input type="text"  style="width: 40vw;" name="DESCRIPTION" id="DESCRIPTION" placeholder="Enter Description" value="" required>
            </div>
            
            <div class="kali-inputbox grid-fill">
                <span>Domain Cname</span>
                <input type="text"  style="width: 40vw;" name="DOMAIN_CNAME" id="DOMAIN_CNAME" placeholder="Enter Cmane Eg : achs" value="" required>
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