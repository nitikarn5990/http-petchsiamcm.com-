<?php  include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php');


$id = $_POST['id'];
$password = $_POST['password'];
 ?>


<?php 
if($id != '' && $password != ''){ 
	$res = mysql_query("SELECT * FROM customer WHERE id = " .$id. "");
	
	$row = mysql_fetch_array($res, MYSQL_ASSOC);
		if($row['login_password'] = $functions->encode_login($password)){
			echo "success";
		}else{
			
			echo "error";
		}
		
		//echo $row['login_password'];

}?>


