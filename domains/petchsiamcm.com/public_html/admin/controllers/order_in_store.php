
<?php
if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {


    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {

        $redirect = true;
    } else {

        $redirect = false;
    }

    if ($_POST['order_in_store_id'] != '') {

    
        //แก้ไข PO
       // $status = $_POST['switch1'] == 'on' ? 'open' : 'closed';

        $arrDataPo = array(
            "id" => $_POST['order_in_store_id'],
            "created_at" => DATE_TIME,
            "updated_at" => DATE_TIME,
            "order_date" => $_POST['order_date'],
         //   "status" => $status
        );
        //$functions->Insert("order_in_store", $arrDataPo);
        
       // $order_in_store->SetValues($arrDataPo);

        if ($order_in_store->UpdateSQL($arrDataPo,["id" => $_POST['order_in_store_id']])) {

            //แก้ไข รายละเอียดการสั่งซื้อ
            if (count($_POST["product_id"]) > 0) {

                foreach ($_POST["product_id"] as $key => $p_ids) {
                    $arrDataDetail = array(
                        "id" => $_POST["order_in_store_detail_id"][$key],
                        "order_in_store_id" => $_POST['order_in_store_id'],
                        "product_id" => $p_ids,
                        // "distributor_id" => $_POST["distributor_id"][$key],
                        "qty" => $_POST["qty"][$key],
                        "cost" => $_POST["cost"][$key],
                        "created_at" => DATE_TIME,
                        "updated_at" => DATE_TIME,
                        "comment" => $_POST["comment"][$key]
                    );
                    $order_in_store_detail->SetValues($arrDataDetail);
                    $order_in_store_detail->Save();
                }
            }
        }
    } else {


        //บันทึก PO
        $arrDataPo = array(
            "created_at" => DATE_TIME,
            "updated_at" => DATE_TIME,
            "order_date" => $_POST['order_date'],
            "status" => 'open'
        );
        //$functions->Insert("order_in_store", $arrDataPo);
        $order_in_store->SetValues($arrDataPo);

        if ($order_in_store->Save()) {
            //บันทึก รายละเอียดการสั่งซื้อ
            foreach ($_POST["product_id"] as $key => $p_ids) {
                $arrDataDetail = array(
                    "order_in_store_id" => $order_in_store->GetValue('id'),
                    "product_id" => $p_ids,
                    //     "distributor_id" => $_POST["distributor_id"][$key],
                    "qty" => $_POST["qty"][$key],
                    "created_at" => DATE_TIME,
                    "updated_at" => DATE_TIME,
                    "comment" => $_POST["comment"][$key]
                );
                $order_in_store_detail->SetValues($arrDataDetail);
                $order_in_store_detail->Save();
            }
            header('location:' . ADDRESS_ADMIN_CONTROL . 'order_in_store&type=po');

            die();
        }
    }
}


// If Deleting the Page

