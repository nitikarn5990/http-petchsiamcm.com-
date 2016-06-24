<?php

session_start();

//include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php');

if ($_POST['submit_bt'] == 'Log in') {

    $username = trim($_POST['username']);

    $password = trim($_POST['password']);

    $sql = "SELECT * FROM " . $customer->getTbl() . " WHERE login_email = '" . $username . "' AND status = 'ใช้งาน'";

    $query = $db->Query($sql);

    $con = $db->NumRows($query);


    if ($con > 0) {

        $row = $db->FetchArray($query);

		$decodePass = $functions->encode_login($password);
       // $decodePass = $functions->deCrypted($getPass, $getKey);

        if ($row['login_password'] == $decodePass) {

            $_SESSION['customer_id'] = $row['id'];
			$_SESSION['customer_name'] = $row['customer_name'];
			$_SESSION['email'] = $row['login_email'];
			$_SESSION['password'] = $row['login_password'];
			$arrData = array(
				'last_login' => DATE_TIME
			);
			$arrID = array(
				'id' => $row['id']
			);
			
			$customer->updateSQL($arrData, $arrID);
			


            header('location:' . ADDRESS . "member.html");  
			die();
        } else {
           // SetAlert('ชื่อผู้ใช้ กับรหัสผ่านไม่ตรงกัน กรุณาลองใหม่อีกครั้ง');
		   echo "<script> $( document ).ready(function() { alert('ชื่อผู้ใช้ กับรหัสผ่านไม่ตรงกัน กรุณาลองใหม่อีกครั้ง') });</script>";
        }
    } else {


        //SetAlert('ไม่มีชื่อผู้ใช้นี้ กรุณาลองใหม่อีกครั้ง');
		echo "<script> $( document ).ready(function() { alert('ไม่มีชื่อผู้ใช้นี้ กรุณาลองใหม่อีกครั้ง')});</script>";
    }
}
?>

<div class="row">
      <div class="col-md-3">
        <?php include "inc/side_category.php" ;?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <h1 class="title-bar">LOGIN
                <div class="title-border"></div>
            </h1>
            <p>&nbsp; </p>
            <?php
    if($_GET['catID'] != ''){ ?>
            <div class="alert alert-success" role="alert"> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <span class="sr-only">Success:</span> สมัครสมาชิกสำเร็จ </div>
            <?php	} ?>
            
            <section class="col-md-6">
                  <fieldset class="well the-fieldset">
                    <legend class="the-legend">สมัครสมาชิก</legend>
           <p>สำหรับผู้ที่ยังไม่ได้ลงทะเบียน สามารถลงทะเบียนเพื่อสั่งซื้อสินค้าได้ค่ะ</p>
              <p><a href="<?php echo ADDRESS ?>register.html" class="btn btn-primary">สมัครสมาชิก</a></p>
           </fieldset>
        
            </section>
            <form action="<?php echo ADDRESS?>signin.html" method="post">
     	
            <section class="col-md-6">
                <fieldset class="well the-fieldset">
                    <legend class="the-legend">เข้าสู่ระบบ</legend>
                    <div class="control-group">
                    <div class="col-xs-12" style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> Email: </label>
                        <input type="email" class="form-control" id="username" name="username"  required>
                    </div>
                    <div class="col-xs-12"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> Password : </label>
                        <input type="password" class="form-control" id="password" name="password"  required>
                    </div>
                    <div class="col-xs-12"  style="padding-bottom:10px;">
                        <input type="submit" class="btn btn-primary" value="Log in" id="submit_bt" name="submit_bt"  >
                    </div>
                </fieldset>
                </form>
            </section>
        </div>
        <p>&nbsp; </p>
    </div>
  
</div>
<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(select_id,result){

	var url = '../ajax/province.php?select_id='+select_id+'&result='+result;
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	//alert(xmlhttp.responseText);
	document.getElementById(result).innerHTML =  xmlhttp.responseText;
}
//window.onLoad=data_show(5,'amphur'); 
</script> 
<script type="text/javascript">

  function checkForm()
  {
	  
	  
   
    if($("#login_password_encryt").val() != $("#login_confirm_password").val() ) {
     
        alert("รหัสผ่านไม่ตรงกัน");
        $("#login_confirm_password").focus();
        return false;
      
	}
    
   

    alert("You entered a valid password: " + form.pwd1.value);
    return true;
  }

</script>
<style>
.the-legend {
    border-style: none;
    border-width: 0;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 0;
}
.the-fieldset {
    border: 2px groove threedface #444;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend{
	padding:0 10px;
	width:auto !important;
	color:#898989;
	
}
</style>
