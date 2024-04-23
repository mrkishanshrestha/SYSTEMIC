<?php
    require_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $APPLICATION="PROFILE";
    $kali->checkAccess($APPLICATION,'BASIC');
    $USER = $kali->getUserInfo('ALL');
?>
<html>
<head>

    <?php
        $kali->link('JQUERY');
        $kali->link('ASSETS');
        $kali->link('KALI_FORM');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('GLOBAL_SCRIPT');
        $kali->link('BOOTSTRAP');
    ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>

<div class="container-xl px-4 mt-4">


<hr class="mt-0 mb-4">

    <div class="row">
        <div class="col-xl-4">

        <div class="card mb-4 mb-xl-0 ">
            <div class="card-header">Profile Picture</div>
            <div class="card-body text-center">
                <img class="img-account-profile rounded-circle mb-2" src="<?php echo $kali->getUserInfo('PROFILE_PICTURE');?>" alt>
                <br><h2><span class="font-weight-bold"><?php echo $USER['first_name'].' '.$USER['last_name'];?></span></h2>
                <span class="text-black-50"><?php echo $_SESSION['MY_AUTHORITY'];?></span>
                <br>
                <button class="btn btn-primary" type="button">Upload new image</button>
            </div>
        </div>
    </div>


<div class="col-xl-8">

<span class="error-log grid-fill danger-glow" id="error-log"></span>

        <div class="card mb-4">
        <div class="card-header">Account Details</div>
        <div class="card-body">
        <form id="profile-update-form" method="post" enctype = "multipart/form-data">

        <div class="row gx-3 mb-3">

        <div class="col-md-6">
        <label class="small mb-1" for="FIRST_NAME">First name</label>
        <input class="form-control" id="FIRST_NAME" name="FIRST_NAME" type="text" placeholder="Enter your first name" value="<?php echo $USER['first_name'];?>">
        </div>

        <div class="col-md-6">
        <label class="small mb-1" for="MIDDLE_NAME">Middle name</label>
        <input class="form-control" id="MIDDLE_NAME" name="MIDDLE_NAME"  type="text" placeholder="Enter your middle name" value="<?php echo $USER['middle_name'];?>">
        </div>

        </div>
        <div class="col-md-6">
        <label class="small mb-1" for="LAST_NAME">Last name</label>
        <input class="form-control" id="LAST_NAME" name="LAST_NAME"  type="text" placeholder="Enter your last name" value="<?php echo $USER['last_name'];?>">
        </div>
        </div>

        <div class="row gx-3 mb-3">


        <div class="mb-3">
        <label class="small mb-1" for="ADDRESS">Address</label>
        <input class="form-control" id="ADDRESS" name="ADDRESS" type="text" placeholder="Enter your location" value="<?php echo $USER['address'];?>">
        </div>
        </div>

        <div class="mb-3">
        <label class="small mb-1" for="EMAIL">Email address</label>
        <input class="form-control" id="EMAIL" name="EMAIL" type="email" placeholder="Enter your email address" value="<?php echo $USER['email'];?>">
        </div>

        <div class="row gx-3 mb-3">

        <div class="col-md-6">
        <label class="small mb-1" for="PHONE_NUMBER">Phone number</label>
        <input class="form-control" id="PHONE_NUMBER" name="PHONE_NUMBER"  type="tel" name="PHONE_NUMBER" placeholder="Enter your phone number" value="<?php echo $USER['phone_number'];?>">
        </div>

        <div class="col-md-6">
        <label class="small mb-1" for="CONTACT_NUMBER">Contact Number</label>
        <input class="form-control" id="CONTACT_NUMBER" name="CONTACT_NUMBER"  type="tel" name="CONTACT_NUMBER" placeholder="Enter your contact number" value="<?php echo $USER['contact_number'];?>">
        </div>
        </div>

        <button class="btn btn-primary" type="submit" name="SUBMIT">Save changes</button>
        </form>
        </div>
        </div>
        </div>
        </div>
</div>

<hr class="mt-0 mb-4">

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
