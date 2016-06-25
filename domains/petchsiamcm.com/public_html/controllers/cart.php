
<?php
session_start();
//session_destroy();
if (count($_SESSION["strProductID"]) == 0) {

    //header("location:" . ADDRESS . "product");
}

//delete item from cart
$cnt = "0";
if ($_GET['catID'] != '' && $_GET['productID'] == 'del') {


    $Line = $_GET["catID"];
    //$_SESSION["strProductID"][$Line] = "";
//	$_SESSION["strQty"][$Line] = "";
    //$_SESSION["intLine"] = $_SESSION["intLine"] - 1;
    unset($_SESSION["strQty"][$Line]);
    unset($_SESSION["strProductID"][$Line]);
    $_SESSION['count_cart'] = $_SESSION['count_cart'] - 1;
    header("location:" . ADDRESS . "cart");
    die();
    //$_SESSION["intLine"] = $_SESSION["intLine"] ;
//session_destroy();
}



//update cart
//product_id
//do == add
if (isset($_POST['product_id'])) {


    if ($_POST['product_id'] != '' && is_numeric($_POST['product_id'])) {

        if ($products->CountDataDesc('id', 'id=' . $_POST['product_id']) == 1) {

            if (!isset($_SESSION["intLine"])) {

                $_SESSION["intLine"] = 0;
                $_SESSION["strProductID"][0] = $_POST['product_id'];
                $_SESSION["strQty"][0] = 1;
            } else {

                $key = array_search($_POST['product_id'], $_SESSION["strProductID"]);
                if ((string) $key != "") {
                    $_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + 1;
                } else {

                    $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
                    $intNewLine = $_SESSION["intLine"];
                    $_SESSION["strProductID"][$intNewLine] = $_POST['product_id'];
                    $_SESSION["strQty"][$intNewLine] = 1;
                }
            }
            if (chk_line_cart() == count($_POST["qty"])) {

                $b = 0;
                for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {

                    if ($_SESSION["strProductID"][$i] != "") {

                        $_SESSION["strQty"][$i] = $_POST["qty"][$b];

                        $b++;
                    }
                }
            }
            header("location:" . ADDRESS . "product");
            die();
        } else {
            
            header("location:" . ADDRESS . "product");
            die();
        }
    }
}

//if ($_GET['catID'] != '' && is_numeric($_GET['catID'])) {
//
//    if ($products->CountDataDesc('id', 'id=' . $_GET['catID']) == 1) {
//
//        if (!isset($_SESSION["intLine"])) {
//
//            $_SESSION["intLine"] = 0;
//            $_SESSION["strProductID"][0] = $_GET['catID'];
//            $_SESSION["strQty"][0] = 1;
//        } else {
//
//            $key = array_search($_GET['catID'], $_SESSION["strProductID"]);
//            if ((string) $key != "") {
//                $_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + 1;
//            } else {
//
//                $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
//                $intNewLine = $_SESSION["intLine"];
//                $_SESSION["strProductID"][$intNewLine] = $_GET['catID'];
//                $_SESSION["strQty"][$intNewLine] = 1;
//            }
//        }
//        header("location:" . ADDRESS . "cart");
//        die();
//    } else {
//        header("location:" . ADDRESS . "product");
//        die();
//    }
//}
if ($_POST['bt_submit'] == 'คำนวณใหม่') {

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


<div class="col-md-12 well">
    <header class="page-title category-title">
        <h1 class="title-bar" style="color: #073705; font-size: 22px;font-weight: bold;text-align: center;">
            สินค้าในตะกร้า
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

                        <th class="text-center">ลบ</th>

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

                                <td class="quantity text-center"><input type="number" class="form-control"  name="qty[]" id="qty" value="<?php echo $qty; ?>" style="text-align: center;" data-validation="required,number"></td>

                                <td class="sumprice text-center"><?= $functions->formatcurrency(($Total)); ?></td>

                                <td class="sumprice text-center"><a href="<?php echo ADDRESS ?>cart/<?= $i; ?>/del"><i class="fa fa-times fa-2x" style="color: rgb(228, 7, 7);"></i></a></td>

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


                        <button type="submit" name="bt_submit" class="btn btn-info" value="คำนวณใหม่"><i class="fa fa-refresh" style="font-size: 16px;"></i> คำนวณใหม่</button>
                        <a href="<?= ADDRESS ?>verify"  class="btn btn-success" ><i class="fa fa-arrow-right" style="font-size: 16px;"></i> สั่งซื้อสินค้า</a> </div>

                </div>
            </div>

        </div>
    </form>
</div>

<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
<script>
    $.validate();

</script>

