<?php
// If they are saving the Information	




if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {


    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


        $redirect = true;
    } else {


        $redirect = false;
    }



    if ($functions->encode_login($_POST['now_password']) == $users->getDataDesc("password", "id = 1")) {
        $arrConfirm = array(
            'password' => $functions->encode_login($_POST['confirm_password']),
            'user_groups_id' => 1,
            'updated_at' => DATE_TIME
        );

        $arrConID = array('id' => $_POST['id']);


        if ($users->updateSQL($arrConfirm, $arrConID)) {


            SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');
			


            if ($redirect) {


                header('location:' . ADDRESS_ADMIN_CONTROL . 'profile');

                die();
            } else {


                header('location:' . ADDRESS_ADMIN_CONTROL . 'profile&action=edit&id=' . $users->GetPrimary());
                die();
            }
        } 
		else {


            SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
        }
    } 
	
	else {
        echo "<script>alert('รหัมผ่านเดิมไม่ถูกต้อง')</script>";
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {

    // For Update

    $users->SetPrimary((int) $_GET['id']);

    if (!$users->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $users->ResetValues();
    }
}
?>

<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>
    <div class="row-fluid">
        <div class="span12">
               <?php


			// Report errors to the user


			Alert(GetAlert('error'));


			Alert(GetAlert('success'),'success');


		?>

            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-application-edit"></i> เปลี่ยนรหัสผ่าน </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate"  enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>profile&action=edit<?php echo ($users->GetPrimary() != '') ? '&id=' . $users->GetPrimary() : ''; ?>" method="post" class="da-form">
    <?php if ($users->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $users->GetPrimary() ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $users->GetValue('created_at') ?>" />
    <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">รหัสผ่านเดิม<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="password" name="now_password" id="now_password" class="span12 required"  minlength="6">
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">รหัสผ่านใหม่<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="password" name="new_password" id="new_password"  class="span12 required" minlength="6">
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ยืนยันรหัสผ่านใหม่<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="password" name="confirm_password" id="confirm_password"  class="span12 required" minlength="6">
                                </div>
                            </div>

                        </div>
                        <div class="btn-row">

                            <input type="submit" name="submit_bt" id="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" onclick="return checkpassword()" />

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        function checkpassword() {
            var now_password = $("#now_password").val();
            var password = $("#new_password").val();
            var confirmPassword = $("#confirm_password").val();



            if (password == confirmPassword) {
                return true;

            } else {
                alert('รหัสผ่านไม่ตรงกัน');
                $("#new_password").focus();
                return false;
            }




        }
    </script>
<?php } ?>


<style>


    /*Colored Label Attributes*/


    .label {


        background-color: #BFBFBF;


        border-bottom-left-radius: 3px;


        border-bottom-right-radius: 3px;


        border-top-left-radius: 3px;


        border-top-right-radius: 3px;


        color: #FFFFFF;


        font-size: 9.75px;


        font-weight: bold;


        padding-bottom: 2px;


        padding-left: 4px;


        padding-right: 4px;


        padding-top: 2px;


        text-transform: uppercase;


        white-space: nowrap;


    }





    .label:hover {


        opacity: 80;


    }





    .label.success {


        background-color: #46A546;


    }


    .label.success2 {


        background-color: #CCC;


    }


    .label.success3 {


        background-color: #61a4e4;





    }





    .label.warning {


        background-color: #FC9207;


    }





    .label.failure {


        background-color: #D32B26;


    }





    .label.alert {


        background-color: #33BFF7;


    }





    .label.good-job {


        background-color: #9C41C6;


    }



</style>
