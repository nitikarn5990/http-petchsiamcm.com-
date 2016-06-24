<?php
if($_SESSION['customer_id'] != ''){
$customer->SetPrimary((int)$_SESSION['customer_id']);

}
if (!$customer->GetInfo()){

?>
		<script>	alert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง'); </script>

<?php } ?>
<div class="member">
    <h1 class="title-bar">Member Information
        <div class="title-border"></div>
    </h1>
</div>
<br>
<div class="col-sm-3">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#">แก้ไขชื่อและที่อยู่</a></li>
        <li><a href="#">ประวัติการสั่งซื้อ <span class="badge"> 42 รายการ</span></a></li>
        <li><a href="#">สถานะการสั่งซื้อ</a></li>
        <li><a href="#">เปลี่ยนรหัสผ่าน</a></li>
    </ul>
</div>
<div class="col-sm-9">

<?php if($_GET['controllers'] != '' && $_GET['catID'] == ''){?>
<section>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset class="well the-fieldset">
    <legend class="the-legend">Member Profile</legend>
    <div class="control-group">
        <div class="col-xs-6" style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> ชื่อ: </label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $customer->GetValue('customer_name')?>" required="required">
        </div>
        <div class="col-xs-6"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> นามสกุล : </label>
            <input type="text" class="form-control" id="customer_lastname" name="customer_lastname" value="<?php echo $customer->GetValue('customer_lastname')?>" required>
        </div>
        <div class="col-xs-12"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> ที่อยู่: </label>
            <input type="text" class="form-control" id="customer_address" name="customer_address" value="<?php echo $customer->GetValue('customer_address')?>" required>
        </div>
        <div class="col-xs-6"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> จังหวัด: </label>
            <div class="da-form-item large">
                <select name='province_id' id='province_id' class="form-control"  onchange="data_show(this.value,'amphur_id');" required>
                    <option value="">กรุณาเลือก</option>
                 
                    <?php $province->CreateDataList3("PROVINCE_ID","PROVINCE_NAME","" , $customer->GetValue('province_id'));?>
                </select>
            </div>
        </div>
        <div class="col-xs-6"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> อำเภอ: </label>
            <div class="da-form-item large">
                <select name="amphur_id" id="amphur_id" onchange="data_show(this.value,'district_id');"  class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php $amphur->CreateDataList3("AMPHUR_ID","AMPHUR_NAME","" , $customer->GetValue('amphur_id'));?>
                </select>
            </div>
        </div>
        <div class="col-xs-6"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> ตำบล: </label>
            <div class="da-form-item large">
                <select name="district_id" id="district_id" class="form-control" required>
                    <option value="">กรุณาเลือก</option>
                    <?php $district->CreateDataList3("DISTRICT_ID","DISTRICT_NAME","" , $customer->GetValue('district_id'));?>
                </select>
            </div>
        </div>
        <div class="col-xs-6"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> รหัสไปรษณีย์ : </label>
            <input type="number" class="form-control" id="zipcode" name="zipcode" value="<?php echo $customer->GetValue('zipcode')?>" required>
        </div>
        <div class="col-xs-6"  style="padding-bottom:10px;">
            <label class="control-label input-label" for="startTime"><em>*</em> โทร : </label>
            <input type="tel" class="form-control" id="customer_tel" name="customer_tel" value="<?php echo $customer->GetValue('customer_tel')?>" required>
        </div>
        <div class="col-xs-12"  style="padding-bottom:10px;">
            <input type="submit" class="btn btn-primary" value="Submit" id="submit_bt" name="submit_bt"  >
        </div>
    </div>
</fieldset>
</section>

<?php }?>

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
