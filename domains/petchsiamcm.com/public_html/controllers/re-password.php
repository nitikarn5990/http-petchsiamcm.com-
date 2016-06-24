<?php
if($_SESSION['customer_id'] != ''){
$customer->SetPrimary((int)$_SESSION['customer_id']);

}
if (!$customer->GetInfo()){

?>
<script>	alert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง'); </script>
<?php } ?>
<?php 
if ($_POST['submit_bt'] == 'แก้ไข'){

		//$customer->SetPrimary((int)$_SESSION['customer_id']);
		
		
		$password = $customer->GetDataDesc("login_password", "id = " . $_SESSION['customer_id']);
		if($functions->decode_login($password) == $_POST['password']){
			
			
			$txt = "success";
			
			
		}else{
			
			$txt = "error";
		}
		
		if($txt == "success"){
			$arrData = array(
				//'login_email' => '',
				'login_password' => $functions->encode_login($_POST['new_password']),
				'updated_at' => DATE_TIME
			
			);
			$arrKey = array(
				'id' => $_SESSION['customer_id']
			
			);
			
			if($customer->updateSQL($arrData, $arrKey)){ ?>
	
				<div class="alert alert-success" role="alert"> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <span class="sr-only">Success:</span> แก้ไขข้อมูลสำเร็จ </div>
<?php       }  ?>
<?php    }else{ ?>

			<script>alert('รหัสผ่านเดิมไม่ตรงกับฐานข้อมูล')</script>


	<?php } ?>
			
<?php } ?>
<div class="member">
    <h1 class="title-bar">Reset Password
        <div class="title-border"></div>
    </h1>
</div>
<br>
<div class="col-sm-3">
    <?php include("inc/menu_member.php")?>
</div>
<div class="col-sm-9">
    <?php if($_GET['controllers'] != ''){?>
    <section>
        <form action="<?php echo ADDRESS ?>re-password.html" method="post" onSubmit="return checkForm()">
            <fieldset class="well the-fieldset">
                <legend class="the-legend">Reset-Password</legend>
                <div class="control-group">
                    <div class="col-xs-6" style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> รหัสผ่านเดิม: </label>
                        <input type="password" class="form-control" id="password" name="password"  minlength="6" required="required">
                    </div>
                  
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> รหัสผ่านใหม่ : </label>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" required>
                    </div>
                    <div class="col-xs-12"  style="padding-bottom:10px;">
                        <input type="submit" class="btn btn-primary" value="แก้ไข" id="submit_bt" name="submit_bt"  >
                    </div>
                </div>
            </fieldset>
        </form>
    </section>
    <?php }?>
</div>
<script language="javascript">


function chk_password(pwd){

	$.ajax({
	  method: "POST",
	  url: "../ajax/re-password.php",
	  data: { id: <?php echo $_SESSION['customer_id']?>, password: pwd }
	})
	  .done(function( msg ) {
		return (msg);
	  });
}
//window.onLoad=data_show(5,'amphur'); 
</script> 
<script type="text/javascript">

  function checkForm()
  {
	  
	  
   
  

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
