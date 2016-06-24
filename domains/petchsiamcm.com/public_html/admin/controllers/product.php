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

        $arrData['product_name_ref'] = $functions->seoTitle($arrData['ref']);
    } else {

        $arrData['product_name_ref'] = $functions->seoTitle($arrData['product_name']);
    }

    $products->SetValues($arrData);

    if ($products->GetPrimary() == '') {


        $products->SetValue('created_at', DATE_TIME);


        $products->SetValue('updated_at', DATE_TIME);
    } else {


        $products->SetValue('updated_at', DATE_TIME);
    }
   // $products->SetValue('alt', 'ss');

    if ($products->Save()) {


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');


        //Redirect if needed
        if (isset($_FILES['file_array'])) {


            $Allfile = "";


            $Allfile_ref = "";


            for ($i = 0; $i < count($_FILES['file_array']['tmp_name']); $i++) {

                if ($_FILES["file_array"]["name"][$i] != "") {


                    $targetPath = DIR_ROOT_GALLERY . "/";

                    $ext = explode(".", $_FILES['file_array']['name'][$i]);
                    $extension = $ext[count($ext) - 1];
                    $rand = mt_rand(1, 100000);

                    $newImage = DATE_TIME_FILE . $rand . "." . $extension;
                    //  $newImage = DATE_TIME_FILE . $rand . $_FILES['file_array']['name'][$i];
                    // echo $newImage;
                    // $newImage = DATE_TIME_FILE .".jpg";
                    $cdir = getcwd(); // Save the current directory


                    chdir($targetPath);

                    copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   

                    $products->UpdateSQL(array('image' => $newImage), array('id' => $products->GetPrimary()));

//                    $product_files->SetValue('file_name', $newImage);
//                    if ($_POST['alt_tag'][$i] == '') {
//
//                        $product_files->SetValue('alt_tag', $newImage);
//                    } else {
//
//                        $product_files->SetValue('alt_tag', $functions->seoTitle($_POST['alt_tag'][$i]));
//                    }
//                    $product_files->SetValue('product_id', $products->GetPrimary());
//
//                    if ($product_files->Save()) {
//                        $product_files->ResetValues();
//                    } else {
//
//                        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
//                    }
                }
            }


//            if ($_POST['products_file_name_cover'] == '') {
//
//
//                $arrOrder = array(
//                    'products_file_name_cover' => $product_files->getDataDesc("file_name", "product_id = '" . $products->GetPrimary() . "' ORDER BY id ASC LIMIT 0,1"),
//                    'updated_at' => DATE_TIME
//                );
//
//
//                $arrOrderID = array('id' => $products->GetPrimary());
//
//
//                $products->updateSQL($arrOrder, $arrOrderID);
//            }
        }


        ////////

        if ($redirect) {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'product');


            die();
        } else {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'product&action=edit&id=' . $products->GetPrimary());


            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}




// If Deleting the Page


