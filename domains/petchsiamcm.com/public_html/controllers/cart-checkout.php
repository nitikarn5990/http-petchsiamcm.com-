<?php
//print_r($_SESSION);

if (count($_SESSION["strProductID"]) == 0) {
    header("location:" . ADDRESS);
}
if ($_POST['bt_submit'] == 'Order') {

    $arrData = array(
        "created_at" => DATE_TIME,
        "status" => 'รอการชำระเงิน',
        "customer_id" => $_SESSION['customer_id'],
        "shipping_cost" => $_SESSION['shipping_cost'],
        "shipping_status" => 'รอการส่งสินค้า',
        "order_date" => DATE_TIME
    );

    //$orders->updateSQL($arrData, $arrKey);
//$orders->setPrimary((int) $_SESSION['customer_id']);
    /* if($orders->SetValues($arrData)){
      $chk_save = true;
      }else{
      $chk_save = false;
      } */
    $orders->SetValues($arrData);
    if ($orders->save()) {

        for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {
            if ($_SESSION["strProductID"][$i] != "") {
                $arrData_detail = array(
                    "orders_id" => $orders->GetPrimary(),
                    "product_id" => $_SESSION['strProductID'][$i],
                    "qty" => $_SESSION['strQty'][$i],
                    "cost" => $products->getDataDesc("product_cost", "id=" . $_SESSION["strProductID"][$i])
                );

                $orders_detail->SetValues($arrData_detail);

                if ($orders_detail->save()) {
                    $chk_save = true;
                } else {
                    $chk_save = false;
                }
            }
        }
        if ($chk_save) {
            unset($_SESSION['strProductID']);
            unset($_SESSION['strQty']);
            unset($_SESSION['intLine']);
            unset($_SESSION['Total']);
            unset($_SESSION['shipping_cost']);
        }
    }
    ?>

    <div class="col-md-9 col-md-push-3">
        <header class="page-title category-title">
            <h1 class="title-bar">Orders success
                <div class="title-border"></div>
            </h1>
        </header>
        <br>
        <div class="row">
            <div class="col-md-12 col-xs-12">
    <?php if ($chk_save) { ?>
                    <div class="alert alert-success" role="alert"> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <span class="sr-only">Success:</span> Order หมายเลข <span> <?php echo str_pad($orders->GetPrimary(), 5, "0", STR_PAD_LEFT) . " " ?> </span>ทำการสั่งซื้อเรียบร้อยแล้วค่ะ </div>
        <?php
        //session_destroy();
    }
    ?>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-md-pull-9">
                <?php include "inc/side_category.php"; ?>
    </div>
            <?php } else { ?>
    <div class="col-md-9 col-md-push-3">
        <header class="page-title category-title">
            <h1 class="title-bar">Check out
                <div class="title-border"></div>
            </h1>
        </header>
        <br>
        <form action="<?php echo ADDRESS ?>cart-checkout.html" method="post">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-12 col-xs-12"> <span style="font-size: 20px;font-weight: bold;">Your Orders</span>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><span style="font-size:large;">Product</span></th>
                                    <th><span style="font-size:large;"> Totals</span></th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {


        if ($_SESSION["strProductID"][$i] != "") {
            ?>
                                        <tr class="">
                                            <td style="font-size:larger;"><?php echo $products->getDataDesc("product_name", "id=" . $_SESSION["strProductID"][$i]) . " x " . $_SESSION["strQty"][$i] ?></td>
                                            <td style=" font-size: larger;">฿<?php echo number_format($_SESSION["strQty"][$i] * $products->getDataDesc("product_cost", "id=" . $_SESSION["strProductID"][$i]), 2) ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <tr class="">
                                    <th style="font-size:medium;"> Subtotal</th>
                                    <td style="  font-size: larger; font-weight: 600;">฿<?php echo number_format($_SESSION["Total"], 2) ?></td>
                                </tr>
                                <tr class="">
                                    <th style="font-size:medium;">Shipping</th>
                                    <td style="font-size: larger;font-weight: 600;">฿<?php echo $_SESSION["shipping_cost"] ?></td>
                                </tr>
                                <tr class="">
                                    <th style="font-size:medium;">Total</th>
                                    <td style="  font-size: larger;font-weight: 600;">฿ <?php echo number_format($_SESSION["Total"] + $_SESSION["shipping_cost"], 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-xs-12 ">
                        <input type="submit" class="btn btn-default col-md-6  col-xs-12" value="Order" name="bt_submit">
                        <a href="<?php echo ADDRESS ?>cart.html" class="btn btn-default col-md-6  col-xs-12">View Orders</a> </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3 col-md-pull-9">
    <?php include "inc/side_category.php"; ?>
    </div>
<?php } ?>
