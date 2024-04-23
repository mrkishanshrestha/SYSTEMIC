<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
	$kali->whoHasAccess(['STUDENT']);
    $kali->link('GLOBAL_DESIGN');
    $kali->link('JQUERY');
    $kali->link('GLOBAL_SCRIPT');
    $kali->link('KALI_FORM');
    $kali->link('ASSETS');
    $kali->link('KALI_TABLE');
    $kali->link('BOOTSTRAP');
    $kali->link('FONT_AWESOME');
?>
<body>

	
	<div class="kali-inputbox">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

    <span id="searchtable"></span>

	<div id="bts_modal_container"></div>


</body>
