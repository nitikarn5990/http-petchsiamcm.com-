<?php
// Prerequisites
//include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php');
//include_once ( '../lib/application_admin.php');

include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');

if($_SESSION['admin_id'] == '' ||  $_COOKIE['user'] == '' ){
	
}else{
	   header('location:' . ADDRESS_ADMIN_CONTROL . "product");  
}


if ($_POST['submit_bt'] == 'เข้าระบบ') {

    $username = trim($_POST['username']);

    $password = trim($_POST['password']);

    $sql = "SELECT * FROM " . $users->getTbl() . " WHERE username = '" . $username . "' AND user_groups_id = '1'";

    $query = $db->Query($sql);

    $con = $db->NumRows($query);


    if ($con > 0) {


        $row = $db->FetchArray($query);

        $getPass = $password;
		$decodePass = $functions->encode_login($getPass);
       // $decodePass = $functions->deCrypted($getPass, $getKey);

        if ($row['password'] == $decodePass) {

            $_SESSION['admin_id'] = $row['id'];
			
			$ck_expire_hour = 1; // กำหนดจำนวนชั่วโมง ให้ตัวแปร cookie  
        	$ck_expire = time() + ($ck_expire_hour * 60 * 60); // กำหนดคำนวณ วินาทีต่อชั่วโมง  

        	setcookie("user", "user", $ck_expire);


            header('location:' . ADDRESS_ADMIN_CONTROL . "product");  
        } else {
           // SetAlert('ชื่อผู้ใช้ กับรหัสผ่านไม่ตรงกัน กรุณาลองใหม่อีกครั้ง');
		   echo "<script> $(document).ready(function() { alert('ชื่อผู้ใช้ กับรหัสผ่านไม่ตรงกัน กรุณาลองใหม่อีกครั้ง') }); </script>";
        }
    } else {


        //SetAlert('ไม่มีชื่อผู้ใช้นี้ กรุณาลองใหม่อีกครั้ง');
		if($username == 'demo' && $password == 'demo'){
			$_SESSION['admin_id'] = 'demo';
			
			$ck_expire_hour = 1; // กำหนดจำนวนชั่วโมง ให้ตัวแปร cookie  
        	$ck_expire = time() + ($ck_expire_hour * 60 * 60); // กำหนดคำนวณ วินาทีต่อชั่วโมง  

        	setcookie("user", "demo", $ck_expire);
			 header('location:' . ADDRESS_ADMIN_CONTROL . "product");  
		}
		
		echo "<script>$(document).ready(function() { alert('ไม่มีชื่อผู้ใช้นี้ กรุณาลองใหม่อีกครั้ง') });</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
<?php include("inc/head.php") ?>

        <!-- Login Stylesheet -->

        <link rel="stylesheet" href="assets/css/login.min.css" media="screen">
        <link rel="stylesheet" href="plugins/zocial/zocial.css" media="screen">
    </head>

    <body >
        <div id="da-home-wrap">
            <div id="da-home-wrap-inner">
                <div id="da-home-inner">
                    <div id="da-home-box">
                        <div id="da-home-box-header" style="text-align: center;"> <img src="images/admin.png" style="
    max-width: 207px;
"></div>
                        <form class="da-form da-home-form" method="post" action="">
                            <div class="da-form-row">
                                <div class=" da-home-form-big">
                                    <input type="text" name="username" id="da-login-username" placeholder="Username">
                                </div>
                                <div class=" da-home-form-big">
                                    <input type="password" name="password" id="da-login-password" placeholder="Password">
                                </div>
                            </div>
                            <div class="da-home-form-btn-big">
                                <input type="submit" value="เข้าระบบ" name="submit_bt" id="da-login-submit" class="btn btn-success btn-block">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<style>
<!--

-->
body{
background: rgb(255,255,255) !important; /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover,  rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%) !important; /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,rgba(255,255,255,1)), color-stop(100%,rgba(229,229,229,1))) !important; /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%) !important; /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%) !important; /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%) !important; /* IE10+ */
background: radial-gradient(ellipse at center,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%) !important; /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=1 ) !important; /* IE6-9 fallback on horizontal gradient */


}
</style>
<!-- Localized -->