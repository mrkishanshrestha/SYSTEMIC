<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
	$kali->whoHasAccess(['KING']);
    $kali->link('GLOBAL_DESIGN');
    $kali->link('JQUERY');
    $kali->link('GLOBAL_SCRIPT');
    $kali->link('KALI_FORM');
    $kali->link('ASSETS');
    $kali->link('BOOTSTRAP');
    $kali->link('FONT_AWESOME');
	$kali->link('KALI_TABLE');
?>
<body>

	
	<div class="kali-inputbox">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

    <span id="searchtable"></span>

	<div id="bts_modal_container"></div>

</body>
