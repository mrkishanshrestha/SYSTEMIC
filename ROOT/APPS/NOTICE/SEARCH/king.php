<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    
    $APPLICATION = "USER";
    $kali->checkAccess($APPLICATION,'VIEW');

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


	<div class="kali-inputbox">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

    <span id="searchtable"></span>

	<div id="bts_modal_container"></div>

</body>
