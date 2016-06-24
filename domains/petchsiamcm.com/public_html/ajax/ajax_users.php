<?php  include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');

$user_refer_id = $_POST['user_refer_id'];



	if($customer->CountDataDesc("id","id = '".$user_refer_id."'" ) > 0){  
		$res = 'ชื่อผู้แนะนำคือ : '.$customer->getDataDesc("customer_name","id = " . $user_refer_id) . ' '. $customer->getDataDesc("customer_lastname","id = " . $user_refer_id);
	
	}else{
		$res = "ไม่พบข้อมูล";
	}
	

echo  $res;

?>

	
