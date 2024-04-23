<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->link('JQUERY');
    $kali->link('GLOBAL_DESIGN');
    $kali->link('GLOBAL_SCRIPT');
    $kali->link('KALI_FORM');
    $kali->link('ASSETS');
    $kali->link('KALI_TABLE');
    $kali->link('FONT_AWESOME');
    $kali->link('BOOTSTRAP');
?>
<body>


<form  id="course_assign-form" method="post" enctype = "multipart/form-data">
        <fieldset class="kali-form">
            <legend class="kali-formLegend">SEARCH ASSIGNED COURSES</legend>

	<div class="kali-inputbox grid-fill">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

</fieldset>
</form>

    <span id="searchtable"></span>

	<div id="bts_modal_container"></div>

</body>
