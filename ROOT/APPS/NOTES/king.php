<?php
    require_once '../../../SYSTEM/IMPORT/BACKEND/kali.php';
?>
<html>
<head>

    <?php
        $kali->link('ASSETS');
        $kali->link('FONT_AWESOME');
        $kali->link('GLOBAL_DESIGN');
        $kali->link('JQUERY');
        $kali->link('GLOBAL_SCRIPT');
    ?>

</head>
<body>

    <section class="main-body">

        <div class="notes-container">

            <div class="notes-header">

                <div class="notes-search-cards ">
                    <input type="search" class="notes-card-search-box" placeholder="Search Notes"/>
                </div>

                <div class="notes-card-header-options">
                    <button class="notes-card-add-new" id="add-new-note">Add Notes</button>
                </div>
                
            </div>

            <div class="notes-body">

                <div class="notes-card-container" id="notes-card-container">


                </div>

            </div>


        </div>








    </section>






</body>
</html>