if ($_GET['action'] == 'del' && $_GET['del_id'] != '') {

    if ($order_in_store->DeleteMultiID($_GET['del_id'])) {

        // Set alert and redirect
        SetAlert('Delete Data Success', 'success');

        header('location:' . ADDRESS_ADMIN_CONTROL . 'order_in_store&type=po');

        die();
    } else {

        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}
if ($_GET['type'] == 'po' && $_GET['po_id'] != '' && $_GET['action'] == 'del') {

    if ($order_in_store->DeleteMultiID($_GET['po_id'])) {

        // Set alert and redirect
        SetAlert('Delete Data Success', 'success');

        header('location:' . ADDRESS_ADMIN_CONTROL . 'order_in_store&type=po');


        die();
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {

    // For Update
    $order_in_store->SetPrimary((int) $_GET['id']);

    // Try to get the information

    if (!$order_in_store->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $order_in_store->ResetValues();
    }
}
?>
<?php if ($_GET['type'] == 'po') { ?>
    <?php if ($_GET['action'] == 'edit' && $_GET['id'] != '') { ?>
        <div class="row-fluid">
            <div class="span12">
                <?php
                // Report errors to the user
                Alert(GetAlert('error'));

                Alert(GetAlert('success'), 'success');
                ?>
                <div class="da-panel collapsible">
                    <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-add"></i>  ข้อมูลการสั่งซื้อสินค้าเข้าร้าน </span> </div>
                    <div class="da-panel-content da-form-container">
                        <form enctype="multipart/form-data" action="" method="post" class="da-form">
                            <input type="hidden" name="submit_bt" value="บันทึกข้อมูล">
                            <input type="hidden" name="order_in_store_id" value="<?= $order_in_store->GetValue('id') ?>">
                            <div class="da-form-inline">

                                <fieldset>
                                    <legend><b>สถานะ PO</b></legend>
                                    <div class="da-form-row">
                                        <label class="da-form-label">สถานะ</label>
                                        <div class="da-form-item large">
                                            <input type="checkbox"  id="on-off-switch" name="<?=$order_in_store->GetValue('id')?>" <?= $order_in_store->GetValue('status') == 'open' ? 'checked' : '' ?>>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend><b>สถานะ PO</b></legend>
                                    <div class="da-form-row">

                                        <label class="da-form-label">หมายเลข PO</label>
                                        <div class="da-form-item large">
                                            PO<?= $order_in_store->GetValue('id') ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend><b>หมายเลข PO</b></legend>
                                    <div class="da-form-row">

                                        <label class="da-form-label">หมายเลข PO</label>
                                        <div class="da-form-item large">
                                            PO<?= $order_in_store->GetValue('id') ?>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend><b>วันที่ทำการสั่งซื้อ</b></legend>
                                    <div class="da-form-row">
                                        <label class="da-form-label">วันที่ทำการสั่งซื้อ <span class="required">*</span></label>
                                        <div class="da-form-item large">
                                            <input type="text" name="order_date" id="order_date" value="<?= $order_in_store->GetValue('order_date') ?>" class="span12" data-validate="required" readonly="readonly"/>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend><b>รายละเอียดในการสั่งซื้อ</b></legend>

                                    <div class="da-form-row ">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 2%;">รหัสสินค้า</th>
                                                    <th class="text-center" style="width: 5%;">ชื่อสินค้า</th>
                                                    <th class="text-center" style="width: 5%;">ตัวแทนจำหน่าย </th>
                                                    <th class="text-center" style="width: 1%;">จำนวนปัจจุบัน </th>
                                                    <th class="text-center" style="width: 1%;">จำนวนที่สั่ง <span style="color: red;">*</span></th>
                                                    <th class="text-center" style="width: 1%;">ราคา/หน่วย </th>
                                                    <th class="text-center" style="width: 1%;">รวม </th>
                                                    <th class="text-center" style="width: 5%;">หมายเหตุ</th>
                                                    <th class="text-center" style="width: 5%;">ตัวเลือก</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql2 = "SELECT * FROM " . $order_in_store_detail->getTbl() . " WHERE order_in_store_id = " . $_GET['id'];

                                                $query2 = $db->Query($sql2);
                                                $total = 0;
                                                if ($db->NumRows($query2) > 0) {

                                                    while ($row2 = $db->FetchArray($query2)) {

                                                        $distributor_id = $products->getDataDesc('distributor_id', 'id = ' . $row2['product_id']);
                                                        $product_distributors_cost = $products->getDataDesc('product_distributors_cost', 'id = ' . $row2['product_id']);
                                                        $total = $total + ($product_distributors_cost * $row2['qty']);
                                                        ?>
                                                        <tr>
                                                    <input type="hidden" name="order_in_store_detail_id[]" value="<?= $row2['id']; ?>">
                                                    <input type="hidden" name="product_id[]" value="<?= $row2['product_id']; ?>">
                                                    <input type="hidden" name="cost[]" value="<?= $product_distributors_cost ?>">
                                                    <td class="text-center display-middle"><?= $row2['product_id']; ?></td>
                                                    <td class="text-center display-middle"><?= $products->getDataDesc('product_name', 'id = ' . $row2['product_id']); ?></td>
                                                    <td class="text-center display-middle">
                                                        <?= $distributor->getDataDesc('name', 'id = ' . $distributor_id); ?>
                                                    </td>
                                                    <td class="text-center display-middle"><?= $products->getDataDesc('qty', 'id = ' . $row2['product_id']) ?></td>
                                                    <td class="text-center display-middle"><input type="text" name="qty[]" class="text-center" value="<?= $row2['qty']; ?>" data-validate="required,number"><span style="color: red;"></span></td>
                                                    <td class="text-center display-middle">
                                                        <?= $product_distributors_cost ?>
                                                    </td>
                                                    <td class="text-center display-middle">
                                                        <?= ($product_distributors_cost * $row2['qty']) ?>
                                                    </td>
                                                    <td class="display-middle"><textarea name="comment[]" class="span12"><?= $row2['comment']; ?></textarea></td>
                                                    <td class="text-center display-middle">
                                                        <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store&type=po&id=<?php echo $row2['order_in_store_id'] ?>&action=del&del_id=<?php echo $row2['id'] ?>'
                                                                                            }" class="btn btn-danger btn-small">ลบ</a>
                                                    </td>
                                                    </tr>

                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="9" class="text-center display-middle">ไม่พบข้อมูล</td>
                                                </tr>   
                                            <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>

                                </fieldset>
                                <fieldset>
                                    <legend><b>จำนวนเงินรวมทั้งสิ้น</b></legend>
                                    <div class="da-form-row">
                                        <label class="da-form-label">รวมทั้งสิ้น <span class="required">*</span></label>
                                        <div class="da-form-item large">
                                            <?= $total ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บาท
                                        </div>
                                    </div>
                                </fieldset>

                            </div>

                            <div class="btn-row">
                                <button type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" >บันทึกข้อมูล</button>

                                <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store&type=po" class="btn btn-danger">ยกเลิก</a> 
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    <?php } else { ?>
        <!-- แสดง PO ทั้งหมด-->
        <div class="row-fluid">
            <div class="span12">
                <?php
                // Report errors to the user


                Alert(GetAlert('error'));


                Alert(GetAlert('success'), 'success');
                ?>
                <form method="POST" action="">
                    <div class="da-panel collapsible">
                        <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> รายการสั่งซื้อสินค้าเข้าร้าน ทั้งหมด </span> </div>
                        <div class="da-panel-toolbar ">
                            <div class="btn-toolbar">
                                <div class="btn-group"> 

                                    <button type="submit" class="btn hidden" name="submit_bt" value="เลือก"><i class="icol-add"></i> เลือก</button>

                                    <a class="btn" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> 
                                </div>
                            </div>
                        </div>
                        <div class="da-panel-content da-table-container">
                            <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>รหัส PO</th>
                                        <th>วันที่สั่งซื้อ</th>
                                        <th class="">สถานะ</th>
                                        <th class="">แก้ไขล่าสุด</th>
                                        <th class="">ตัวเลือก</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM " . $order_in_store->getTbl();
                                    $query = $db->Query($sql);
                                   if ($db->NumRows($query) > 0) {
                                    while ($row = $db->FetchArray($query)) {
                                        ?>
                                        <tr>
                                            <td class="center" width="5%"><input type="checkbox" value="<?php echo $row['id']; ?>" id="m_product_id" name="m_product_id[]"></td>
                                            <td class="center">PO<?php echo $row['id']; ?></td>
                                            <td class="center"><?php echo $row['order_date']; ?></td>
                                            <td class="center f-big" style="text-align: center;margin: auto;"><input type="checkbox"  id="on-off-switch<?=$row['id'];?>" name="<?php echo $row['id']; ?>" <?= $row['status'] == 'open' ? 'checked' : '' ?> ></td>
                                            <td class="center"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
                                            <td class="center"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store&type=po&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store&type=po&action=del&po_id=<?php echo $row['id'] ?>'
                                                                            }" class="btn btn-danger btn-small">ลบ</a></td>

                                        </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php } ?>
<?php } else { ?>
    <?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>



    <?php } else { ?>

        <!-- ถ้ามีการเลือกสินค้าที่จะสั่งซื้อเข้าร้าน-->
        <?php if (isset($_POST['m_product_id']) || $_POST['product_id'] != '') {
            ?>

            <div class="row-fluid">
                <div class="span12">
                    <?php
                    // Report errors to the user


                    Alert(GetAlert('error'));


                    Alert(GetAlert('success'), 'success');
                    ?>

                    <div class="da-panel collapsible">
                        <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-add"></i>  ข้อมูลการสั่งซื้อสินค้าเข้าร้าน </span> </div>
                        <div class="da-panel-content da-form-container">
                            <form enctype="multipart/form-data" action="<?= ADDRESS_ADMIN_CONTROL ?>order_in_store" method="post" class="da-form">
                                <input type="hidden" name="submit_bt" value="บันทึกข้อมูล">
                                <div class="da-form-inline">
                                    <fieldset>
                                        <legend><b>วันที่ทำการสั่งซื้อ</b></legend>
                                        <div class="da-form-row">
                                            <label class="da-form-label">วันที่ทำการสั่งซื้อ <span class="required">*</span></label>
                                            <div class="da-form-item large">
                                                <input type="text" name="order_date" id="order_date" value="" class="span12" data-validate="required" readonly="readonly"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend><b>รายละเอียดในการสั่งซื้อ</b></legend>

                                        <div class="da-form-row ">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center" style="width: 2%;">รหัสสินค้า</th>
                                                        <th class="text-center" style="width: 5%;">ชื่อสินค้า</th>
                                                        <th class="text-center" style="width: 5%;">ตัวแทนจำหน่าย</th>
                                                        <th class="text-center" style="width: 1%;">จำนวนปัจจุบัน </th>
                                                        <th class="text-center" style="width: 1%;">จำนวนที่สั่ง <span style="color: red;">*</span></th>
                                                        <th class="text-center" style="width: 5%;">หมายเหตุ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_POST['m_product_id'])) {

                                                        foreach ($_POST['m_product_id'] as $value) {
                                                            $p_id .= ',' . $value;
                                                        }
                                                        $p_id = substr($p_id, 1);
                                                    }
                                                    if ($_POST['product_id'] != '') {
                                                        $p_id = $_POST['product_id'];
                                                    }
                                                    $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE id in(" . $p_id . ")";

                                                    $query2 = $db->Query($sql2);
                                                    if ($db->NumRows($query2) > 0) {

                                                        while ($row2 = $db->FetchArray($query2)) {
                                                            ?>
                                                            <tr>
                                                        <input type="hidden" name="product_id[]" value="<?= $row2['id'] ?>">

                                                        <td class="text-center display-middle"><?= $row2['id'] ?></td>
                                                        <td class="text-center display-middle"><?= $row2['product_name'] ?></td>
                                                        <td class="text-center display-middle">

                                                            <?= $distributor->getDataDesc('name', 'id = ' . $row2['distributor_id']); ?>
                                                        </td>
                                                        <td class="text-center display-middle"><?= $row2['qty'] ?></td>
                                                        <td class="text-center display-middle"><input type="text" name="qty[]" class="text-center" data-validate="required,number"><span style="color: red;"></span></td>
                                                        <td class="display-middle"><textarea name="comment[]" class="span12"></textarea></td>
                                                        </tr>

                                                    <?php } ?>
                                                <?php } ?>        
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="da-form-row ">

                                        </div>

                                    </fieldset>

                                </div>

                                <div class="btn-row">
                                    <button type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" >บันทึกข้อมูล</button>

                                    <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store" class="btn btn-danger">ยกเลิก</a> 
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        <?php } else { ?>
            <!-- แสดงสินค้าทั้งหมด-->
            <div class="row-fluid">
                <div class="span12">
                    <?php
                    // Report errors to the user


                    Alert(GetAlert('error'));


                    Alert(GetAlert('success'), 'success');
                    ?>
                    <form method="POST" action="">
                        <div class="da-panel collapsible">
                            <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> เลือกสินค้าที่จะสั่งซื้อเข้าร้าน </span> </div>
                            <div class="da-panel-toolbar ">
                                <div class="btn-toolbar">
                                    <div class="btn-group"> 

                                        <button type="submit" class="btn" name="submit_bt" value="เลือก"><i class="icol-add"></i> เลือก</button>

                                        <a class="btn hidden" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> 
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
                                            <th>กลุ่มสินค้า</th>
                                            <th>ภาพสินค้า</th>
                                            <th class="">จำนวนสินค้า</th>
                                            <th class="hidden">แก้ไขล่าสุด</th>
                                            <th class="hidden">ตัวเลือก</th>
                                            <th class="">เลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน'";


                                        $query = $db->Query($sql);


                                        while ($row = $db->FetchArray($query)) {
                                            ?>
                                            <tr>
                                                <td class="center" width="5%"><input type="checkbox" value="<?php echo $row['id']; ?>" id="m_product_id" name="m_product_id[]"></td>
                                                <td class="center"><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['product_name']; ?></td>
                                                <td><?php echo $category->getDataDesc("category_name", "id = '" . $row['category_id'] . "'") ?></td>
                                                <td class="center"><img src="<?php echo ADDRESS_GALLERY . $products->getDataDesc("products_file_name_cover", "id = '" . $row['id'] . "'") ?>" style="height:70px; width:70px;"></td>
                                                <td><?php echo $row['qty']; ?></td>
                                                <td class="center hidden"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
                                                <td class="center hidden"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                            document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=del&id=<?php echo $row['id'] ?>'
                                                                                    }" class="btn btn-danger btn-small">ลบ</a></td>
                                                <td class="center"> <button type="submit" class="btn" name="product_id" value="<?php echo $row['id']; ?>"><i class="icol-add"></i> เลือก</button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        <?php } ?>
    <?php } ?>
<?php } ?>  

<script>
    $("#checkAll").click(function (e) {
        $('input:checkbox').prop('checked', this.checked);
    });

    function multi_delete() {

        var msg_id = "";
        var res = "";

        $('input:checkbox[id^="m_product_id"]:checked').each(function () {


            msg_id += ',' + $(this).val();
            res = msg_id.substring(1);


        });
        if (res != '') {
            if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store&type=po&action=del&del_id=' + res;
            }
        }

    }

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

        $('input:radio[name="products_file_name_cover"][value="<?php echo $products->getDataDesc("products_file_name_cover", "id = '" . $_GET['id'] . "'"); ?>"]').prop('checked', true);

    });

