<?php
// If they are saving the Information	





if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {


    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


        $redirect = true;
    } else {


        $redirect = false;
    }


    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);




    $social->SetValues($arrData);



//    if ($social->GetPrimary() == '') {
//
//
//        $social->SetValue('created_at', DATE_TIME);
//
//
//        $social->SetValue('updated_at', DATE_TIME);
//    } else {
//
//
//        $social->SetValue('updated_at', DATE_TIME);
//    }



    //	$social->Save();


    if ($social->Save()) {


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');


        if ($redirect) {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'social');


            die();
        } else {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'social&action=edit&id=' . $social->GetPrimary());


            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {


    // For Update


    $social->SetPrimary((int) $_GET['id']);


    // Try to get the information


    if (!$social->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $social->ResetValues();
    }
}
?>
<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>
    <div class="row-fluid">
        <div class="span12">
    <?php
    // Report errors to the user


    Alert(GetAlert('error'));


    Alert(GetAlert('success'), 'success');
    ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($social->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($social->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> Social </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>social<?php echo ($social->GetPrimary() != '') ? '&id=' . $social->GetPrimary() : ''; ?>" method="post" class="da-form">
    <?php if ($social->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $social->GetPrimary() ?>" />
                         
    <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label"><i class="fa fa-facebook-square fa-2x"></i> Facebook <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="facebook" id="" value="<?php echo ($social->GetPrimary() != '') ? $social->GetValue('facebook') : ''; ?>" class="span12 required" />
                                     <label class="help-block">ไม่ต้องใส่ https://</label>
                                </div>
                            </div>
                             <div class="da-form-row">
                                <label class="da-form-label"><i class="fa fa-twitter-square fa-2x"></i> Twitter <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="twitter" id="" value="<?php echo ($social->GetPrimary() != '') ? $social->GetValue('twitter') : ''; ?>" class="span12 required" />
                                    <label class="help-block">ไม่ต้องใส่ https://</label>
                                </div>
                            </div>

                        </div>
                        <div class="btn-row">

                            <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />

                    </form>
                </div>
            </div>
        </div>
    </div>
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
