
<?php
// If they are saving the Information


if ($_POST ['submit_bt'] == 'บันทึกข้อมูล' || $_POST ['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {

    if ($_POST ['submit_bt'] == 'บันทึกข้อมูล') {

        $redirect = true;
    } else {

        $redirect = false;
    }

    //$arrData = array ();
    //$arrData = $functions->replaceQuote ( $_POST );
    //$orders->SetValues ( $arrData );

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

            header('location:' . ADDRESS_ADMIN_CONTROL . 'ordered');

            die();
        } else {

            header('location:' . ADDRESS_ADMIN_CONTROL . 'ordered&action=edit&id=' . $_GET['id']);

            die();
        }
    } else {

        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}

// If Deleting the Page

if ($_GET ['id'] != '' && $_GET ['action'] == 'del') {

    // Get all the form data
    // /$arrDel = array('id' => $_GET['id']);
    // $orders->SetValues($arrDel);
    // Remove the info from the DB

    if ($orders->DeleteMultiID($_GET ['id'])) {

        // Set alert and redirect

        SetAlert('Delete Data Success', 'success');

        header('location:' . ADDRESS_ADMIN_CONTROL . 'ordered');

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
                            class="icol-<?php echo ($orders->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($orders->GetPrimary() != '') ? '' : '' ?> หมายเลขสั่งซื้อ  <?php echo $orders->getDataDesc('years','id='.$orders->GetPrimary()) . $functions->padLeft($orders->getDataDesc('months','id='.$orders->GetPrimary()),2,'0').$functions->padLeft($orders->getDataDesc('id','id='.$orders->GetPrimary()),5,'0')  ?> </span>
                </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data"
                          action="<?php echo ADDRESS_ADMIN_CONTROL ?>ordered<?php echo ($orders->GetPrimary() != '') ? '&action=edit&id=' . $orders->GetPrimary() : ''; ?>"
                          method="post" class="da-form">
                              <?php if ($orders->GetPrimary() != ''): ?>
                            <input type="hidden" name="id"
                                   value="<?php echo $orders->GetPrimary() ?>" /> <input
                                   type="hidden" name="created_at"
                                   value="<?php echo $orders->GetValue('created_at') ?>" />
                               <?php endif; ?>
                        <div class="da-form-inline">
                             <div class="da-form-row">
                                <label class="da-form-label">หมายเลขสั่งซื้อ<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $orders->getDataDesc('years','id='.$orders->GetPrimary()) . $functions->padLeft($orders->getDataDesc('months','id='.$orders->GetPrimary()),2,'0').$functions->padLeft($orders->getDataDesc('id','id='.$orders->GetPrimary()),5,'0') : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                    
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อผู้สั่งซื้อ<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $orders->GetValue("name") : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                    
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ที่อยู่เพื่อจัดส่ง<span
                                        class="required">*</span></label>
                                    <?php
                                    $address = $orders->getDataDesc("address", "id=" . $orders->GetValue("id"));
                                    $address .= ' ' . $orders->getDataDesc("province", "id=" . $orders->GetValue("id"));
                                    $address .= ' ' . $orders->getDataDesc("zipcode", "id=" . $orders->GetValue("id"));
                                    ?>	

                                <div class="da-form-item large">
                                    <textarea rows="5" cols="5" readonly="readonly" style="width: 100%;"><?php echo $address ?></textarea>

                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">โทร<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $orders->GetValue('tel') : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                              <div class="da-form-row">
                                <label class="da-form-label">Email<span
                                        class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="txt_name" id="txt_name"
                                           value="<?php echo ($orders->GetPrimary() != '') ? $orders->GetValue('email') : ''; ?>"
                                           class="span12 required" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="da-form-row">

                                <label class="da-form-label">รายการสินค้า <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <div class="span12">
                                        <?php
                                        $sql = "SELECT * FROM " . $orders_detail->getTbl() . " WHERE orders_id = " . $orders->GetPrimary() . " ORDER BY qty DESC";

                                        $query = $db->Query($sql); ?>

                                        <table border="0" cellpadding="0" cellspacing="0" class="item-list" style="width: 100%;">

                                            <tbody>
                                                <tr>
                                                    <th class="hidden">ภาพสินค้า</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>ราคา/หน่วย</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคารวม</th>
                                                </tr>
                                                <?php
                                                $k = 0;
                                              
                                                 while ($row = $db->FetchArray($query)) {

                                                        $strSQL = "SELECT * FROM products WHERE id = " . $row['product_id'] . "";
                                                        $objQuery = mysql_query($strSQL) or die(mysql_error());
                                                        $objResult = mysql_fetch_array($objQuery, MYSQL_ASSOC);
                                                        $qty = $row['qty'];
                                                        $Total = $row['total'];
                                                       
                                                       
                                                        ?>

                                                        <tr>
                                                            <td class="pro-id" style="text-align: center;font-size: 14px;"><img src="<?php echo ADDRESS . 'images/' . $objResult["products_file_name_cover"] ?>" style="width:70px;"></td>
                                                            <td class="pro-desc" style="text-align: center;font-size: 14px;"><?= $objResult["product_name"]; ?></td>
                                                            <td class="pro-price" style="text-align: center;font-size: 14px;"><?= $functions->formatcurrency($objResult["product_cost"]); ?></td>

                                                            <td class="quantity" style="text-align: center;font-size: 14px;"><?php echo $qty; ?></td>

                                                            <td class="sumprice"style="text-align: center;font-size: 14px;"><?= $functions->formatcurrency(($Total)); ?></td>

                                                        </tr>
                                                 
                                                    <?php  }  ?>
                                            </tbody>
                                        </table>


                                    </div>

                                </div>
                            </div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">จำนวนเงินรวม<span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="text" name="product_cost" id="product_cost"
                                               value="<?php echo ($orders->GetPrimary() != '') ? number_format($orders_detail->SumDataDesc("total", "orders_id =" . $orders->GetValue('id')), 2) : ''; ?>"
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

                                <div class="da-form-row">
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
                            </div>
                            <div class="btn-row">
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล"
                                       class="btn btn-success" /> 
                                <input type="submit" name="submit_bt"
                                       value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" /> 
                                <a
                                       href="<?php echo ADDRESS_ADMIN_CONTROL ?>ordered"
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
                    <span class="da-panel-title"> <i class="icol-grid"></i> ข้อมูลการสั่งซื้อ ทั้งหมด
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
                <div class="da-panel-content da-table-container">
                    <table id="da-ex-datatable-sort" class="da-table" sort="3"
                           order="asc" width="1000" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>หมายเลขสั่งซื้อ</th>    
                                <th>ชื่อผู้สั่งซื้อ</th>
                                  <th>เบอร์ติดต่อ</th>
                                   <th>Email</th>
                                <th>สถานะ</th>
                                <th>วันที่สั่งซื้อ</th>
                                <th>ตัวเลือก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM " . $orders->getTbl() . " ORDER BY id DESC";

                            $query = $db->Query($sql);

                            while ($row = $db->FetchArray($query)) {
                                $cStatus = "style='background-color: rgba(240, 105, 105, 0.42)';";
                                if ($row['status'] == 'ชำระเงินแล้ว') {
                                    $cStatus = "style='background-color: rgba(165, 240, 105, 0.42)';";
                                }
                                ?>
                                <tr class="" <?= $cStatus ?> >
                                    <td class="center" width="5%"><input type="checkbox"
                                                                         value="<?php echo $row['id']; ?>" id="chkboxID"></td>
                                    <td class="center"><?= $orders->getDataDesc('years','id='.$row['id']) . $functions->padLeft($orders->getDataDesc('months','id='.$row['id']),2,'0').$functions->padLeft($orders->getDataDesc('id','id='.$row['id']),5,'0') ?></td>
                                    <td class="center"><?php echo $row['name'] ?></td>
                                     <td class="center"><?php echo $row['tel'] ?></td>
                                      <td class="center"><?php echo $row['email'] ?></td>
                                    <td class="center"><?php echo $row['status']; ?></td>
                                    <td class="center"><?php echo $functions->ShowDateThTime($row['order_date']) ?></td>

                                    <td class="center"><a
                                            href="<?php echo ADDRESS_ADMIN_CONTROL ?>ordered&action=edit&id=<?php echo $row['id'] ?>"
                                            class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#"
                                            onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                                document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>ordered&action=del&id=<?php echo $row['id'] ?>'
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
                    document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>ordered&action=del&id=' + res;
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
    .bg-danger2{

        background-color: rgba(240, 105, 105, 0.42);                         

    }
    .bg-success2{
        background-color: rgba(165, 240, 105, 0.42);
    }
  
</style>
