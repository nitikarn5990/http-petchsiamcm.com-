
<?php
if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {

//เช็ค ผู้แนำนะ


    if ($_POST['customer_refer_id'] != '') {
        if (substr($_POST['customer_refer_id'], 0, 4) == 'pcsc') {
            $customer_id = substr($_POST['customer_refer_id'], 4);

            if (is_numeric($customer_id)) {
                if ($customer->getDataDesc("id", "id = " . ($customer_id)) != "") {
                 
                } else {
                    SetAlert('ไม่พบข้อมูล ผู้แนะนำ กรุณาป้อนข้อมูลให้ถูกต้อง');
                    header('Location: ' . $_SERVER['REQUEST_URI']);

                    die();
                }
            } else {
                SetAlert('ไม่พบข้อมูล ผู้แนะนำ กรุณาป้อนข้อมูลให้ถูกต้อง');
                header('Location: ' . $_SERVER['REQUEST_URI']);

                die();
            }

       
        } else {

            // echo "no have2";
            //die();
            SetAlert('ไม่พบข้อมูล ผู้แนะนำ กรุณาป้อนข้อมูลให้ถูกต้อง');
            header('Location: ' . $_SERVER['REQUEST_URI']);

            die();
        }
    }




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

    $customer->SetValues($arrData);

    if ($customer->GetPrimary() == '') {

        $customer->SetValue('created_at', DATE_TIME);

        $customer->SetValue('updated_at', DATE_TIME);
    } else {

        $customer->SetValue('updated_at', DATE_TIME);
    }

    $customer->SetValue('login_password', $functions->encode_login($_POST['login_password']));

    $customer->SetValue('precode', 'pcsc');
    $customer->SetValue('customer_refer_id', $customer_id);
    

    if ($customer->Save()) {

        if (isset($_FILES['file_bank'])) {

            for ($i = 0; $i < count($_FILES['file_bank']['tmp_name']); $i++) {

                if ($_FILES["file_bank"]["name"][$i] != "") {

                    $targetPath = DIR_ROOT_IMG . "/";

                    $ext = explode(".", $_FILES['file_bank']['name'][$i]);
                    $extension = $ext[count($ext) - 1];
                    $rand = mt_rand(1, 100000);

                    $newImage = DATE_TIME_FILE . $rand . "." . $extension;
                    //  $newImage = DATE_TIME_FILE . $rand . $_FILES['file_bank']['name'][$i];
                    // echo $newImage;
                    // $newImage = DATE_TIME_FILE .".jpg";
                    $cdir = getcwd(); // Save the current directory

                    chdir($targetPath);

                    copy($_FILES['file_bank']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   

                    $customer->UpdateSQL(array('image_bank' => $newImage), array('id' => $customer->GetValue('id')));

                    $image_bank = 'success';
                }
            }
        }

        if (isset($_FILES['file_idcard'])) {

            for ($i = 0; $i < count($_FILES['file_idcard']['tmp_name']); $i++) {

                if ($_FILES["file_idcard"]["name"][$i] != "") {

                    $targetPath = DIR_ROOT_IMG . "/";

                    $ext = explode(".", $_FILES['file_idcard']['name'][$i]);
                    $extension = $ext[count($ext) - 1];
                    $rand = mt_rand(1, 100000);

                    $newImage = DATE_TIME_FILE . $rand . "." . $extension;
                    //  $newImage = DATE_TIME_FILE . $rand . $_FILES['file_bank']['name'][$i];
                    // echo $newImage;
                    // $newImage = DATE_TIME_FILE .".jpg";
                    $cdir = getcwd(); // Save the current directory

                    chdir($targetPath);

                    copy($_FILES['file_idcard']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   

                    $customer->UpdateSQL(array('image_idcard' => $newImage), array('id' => $customer->GetValue('id')));

                    $image_bank = 'success';
                }
            }
        }

        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

        if ($redirect) {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'customer');

            die();
        } else {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'customer&action=edit&id=' . $customer->GetPrimary());

            die();
        }
    } else {

        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'del') {


    // Get all the form data
    ///$arrDel = array('id' => $_GET['id']);
    //$customer->SetValues($arrDel);
    // Remove the info from the DB


    if ($customer->DeleteMultiID($_GET['id'])) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'customer');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {

    // For Update

    $customer->SetPrimary((int) $_GET['id']);

    // Try to get the information

    if (!$customer->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $customer->ResetValues();
    }
}
?>
<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>

    <div class="row-fluid">
        <div class="span12">
            <?php
            // Report errors to the user
            Alert2(GetAlert('error'));

            Alert2(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($customer->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($customer->GetPrimary() != '') ? 'แก้ไข' : '' ?> สมาชิก </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>customer<?php echo ($customer->GetPrimary() != '') ? '&action=edit&id=' . $customer->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($customer->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $customer->GetValue('id') ?>" />
                            <input type="hidden" name="image_idcard" value="<?php echo $customer->GetValue('image_idcard') ?>" />
                            <input type="hidden" name="image_bank" value="<?php echo $customer->GetValue('image_bank') ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $customer->GetValue('created_at') ?>" />
                        <?php endif; ?>
                        <div class="da-form-inline">
                            <fieldset>
                                <legend><b>ข้อมูลสมาชิก</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">รหัส <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="codeid" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('precode') . $customer->GetValue('id') : ''; ?>" class="span12 required" readonly="readonly"/>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อสมาชิก <span class="required">*</span></label>
                                <div class="da-form-item large ">
                                    <input type="text" name="customer_name" id="customer_name" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_name') : ''; ?>" class="span12 required" />
                                </div>

                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">นามสกุล <span class="required">*</span></label>
                                <div class="da-form-item large ">
                                    <input type="text" name="customer_lastname" id="customer_lastname" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_lastname') : ''; ?>" class="span12 required" />
                                </div>

                            </div>

                            <div class="da-form-row">
                                <label class="da-form-label">เบอร์โทร<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="customer_tel" id="customer_tel" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_tel') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">Email<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="customer_email" id="customer_email" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_email') : ''; ?>" class="span12 required email" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ที่อยู่ <span class="required">*</span></label>
                                <div class="da-form-item large">

                                    <textarea class="span12 required" name="customer_address"><?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_address') : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">จังหวัด <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="customer_province" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_province') : ''; ?>" class="span12 required" />
                                </div>
                            </div>

                            <div class="da-form-row">
                                <label class="da-form-label">รหัสไปรษณีย์ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="customer_zipcode" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('customer_zipcode') : ''; ?>" class="span12 required"/>
                                </div>
                            </div>
                            <fieldset>
                                <legend><b>ไฟล์สำเนาบัตรประชาชน</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">ไฟล์ที่อัพโหลด <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <?php if ($customer->GetValue('image_idcard') != '') { ?>
                                            <img src="<?= ADDRESS ?>img/<?= $customer->GetValue('image_idcard') ?>" class="span12">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ไฟล์แนบ <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="file" class="span12" name="file_idcard[]">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend><b>ไฟล์สำเนาหน้าสมุดบัญชี</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">ไฟล์ที่อัพโหลด <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <?php if ($customer->GetValue('image_bank') != '') { ?>
                                            <img src="<?= ADDRESS ?>img/<?= $customer->GetValue('image_bank') ?>" class="span12">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ไฟล์แนบ <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="file" class="span12" name="file_bank[]">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend><b>หน้าสมุดบัญชี</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">ชื่อธนาคาร <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <select name="bank_company" class="span12 required">
                                            <option value="">---- เลือก ----</option>
                                            <?php
                                            $sql = "SELECT * FROM " . $bank_company->getTbl() . " ORDER BY bank_name ";

                                            $query = $db->Query($sql);

                                            if ($db->NumRows($query) > 0) {
                                                ?>
                                                <?php while ($row = $db->FetchArray($query)) { ?>
                                                    <option value="<?= $row['bank_name'] ?>" <?= $customer->GetValue('bank_company') == $row['bank_name'] ? 'selected' : '' ?>><?= $row['bank_name'] ?></option>

                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ประเภทบัญชี <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <select name="bank_type_account" class="span12 required">
                                            <option value="">---- เลือก ----</option>
                                            <option value="เงินฝากออมทรัพย์"  <?= $customer->GetValue('bank_type_account') == 'เงินฝากออมทรัพย์' ? 'selected' : '' ?>>เงินฝากออมทรัพย์</option>
                                            <option value="เงินฝากประจำ" <?= $customer->GetValue('bank_type_account') == 'เงินฝากประจำ' ? 'selected' : '' ?>>เงินฝากประจำ</option>
                                            <option value="เงินฝากกระแสรายวัน" <?= $customer->GetValue('bank_type_account') == 'เงินฝากกระแสรายวัน' ? 'selected' : '' ?>>เงินฝากกระแสรายวัน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ชื่อบัญชี <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="bank_name" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('bank_name') : ''; ?>" class="span12 required" />
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">เลขบัญชี <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="bank_number" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('bank_number') : ''; ?>" class="span12 required" />
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">สาขา <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="bank_branch" id="" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('bank_branch') : ''; ?>" class="span12 required" />
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend><b>การเข้าสู่ระบบ</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">เข้าสู่ระบบล่าสุด<span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="last_login" id="last_login" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('last_login') : ''; ?>" class="span12 required" readonly="readonly"/>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend><b>สถานะ</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <ul class="da-form-list">
                                            <?php
                                            $getStatus = $customer->get_enum_values('status');

                                            $i = 1;

                                            foreach ($getStatus as $status) {
                                                ?>
                                                <li>
                                                    <input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($customer->GetPrimary() != "") ? ($customer->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
                                                    <label><?php echo $status ?></label>
                                                </li>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend><b>Refer (ผู้แนะนำ)</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">รหัสผู้แนะนำ <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <?php
                                        if ($customer->GetValue('customer_refer_id') != 0) {
                                            $customer_refer_id = $customer->getDataDesc("precode", "id=" . $customer->GetValue('customer_refer_id')) . $customer->getDataDesc("id", "id=" . $customer->GetValue('customer_refer_id'));
                                            $customer_refer_name = $customer->getDataDesc("customer_name", "id=" . $customer->GetValue('customer_refer_id')) . " " . $customer->getDataDesc("customer_lastname", "id=" . $customer->GetValue('customer_refer_id'));
                                        } else {
                                            $customer_refer_id = "";
                                            $customer_refer_name = "";
                                        }
                                        ?>
                                        <input type="text"  name="customer_refer_id" id="customer_refer_id" value="<?php echo $customer_refer_id ?>" class="span12" />
                                    </div>
                                     <label class="help-block">ถ้าไม่มีให้เป็นค่าว่าง</label>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ชื่อผู้แนะนำ <span class="required"></span></label>
                                    <div class="da-form-item large">
                                        <input type="text" disabled="" name="customer_refer_name" id="customer_refer_name" value="<?php echo $customer_refer_name; ?>" class="span12" />
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend><b>ข้อมูลเข้าสู่ระบบ</b></legend>
                                <div class="da-form-row">
                                    <label class="da-form-label">User name <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="login_email" id="login_email" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('login_email') : ''; ?>" class="span12 required" />
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Password<span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="login_password" id="login_password" value="<?php echo ($customer->GetPrimary() != '') ? $functions->decode_login($customer->GetValue('login_password')) : ''; ?>" class="span12 required" />
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" name="register_date" id="register_date" value="<?php echo ($customer->GetPrimary() != '') ? $customer->GetValue('register_date') : ''; ?>">
                        </div>
                        <div class="btn-row">
                            <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
                            <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                            <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>customer" class="btn btn-danger">ยกเลิก</a> </div>
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


            Alert2(GetAlert('error'));


            Alert2(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> สมาชิก ทั้งหมด </span> </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> 
                        </div>
                    </div>
                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                        <thead>
                            <tr style="font-size: 12px">
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>รหัสสมาชิก</th>
                                <th>ชื่อ</th>
                                <th>สถานะ</th>
                                <th>เข้าสู่ระบบล่าสุด</th>
                                <th>แก้ไขล่าสุด</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . $customer->getTbl();

                            $query = $db->Query($sql);

                            while ($row = $db->FetchArray($query)) {
                                ?>
                                <tr>
                                    <td class="center" width="5%" style="font-size: 12px"><input type="checkbox" value="<?php echo $row['id']; ?>" id="chkboxID"></td>
                                    <td class="center" style="font-size: 12px"><?php echo $row['precode'] . $row['id']; ?></td>
                                    <td style="font-size: 12px"><?php echo $row['customer_name'] . " " . $row['customer_lastname'] ?></td>
                                    <td class="center" style="font-size: 12px"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross' ?>" title="<?php echo $row['status'] ?>"></i></td>
                                    <td style="font-size: 12px"><?php echo $row['last_login']; ?></td>
                                    <td style="font-size: 12px"><?php echo $row['updated_at']; ?></td>
                                    <td class="center" style="font-size: 12px"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>customer&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>customer&action=del&id=<?php echo $row['id'] ?>'
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
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>customer&action=del&id=' + res;
                }
            }

        }

    </script>
<?php } ?>

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
        // alert(result);

        var url = '../ajax/province.php?select_id=' + select_id + '&result=' + result;
        //alert(url);

        xmlhttp = uzXmlHttp();
        xmlhttp.open("GET", url, false);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
        xmlhttp.send(null);
        console.log(xmlhttp.responseText);
        document.getElementById(result).innerHTML = xmlhttp.responseText;
    }
//window.onLoad=data_show(5,'amphur'); 
</script> 
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

        $('input:radio[name="products_file_name_cover"][value="<?php echo $customer->getDataDesc("products_file_name_cover", "id = '" . $_GET['id'] . "'"); ?>"]').prop('checked', true);

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

