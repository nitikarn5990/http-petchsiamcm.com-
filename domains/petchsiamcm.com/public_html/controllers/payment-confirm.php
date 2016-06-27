<!-- Latest compiled and minified CSS -->
<link href="../plugins/datepicker/jquery.datepick.css" rel="stylesheet">

<script src="../plugins/datepicker/jquery.plugin.js"></script>
<script src="../plugins/datepicker/jquery.datepick.js"></script>
<script src="../plugins/datepicker/jquery.datepick-th.js"></script>
<script>
    $(function () {
        // $('#transfer_date').datepick();
        $('#transfer_date').datepick({
            maxDate: +0,
            dateFormat: 'yyyy-mm-dd'
        });
        // $('#inlineDatepicker').datepick({onSelect: showDate});
    });

</script>
<?php
if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {

    $recaptcha_secret = "6LeMxSITAAAAAEPNFj9C3VJifv8yAUH3HDLkgRuW";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
    $response = json_decode($response, true);
   
    if ($response["success"] === true) {
        
        $arrData = array();

        $arrData = $functions->replaceQuote($_POST);

        $payment_confirm->SetValues($arrData);


        if ($payment_confirm->GetPrimary() == '') {

            $payment_confirm->SetValue('created_at', DATE_TIME);

            $payment_confirm->SetValue('updated_at', DATE_TIME);
            
        } else {

            $payment_confirm->SetValue('updated_at', DATE_TIME);
        }

        $payment_confirm->SetValue('transfer_date', $_POST['transfer_date'] . " " . $_POST['transfer_hr'] . ":" . $_POST['transfer_min'] . ":00");
        $payment_confirm->SetValue('status', 'รอการชำระเงิน');
        $payment_confirm->SetValue('status2', 'ยังไม่ได้ส่งของ');

        if ($payment_confirm->Save()) {

            if (isset($_FILES['file_array'])) {

                $Allfile = "";

                $Allfile_ref = "";

                for ($i = 0; $i < count($_FILES['file_array']['tmp_name']); $i++) {

                    if ($_FILES["file_array"]["name"][$i] != "") {

                        //   unset($arrData['webs_money_image']);

                        $targetPath = DIR_ROOT_IMAGES . "/";

                        $ext = explode('.', $_FILES['file_array']['name'][$i]);
                        $extension = $ext[count($ext) - 1];
                        $rand = mt_rand(1, 100000);

                        $newImage = DATE_TIME_FILE . $rand . "." . $extension;

                        $cdir = getcwd(); // Save the current directory

                        chdir($targetPath);

                        copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);

                        chdir($cdir); // Restore the old working directory   
                        //   $payment_confirm->SetValue('image_receipt', $newImage);

                        if ($payment_confirm->GetPrimary() != '') {

                            $arrOrder = array(
                                'image_receipt' => $newImage,
                                'updated_at' => DATE_TIME
                            );

                            $arrOrderID = array('id' => $payment_confirm->GetPrimary());
                            if ($payment_confirm->updateSQL($arrOrder, $arrOrderID)) {

                                //echo "<script>alert('แจ้งชำระเงิน สำเร็จ')</script>";
                            }
                        } else {

                            echo "<script>alert('ไม่สามารถทำรายการได้ กรุณาลองใหม่อีกครั้ง')</script>";
                        }
                    }
                }
            }

             SetAlert('แจ้งโอนเงิน สำเร็จแล้ว', 'success');
             header('location:' . ADDRESS . 'payment-confirm');
             die();
             
        } else {
            
            //  SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
           // echo "<script>alert('ไม่สามารถทำรายการได้ กรุณาลองใหม่อีกครั้ง')</script>";
             SetAlert('ไม่สามารถทำรายการได้ กรุณาลองใหม่อีกครั้ง');
             header('location:' . ADDRESS . 'payment-confirm');
        }
    }else{
          echo "<script>  $(document).ready(function(){   noty({  text: 'Captcha Error', type: 'warning',
                    theme: 'relax',
                    timeout: 5000, }); });</script>";
    }
}
?>
<?php
if ($_GET['catID'] != '') {
    $order_id = ($_GET['catID']);
} else {
    $order_id = '';
}
?>

