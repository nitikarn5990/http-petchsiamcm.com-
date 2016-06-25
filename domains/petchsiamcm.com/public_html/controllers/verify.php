<?php
session_start();


if (count($_SESSION["strProductID"]) == 0) {

    header("location:" . ADDRESS . "product");
}
?>
<div class="col-md-12 well">
    <header class="page-title category-title">
        <h1 class="title-bar" style="color: #073705; font-size: 22px;font-weight: bold;text-align: center;">
            สรุปรายการ สินค้าในตะกร้า
            <div class="title-border"></div>
        </h1>
    </header>
    <br>

    <form action="<?php echo ADDRESS ?>cart" method="post">
        <div class="table-responsive">
            <table border="0" cellpadding="0" cellspacing="0" class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="text-center">ภาพสินค้า</th>
                        <th class="text-center">ชื่อสินค้า</th>
                        <th class="text-center">ราคา/หน่วย</th>

                        <th class="text-center" style="width: 100px;">จำนวน</th>
                        <th class="text-center">ราคารวม</th>



                    </tr>
                    <?php
                    $k = 0;
                    $total_qty = 0;
                    for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {


                        if ($_SESSION["strProductID"][$i] != "") {

                            $strSQL = "SELECT * FROM products WHERE id = " . $_SESSION["strProductID"][$i] . "";
                            $objQuery = mysql_query($strSQL) or die(mysql_error());
                            $objResult = mysql_fetch_array($objQuery, MYSQL_ASSOC);
                            
                            if ($_SESSION['group'] != '' && $_SESSION['group'] == 'member') {
                                $products_cost = $objResult['product_member_cost'];
                            } else {
                                $products_cost = $objResult['product_cost'];
                            }

                            $qty = $_SESSION["strQty"][$i];
                            $Total = $qty * $products_cost;
                            $SumTotal = $SumTotal + $Total;
                            $_SESSION["Total"] = $SumTotal;

                            $total_qty = $total_qty + $qty;
                            ?>

                            <tr>
                                <td class="pro-id text-center"><img src="<?php echo ADDRESS . 'files/gallery/' . $objResult["image"] ?>" style="width:70px;"></td>
                                <td class="pro-desc"><?= $objResult["product_name"]; ?></td>
                                <td class="pro-price text-center"><?= $functions->formatcurrency($products_cost); ?></td>

                                <td class="quantity text-center"><?php echo $qty; ?></td>

                                <td class="sumprice text-center"><?= $functions->formatcurrency(($Total)); ?></td>

                            </tr>
                        <input type="hidden"  name="product_id[]" id="product_id" value="<?php echo $objResult["id"] ?>" >


                        <?php
                        $k = $k + 1;
                    }
                }
                $_SESSION['count_cart'] = $total_qty;
                ?>
                </tbody>
            </table>
            <div id="product-summary" style="width: 430px;
                 position: relative;
                 float: left;">
                <p class="title-bar" style="color: #232323;font-size: 14px;font-weight: bold;">สินค้าในตะกร้าสินค้า : <?= $total_qty ?> รายการ
                <div class="title-border"></div>
                </p>
                <table style="width: 430px;">
                    <tbody>
                        <tr>
                            <th style="font-size: 16px;text-align: left;color: orange;">สรุปรายการสินค้า (Subtotal)</th>
                            <td></td>
                            <td></td>
                        </tr>  

                        <tr>
                            <th style="text-align: left;">ราคารวมทั้งหมด</th>
                            <td style="text-align: right;"><?php echo number_format($SumTotal, 2) ?></td>
                            <td style="text-align: right;">฿&nbsp;</td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div id="cart-button" style="position: relative;float: right;width: 285px;">
                <div class="" style="border-color:#DDDDDD;">
                    <div class="panel-body" style="text-align: right;  padding-top: 50px;">
                        <a href="<?= ADDRESS ?>shipping"  class="btn btn-success" ><i class="fa fa-arrow-right" style="font-size: 16px;"></i> ยืนยันการสั่งซื้อ</a> </div>

                </div>
            </div>

        </div>
    </form>
</div>

