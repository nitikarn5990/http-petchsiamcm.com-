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


    $ads->SetValues($arrData);



    if ($ads->GetPrimary() == '') {


        $ads->SetValue('created_at', DATE_TIME);


        $ads->SetValue('updated_at', DATE_TIME);
    } else {


        $ads->SetValue('updated_at', DATE_TIME);
    }



    if ($ads->Save()) {


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');


        //Redirect if needed



        if (isset($_FILES['file_array'])) {



            $Allfile = "";


            $Allfile_ref = "";

            //loop file array
            for ($i = 0; $i < count($_FILES['file_array']['tmp_name']); $i++) {


                if ($_FILES["file_array"]["name"][$i] != "") {


                    $targetPath = DIR_ROOT_ADS . "/";

                    $newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'][$i];

                    $cdir = getcwd(); // Save the current directory


                    chdir($targetPath);
                    copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);


                    chdir($cdir); // Restore the old working directory   
                    //$ads->SetValue('ads_file_name', $newImage);


                    $ads_files->SetValue('file_name', $newImage);


                    //	$ads_files->SetValue('alt_tag', $_POST['alt_tag']);	


                    $ads_files->SetValue('ads_id', $ads->GetPrimary());




                    //$product_files->Save();


                    if ($ads_files->Save()) {

                        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

                        //	$ads_files->ResetValues();
                    } else {


                        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                    }
                }
            }
        }

        $img_name = $ads_files->getDataDescLastID("file_name", "ads_id = " . $_GET['id']);
        $ads_file_id = $ads_files->getDataDesc("id", "file_name = '" . $img_name . "'");

        $arrOrder = array(
            'alt_tag' => $_POST['alt_tag'],
        );

        //	$pk_id =  $ads_files->GetPrimary() == '' ? $_GET['id'] : $ads_files->GetPrimary();
        $arrOrderID = array('id' => $ads_file_id);

        $ads_files->updateSQL($arrOrder, $arrOrderID);

        ////////


        if ($redirect) {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'ads');


            die();
        } else {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'ads&action=edit&id=' . $ads->GetPrimary());


            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'del') {


    // Get all the form data


    $arrDel = array('id' => $_GET['id']);


    $ads->SetValues($arrDel);

    // Remove the info from the DB


    if ($ads->Delete()) {
        /*
          if (unlink(DIR_ROOT_ADS . $ads->GetValue('ads_file_name'))) {

          //	fulldelete($location);

          SetAlert('Delete Data Success', 'success');
          } */

        // Set alert and redirect
        SetAlert('Delete Data Success', 'success');
        header('location:' . ADDRESS_ADMIN_CONTROL . 'ads');

        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}





if ($_GET['id'] != '' && $_GET['action'] == 'edit') {


    // For Update


    $ads->SetPrimary((int) $_GET['id']);


    // Try to get the information


    if (!$ads->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $ads->ResetValues();
    }
}
?>
<?php
if ($_GET['action'] == "add") {
    if ($ads->getNumRows() >= 2) {

        header('location:' . ADDRESS_ADMIN_CONTROL . 'ads');
        die();
    }
}
?>
<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>

    <div class="row-fluid">
        <div class="span12">
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($ads->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($ads->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> ภาพโฆษณา</span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>ads<?php echo ($ads->GetPrimary() != '') ? '&id=' . $ads->GetPrimary() : ''; ?>" method="post" class="da-form">
    <?php if ($ads->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $ads->GetPrimary() ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $ads->GetValue('created_at') ?>" />
    <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อภาพ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="ads_name" id="ads_name" value="<?php echo ($ads->GetPrimary() != '') ? $ads->GetValue('ads_name') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ไฟล์ที่อัพโหลด</label>
                                <div class="da-form-item large">
                                    <ul style=" list-style-type: none;" class="da-form-list">
                                        <ul>
                                            <li> <span class="">
    <?php if ($ads->GetPrimary() != '') { ?>
                                                        <img src="<?php echo ADDRESS_ADS . $ads_files->getDataDescLastID("file_name", "ads_id = " . $ads->GetPrimary()) ?>" style="max-width: 100%;" class="img-thumbnail">
    <?php } ?>
                                                </span> </li>
                                        </ul>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">อัพโหลดไฟล์</label>
                                <div class="da-form-item large" id="filecopy"> <span class="formNote"><strong>Alt tag</strong> </span>
                                    <input type="text" placeholder="" name="alt_tag" value="<?php echo $ads_files->getDataDescLastID("alt_tag", "ads_id = " . $ads->GetPrimary()) ?>" >
                                    <input type="file" name="file_array[]" id="image"  class="span4"/>
                                    <label class="da-form-label"> <span class="required">*</span>ขนาดรูปภาพแนะนำ 319x319</label>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ลิงค์ไปยัง </label>
                                <div class="da-form-item large">
                                    <select id="link_to" name="link_to" class="span12 select2">
                                        <option value=""></option>
    <?php
    //split string

    $link_to = $ads->getDataDescLastID("link_to", "id = " . $ads->GetPrimary());
    $arr_link_to = explode("-", $link_to);
    ?>
    <?php
    $sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";


    $query = $db->Query($sql);
    while ($row = $db->FetchArray($query)) {

        if ($arr_link_to[0] == 'category') {
            ?>
                                                <option <?php echo $row['id'] == $arr_link_to[1] ? ' selected="selected"' : ''; ?> value="<?php echo "category" . "-" . $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo "category" . "-" . $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                            <?php }
                                            ?>
                                            <?php
                                            $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' AND category_id = " . $row['id'] . "";
                                            $query2 = $db->Query($sql2);
                                            while ($row2 = $db->FetchArray($query2)) {
                                                if ($arr_link_to[0] == 'product') {
                                                    ?>
                                                    <option <?php echo $row2['id'] == $arr_link_to[1] ? ' selected="selected"' : ''; ?> value="<?php echo "product" . "-" . $row2['id'] ?>"> ---- <?php echo $row2['product_name'] ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo "product" . "-" . $row2['id'] ?>"> ---- <?php echo $row2['product_name'] ?></option>
                                                <?php } ?>

                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">จัดลำดับ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="number" name="sort" id="sort" value="<?php echo ($ads->GetPrimary() != '') ? $ads->GetValue('sort') : '0'; ?>" class="span12" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <ul class="da-form-list">
    <?php
    $getStatus = $ads->get_enum_values('status');


    $i = 1;


    foreach ($getStatus as $status) {
        ?>
                                            <li>
                                                <input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($ads->GetPrimary() != "") ? ($ads->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
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
                            <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>ads" class="btn btn-danger">ยกเลิก</a> </div>
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
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> รูปภาพ ทั้งหมด </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group"> <a class="btn" href="<?php echo ADDRESS_ADMIN_CONTROL ?>ads&action=add"><i class="icol-add"></i> เพิ่มข้อมูล</a> </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="0" order="asc" width="1000">
                        <thead>
                            <tr>
                                <th >รหัส</th>
                                <th>ชื่อภาพ</th>
                                <th>ภาพ</th>
                                <th>สถานะ</th>
                                <th>แก้ไขล่าสุด</th>
                                <th>ลำดับ</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    $sql = "SELECT * FROM " . $ads->getTbl() . " WHERE status = 'ใช้งาน' ORDER BY sort ASC";


    $query = $db->Query($sql);


    while ($row = $db->FetchArray($query)) {
        ?>
                                <tr>
                                    <td class="center" width="15"><?php echo $row['id']; ?></td>
                                    <td  width=""><?php echo $row['ads_name']; ?></td>
                                    <td class="center"  width="" style=""><img src="<?php echo  $ads_files->getDataDescLastID("file_name", "ads_id = '" . $row['id'] . "'") == "" ? NO_IMAGE : ADDRESS_ADS . $ads_files->getDataDescLastID("file_name", "ads_id = '" . $row['id'] . "'") ?>" style="height:70px; width:150px;"></td>
                                    
                                    <td class="center" width=""><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross' ?>" title="<?php echo $row['status'] ?>"></i></td>
                                    <td class="center" width=""><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
                                    <td class="center" width=""><?php echo $row['sort']; ?></td>
                                    <td class="center"  width=""><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>ads&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a>
                                     
                                                        </td>
                                </tr>
    <?php } ?>
                        </tbody>
                    </table>
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
