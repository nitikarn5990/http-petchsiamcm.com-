
<div class="member">
    <h1 class="title-bar">Ordered <span class="pull-right"><a href="<?= ADDRESS ?>ordered_status.html" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a></span>
        <div class="title-border"></div>
    </h1>
</div>
<br>
<?php if ($_GET['catID'] != '') { ?>
    <div class="col-md-3">
        <?php include("inc/menu_member.php") ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom:0px; ">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Picture</th>
                            <th>ProductName</th>
                            <th style="text-align:center;">Price</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:center;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM " . $orders_detail->getTbl() . " WHERE  orders_id = " . $_GET['catID'] . " ORDER BY id ASC";

                        //echo $sql;
                        $query = $db->Query($sql);
                        $SumTotal = 0;
                        while ($row = $db->FetchArray($query)) {

                            //$product_id =  $orders_detail->getDataDesc("product_id","orders_id =". $row['id']);
                            $product_name = $products->getDataDesc("product_name", "id =" . $row['product_id']);
                            $cost = $row['cost'];
                            $qty = $row['qty'];
                            $total = $qty * $cost;
                            $SumTotal = $SumTotal + $total;
                            ?>
                            <tr>
                                <td align="center" class="col-sm-2"><img src="<?php echo ADDRESS_GALLERY . $products->getDataDesc("products_file_name_cover", "id =" . $row['product_id']) ?>" style="width:48px;"></td>
                                <td valign="middle" class="col-sm-3"><?= $product_name; ?></td>
                                <td align="center" class="col-sm-2"><?= $cost; ?></td>
                                <td align="center" class="col-sm-3"><?= $qty; ?></td>
                                <td align="center" class="col-sm-1"><?= number_format($total, 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-6 col-xs-12">
                    <div class="col-md-12 col-xs-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="  text-align: center;"><span style="font-size:large;">Cart Totals</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <th style="text-align:center;">Subtotal</th>
                                    <td><?php echo number_format($SumTotal, 2) ?></td>
                                </tr>
                                <tr class="">
                                    <th style="text-align:center;">Shipping</th>
                                    <td><?php echo $orders->getDataDesc("shipping_cost", "id = " . $_GET['catID']) ?></td>
                                </tr>
                                <tr class="">
                                    <th style="text-align:center;">Total</th>
                                    <td>฿ <?php echo number_format($SumTotal + $orders->getDataDesc("shipping_cost", "id = " . $_GET['catID']), 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
<?php } else { ?>
    <div class="col-sm-3">
        <?php include("inc/menu_member.php") ?>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="title-bar">การส่งสินค้า
                    <div class="title-border"></div>
                </h1>
            </div>
        </div>
        
        <?php if ($_GET['controllers'] != '') { ?>
        <p>&nbsp;</p>
            <div class="table-responsive">
                <table class="table" id="table-ordered_status">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th class="text-center">Items</th>
                            <th class="text-center">Status</th>
                            <th>Show detail</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th class="text-center">Items</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Show detail</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM " . $orders->getTbl() . " WHERE  customer_id = " . $_SESSION['customer_id'] . " ORDER BY id DESC";

                        //echo $sql;
                        $query = $db->Query($sql);
                        while ($row = $db->FetchArray($query)) {
                            ?>
                        <tr style="<?= $row['shipping_status'] == 'รอการส่งสินค้า' || $row['shipping_status'] == '' ? 'background-color: #fcf8e3;' : '    background-color: #dff0d8;' ?>">
                                <td><?= str_pad($row['id'], 5, "0", STR_PAD_LEFT); ?></td>
                                <td><?php echo $functions->ShowDateThTime($row['order_date']) ?></td>
                                <td class="text-center"><?php echo $orders_detail->SumDataDesc("qty", "orders_id = " . $row['id']) ?></td>
                                <td class="text-center"><?= $row['shipping_status'] == 'รอการส่งสินค้า' || $row['shipping_status'] == '' ? 'รอการส่งสินค้า' : 'ส่งสินค้าแล้ว' ?></td>
                                <td class="text-center"><a href="<?php echo ADDRESS ?>ordered_status/<?= $row['id'] ?>.html" class="btn btn-default">Detail</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        
        <?php } ?>
    </div>
<?php } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<style>

    .the-legend {
        border-style: none;
        border-width: 0;
        font-size: 14px;
        line-height: 20px;
        margin-bottom: 0;
    }
    .the-fieldset {
        border: 2px groove threedface #444;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
        box-shadow:  0px 0px 0px 0px #000;
    }
    legend{
        padding:0 10px;
        width:auto !important;
        color:#898989;

    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button:active,
    .dataTables_wrapper .dataTables_paginate .paginate_button:focus{
        border: 1px solid transparent !important;
       background:  none !important;
       box-shadow: none !important;
    }

</style>



<script>
    $(document).ready(function () {
        $('#table-ordered_status').DataTable();
    });
</script>