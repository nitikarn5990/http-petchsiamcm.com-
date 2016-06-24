<?php
session_start();

if (count($_SESSION["strProductID"]) == 0) {

    header("location:" . ADDRESS . "product.html");
}
$cnt = "0";

//delete session
if ($_GET['catID'] != '') {

    $Line = $_GET["catID"];
    //$_SESSION["strProductID"][$Line] = "";
//	$_SESSION["strQty"][$Line] = "";
    //$_SESSION["intLine"] = $_SESSION["intLine"] - 1;
    unset($_SESSION["strQty"][$Line]);
    unset($_SESSION["strProductID"][$Line]);
    header("location:" . ADDRESS . "cart.html");
    //$_SESSION["intLine"] = $_SESSION["intLine"] ;
//session_destroy();
}

// $_SESSION["intLine"];


if ($_POST['bt_submit'] == 'Update cart') {

    //echo chk_line_cart();
    //echo "<br>". count($_POST["qty"]);
    if (chk_line_cart() == count($_POST["qty"])) {

        $b = 0;
        for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {

            if ($_SESSION["strProductID"][$i] != "") {

                $_SESSION["strQty"][$i] = $_POST["qty"][$b];

                $b++;
            }
        }
    }
}


// check rate shipping
$sql = "SELECT * FROM " . $shipping->getTbl();
$query = $db->Query($sql);
while ($row = $db->FetchArray($query)) {

    $arr_rate[] = array(
        "shipping_rate_min" => $row['shipping_rate_min'],
        "shipping_rate_max" => $row['shipping_rate_max'],
        "shipping_cost" => $row['shipping_cost']
    );
}


for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {

    if ($_SESSION["strProductID"][$i] != "") {

        $weight = $products->getDataDesc("product_weight", "id = " . $_SESSION["strProductID"][$i]);
        $sum_weight = $sum_weight + (int) $_SESSION["strQty"][$i] * $weight;
    }
}

function shipping_cost_check($totalWeight, $arr) {

    foreach ($arr as $arr_rates) {
        if ($totalWeight >= $arr_rates['shipping_rate_min'] && $totalWeight <= $arr_rates['shipping_rate_max']) {

            $last_cost = $arr_rates['shipping_cost'];
        }
    }

    return $last_cost;
}

//set and check shipping type
if ($shipping_total->getDataDesc("shipping_type", "id = 1") == 'rate_total') {
    $_SESSION['shipping_cost'] = $shipping_total->getDataDesc("shipping_cost_total", "id = 1");
} else if ($shipping_total->getDataDesc("shipping_type", "id = 1") == 'rate_custom') {
    $_SESSION['shipping_cost'] = shipping_cost_check($sum_weight, $arr_rate);
}

function chk_line_cart() {

    $chk = 0;
    for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {

        if ($_SESSION["strProductID"][$i] != "") {

            //	echo $_SESSION["strQty"][$i] ."<br>";

            $chk++;
        }
    }
    return $chk;
}
?>
<div class="col-md-9 col-md-push-3">
    <header class="page-title category-title">
        <h1 class="title-bar">Cart
            <div class="title-border"></div>
        </h1>
    </header>
    <br>
    <div class="row">
        <form action="<?php echo ADDRESS ?>cart.html" method="post">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom:0px; ">
                    <thead>
                        <tr>

                            <th style="text-align:center;">Picture</th>
                            <th>ProductName</th>
                            <th style="text-align:center;">Price</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;">Del</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$k = 0;
for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {


    if ($_SESSION["strProductID"][$i] != "") {

        $strSQL = "SELECT * FROM products WHERE id = " . $_SESSION["strProductID"][$i] . "";
        $objQuery = mysql_query($strSQL) or die(mysql_error());
        $objResult = mysql_fetch_array($objQuery, MYSQL_ASSOC);
        $qty = $_SESSION["strQty"][$i];
        $Total = $qty * $objResult["product_cost"];
        $SumTotal = $SumTotal + $Total;
        $_SESSION["Total"] = $SumTotal;
        ?>
                                <tr>

                                    <td align="center" class="col-sm-2"><img src="<?php echo ADDRESS_GALLERY . $objResult["products_file_name_cover"] ?>" style="width:48px;"></td>
                                    <td valign="middle" class="col-sm-3"><?= $objResult["product_name"]; ?></td>
                                    <td align="center" class="col-sm-2"><?= $objResult["product_cost"]; ?></td>

                                    <td align="center" class="col-sm-3"><input type="number"  name="qty[]" id="qty" value="<?php echo $qty; ?>" style="width: 80px;text-align: center;"></td>
                                    <td align="center" class="col-sm-1"><?= number_format($Total, 2); ?></td>
                                    <td align="center" class="col-sm-1"><a href="<?php echo ADDRESS ?>cart/<?= $i; ?>.html"><i class="glyphicon glyphicon-remove" style="color: rgb(228, 7, 7);"></i></a></td>
                                </tr>
                            <input type="hidden"  name="product_id[]" id="product_id" value="<?php echo $objResult["id"] ?>" >
                            <?php
                            $k = $k + 1;
                            }
                            }
                            ?>
                            </tbody>

                        </table>
                    </div>
                    <div class="panel panel-default" style="border-color:#DDDDDD;">
                        <div class="panel-body">
                            <input type="submit" value="Update cart" name="bt_submit" class="btn btn-default">
                            <a href="<?php echo ADDRESS ?>product.html" class="btn btn-default">Continue shopping</a> </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-6 col-xs-12">
                    <div class="col-md-12 col-xs-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><span style="font-size:large;">Cart Totals</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <th style="text-align:center;">Subtotal</th>
                                    <td><?php echo number_format($SumTotal, 2) ?></td>
                                </tr>
                                <tr class="">
                                    <th style="text-align:center;">Shipping</th>
                                    <td><?php echo $_SESSION['shipping_cost'] ?></td>
                                </tr>
                                <tr class="">
                                    <th style="text-align:center;">Total</th>
                                    <td>฿ <?php echo number_format($SumTotal + $_SESSION['shipping_cost'], 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 col-xs-12"> <a href="<?php echo ADDRESS ?>cart-checkout.html" class="btn btn-default col-md-12 col-xs-12">Proceed to Checkout</a> </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-md-pull-9">
        <?php include "inc/side_category.php"; ?>
</div>