if ($_GET['id'] != '' && $_GET['action'] == 'del') {

    if ($products->DeleteMultiID($_GET['id'])) {

        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'product');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {

    // For Update
    $products->SetPrimary((int) $_GET['id']);


    // Try to get the information


    if (!$products->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $products->ResetValues();
    }
}

//


if ($_GET['product_files_id'] != '' && $_GET['action'] == 'edit') {


    $product_files->SetPrimary((int) $_GET['product_files_id']);

    if ($product_files->Delete()) {

        if (unlink(DIR_ROOT_GALLERY . $product_files->GetValue('file_name'))) {

            // SetAlert('Delete Data Success', 'success');
        }

        header('location:' . ADDRESS_ADMIN_CONTROL . 'product&action=edit&id=' . $products->GetPrimary());

        die();
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
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($products->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($products->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> สินค้า </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>product<?php echo ($products->GetPrimary() != '') ? '&id=' . $products->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($products->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $products->GetPrimary() ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $products->GetValue('created_at') ?>" />
                            <input type="hidden" name="image" value="<?php echo $products->GetValue('image') ?>" />
                        <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อสินค้า <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="product_name" id="product_name" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_name') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อใช้อ้างอิง / URL</label>
                                <div class="da-form-item large">
                                    <input type="text" name="ref" id="ref" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_name_ref') : ''; ?>" class="span12" />
                                    <label class="help-block">ว่างไว้ถ้าต้องการให้สร้างชื่ออ้างอิงอัตโนมัติ</label>
                                </div>
                            </div>

                            <div class="da-form-row">
                                <label class="da-form-label">รายละเอียด<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <textarea name="product_detail" id="product_detail" class="span12 tinymce required"><?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_detail') : ''; ?></textarea>
                                    <label for="product_detail" generated="true" class="error" style="display:none;"></label>
                                </div>
                            </div>


                            <div class="da-form-row">
                                <label class="da-form-label">ราคาทั่วไป (บาท)<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="number" name="product_cost" id="product_cost" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_cost') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ราคาสมาชิก (บาท)<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="number" name="product_member_cost" id="product_member_cost" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_member_cost') : ''; ?>" class="span12 required" />
                                </div>
                            </div>


                            <div style="visibility:hidden;">
                                <div class="da-form-item large" id="filecopy">
                                    <?php if ($webs_money->GetValue('webs_money_image') != "") { ?>
                                        <div class="img-block" style="margin-bottom:10px"> <img src="<?php echo DIR_ADMIN_IMAGES . $webs_money->GetValue('webs_money_image') ?>" /> </div>
                                    <?php } ?>
                                    <span class="formNote"><strong>Alt Tag</strong> </span>
                                   
                                    <input type="file" name="file_array[]" id="image"  class="span4" />
                                    <a href="javascript:addfile();" >เพิ่ม</a> <a href="javascript:delfile();" >ลบ</a>
                                    <label class="help-block">ไฟล์เอกสาร</label>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ไฟล์ที่อัพโหลด</label>
                                <div class="da-form-item large">
                                    <ul style=" list-style-type: none;" class="da-form-list">
                                        <?php
                                        if ($products->GetPrimary() != '' && $products->GetValue('image') != '') {
                                            ?>
                                            <ul>
                                                <li> 
                                                    <img src="../files/gallery/<?= $products->GetValue('image') ?>" style="max-width: 200px;">

                                                </li>
                                            </ul>
                                        <?php } ?>
                                        <label class="help-block"></label>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">อัพโหลดไฟล์</label>
                                <div class="da-form-item large" id="filecopy"> <span class="formNote"><strong>Alt Tag</strong> </span>
                                    <input type="text" placeholder="" name="alt" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('alt') : ''; ?>">
                                    <input type="file" name="file_array[]" id="image"  class="span4"/>
                                    <span class="hidden">
                                        <a href="javascript:addfile();" >เพิ่ม</a> <a href="javascript:delfile();" >ลบ</a>
                                        <label class="help-block">ไฟล์เอกสาร</label>
                                    </span>
                                </div>
                            </div>

                            <div class="da-form-row">
                                <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <ul class="da-form-list">
                                        <?php
                                        $getStatus = $products->get_enum_values('status');


                                        $i = 1;


                                        foreach ($getStatus as $status) {
                                            ?>
                                            <li>
                                                <input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($products->GetPrimary() != "") ? ($products->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
                                                <label><?php echo $status ?></label>
                                            </li>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="btn-row">
                            <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
                            <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                            <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product" class="btn btn-danger">ยกเลิก</a> </div>
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
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> สินค้า ทั้งหมด </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group"> 
                            <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> 
                            <a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> ลบ</a> 
                        </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>รหัส</th>
                                <th>ชื่อสินค้า</th>
                                <th>ภาพสินค้า</th>
                                <th>สถานะ</th>
                                <th>แก้ไขล่าสุด</th>

                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . $products->getTbl();

                            $query = $db->Query($sql);

                            while ($row = $db->FetchArray($query)) {
                                ?>
                                <tr>
                                    <td class="center" width="5%"><input type="checkbox" value="<?php echo $row['id']; ?>" id="chkboxID"></td>
                                    <td class="center"><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>

                                    <td class="center"><img src="<?php echo ADDRESS_GALLERY .  $row['image'];?>" style="height:70px; width:70px;"></td>

                                    <td class="center"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross' ?>" title="<?php echo $row['status'] ?>"></i></td>
                                    <td class="center"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>

                                    <td class="center"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                        document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=del&id=<?php echo $row['id'] ?>'
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
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=del&id=' + res;
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

        $('input:radio[name="products_file_name_cover"][value="<?php echo $products->getDataDesc("products_file_name_cover", "id = '" . $_GET['id'] . "'"); ?>"]').prop('checked', true);

    });

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
