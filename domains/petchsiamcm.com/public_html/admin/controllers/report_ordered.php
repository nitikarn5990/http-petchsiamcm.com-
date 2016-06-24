<?php
// If they are saving the Information



if ($_POST ['submit_bt'] == 'บันทึกข้อมูล' || $_POST ['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {

    if ($_POST ['submit_bt'] == 'บันทึกข้อมูล') {

        $redirect = true;
    } else {

        $redirect = false;
    }

    $arrData = array(
        "updated_at" => DATE_TIME,
        "status" => $_POST['status']
    );
    $arrKey = array(
        "id" => $_GET['id']
    );

    if ($orders->updateSQL($arrData, $arrKey)) {

        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

        if ($redirect) {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'report_ordered');

            die();
        } else {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'report_ordered&action=edit&id=' . $_GET['id']);

            die();
        }
    } else {

        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}

// If Deleting the Page

if ($_GET ['id'] != '' && $_GET ['action'] == 'del') {

    if ($orders->DeleteMultiID($_GET ['id'])) {

        // Set alert and redirect

        SetAlert('Delete Data Success', 'success');

        header('location:' . ADDRESS_ADMIN_CONTROL . 'report_ordered');

        die();
    } else {

        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}

if ($_GET ['id'] != '' && $_GET ['action'] == 'edit') {

    // For Update

    $orders->SetPrimary((int) $_GET['id']);

    // Try to get the information

    if (!$orders->GetInfo()) {

        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');

        $orders->ResetValues();
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
                <div class="da-panel-header">
                    <span class="da-panel-title"> <i
                            class="icol-<?php echo ($orders->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($orders->GetPrimary() != '') ? '' : '' ?> เลขที่ใบสั่งซื้อ  <?php echo str_pad($orders->GetValue('id'), 5, "0", STR_PAD_LEFT) ?> </span>
                </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data"
                          action="<?php echo ADDRESS_ADMIN_CONTROL ?>report_ordered<?php echo ($orders->GetPrimary() != '') ? '&action=edit&id=' . $orders->GetPrimary() : ''; ?>"
                          method="post" class="da-form">
                              <?php if ($orders->GetPrimary() != ''): ?>
                            <input type="hidden" name="id"
                                   value="<?php echo $orders->GetPrimary() ?>" /> <input
                                   type="hidden" name="created_at"
                                   value="<?php echo $orders->GetValue('created_at') ?>" />
                               <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">รหัสสมาชิก<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $orders->GetValue("customer_id") : '' ?>"
                                           class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อผู้สั่งซื้อ<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $customer->getDataDesc("customer_name", "id=" . $orders->GetValue("customer_id")) . " " . $customer->getDataDesc("customer_lastname", "id=" . $orders->GetValue("customer_id")) : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ที่อยู่เพื่อจัดส่ง<span
                                        class="required">*</span></label>
                                    <?php
                                    $address = $customer->getDataDesc("customer_address", "id=" . $orders->GetValue("customer_id"));
                                    $province = " จ." . $customer->getDataDesc("province", "id=" . $orders->GetValue("customer_id"));
                                    // $amphur = " อ." . $amphur->getDataDesc("AMPHUR_NAME", "AMPHUR_ID = " . $customer->getDataDesc("amphur_id", "id=" . $orders->GetValue("customer_id")));
                                    // $district = " ต." . $district->getDataDesc("DISTRICT_NAME", "DISTRICT_ID = " . $customer->getDataDesc("district_id", "id=" . $orders->GetValue("customer_id")));
                                    $zipcode = " รหัสไปรษณีย์ " . $customer->getDataDesc("zipcode", "id=" . $orders->GetValue("customer_id"));

                                    $total_address = $address . $province . $zipcode;
                                    ?>	

                                <div class="da-form-item large">
                                    <textarea rows="5" class="span12" cols="5" readonly="readonly"><?php echo $total_address ?></textarea>

                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">โทร<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $customer->getDataDesc("customer_tel", "id=" . $orders->GetValue("customer_id")) : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row">

                                <label class="da-form-label">รายการสินค้า <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <div class="span12">
                                        <?php
                                        $sql = "SELECT * FROM " . $orders_detail->getTbl() . " WHERE orders_id = " . $orders->GetPrimary() . " ORDER BY qty DESC";

                                        $query = $db->Query($sql);

                                        while ($row = $db->FetchArray($query)) {
                                            $image = $products->getDataDesc("products_file_name_cover", "id = " . $row['product_id']);
                                            $product_name = $products->getDataDesc("product_name", "id = " . $row['product_id']);
                                            $product_cost = $products->getDataDesc("product_cost", "id = " . $row['product_id']);
                                            ?>
                                            <div class="span5">
                                                <img
                                                    src="<?php echo ADDRESS_GALLERY . $image ?>"
                                                    alt="" style="max-width: 150px;">
                                                <p>ชื่อสินค้า : <?= $product_name ?> </p>
                                                <p> จำนวน : <?php echo $row['qty'] ?> หน่วย</p>
                                                <p>ราคาต่อหน่วย : <?php echo $product_cost ?> บาท</p>
                                                <p>ราคารวม: <?php echo $product_cost * $row['qty'] ?> บาท</p>
                                            </div>
                                        <?php } ?>


                                    </div>
                                </div>
                            </div>
                            <?php
                            //หาจำนวนเงินของ order
                            $sql = "SELECT * FROM " . $orders_detail->getTbl() . " WHERE  orders_id = " . $orders->GetPrimary() . " ORDER BY id ASC";

                            $query = $db->Query($sql);
                            $SumTotal = 0;
                            while ($row = $db->FetchArray($query)) {

                                //$product_id =  $orders_detail->getDataDesc("product_id","orders_id =". $row['id']);
                                //   $product_name = $products->getDataDesc("product_name", "id =" . $row['product_id']);
                                $cost = $row['cost'];
                                $qty = $row['qty'];
                                $total = $qty * $cost;
                                $SumTotal = $SumTotal + $total;
                            }
                            ?>

                            <div class="da-form-row">
                                <label class="da-form-label">ค่าขนส่ง<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="shipping_cost" id="product_cost"
                                           value="<?php echo ($orders->GetPrimary() != '') ? number_format($orders->GetValue('shipping_cost'), 2) : ''; ?>"
                                           class="span12 required"  readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">จำนวนเงินรวม<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="product_cost" id="product_cost"
                                           value="<?php echo ($orders->GetPrimary() != '') ? number_format($SumTotal + $orders->GetValue('shipping_cost'), 2) : ''; ?>"
                                           class="span12 required"  readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">วันที่สั่งซื้อ<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_date" id="txt_date"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $functions->ShowDateThTime($orders->GetValue('order_date')) : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row <?= $orders->GetValue('status') == 'รอการชำระเงิน' ? 'bg-warning' : 'bg-success' ?>">
                                <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <ul class="da-form-list">
                                        <?php
                                        $getStatus = $orders->get_enum_values('status');

                                        $i = 1;

                                        foreach ($getStatus as $status) {
                                            ?>
                                            <li><input type="radio"
                                                       name="status" id="status" value="<?php echo $status ?>"
                                                       <?php echo ($orders->GetPrimary() != "") ? ($orders->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?>
                                                       class="required" /> <label><?php echo $status ?></label></li>
                                                <?php
                                                $i ++;
                                            }
                                            ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="btn-row">
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล"
                                       class="btn btn-success" /> <input type="submit" name="submit_bt"
                                       value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" /> <a
                                       href="<?php echo ADDRESS_ADMIN_CONTROL ?>report_ordered"
                                       class="btn btn-danger">ยกเลิก</a>
                            </div>

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
                <div class="da-panel-header">
                    <span class="da-panel-title"> <i class="icol-grid"></i> 
                        สรุปการสั่งซื้อ ทั้งหมด
                    </span>
                </div>
                <div class="da-panel-toolbar">
                    <div class="btn-toolbar">
                        <div class="btn-group">
                            <a class="btn" onClick="multi_delete()"><img
                                    src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png"
                                    height="16" width="16"> Delete</a>
                        </div>
                    </div>
                </div>
                <div class="da-panel-content">
                    <div class="da-form-inline">
                        <div class="da-form-row">

                            <label class="da-form-label">ค้นหาตามวันที่
                            </label>
                            <div class="da-form-item large ">
                                <form action="" method="POST">
                                    <input type="text" readonly="" name="s_date"
                                           data-range="true" value="<?=$_POST['s_date']!=''? $_POST['s_date']:''?>"
                                           data-multiple-dates-separator=" - "
                                           data-language="en"
                                           data-date-format="yyyy-mm-dd"
                                           class="datepicker-here"/>

                                    <button type="submit" name="btn_s" class="btn btn-primary">ค้นหา</button>
                                </form>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3"
                           order="asc" width="1000" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>เลขที่ใบสั่งซื้อ</th>
                                <th>ชื่อผู้สั่งซื้อ</th>
                                <th>จำนวนสินค้า</th>

                                <th>สถานะ</th>
                                <th>วันที่สั่งซื้อ</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_POST['s_date'] != '') {
                                
                                $s_date = $_POST['s_date'];
                                $arrDate = explode(' - ', $s_date);
                  
                    
                                $date_start = $arrDate[0] . ' 00:00:00 ';
                                $date_end = $arrDate[1] == '' ? $arrDate[0] . '  23:59:59 ' : $arrDate[1] . '  23:59:59 ';
                           
                                $sql = "SELECT * FROM " . $orders->getTbl() . " WHERE status = 'ชำระเงินแล้ว' AND (order_date BETWEEN '".$date_start."' AND '".$date_end."' ) ORDER BY id DESC";
                            } else {
                                $sql = "SELECT * FROM " . $orders->getTbl() . " WHERE status = 'ชำระเงินแล้ว' ORDER BY id DESC";
                            }


                            $query = $db->Query($sql);

                            while ($row = $db->FetchArray($query)) {
                                ?>
                                <tr>
                                    <td class="center" width="5%"><input type="checkbox"
                                                                         value="<?php echo $row['id']; ?>" id="chkboxID"></td>
                                    <td class="center" width="15%"><?php echo str_pad($row['id'], 5, "0", STR_PAD_LEFT); ?></td>
                                    <td class="center"><?php echo $customer->getDataDesc("customer_name", "id = " . $row['customer_id']) ?></td>
                                    <td class="center"><?php echo $orders_detail->SumDataDesc("qty", "orders_id =" . $row['id']) ?></td>


                                    <td class="center"><?php echo $row['status']; ?></td>
                                    <td class="center"><?php echo $functions->ShowDateThTime($row['order_date']) ?></td>

                                    <td class="center"><a
                                            href="<?php echo ADDRESS_ADMIN_CONTROL ?>report_ordered&action=edit&id=<?php echo $row['id'] ?>"
                                            class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#"
                                            onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>report_ordered&action=del&id=<?php echo $row['id'] ?>'
                                                                        }"
                                            class="btn btn-danger btn-small">ลบ</a></td>
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
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>report_ordered&action=del&id=' + res;
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





        $('input:radio[name="products_file_name_cover"][value="<?php echo $orders->getDataDesc("products_file_name_cover", "id = '" . $_GET['id'] . "'"); ?>"]').prop('checked', true);


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
        padding-top: 2px;
        text-transform: uppercase;
        white-space: nowrap;
        padding-right: 4px;
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
        font-size: 12px;
    }
</style>
