<?php
	require_once '../../../../SYSTEM/IMPORT/BACKEND/kali.php';
    $kali->whoHasAccess(['KING']);
?>
<head>
<?php
    	$kali->link('JQUERY');
		$kali->link('GLOBAL_DESIGN');
		$kali->link('GLOBAL_SCRIPT');
		$kali->link('FONT_AWESOME');
		$kali->link('BOOTSTRAP');
		$kali->link('KALI_TABLE');
		$kali->link('KALI_FORM');
		$kali->link('ASSETS');
?>
</head>
<body>

<script src="ASSETS/js/script_2.js"></script>
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">



	<div class="kali-inputbox">
		<input type="search" id="SEARCH_BOX" name="SEARH_BOX" placeholder="Search User Here">
	</div>

    <span id="searchtable"></span>

	<div id="bts_modal_container"></div>

</body>