<div class="col-md-12 well">
    <div class="col-md-12">
      
            <?php
            // Report errors to the user


            Alert(GetAlert('error'));


            Alert(GetAlert('success'), 'success');
            ?>
      
        
    </div>
    <div class="col-md-12">
        <h1 style="margin-top: 0px;"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU4IDU4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1OCA1ODsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnIGlkPSJYTUxJRF82N18iPgoJPHBhdGggaWQ9IlhNTElEXzExOF8iIHN0eWxlPSJmaWxsOiNENUI4OUE7IiBkPSJNNTQuNzgzLDUwSDMuMjE3QzEuNDQsNTAsMCw0OC41NiwwLDQ2Ljc4M1YxMS4yMTdDMCw5LjQ0LDEuNDQsOCwzLjIxNyw4aDUxLjU2NiAgIEM1Ni41Niw4LDU4LDkuNDQsNTgsMTEuMjE3djM1LjU2NkM1OCw0OC41Niw1Ni41Niw1MCw1NC43ODMsNTAiLz4KCTxwYXRoIGlkPSJYTUxJRF8xMTdfIiBzdHlsZT0iZmlsbDojRTc0QzNEOyIgZD0iTTQ2LDIwYzAsMy4zMTQtMi42ODYsNi02LDZjLTMuMzE1LDAtNi0yLjY4Ni02LTZzMi42ODUtNiw2LTYgICBDNDMuMzE0LDE0LDQ2LDE2LjY4Niw0NiwyMCIvPgoJPHBhdGggaWQ9IlhNTElEXzExNl8iIHN0eWxlPSJmaWxsOiNGMEM0MUI7IiBkPSJNNTMsMjBjMCwzLjMxNC0yLjY4Niw2LTYsNnMtNi0yLjY4Ni02LTZzMi42ODYtNiw2LTZTNTMsMTYuNjg2LDUzLDIwIi8+Cgk8cGF0aCBpZD0iWE1MSURfMTE1XyIgc3R5bGU9ImZpbGw6I0U0RDZCNjsiIGQ9Ik0xNCwxNUg1Yy0wLjU1MywwLTEsMC40NDgtMSwxczAuNDQ3LDEsMSwxaDljMC41NTMsMCwxLTAuNDQ4LDEtMVMxNC41NTMsMTUsMTQsMTUiLz4KCTxwYXRoIGlkPSJYTUxJRF8xMTRfIiBzdHlsZT0iZmlsbDojRTRENkI2OyIgZD0iTTI4LDE2YzAtMC41NTItMC40NDctMS0xLTFoLTljLTAuNTUzLDAtMSwwLjQ0OC0xLDFzMC40NDcsMSwxLDFoOSAgIEMyNy41NTMsMTcsMjgsMTYuNTUyLDI4LDE2Ii8+Cgk8cGF0aCBpZD0iWE1MSURfMTEzXyIgc3R5bGU9ImZpbGw6I0U0RDZCNjsiIGQ9Ik02LDIwSDVjLTAuNTUzLDAtMSwwLjQ0OC0xLDFzMC40NDcsMSwxLDFoMWMwLjU1MywwLDEtMC40NDgsMS0xUzYuNTUzLDIwLDYsMjAiLz4KCTxwYXRoIGlkPSJYTUxJRF8xMTJfIiBzdHlsZT0iZmlsbDojRTRENkI2OyIgZD0iTTEyLDIwaC0yYy0wLjU1MywwLTEsMC40NDgtMSwxczAuNDQ3LDEsMSwxaDJjMC41NTMsMCwxLTAuNDQ4LDEtMVMxMi41NTMsMjAsMTIsMjAgICAiLz4KCTxwYXRoIGlkPSJYTUxJRF8xMTFfIiBzdHlsZT0iZmlsbDojRTRENkI2OyIgZD0iTTE3LDIwaC0xYy0wLjU1MywwLTEsMC40NDgtMSwxczAuNDQ3LDEsMSwxaDFjMC41NTMsMCwxLTAuNDQ4LDEtMVMxNy41NTMsMjAsMTcsMjAgICAiLz4KCTxwYXRoIGlkPSJYTUxJRF8xMTBfIiBzdHlsZT0iZmlsbDojRTRENkI2OyIgZD0iTTIzLDIwaC0yYy0wLjU1MywwLTEsMC40NDgtMSwxczAuNDQ3LDEsMSwxaDJjMC41NTMsMCwxLTAuNDQ4LDEtMVMyMy41NTMsMjAsMjMsMjAgICAiLz4KCTxwYXRoIGlkPSJYTUxJRF8xMDlfIiBzdHlsZT0iZmlsbDojRTRENkI2OyIgZD0iTTI2LjMsMjAuMjlDMjYuMTA5LDIwLjQ4LDI2LDIwLjczLDI2LDIxczAuMTA5LDAuNTIsMC4yOSwwLjcxICAgQzI2LjQ3OSwyMS44OSwyNi43NCwyMiwyNywyMmMwLjI2LDAsMC41MTktMC4xMSwwLjcxLTAuMjlDMjcuODksMjEuNTIsMjgsMjEuMjYsMjgsMjFjMC0wLjI2LTAuMTEtMC41Mi0wLjI5LTAuNyAgIEMyNy4zNCwxOS45MiwyNi42NiwxOS45MiwyNi4zLDIwLjI5Ii8+Cgk8cmVjdCBpZD0iWE1MSURfMTA4XyIgeD0iNSIgeT0iMzciIHN0eWxlPSJmaWxsOiM2NjUyNDg7IiB3aWR0aD0iOSIgaGVpZ2h0PSI2Ii8+Cgk8cmVjdCBpZD0iWE1MSURfMTA3XyIgeD0iMTgiIHk9IjM3IiBzdHlsZT0iZmlsbDojNjY1MjQ4OyIgd2lkdGg9IjkiIGhlaWdodD0iNiIvPgoJPHJlY3QgaWQ9IlhNTElEXzEwNl8iIHg9IjMxIiB5PSIzNyIgc3R5bGU9ImZpbGw6IzY2NTI0ODsiIHdpZHRoPSI5IiBoZWlnaHQ9IjYiLz4KCTxyZWN0IGlkPSJYTUxJRF8xMDVfIiB4PSI0NCIgeT0iMzciIHN0eWxlPSJmaWxsOiM2NjUyNDg7IiB3aWR0aD0iOSIgaGVpZ2h0PSI2Ii8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" width="32" height="32"/> <?php echo $payment_confirm_detail->getDataDesc('title', 'id = 1') ?></h1>
        <?php echo $payment_confirm_detail->getDataDesc('detail', 'id = 1') ?>
    </div>
    <div class="col-md-12">
        <form class="form-horizontal" id="myform" enctype="multipart/form-data"   method="POST" action="<?php echo ADDRESS ?>payment-confirm">
            <h4>
                ข้อมูลการโอนเงิน
            </h4>
            <div class="row">
                <div class="col-md-12"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">หมายเลขสั่งซื้อ <em>*</em></label>
                    <span>
                        <input type="text" class="form-control" id="order_id" name="order_id"  data-validation="required,number" value="<?= isset($_POST['order_id']) ? $_POST['order_id'] : ''?>">
                    </span> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">ชื่อ - สกุล <em>*</em></label>
                    <span>
                        <input type="text" class="form-control" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''?>" data-validation="required" >
                    </span> 
                </div>
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">เบอร์โทร <em>*</em></label>
                    <span>
                        <input type="text" class="form-control" name="tel" value="<?= isset($_POST['tel']) ? $_POST['tel'] : ''?>" data-validation="number,required">
                    </span> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">Email <em>*</em></label>
                    <span>
                        <input type="text" name="email" class="form-control" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''?>"  data-validation="required,email">
                    </span> 
                </div>
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">จำนวนเงินที่ชำระ <em>*</em></label>
                    <span> 
                        <input type="text" class="form-control" id="transfer_amount" value="<?= isset($_POST['transfer_amount']) ? $_POST['transfer_amount'] : ''?>" name="transfer_amount"  data-validation="required,number">
                    </span> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">วันที่โอน <em>*</em></label>
                    <span>
                        <input type="text" class="form-control" id="transfer_date" name="transfer_date" readonly="" data-validation="required" >
                    </span> 
                </div>
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <div class="col-md-6" style="padding-left: 0;">
                        <label for="inputHelpBlock">ชั่วโมงที่โอนเงิน <em>*</em></label>
                        <select class="form-control " id="transfer_hr" name="transfer_hr"  data-validation="required,number">
                            <option value="">-ชั่วโมง-</option>
                            <?php
                            for ($h = 0; $h < 24; $h++) {
                                echo "<option value=" . str_pad($h, 2, "0", STR_PAD_LEFT) . ">" . str_pad($h, 2, "0", STR_PAD_LEFT) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="padding-left: 0;">
                        <label for="inputHelpBlock">นาทีที่โอนเงิน <em>*</em></label>
                        <select class="form-control" id="transfer_min" name="transfer_min"  data-validation="required,number">
                            <option value="">-นาที-</option>
                            <?php
                            for ($m = 0; $m < 60; $m++) {
                                echo "<option value=" . str_pad($m, 2, "0", STR_PAD_LEFT) . ">" . str_pad($m, 2, "0", STR_PAD_LEFT) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <label for="inputHelpBlock">อัพโหลดรูปสลิป (ถ้ามี) <em></em></label>
                    <input type="file" class="form-control" name="file_array[]" id="file_array">
                </div>
                <div class="col-md-6"  style="padding-bottom:10px;">

                    <label for="inputHelpBlock">หมายเหตุ <em></em></label>
                    <textarea class="form-control" rows="3" name="comment"><?= isset($_POST['comment']) ? $_POST['comment'] : ''?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"  style="padding-bottom:10px;">
                    <div class="g-recaptcha" data-sitekey="6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="submit_bt" class="btn btn-success" name="submit_bt" value="บันทึกข้อมูล"><i class="fa fa-save"></i>&nbsp;บันทึกข้อมูล</button>
                </div>
            </div>
        </form>
    </div>
</div>


<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>

<script>
    $.validate();
    
</script>