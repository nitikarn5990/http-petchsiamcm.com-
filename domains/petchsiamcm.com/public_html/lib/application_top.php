<?php
	// Global Defines
	include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/define.php');
	
	// Simpl Framework
	include_once(FS_SIMPL . 'simpl.php');
	
	// Custom Functions and Classes
	include_once(DIR_ABS . DIR_INC . 'functions.php');
	
	// Make the DB Connection
	$db = new DB;
	$db->Connect();
?>