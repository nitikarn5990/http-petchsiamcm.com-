<?php
if ($_SESSION['customer_id'] != '') {
    $customer->SetPrimary((int) $_SESSION['customer_id']);
} else {
    header("location: " . ADDRESS);
}
if (!$customer->GetInfo()) {
    ?>
    <script>	alert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');</script>
<?php } ?>
<?php
if ($_POST['submit_bt'] == 'แก้ไข') {

    $customer->SetPrimary((int) $_SESSION['customer_id']);

    $arrData = array();
    $arrData = $functions->replaceQuote($_POST);

    $customer->SetValues($arrData);
    $customer->SetValue('updated_at', DATE_TIME);
    $customer->SetValue('login_email', $_SESSION['email']);
    $customer->SetValue('login_password', $_SESSION['password']);
    $customer->SetValue('status', 'ใช้งาน');

    $customer->SetPrimary((int) $_SESSION['customer_id']);

    if ($customer->Save()) {

        if ($customer->GetPrimary() != '') {
            ?>

            <div class="alert alert-success" role="alert"> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <span class="sr-only">Success:</span> แก้ไขข้อมูลสำเร็จ </div>
        <?php
        }
    }
}
?>
<div class="member">
    <h1 class="title-bar">Member Information
        <div class="title-border"></div>
    </h1>
</div>
<br>
<div class="col-sm-3">
<?php include("inc/menu_member.php") ?>
</div>
<div class="col-sm-9">
<?php if ($_GET['controllers'] != '' && $_GET['catID'] == '') { ?>
        <section>
            <form action="<?php echo ADDRESS ?>member.html" method="post">
                <fieldset class="well the-fieldset">
                    <legend class="the-legend">Member Profile</legend>
                    <div class="control-group">
                        <div class="col-xs-6" style="padding-bottom:10px;">
                            <label class="control-label input-label" for="startTime"><em>*</em> ชื่อ: </label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $customer->GetValue('customer_name') ?>" required="required">
                        </div>
                        <div class="col-xs-6"  style="padding-bottom:10px;">
                            <label class="control-label input-label" for="startTime"><em>*</em> นามสกุล : </label>
                            <input type="text" class="form-control" id="customer_lastname" name="customer_lastname" value="<?php echo $customer->GetValue('customer_lastname') ?>" required>
                        </div>
                        <div class="col-xs-12"  style="padding-bottom:10px;">
                            <label class="control-label input-label" for="startTime"><em>*</em> ที่อยู่: </label>
                            <input type="text" class="form-control" id="customer_address" name="customer_address" value="<?php echo $customer->GetValue('customer_address') ?>" required>
                        </div>
                        <div class="col-xs-6"  style="padding-bottom:10px;">
                            <label class="control-label input-label" for="startTime"><em>*</em> จังหวัด : </label>
                            <input type="text" class="form-control" id="province" name="province" value="<?php echo $customer->GetValue('province') ?>" required>
                        </div>
                        <div class="col-xs-6"  style="padding-bottom:10px;">
                            <label class="control-label input-label" for="startTime"><em>*</em> รหัสไปรษณีย์ : </label>
                            <input type="number" class="form-control" id="zipcode" name="zipcode" value="<?php echo $customer->GetValue('zipcode') ?>" required>
                        </div>
                        <div class="col-xs-6"  style="padding-bottom:10px;">
                            <label class="control-label input-label" for="startTime"><em>*</em> โทร : </label>
                            <input type="tel" class="form-control" id="customer_tel" name="customer_tel" value="<?php echo $customer->GetValue('customer_tel') ?>" required>
                        </div>
                        <div class="col-xs-12"  style="padding-bottom:10px;">
                            <input type="submit" class="btn btn-primary" value="แก้ไข" id="submit_bt" name="submit_bt"  >
                        </div>
                    </div>
                </fieldset>
        </section>
<?php } ?>
</div>
<script language="javascript">
// Start XmlHttp Object
    function uzXmlHttp() {
        var xmlhttp = false;
        try {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                xmlhttp = false;
            }
        }

        if (!xmlhttp && document.createElement) {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }
// End XmlHttp Object

    function data_show(select_id, result) {

        var url = '../ajax/province.php?select_id=' + select_id + '&result=' + result;
        //alert(url);

        xmlhttp = uzXmlHttp();
        xmlhttp.open("GET", url, false);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
        xmlhttp.send(null);
        //alert(xmlhttp.responseText);
        document.getElementById(result).innerHTML = xmlhttp.responseText;
    }
//window.onLoad=data_show(5,'amphur'); 
</script> 
<script type="text/javascript">

    function checkForm()
    {



        if ($("#login_password_encryt").val() != $("#login_confirm_password").val()) {

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
