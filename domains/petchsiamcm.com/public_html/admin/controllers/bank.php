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

    if ($arrData['ref'] != "") {

        $arrData['bank_name_ref'] = $functions->seoTitle($arrData['ref']);
    } else {

        $arrData['bank_name_ref'] = $functions->seoTitle($arrData['bank_name']);
    }

    $bank->SetValues($arrData);
    if ($bank->GetPrimary() == '') {


        $bank->SetValue('created_at', DATE_TIME);


        $bank->SetValue('updated_at', DATE_TIME);
    } else {


        $bank->SetValue('updated_at', DATE_TIME);
    }

    if ($bank->Save()) {


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

        //Save Image
        if (isset($_FILES['file_array'])) {


            $Allfile = "";


            $Allfile_ref = "";


            for ($i = 0; $i < count($_FILES['file_array']['tmp_name']); $i++) {

                if ($_FILES["file_array"]["name"][$i] != "") {

                    $targetPath = DIR_ROOT_GALLERY . "/";
                    $newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'][$i];

                    $cdir = getcwd(); // Save the current directory

                    chdir($targetPath);

                    copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   


                    if ($bank->UpdateSQL(["image" => $newImage], ["id" => $bank->GetValue('id')])) {
                        
                    } else {

                        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                    }
                }
            }
        }

        if ($redirect) {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'bank');

            die();
        } else {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'bank&action=edit&id=' . $bank->GetPrimary());
            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'del') {


    if ($bank->DeleteMultiID($_GET['id'])) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'bank');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {


    // For Update


    $bank->SetPrimary((int) $_GET['id']);


    // Try to get the information


    if (!$bank->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $bank->ResetValues();
    }
}

//
if ($_GET['bank_files_id'] != '') {


    // Get all the form data


    $arrDel = array('id' => $_GET['bank_files_id']);


    $bank->SetValues($arrDel);


    // Remove the info from the DB


    if ($bank->Delete()) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'bank&action=edit&id=' . $bank->GetPrimary());

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
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($bank->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($bank->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> ธนาคาร </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>bank<?php echo ($bank->GetPrimary() != '') ? '&id=' . $bank->GetPrimary() : ''; ?>" method="post" class="da-form">
    <?php if ($bank->GetPrimary() != ''): ?>
                         <input type="hidden" name="image" value="<?php echo $bank->GetValue('image') ?>" />
                            <input type="hidden" name="id" value="<?php echo $bank->GetPrimary() ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $bank->GetValue('created_at') ?>" />
    <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อบัญชี <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="bank_name" id="bank_name" value="<?php echo ($bank->GetPrimary() != '') ? $bank->GetValue('bank_name') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อธนาคาร <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <select id="bank_id" name="bank_id" class="span12 select2 required">
                                        <option value=""></option>
    <?php $bank_company->CreateDataList("id", "bank_name", "status='ใช้งาน'", ($bank->GetPrimary() != "") ? $bank->GetValue('bank_id') : "") ?>
                                    </select>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">เลขที่บัญชี <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="bank_number" id="bank_cost" value="<?php echo ($bank->GetPrimary() != '') ? $bank->GetValue('bank_number') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">สาขา <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="bank_branch" id="bank_branch" value="<?php echo ($bank->GetPrimary() != '') ? $bank->GetValue('bank_branch') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ภาพที่อัพโหลด</label>
                                <div class="da-form-item large" id="filecopy">
                                    <?php 
                                if ($bank->GetPrimary() != '') {
                                    if ($bank->GetValue('image') != '') { ?>
                                          <img src="<?=ADDRESS_GALLERY . $bank->GetValue('image')?>">
                                <?php  } ?>
                              <?php  }   ?>
                                  
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">อัพโหลดภาพ</label>
                                <div class="da-form-item large" id="filecopy">
                                    <input type="file" name="file_array[]" id="image"  class="span4"/>

                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <ul class="da-form-list">
    <?php
    $getStatus = $bank->get_enum_values('status');


    $i = 1;


    foreach ($getStatus as $status) {
        ?>
                                            <li>
                                                <input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($bank->GetPrimary() != "") ? ($bank->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
                                                <label><?php echo $status ?></label>
                                            </li>
        <?php $i++;
    } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-row">
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                                <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>bank" class="btn btn-danger">ยกเลิก</a> </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row-fluid">
        <div class="span12">
    <?php
    // Report errors to the user


    Alert(GetAlert('error'));


    Alert(GetAlert('success'), 'success');
    ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> ธนาคาร ทั้งหมด </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group"> <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL ?>bank&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> <a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                        <thead>
                            <tr style="font-size: 12px;">
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>รหัส</th>
                                <th>ชื่อบัญชี</th>
                                <th>ธนาคาร</th>
                                <th>สถานะ</th>
                                <th>แก้ไขล่าสุด</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    $sql = "SELECT * FROM " . $bank->getTbl();


    $query = $db->Query($sql);


    while ($row = $db->FetchArray($query)) {
        ?>
                                <tr>
                                    <td class="center" width="5%" style="font-size: 12px;"><input type="checkbox" value="<?php echo $row['id']; ?>" id="chkboxID"></td>
                                    <td class="center" style="font-size: 12px;"><?php echo $row['id']; ?></td>
                                    <td style="font-size: 12px;"><?php echo $row['bank_name']; ?></td>
                                    <td style="font-size: 12px;text-align: center;"><?php echo $bank_company->getDataDesc('bank_name', 'id = ' . $row['bank_id']); ?></td>
                                    <td class="center" style="font-size: 12px;"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross' ?>" title="<?php echo $row['status'] ?>"></i></td>
                                    <td class="center" style="font-size: 12px;"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
                                    <td class="center" style="font-size: 12px;"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>bank&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>bank&action=del&id=<?php echo $row['id'] ?>'
                                                        }" class="btn btn-danger btn-small">ลบ</a></td>
                                </tr>
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
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>bank&action=del&id=' + res;
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





        $('input:radio[name="banks_file_name_cover"][value="<?php echo $bank->getDataDesc("banks_file_name_cover", "id = '" . $_GET['id'] . "'"); ?>"]').prop('checked', true);





    });





//});





</script> 
<script>


    $(function () {


        // $( "#datepicker" ).datepicker();


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
