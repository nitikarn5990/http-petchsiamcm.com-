<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');

//$user_refer_id = $_POST['user_refer_id'];
//
//
//
//	if($customer->CountDataDesc("id","id = '".$user_refer_id."'" ) > 0){  
//		$res = 'ชื่อผู้แนะนำคือ : '.$customer->getDataDesc("customer_name","id = " . $user_refer_id) . ' '. $customer->getDataDesc("customer_lastname","id = " . $user_refer_id);
//	
//	}else{
//		$res = "ไม่พบข้อมูล";
//	}
//	
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

$total_qty = 0;
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
            $total_qty = count_qty_cart();

        } else {
            
        }
    }
}else{
      $total_qty = count_qty_cart();
}

function count_qty_cart() {
    //นับจำนวน qty
    $cnt_qty = 0;
    for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {

        if ($_SESSION["strProductID"][$i] != "") {

            $strSQL = "SELECT * FROM products WHERE id = " . $_SESSION["strProductID"][$i] . "";
            $objQuery = mysql_query($strSQL) or die(mysql_error());
            $objResult = mysql_fetch_array($objQuery, MYSQL_ASSOC);

//                    if ($_SESSION['group'] != '' && $_SESSION['group'] == 'member') {
//                        $products_cost = $objResult['product_member_cost'];
//                    } else {
//                        $products_cost = $objResult['product_cost'];
//                    }

            $qty = $_SESSION["strQty"][$i];
            // $Total = $qty * $products_cost;
            // $SumTotal = $SumTotal + $Total;
            //$_SESSION["Total"] = $SumTotal;

            $cnt_qty = $cnt_qty + $qty;
        }
    }
    return $cnt_qty;
}

echo $total_qty;
?>


