<?php  include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php');



$login_email = $_POST['login_email'];
 ?>


<?php 
$txt = "";

	if($customer->CountDataDesc("id","login_email = '". $login_email ."'") > 0){  
		$txt = "error";
	
	}else{
		$txt = "success";
	}
	



echo  $txt;

?>

	
