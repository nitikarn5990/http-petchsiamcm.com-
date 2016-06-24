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

//    if ($arrData['ref'] != "") {
//
//        $arrData['distributor_name_ref'] = $functions->seoTitle($arrData['ref']);
//    } else {
//
//        $arrData['distributor_name_ref'] = $functions->seoTitle($arrData['distributor_name']);
//    }

    $distributor->SetValues($arrData);
    if ($distributor->GetPrimary() == '') {


        $distributor->SetValue('created_at', DATE_TIME);


        $distributor->SetValue('updated_at', DATE_TIME);
    } else {


        $distributor->SetValue('updated_at', DATE_TIME);
    }



    //	$distributor->Save();


    if ($distributor->Save()) {


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');




        if ($redirect) {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'distributor');


            die();
        } else {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'distributor&action=edit&id=' . $distributor->GetPrimary());


            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'del') {


    if ($distributor->DeleteMultiID($_GET['id'])) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'distributor');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {


    // For Update


    $distributor->SetPrimary((int) $_GET['id']);


    // Try to get the information


    if (!$distributor->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $distributor->ResetValues();
    }
}

//
if ($_GET['distributor_files_id'] != '') {


    // Get all the form data


    $arrDel = array('id' => $_GET['distributor_files_id']);


    $distributor->SetValues($arrDel);


    // Remove the info from the DB


    if ($distributor->Delete()) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'distributor&action=edit&id=' . $distributor->GetPrimary());

        die();
    } else {
        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
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
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($distributor->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($distributor->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> ตัวแทนจำหน่าย </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>distributor<?php echo ($distributor->GetPrimary() != '') ? '&id=' . $distributor->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($distributor->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $distributor->GetPrimary() ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $distributor->GetValue('created_at') ?>" />
                        <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อตัวแทนจำหน่าย <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="name" id="distributor_name" value="<?php echo ($distributor->GetPrimary() != '') ? $distributor->GetValue('name') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ที่อยู่<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="address" id="address" value="<?php echo ($distributor->GetPrimary() != '') ? $distributor->GetValue('address') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">เบอร์ติดต่อ<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="tel" id="tel" value="<?php echo ($distributor->GetPrimary() != '') ? $distributor->GetValue('tel') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">รายละเอียด <span class="required"></span></label>
                                <div class="da-form-item large">
                 
                                    <textarea name="detail" class="span12"><?php echo ($distributor->GetPrimary() != '') ? $distributor->GetValue('detail') : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="btn-row">
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                                <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>distributor" class="btn btn-danger">ยกเลิก</a> 
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }else { ?>
    <div class="row-fluid">
        <div class="span12">
            <?php
            // Report errors to the user

            Alert(GetAlert('error'));


            Alert(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> ตัวแทนจำหน่าย ทั้งหมด </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group"> <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL ?>distributor&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> <a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                        <thead>
                            <tr style="font-size: 12px;">
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>รหัส</th>
                                <th>ชื่อตัวแทนจำหน่าย</th>
                                <th>เบอร์ติดต่อ</th>
                                <th>แก้ไขล่าสุด</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . $distributor->getTbl();

                            $query = $db->Query($sql);
                            if ($db->NumRows($query) > 0) {

                                while ($row = $db->FetchArray($query)) {
                                    ?>
                                    <tr>
                                        <td class="center" width="5%" style="font-size: 12px;"><input type="checkbox" value="<?php echo $row['id']; ?>" id="chkboxID"></td>
                                        <td class="center" style="font-size: 12px;"><?php echo $row['id']; ?></td>
                                        <td style="font-size: 12px;"><?php echo $row['name']; ?></td>
                                        <td style="font-size: 12px;"><?php echo $row['tel']; ?></td>

                                        <td class="center" style="font-size: 12px;"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
                                        <td class="center" style="font-size: 12px;"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>distributor&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>distributor&action=del&id=<?php echo $row['id'] ?>'
                                                            }" class="btn btn-danger btn-small">ลบ</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>                  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("#checkAll").click(function (e) {
            $('input:checkbox').prop('checked', this.checked);
        });

        function multi_delete() {

            var msg_id = "";
            var res = "";

            $('input:checkbox[id^="chkboxID"]:checked').each(function () {


                msg_id += ',' + $(this).val();
                res = msg_id.substring(1);


            });
            if (res != '') {
                if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>distributor&action=del&id=' + res;
                }
            }


        }

    </script>
<?php } ?>
<script type="text/javascript">


//$( document ).ready(function() {


    function addfile() {


        $("#filecopy:first").clone().insertAfter("div #filecopy:last");


    }


    function delfile() {
        //$("#filecopy").clone().insertAfter("div #filecopy:last");
        var conveniancecount = $("div #filecopy").length;

        if (conveniancecount > 2) {
            $("div #filecopy:last").remove();

        }
    }


    $(document).ready(function () {

        // $('input:radio[name="distributors_file_name_cover"][value="<?php // echo $distributor->getDataDesc("distributors_file_name_cover", "id = '" . $_GET['id'] . "'");  ?>"]').prop('checked', true);

    });


</script> 
<script>


    $(function () {

        $("#activity_date").datepicker({dateFormat: "yy-mm-dd"}).val()


    });


</script>
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