</script> 
<script>
    $(function () {


        // $( "#datepicker" ).datepicker();


        $("#activity_date").datepicker({dateFormat: "yy-mm-dd"}).val()


    });


</script>




<script>
    $(function () {
        $('#order_date').datepicker({
            minDate: '0',
            dateFormat: "yy-mm-dd",
        });
    });
    function cleartext(ele) {
        $(ele).val('');
    }
</script>
<style>
    /*Colored Label Attributes*/
    .error{
        display: block;
        color: #d44d24;
        font-size: 11px;
        margin-top: 1px;
    }
    .display-middle{
        display: table-cell;
        vertical-align: middle !important;
    }
    textarea{
        height: 6em;
    }
    .text-center{
        text-align: center !important;
    }
    .ui-datepicker{
        z-index: 9999 !important;
    }
    .hidden{
        display: none;
    }
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

    table {
        max-width: 100%;
        background-color: transparent;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table {
        width: 100%;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        padding: 8px;
        line-height: 20px;
        text-align: left;
        vertical-align: top;
        border-top: 1px solid #dddddd;
    }

    .table th {
        font-weight: bold;
    }

    .table thead th {
        vertical-align: bottom;
    }

    .table caption + thead tr:first-child th,
    .table caption + thead tr:first-child td,
    .table colgroup + thead tr:first-child th,
    .table colgroup + thead tr:first-child td,
    .table thead:first-child tr:first-child th,
    .table thead:first-child tr:first-child td {
        border-top: 0;
    }

    .table tbody + tbody {
        border-top: 2px solid #dddddd;
    }

    .table-condensed th,
    .table-condensed td {
        padding: 4px 5px;
    }

    .table-bordered {
        border: 1px solid #dddddd;
        border-collapse: separate;
        *border-collapse: collapse;
        border-left: 0;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .table-bordered th,
    .table-bordered td {
        border-left: 1px solid #dddddd;
    }

    .table-bordered caption + thead tr:first-child th,
    .table-bordered caption + tbody tr:first-child th,
    .table-bordered caption + tbody tr:first-child td,
    .table-bordered colgroup + thead tr:first-child th,
    .table-bordered colgroup + tbody tr:first-child th,
    .table-bordered colgroup + tbody tr:first-child td,
    .table-bordered thead:first-child tr:first-child th,
    .table-bordered tbody:first-child tr:first-child th,
    .table-bordered tbody:first-child tr:first-child td {
        border-top: 0;
    }

    .table-bordered thead:first-child tr:first-child th:first-child,
    .table-bordered tbody:first-child tr:first-child td:first-child {
        -webkit-border-top-left-radius: 4px;
        border-top-left-radius: 4px;
        -moz-border-radius-topleft: 4px;
    }

    .table-bordered thead:first-child tr:first-child th:last-child,
    .table-bordered tbody:first-child tr:first-child td:last-child {
        -webkit-border-top-right-radius: 4px;
        border-top-right-radius: 4px;
        -moz-border-radius-topright: 4px;
    }

    .table-bordered thead:last-child tr:last-child th:first-child,
    .table-bordered tbody:last-child tr:last-child td:first-child,
    .table-bordered tfoot:last-child tr:last-child td:first-child {
        -webkit-border-radius: 0 0 0 4px;
        -moz-border-radius: 0 0 0 4px;
        border-radius: 0 0 0 4px;
        -webkit-border-bottom-left-radius: 4px;
        border-bottom-left-radius: 4px;
        -moz-border-radius-bottomleft: 4px;
    }

    .table-bordered thead:last-child tr:last-child th:last-child,
    .table-bordered tbody:last-child tr:last-child td:last-child,
    .table-bordered tfoot:last-child tr:last-child td:last-child {
        -webkit-border-bottom-right-radius: 4px;
        border-bottom-right-radius: 4px;
        -moz-border-radius-bottomright: 4px;
    }

    .table-bordered caption + thead tr:first-child th:first-child,
    .table-bordered caption + tbody tr:first-child td:first-child,
    .table-bordered colgroup + thead tr:first-child th:first-child,
    .table-bordered colgroup + tbody tr:first-child td:first-child {
        -webkit-border-top-left-radius: 4px;
        border-top-left-radius: 4px;
        -moz-border-radius-topleft: 4px;
    }

    .table-bordered caption + thead tr:first-child th:last-child,
    .table-bordered caption + tbody tr:first-child td:last-child,
    .table-bordered colgroup + thead tr:first-child th:last-child,
    .table-bordered colgroup + tbody tr:first-child td:last-child {
        -webkit-border-top-right-radius: 4px;
        border-top-right-radius: 4px;
        -moz-border-radius-topright: 4px;
    }

    .table-striped tbody tr:nth-child(odd) td,
    .table-striped tbody tr:nth-child(odd) th {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover td,
    .table-hover tbody tr:hover th {
        background-color: #f5f5f5;
    }

    table td[class*="span"],
    table th[class*="span"],
    .row-fluid table td[class*="span"],
    .row-fluid table th[class*="span"] {
        display: table-cell;
        float: none;
        margin-left: 0;
    }

    .table td.span1,
    .table th.span1 {
        float: none;
        width: 44px;
        margin-left: 0;
    }

    .table td.span2,
    .table th.span2 {
        float: none;
        width: 124px;
        margin-left: 0;
    }

    .table td.span3,
    .table th.span3 {
        float: none;
        width: 204px;
        margin-left: 0;
    }

    .table td.span4,
    .table th.span4 {
        float: none;
        width: 284px;
        margin-left: 0;
    }

    .table td.span5,
    .table th.span5 {
        float: none;
        width: 364px;
        margin-left: 0;
    }

    .table td.span6,
    .table th.span6 {
        float: none;
        width: 444px;
        margin-left: 0;
    }

    .table td.span7,
    .table th.span7 {
        float: none;
        width: 524px;
        margin-left: 0;
    }

    .table td.span8,
    .table th.span8 {
        float: none;
        width: 604px;
        margin-left: 0;
    }

    .table td.span9,
    .table th.span9 {
        float: none;
        width: 684px;
        margin-left: 0;
    }

    .table td.span10,
    .table th.span10 {
        float: none;
        width: 764px;
        margin-left: 0;
    }

    .table td.span11,
    .table th.span11 {
        float: none;
        width: 844px;
        margin-left: 0;
    }

    .table td.span12,
    .table th.span12 {
        float: none;
        width: 924px;
        margin-left: 0;
    }

    .table tbody tr.success td {
        background-color: #dff0d8;
    }

    .table tbody tr.error td {
        background-color: #f2dede;
    }

    .table tbody tr.warning td {
        background-color: #fcf8e3;
    }

    .table tbody tr.info td {
        background-color: #d9edf7;
    }

    .table-hover tbody tr.success:hover td {
        background-color: #d0e9c6;
    }

    .table-hover tbody tr.error:hover td {
        background-color: #ebcccc;
    }

    .table-hover tbody tr.warning:hover td {
        background-color: #faf2cc;
    }

    .table-hover tbody tr.info:hover td {
        background-color: #c4e3f3;
    }
    .f-big:first-letter {font-size: 16px;}


</style>
<script>
    new DG.OnOffSwitch({
        el: '#on-off-switch',
        textOn: 'Open',
        textOff: 'Closed',
          listener: function (name, checked) {
            // document.getElementById("listener-text-table").innerHTML = "Switch " + name + " changed value to " + checked;
         
            $.ajax({
                type: "GET",
                url: "ajax_set_status_po.php",
                cache: false,
                data: "status="+checked+"&id="+name,
                success: function (msg) {
                    if (msg === 'success') {
                        notie.alert(1, 'Success!', 1.5);
                    }else{
                        notie.alert(3, 'Error.', 2.5);
                    }
                   
                }
            });


        }
    });
    </script>
<script>
  <?php
                                    $sql = "SELECT * FROM " . $order_in_store->getTbl();
                                    $query = $db->Query($sql);
                                   if ($db->NumRows($query) > 0) {
                                    while ($row = $db->FetchArray($query)) {
                                        ?>
  
    new DG.OnOffSwitch({
        el: '#on-off-switch<?=$row['id']?>',
        textOn: 'Open',
        textOff: 'Closed',
        listener: function (name, checked) {
            // document.getElementById("listener-text-table").innerHTML = "Switch " + name + " changed value to " + checked;
         
            $.ajax({
                type: "GET",
                url: "ajax_set_status_po.php",
                cache: false,
                data: "status="+checked+"&id="+name,
                success: function (msg) {
                    if (msg === 'success') {
                        notie.alert(1, 'Success!', 1.5);
                    }else{
                        notie.alert(3, 'Error.', 2.5);
                    }
                   
                }
            });


        }
    });

       <?php }?>
         <?php }?>
    </script>