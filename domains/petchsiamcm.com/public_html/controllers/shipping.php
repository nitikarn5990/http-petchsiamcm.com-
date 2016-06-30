<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/phpmailer/class.phpmailer.php');

session_start();

if (count($_SESSION["strProductID"]) == 0) {

    header("location:" . ADDRESS . "product");
    die();
}


if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


    $recaptcha_secret = "6LeMxSITAAAAAEPNFj9C3VJifv8yAUH3HDLkgRuW";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
    $response = json_decode($response, true);

    if ($response["success"] === true) {


        $arrData = array();
        $arrData = $functions->replaceQuote($_POST);
        $orders->SetValues($arrData);
        if ($orders->GetPrimary() == '') {


            $orders->SetValue('created_at', DATE_TIME);


            $orders->SetValue('updated_at', DATE_TIME);
        } else {


            $orders->SetValue('updated_at', DATE_TIME);
        }
        $orders->SetValue('order_date', DATE_TIME);
        $orders->SetValue('status', 'รอการชำระเงิน');
        if ($_SESSION['admin_id'] != '') {
            $orders->SetValue('customer_id', $_SESSION['admin_id']);
        } else {
            $orders->SetValue('customer_id', "0");
        }


        $year_bill = substr(intval(date('Y')) + intval(543), 2);
        $orders->SetValue('years', $year_bill);
        $orders->SetValue('months', date('m'));

        if ($orders->Save()) {
            $orders_id = $orders->GetValue('id');
            // send_email_order($orders_id);
            if ($orders_id != '') {
                //  $orders_id = $orders->GetValue('id');

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



                        //order detail
                        $orders_detail->SetValue('image', $products->getDataDesc("image", "id = " . $_SESSION["strProductID"][$i]));
                        $orders_detail->SetValue('orders_id', $orders_id);
                        $orders_detail->SetValue('product_id', $_SESSION["strProductID"][$i]);
                        $orders_detail->SetValue('product_name', $objResult["product_name"]);

                        $orders_detail->SetValue('qty', $qty);
                        $orders_detail->SetValue('cost', $products_cost);
                        // $orders_detail->SetValue('total', $Total);
                        if ($orders_detail->save()) {
                            
                        }
                    }
                }



                //gmail:petchsiamcm2016@gmail.com
                //pass: pcsc2016
                $acc_email = 'petchsiamcm2016@gmail.com';
                $acc_pass = 'pcsc2016';

                $mail = new PHPMailer();
                $mail->IsHTML(true);
                $mail->IsSMTP();
                $mail->SMTPAuth = true; // enable SMTP authentication
                $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
                $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
                // $mail->Host = "mail.petchsiamcm.com"; // sets GMAIL as the SMTP server   

                $mail->Port = 465; // set the SMTP port for the GMAIL server

                $mail->Username = $acc_email; // บัญชีสำหรับส่งเมล์ Gmail
                $mail->Password = $acc_pass; //  รหัส GMAIL
                $mail->FromName = 'บริษัท เพชรสยามการเกษตร จำกัด';  // ชื่อผู้ส่ง
                $mail->Subject = "รายละเอียดการสั่งซื้อสินค้า"; //ชื่อเรื่อง
                $mail->AddCC('nitikarnboom2030@gmail.com', ADDRESS); //สำเนาส่งถึง เมล์เจ้าของร้าน
                $mail->AddReplyTo('nitikarnboom2030@gmail.com', ADDRESS); //ตอบกลับถึง เมล์เจ้าของร้าน

                $mail->CharSet = "utf-8";


                $logo = ADDRESS . 'images/logo.png';
                $body = "";
                $detail = "";
                $name = $orders->getDataDesc("first_name", "id = " . $orders_id) . ' ' . $orders->getDataDesc("last_name", "id = " . $orders_id);
                $address = $orders->getDataDesc("address", "id = " . $orders_id);
                $tel = $orders->getDataDesc("tel", "id = " . $orders_id);
                $email = $orders->getDataDesc("email", "id = " . $orders_id);

                $order_no = $orders->getDataDesc("years", "id = " . $orders_id) . $functions->padLeft($orders->getDataDesc("months", "id = " . $orders_id), 2, '0') . $functions->padLeft($orders_id, 6, '0');
                $SumTotal = 0;
                $amt = 0;
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
                        $amt = $amt + $Total;
                        $_SESSION["Total"] = $SumTotal;




                        $detail .= "<tr>
                                <td class='pro-id' style='text-align: center;font-size: 14px;'><img src=" . ADDRESS . 'files/gallery/' . $objResult["image"] . " style='width:70px;' /></td>
                                <td class='pro-desc' style='text-align: center;font-size: 14px;'>" . $objResult["product_name"] . "</td>
                                <td class='pro-price' style='text-align: center;font-size: 14px;'>" . $functions->formatcurrency($products_cost) . "</td>
                                <td class='quantity' style='text-align: center;font-size: 14px;'>" . $qty . "</td>
                                <td class='sumprice' style='text-align: center;font-size: 14px;'>" . $functions->formatcurrency(($Total)) . "</td>
                            </tr>";
                    }
                }


                $link_confirm_payment = "<a style='font-size=20px;' href=" . ADDRESS . payment - confirm . " target='_blank'>แจ้งชำระเงิน คลิ๊ก</a>";

                $my_body = "<table align='center' border='0' cellpadding='0' cellspacing='5' width='100%'>
	<tbody>
		<tr>
			<td> 
			<p style='text-align: center;'><img alt='' src='" . $logo . "' style='width: 150px; height: 104px;' /></p>
			</td>
		</tr>
		<tr>
			<td>
			<table border='0' cellpadding='0' cellspacing='1' width='100%'>
				<tbody>
					<tr>
						<td>
						<table border='0' cellpadding='0' cellspacing='1' width='100%'>
							<tbody>
							</tbody>
						</table>

						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<tbody>
								<tr>
								</tr>
								<tr>
									<td style='width:170px;height:30px;background-color:rgb(0,0,0)'>
									<div style='text-align:center'><font color='#ffffff'>ข้อมูลการสั่งซื้อสินค้า</font></div>
									</td>
									<td style='background-color:#2d8a3f'>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#efefef'>
						<table border='0' cellpadding='0' cellspacing='5' width='100%'>
							<tbody>
								<tr>
									<td width='60%'>
									<div>
									<ul>
										<li style='color:#000;margin-bottom: 10px;'>หมายเลขสั่งซื้อ : &nbsp; &nbsp;<strong>" . $order_no . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>ชื่อ-สกุล : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong> " . $name . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>ที่อยู่ในการจัดส่ง &nbsp;:&nbsp;<strong>" . $address . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>เบอร์ติดต่อ : &nbsp; &nbsp; &nbsp; &nbsp;<strong> " . $tel . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>Email &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; " . $email . "</li>
										<li style='color:#000;margin-bottom: 10px;'>รายการสินค้า​ &nbsp;:<br>
										<table border='1' cellpadding='0' cellspacing='0' class='item-list' style='width: 100%;border-collapse: collapse; border: 1px solid #D4D4D4;'>
											<tbody>
												<tr>
													<th class='hidden' style='text-align: center;'>ภาพสินค้า</th>
													<th style='text-align: center;'>ชื่อสินค้า</th>
													<th style='text-align: center;'>ราคา/หน่วย</th>
													<th style='text-align: center;'>จำนวน</th>
													<th style='text-align: center;'>ราคารวม</th>
												</tr>
												" . $detail . "
											</tbody>
										</table>
										</li>
										<li style='color:#000'>จำนวนเงินรวม&nbsp;: <span style='color:#FF0000;'>" . $functions->formatcurrency($amt) . "</span> บาท</li>
									</ul>
									</div>
									</td>
								</tr>
								<tr>
									<td width='60%'>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
                        <p style='text-align: center;font-size: 20px;'><a href='" . ADDRESS . 'payment-confirm/' . ($order_no) . "' target='_blank'>แจ้งชำระเงิน คลิ๊ก!!!</a></p>
			<p>ขอแสดงความนับถือ</p>

			<p><a href='" . ADDRESS . "' target='_blank'>" . ADDRESS . "</a><br />
			<br />
			&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>";


                $mail->Body = $my_body;
                $mail->AddAddress($email); // to Address

                $mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low

                if (!$mail->Send()) {

                    $arrDel = array('id' => $orders_id);

                    $orders->SetValues($arrDel);

                    if ($orders->Delete()) {
                        echo "<script>alert('ส่งไม่สำเร็จสำเร็จ กรุณาลองใหม่อีกครั้ง !!!')</script>";
                        // echo "<script>$.unblockUI()</script>";
                        header("location:" . ADDRESS . "shipping");
                        die();
                    }
                } else {
                    //  echo "<script>alert('ส่งสำเร็จ !!!')</script>";
                    //  echo "<script>$.unblockUI()</script>";
                    // header("location:" . ADDRESS . "success/" . $orders_id);
                    //    header("location:" . ADDRESS . "product");
                    ?>

                    <?php
//clear cart
                    unset($_SESSION["intLine"]);
                    unset($_SESSION["strQty"]);
                    unset($_SESSION["strProductID"]);
                    unset($_SESSION["count_cart"]);
                    ?>
                    <div class="col-md-12 well text-center">
                        <div class="alert alert-success">
                            <p><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU4IDU4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1OCA1ODsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHJlY3QgeD0iMSIgeT0iMiIgc3R5bGU9ImZpbGw6I0UwQzZBOTsiIHdpZHRoPSI1NiIgaGVpZ2h0PSIxNCIvPgoJPHBvbHlsaW5lIHN0eWxlPSJmaWxsOiNGRkVDRDc7IiBwb2ludHM9IjUwLDggNTYsMiA1OCwyIDU4LDE2IDU2LDE2IDUwLDggICIvPgoJPHBvbHlnb24gc3R5bGU9ImZpbGw6I0NDQjI5NzsiIHBvaW50cz0iNTAsOCA1MCwxNiA1NiwxNiAgIi8+Cgk8cG9seWxpbmUgc3R5bGU9ImZpbGw6I0ZGRUNENzsiIHBvaW50cz0iOCw4IDIsMiAwLDIgMCwxNiAyLDE2IDgsOCAgIi8+Cgk8cG9seWdvbiBzdHlsZT0iZmlsbDojQ0NCMjk3OyIgcG9pbnRzPSI4LDggOCwxNiAyLDE2ICAiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGMEQ3Qjg7IiBkPSJNNTQuMjU4LDU2SDMuNzQyQzEuNjc1LDU2LDAsNTQuMzI1LDAsNTIuMjU4VjE2aDU4djM2LjI1OEM1OCw1NC4zMjUsNTYuMzI1LDU2LDU0LjI1OCw1NnoiLz4KCTxjaXJjbGUgc3R5bGU9ImZpbGw6IzcyNTQzQTsiIGN4PSIxNyIgY3k9IjI0IiByPSIzIi8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM3MjU0M0E7IiBjeD0iNDEiIGN5PSIyNCIgcj0iMyIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0NFQjY5RTsiIGQ9Ik0yOSw0M2MtNy4xNjgsMC0xMy01LjgzMi0xMy0xM3YtNmMwLTAuNTUzLDAuNDQ3LTEsMS0xczEsMC40NDcsMSwxdjZjMCw2LjA2NSw0LjkzNSwxMSwxMSwxMSAgIHMxMS00LjkzNSwxMS0xMXYtNmMwLTAuNTUzLDAuNDQ3LTEsMS0xczEsMC40NDcsMSwxdjZDNDIsMzcuMTY4LDM2LjE2OCw0MywyOSw0M3oiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" style="width: 100px;"/></p>
                            <h3 style="text-transform: uppercase;"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8cGF0aCBkPSJNMjU2LDBDMTE0LjYxNSwwLDAsMTE0LjYxNSwwLDI1NnMxMTQuNjE1LDI1NiwyNTYsMjU2czI1Ni0xMTQuNjE1LDI1Ni0yNTZTMzk3LjM4NSwwLDI1NiwweiBNMjA4LDQxNkwxMDIsMjc4bDQ3LTQ5bDU5LDc1ICAgbDE4NS0xNTFsMjMsMjNMMjA4LDQxNnoiIGZpbGw9IiM5MURDNUEiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" /> 
                                &nbsp;thank you for your order</h3>
                            <h5><b>Order number is: <?= $orders->getDataDesc("years", "id = " . $orders_id) . $orders->getDataDesc("months", "id = " . $orders_id) . $functions->padLeft($orders->getDataDesc("id", "id = " . $orders_id), 6, '0') ?></b></h5>
                            <p>ใบสั่งซื้อได้ถูกส่งไปยัง <?= $orders->getDataDesc("email", "id = " . $orders_id) ?> ของท่านแล้ว กรุณาเช็คที่กล่องจดหมาย (ถ้าไม่เจอให้ตรวจสอบที่ Junk box)</p>
                            <p class="hidden"><a href="" class="btn btn-default"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU4IDU4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1OCA1ODsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6I0JEQzNDNzsiIGQ9Ik01OCw0MC41SDh2LTI2aDUwVjQwLjV6IE0xMCwzOC41aDQ2di0yMkgxMFYzOC41eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0JEQzNDNzsiIGQ9Ik05LDE2LjVjLTAuNTUyLDAtMS0wLjQ0Ny0xLTF2LTljMC0wLjU1MywwLjQ0OC0xLDEtMXMxLDAuNDQ3LDEsMXY5QzEwLDE2LjA1Myw5LjU1MiwxNi41LDksMTYuNXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNCREMzQzc7IiBkPSJNOSw0Ny41Yy0wLjU1MiwwLTEtMC40NDctMS0xdi03YzAtMC41NTMsMC40NDgtMSwxLTFzMSwwLjQ0NywxLDF2N0MxMCw0Ny4wNTMsOS41NTIsNDcuNSw5LDQ3LjV6Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM1NTYwODA7IiBjeD0iMTkiIGN5PSI1MS41IiByPSI0Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM1NTYwODA7IiBjeD0iNDMiIGN5PSI1MS41IiByPSI0Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojQkRDM0M3OyIgZD0iTTUyLDQ3LjVIOWMtMC41NTIsMC0xLTAuNDQ3LTEtMXMwLjQ0OC0xLDEtMWg0M2MwLjU1MiwwLDEsMC40NDcsMSwxUzUyLjU1Miw0Ny41LDUyLDQ3LjV6Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM3MUMyODU7IiBjeD0iMzMiIGN5PSIxNS41IiByPSIxMyIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGRkZGRjsiIGQ9Ik0zMywyNC41Yy0wLjU1MiwwLTEtMC40NDctMS0xdi0xNmMwLTAuNTUzLDAuNDQ4LTEsMS0xczEsMC40NDcsMSwxdjE2ICAgQzM0LDI0LjA1MywzMy41NTIsMjQuNSwzMywyNC41eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGRkZGRjsiIGQ9Ik0zMywyNC41Yy0wLjI1NiwwLTAuNTEyLTAuMDk4LTAuNzA3LTAuMjkzYy0wLjM5MS0wLjM5MS0wLjM5MS0xLjAyMywwLTEuNDE0bDctNyAgIGMwLjM5MS0wLjM5MSwxLjAyMy0wLjM5MSwxLjQxNCwwczAuMzkxLDEuMDIzLDAsMS40MTRsLTcsN0MzMy41MTIsMjQuNDAyLDMzLjI1NiwyNC41LDMzLDI0LjV6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojRkZGRkZGOyIgZD0iTTMzLDI0LjVjLTAuMjU2LDAtMC41MTItMC4wOTgtMC43MDctMC4yOTNsLTctN2MtMC4zOTEtMC4zOTEtMC4zOTEtMS4wMjMsMC0xLjQxNCAgIHMxLjAyMy0wLjM5MSwxLjQxNCwwbDcsN2MwLjM5MSwwLjM5MSwwLjM5MSwxLjAyMywwLDEuNDE0QzMzLjUxMiwyNC40MDIsMzMuMjU2LDI0LjUsMzMsMjQuNXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNCREMzQzc7IiBkPSJNOSw3LjVINGMtMC41NTIsMC0xLTAuNDQ3LTEtMXMwLjQ0OC0xLDEtMWg1YzAuNTUyLDAsMSwwLjQ0NywxLDFTOS41NTIsNy41LDksNy41eiIvPgoJPGNpcmNsZSBzdHlsZT0iZmlsbDojRDg2MjVFOyIgY3g9IjMiIGN5PSI2LjUiIHI9IjMiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />&nbsp;ซื้อสินค้าเพิ่ม</a></p>
                            <p>

                            </p>
                        </div>
                    </div>



                    <?php
                }
            }
        }
    } else {
        //captcha error
//        echo "<script>  $(document).ready(function(){   noty({  text: 'Captcha Error', type: 'warning',
//                    theme: 'relax',
//                    timeout: 5000, }); });</script>";

        SetAlert('Captcha Error');
        header("location:" . ADDRESS . "shipping");
        die();
    }
} else {
    //คลิก ยืนยันการสั่งซื้อ
    if ($_POST['btn_verify'] == 'ยืนยันการสั่งซื้อ' || $_POST['btn_verify'] == '') {

        if ($_SESSION["group"] === 'member') {
            ?>

            <div class="col-md-12 well text-center">
                <?php
                // $arrData = array();
                //  $arrData = $functions->replaceQuote($_POST);
                //$orders->SetValues($arrData);
                if ($orders->GetPrimary() == '') {


                    $orders->SetValue('created_at', DATE_TIME);


                    $orders->SetValue('updated_at', DATE_TIME);
                } else {


                    $orders->SetValue('updated_at', DATE_TIME);
                }
                $orders->SetValue('order_date', DATE_TIME);
                $orders->SetValue('status', 'รอการชำระเงิน');

                if ($_SESSION['admin_id'] != '') {
                    $orders->SetValue('customer_id', $_SESSION['admin_id']);
                } else {
                    $orders->SetValue('customer_id', "0");
                }


                $year_bill = substr(intval(date('Y')) + intval(543), 2);
                $orders->SetValue('years', $year_bill);
                $orders->SetValue('months', date('m'));

                //get customer 
                $customer->SetPrimary((int) $_SESSION['admin_id']);
                
                if ($customer->GetInfo()) {
                    
                    $orders->SetValue('first_name', $customer->GetValue('customer_name'));
                    $orders->SetValue('last_name', $customer->GetValue('customer_lastname'));
                    $orders->SetValue('address', $customer->GetValue('customer_address'));
                    $orders->SetValue('province', $customer->GetValue('customer_province'));
                    $orders->SetValue('zipcode', $customer->GetValue('customer_zipcode'));
                    $orders->SetValue('tel', $customer->GetValue('customer_tel'));
                    $orders->SetValue('email', $customer->GetValue('customer_email'));
                }





                if ($orders->Save()) {
                    $orders_id = $orders->GetValue('id');
                    // echo $orders_id;
                    // die();
                    //send_email_order($orders_id);

                    if ($orders_id != '') {
                        //  $orders_id = $orders->GetValue('id');

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



                                //order detail
                                $orders_detail->SetValue('image', $products->getDataDesc("image", "id = " . $_SESSION["strProductID"][$i]));
                                $orders_detail->SetValue('orders_id', $orders_id);
                                $orders_detail->SetValue('product_id', $_SESSION["strProductID"][$i]);
                                $orders_detail->SetValue('product_name', $objResult["product_name"]);

                                $orders_detail->SetValue('qty', $qty);
                                $orders_detail->SetValue('cost', $products_cost);
                                // $orders_detail->SetValue('total', $Total);
                                if ($orders_detail->save()) {
                                    
                                }
                            }
                        }



                        //gmail:petchsiamcm2016@gmail.com
                        //pass: pcsc2016
                        $acc_email = 'petchsiamcm2016@gmail.com';
                        $acc_pass = 'pcsc2016';

                        $mail = new PHPMailer();
                        $mail->IsHTML(true);
                        $mail->IsSMTP();
                        $mail->SMTPAuth = true; // enable SMTP authentication
                        $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
                        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
                        // $mail->Host = "mail.petchsiamcm.com"; // sets GMAIL as the SMTP server   

                        $mail->Port = 465; // set the SMTP port for the GMAIL server

                        $mail->Username = $acc_email; // บัญชีสำหรับส่งเมล์ Gmail
                        $mail->Password = $acc_pass; //  รหัส GMAIL
                        $mail->FromName = 'บริษัท เพชรสยามการเกษตร จำกัด';  // ชื่อผู้ส่ง
                        $mail->Subject = "รายละเอียดการสั่งซื้อสินค้า"; //ชื่อเรื่อง
                        $mail->AddCC('nitikarnboom2030@gmail.com', ADDRESS); //สำเนาส่งถึง เมล์เจ้าของร้าน
                        $mail->AddReplyTo('nitikarnboom2030@gmail.com', ADDRESS); //ตอบกลับถึง เมล์เจ้าของร้าน

                        $mail->CharSet = "utf-8";


                        $logo = ADDRESS . 'images/logo.png';
                        $body = "";
                        $detail = "";
                        $name = $orders->getDataDesc("first_name", "id = " . $orders_id) . ' ' . $orders->getDataDesc("last_name", "id = " . $orders_id);
                        $address = $orders->getDataDesc("address", "id = " . $orders_id);
                        $tel = $orders->getDataDesc("tel", "id = " . $orders_id);
                        $email = $orders->getDataDesc("email", "id = " . $orders_id);

                        $order_no = $orders->getDataDesc("years", "id = " . $orders_id) . $functions->padLeft($orders->getDataDesc("months", "id = " . $orders_id), 2, '0') . $functions->padLeft($orders_id, 6, '0');
                        $SumTotal = 0;
                        $amt = 0;
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
                                $amt = $amt + $Total;
                                $_SESSION["Total"] = $SumTotal;




                                $detail .= "<tr>
                                <td class='pro-id' style='text-align: center;font-size: 14px;'><img src=" . ADDRESS . 'files/gallery/' . $objResult["image"] . " style='width:70px;' /></td>
                                <td class='pro-desc' style='text-align: center;font-size: 14px;'>" . $objResult["product_name"] . "</td>
                                <td class='pro-price' style='text-align: center;font-size: 14px;'>" . $functions->formatcurrency($products_cost) . "</td>
                                <td class='quantity' style='text-align: center;font-size: 14px;'>" . $qty . "</td>
                                <td class='sumprice' style='text-align: center;font-size: 14px;'>" . $functions->formatcurrency(($Total)) . "</td>
                            </tr>";
                            }
                        }


                        $link_confirm_payment = "<a style='font-size=20px;' href=" . ADDRESS . payment - confirm . " target='_blank'>แจ้งชำระเงิน คลิ๊ก</a>";

                        $my_body = "<table align='center' border='0' cellpadding='0' cellspacing='5' width='100%'>
	<tbody>
		<tr>
			<td> 
			<p style='text-align: center;'><img alt='' src='" . $logo . "' style='width: 150px; height: 104px;' /></p>
			</td>
		</tr>
		<tr>
			<td>
			<table border='0' cellpadding='0' cellspacing='1' width='100%'>
				<tbody>
					<tr>
						<td>
						<table border='0' cellpadding='0' cellspacing='1' width='100%'>
							<tbody>
							</tbody>
						</table>

						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<tbody>
								<tr>
								</tr>
								<tr>
									<td style='width:170px;height:30px;background-color:rgb(0,0,0)'>
									<div style='text-align:center'><font color='#ffffff'>ข้อมูลการสั่งซื้อสินค้า</font></div>
									</td>
									<td style='background-color:#2d8a3f'>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#efefef'>
						<table border='0' cellpadding='0' cellspacing='5' width='100%'>
							<tbody>
								<tr>
									<td width='60%'>
									<div>
									<ul>
										<li style='color:#000;margin-bottom: 10px;'>หมายเลขสั่งซื้อ : &nbsp; &nbsp;<strong>" . $order_no . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>ชื่อ-สกุล : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong> " . $name . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>ที่อยู่ในการจัดส่ง &nbsp;:&nbsp;<strong>" . $address . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>เบอร์ติดต่อ : &nbsp; &nbsp; &nbsp; &nbsp;<strong> " . $tel . "</strong></li>
										<li style='color:#000;margin-bottom: 10px;'>Email &nbsp;: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; " . $email . "</li>
										<li style='color:#000;margin-bottom: 10px;'>รายการสินค้า​ &nbsp;:<br>
										<table border='1' cellpadding='0' cellspacing='0' class='item-list' style='width: 100%;border-collapse: collapse; border: 1px solid #D4D4D4;'>
											<tbody>
												<tr>
													<th class='hidden' style='text-align: center;'>ภาพสินค้า</th>
													<th style='text-align: center;'>ชื่อสินค้า</th>
													<th style='text-align: center;'>ราคา/หน่วย</th>
													<th style='text-align: center;'>จำนวน</th>
													<th style='text-align: center;'>ราคารวม</th>
												</tr>
												" . $detail . "
											</tbody>
										</table>
										</li>
										<li style='color:#000'>จำนวนเงินรวม&nbsp;: <span style='color:#FF0000;'>" . $functions->formatcurrency($amt) . "</span> บาท</li>
									</ul>
									</div>
									</td>
								</tr>
								<tr>
									<td width='60%'>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td>
                        <p style='text-align: center;font-size: 20px;'><a href='" . ADDRESS . 'payment-confirm/' . ($order_no) . "' target='_blank'>แจ้งชำระเงิน คลิ๊ก!!!</a></p>
			<p>ขอแสดงความนับถือ</p>

			<p><a href='" . ADDRESS . "' target='_blank'>" . ADDRESS . "</a><br />
			<br />
			&nbsp;</p>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>";


                        $mail->Body = $my_body;
                        $mail->AddAddress($email); // to Address

                        $mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low

                        if (!$mail->Send()) {
                            $arrDel = array('id' => $orders_id);

                            $orders->SetValues($arrDel);

                            if ($orders->Delete()) {
                                echo "<script>alert('ส่งไม่สำเร็จสำเร็จ กรุณาลองใหม่อีกครั้ง !!!')</script>";
                                // echo "<script>$.unblockUI()</script>";
                                header("location:" . ADDRESS . "shipping");
                                die();
                            }
                        } else {
                            //  echo "<script>alert('ส่งสำเร็จ !!!')</script>";
                            //  echo "<script>$.unblockUI()</script>";
                            // header("location:" . ADDRESS . "success/" . $orders_id);
                            //    header("location:" . ADDRESS . "product");
                            ?>

                            <?php
//clear cart
                            unset($_SESSION["intLine"]);
                            unset($_SESSION["strQty"]);
                            unset($_SESSION["strProductID"]);
                            unset($_SESSION["count_cart"]);
                            ?>
                            <div class="alert alert-success">
                                <p><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU4IDU4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1OCA1ODsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHJlY3QgeD0iMSIgeT0iMiIgc3R5bGU9ImZpbGw6I0UwQzZBOTsiIHdpZHRoPSI1NiIgaGVpZ2h0PSIxNCIvPgoJPHBvbHlsaW5lIHN0eWxlPSJmaWxsOiNGRkVDRDc7IiBwb2ludHM9IjUwLDggNTYsMiA1OCwyIDU4LDE2IDU2LDE2IDUwLDggICIvPgoJPHBvbHlnb24gc3R5bGU9ImZpbGw6I0NDQjI5NzsiIHBvaW50cz0iNTAsOCA1MCwxNiA1NiwxNiAgIi8+Cgk8cG9seWxpbmUgc3R5bGU9ImZpbGw6I0ZGRUNENzsiIHBvaW50cz0iOCw4IDIsMiAwLDIgMCwxNiAyLDE2IDgsOCAgIi8+Cgk8cG9seWdvbiBzdHlsZT0iZmlsbDojQ0NCMjk3OyIgcG9pbnRzPSI4LDggOCwxNiAyLDE2ICAiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGMEQ3Qjg7IiBkPSJNNTQuMjU4LDU2SDMuNzQyQzEuNjc1LDU2LDAsNTQuMzI1LDAsNTIuMjU4VjE2aDU4djM2LjI1OEM1OCw1NC4zMjUsNTYuMzI1LDU2LDU0LjI1OCw1NnoiLz4KCTxjaXJjbGUgc3R5bGU9ImZpbGw6IzcyNTQzQTsiIGN4PSIxNyIgY3k9IjI0IiByPSIzIi8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM3MjU0M0E7IiBjeD0iNDEiIGN5PSIyNCIgcj0iMyIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0NFQjY5RTsiIGQ9Ik0yOSw0M2MtNy4xNjgsMC0xMy01LjgzMi0xMy0xM3YtNmMwLTAuNTUzLDAuNDQ3LTEsMS0xczEsMC40NDcsMSwxdjZjMCw2LjA2NSw0LjkzNSwxMSwxMSwxMSAgIHMxMS00LjkzNSwxMS0xMXYtNmMwLTAuNTUzLDAuNDQ3LTEsMS0xczEsMC40NDcsMSwxdjZDNDIsMzcuMTY4LDM2LjE2OCw0MywyOSw0M3oiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" style="width: 100px;"/></p>
                                <h3 style="text-transform: uppercase;"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8cGF0aCBkPSJNMjU2LDBDMTE0LjYxNSwwLDAsMTE0LjYxNSwwLDI1NnMxMTQuNjE1LDI1NiwyNTYsMjU2czI1Ni0xMTQuNjE1LDI1Ni0yNTZTMzk3LjM4NSwwLDI1NiwweiBNMjA4LDQxNkwxMDIsMjc4bDQ3LTQ5bDU5LDc1ICAgbDE4NS0xNTFsMjMsMjNMMjA4LDQxNnoiIGZpbGw9IiM5MURDNUEiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" /> 
                                    &nbsp;thank you for your order</h3>
                                <h5><b>Order number is: <?= $orders->getDataDesc("years", "id = " . $orders_id) . $orders->getDataDesc("months", "id = " . $orders_id) . $functions->padLeft($orders->getDataDesc("id", "id = " . $orders_id), 6, '0') ?></b></h5>
                                <p>ใบสั่งซื้อได้ถูกส่งไปยัง <?= $customer->getDataDesc("customer_email", "id = " . $_SESSION["admin_id"]) ?> ของท่านแล้ว กรุณาเช็คที่กล่องจดหมาย (ถ้าไม่เจอให้ตรวจสอบที่ Junk box)</p>
                                <p class="hidden"><a href="" class="btn btn-default"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU4IDU4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1OCA1ODsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6I0JEQzNDNzsiIGQ9Ik01OCw0MC41SDh2LTI2aDUwVjQwLjV6IE0xMCwzOC41aDQ2di0yMkgxMFYzOC41eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0JEQzNDNzsiIGQ9Ik05LDE2LjVjLTAuNTUyLDAtMS0wLjQ0Ny0xLTF2LTljMC0wLjU1MywwLjQ0OC0xLDEtMXMxLDAuNDQ3LDEsMXY5QzEwLDE2LjA1Myw5LjU1MiwxNi41LDksMTYuNXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNCREMzQzc7IiBkPSJNOSw0Ny41Yy0wLjU1MiwwLTEtMC40NDctMS0xdi03YzAtMC41NTMsMC40NDgtMSwxLTFzMSwwLjQ0NywxLDF2N0MxMCw0Ny4wNTMsOS41NTIsNDcuNSw5LDQ3LjV6Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM1NTYwODA7IiBjeD0iMTkiIGN5PSI1MS41IiByPSI0Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM1NTYwODA7IiBjeD0iNDMiIGN5PSI1MS41IiByPSI0Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojQkRDM0M3OyIgZD0iTTUyLDQ3LjVIOWMtMC41NTIsMC0xLTAuNDQ3LTEtMXMwLjQ0OC0xLDEtMWg0M2MwLjU1MiwwLDEsMC40NDcsMSwxUzUyLjU1Miw0Ny41LDUyLDQ3LjV6Ii8+Cgk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM3MUMyODU7IiBjeD0iMzMiIGN5PSIxNS41IiByPSIxMyIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGRkZGRjsiIGQ9Ik0zMywyNC41Yy0wLjU1MiwwLTEtMC40NDctMS0xdi0xNmMwLTAuNTUzLDAuNDQ4LTEsMS0xczEsMC40NDcsMSwxdjE2ICAgQzM0LDI0LjA1MywzMy41NTIsMjQuNSwzMywyNC41eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGRkZGRjsiIGQ9Ik0zMywyNC41Yy0wLjI1NiwwLTAuNTEyLTAuMDk4LTAuNzA3LTAuMjkzYy0wLjM5MS0wLjM5MS0wLjM5MS0xLjAyMywwLTEuNDE0bDctNyAgIGMwLjM5MS0wLjM5MSwxLjAyMy0wLjM5MSwxLjQxNCwwczAuMzkxLDEuMDIzLDAsMS40MTRsLTcsN0MzMy41MTIsMjQuNDAyLDMzLjI1NiwyNC41LDMzLDI0LjV6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojRkZGRkZGOyIgZD0iTTMzLDI0LjVjLTAuMjU2LDAtMC41MTItMC4wOTgtMC43MDctMC4yOTNsLTctN2MtMC4zOTEtMC4zOTEtMC4zOTEtMS4wMjMsMC0xLjQxNCAgIHMxLjAyMy0wLjM5MSwxLjQxNCwwbDcsN2MwLjM5MSwwLjM5MSwwLjM5MSwxLjAyMywwLDEuNDE0QzMzLjUxMiwyNC40MDIsMzMuMjU2LDI0LjUsMzMsMjQuNXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNCREMzQzc7IiBkPSJNOSw3LjVINGMtMC41NTIsMC0xLTAuNDQ3LTEtMXMwLjQ0OC0xLDEtMWg1YzAuNTUyLDAsMSwwLjQ0NywxLDFTOS41NTIsNy41LDksNy41eiIvPgoJPGNpcmNsZSBzdHlsZT0iZmlsbDojRDg2MjVFOyIgY3g9IjMiIGN5PSI2LjUiIHI9IjMiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />&nbsp;ซื้อสินค้าเพิ่ม</a></p>
                                <p>

                                </p> 
                            </div>



                            <?php
                        }
                    }


                    unset($_SESSION["intLine"]);
                    unset($_SESSION["strQty"]);
                    unset($_SESSION["strProductID"]);
                    unset($_SESSION["count_cart"]);

//clear cart
                    ?>

                </div>
            <?php } ?>


        <?php } else { ?>

            <div class="well col-md-12">
                <div class="col-md-12">

                    <?php
                    // Report errors to the user


                    Alert(GetAlert('error'));


                    Alert(GetAlert('success'), 'success');
                    ?>


                </div>
                <div class="col-md-12">
                    <h1 style="margin-top: 0px;font-size: 31px;">
                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQyMi41MTggNDIyLjUxOCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDIyLjUxOCA0MjIuNTE4OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxwYXRoIGQ9Ik00MjIuNTEyLDIxNS40MjRjMC0wLjA3OS0wLjAwNC0wLjE1OC0wLjAwNS0wLjIzN2MtMC4xMTYtNS4yOTUtNC4zNjgtOS41MTQtOS43MjctOS41MTRoLTIuNTU0bC0zOS40NDMtNzYuMjU4ICBjLTEuNjY0LTMuMjItNC45ODMtNS4yMjUtOC42NDctNS4yMjZsLTY3LjM0LTAuMDE0bDIuNTY5LTIwLjM2NGMwLjczMy04LjEzOC0xLjc4My0xNS44MjItNy4wODYtMjEuNjM4ICBjLTUuMjkzLTUuODA0LTEyLjY4My05LjAwMS0yMC44MS05LjAwMWgtMjA5Yy01LjI1NSwwLTkuNzE5LDQuMDY2LTEwLjIyLDkuMzA4bC0yLjA5NSwxNi43NzhoMTE5LjA3OCAgYzcuNzMyLDAsMTMuODM2LDYuMjY4LDEzLjYzNCwxNGMtMC4yMDMsNy43MzItNi42MzUsMTQtMTQuMzY3LDE0SDEyNi43OGMwLjAwNywwLjAyLDAuMDE0LDAuMDQsMC4wMjEsMC4wNTlIMTAuMTYzICBjLTUuNDY4LDAtMTAuMDE3LDQuNDMyLTEwLjE2LDkuOWMtMC4xNDMsNS40NjgsNC4xNzMsOS45LDkuNjQxLDkuOUgxNjQuMDZjNy4xNjgsMS4xMDQsMTIuNTIzLDcuMzAzLDEyLjMyNiwxNC44MDggIGMtMC4yMTYsOC4yNDItNy4wMzksMTQuOTI1LTE1LjI2NywxNC45OTRINTQuNjYxYy01LjUyMywwLTEwLjExNyw0LjQ3Ny0xMC4yNjIsMTBjLTAuMTQ1LDUuNTIzLDQuMjE1LDEwLDkuNzM4LDEwaDEwNS4yMDQgIGM3LjI3MywxLjAxMywxMi43MzUsNy4yNjIsMTIuNTM3LDE0Ljg0Yy0wLjIxNyw4LjI4NC03LjEwOSwxNS0xNS4zOTMsMTVIMzUuNzkydjAuMDExSDI1LjY1MWMtNS41MjMsMC0xMC4xMTcsNC40NzctMTAuMjYyLDEwICBjLTAuMTQ1LDUuNTIzLDQuMjE0LDEwLDkuNzM4LDEwaDguNzUybC0zLjQyMywzNS44MThjLTAuNzM0LDguMTM3LDEuNzgyLDE1LjgyMSw3LjA4NiwyMS42MzdjNS4yOTIsNS44MDUsMTIuNjgzLDkuMDAxLDIwLjgxLDkuMDAxICBoNy41NUM2OS41LDMzMy44LDg3LjMsMzQ5LjM0NSwxMDkuMDczLDM0OS4zNDVjMjEuNzczLDAsNDAuMzg3LTE1LjU0NSw0NS4wNi0zNi4xMThoOTQuMjE5YzcuNjE4LDAsMTQuODMtMi45MTMsMjAuNDg2LTcuNjgyICBjNS4xNzIsNC45NjQsMTIuMDI4LDcuNjgyLDE5LjUxNCw3LjY4MmgxLjU1YzMuNTk3LDIwLjU3MywyMS4zOTcsMzYuMTE4LDQzLjE3MSwzNi4xMThjMjEuNzczLDAsNDAuMzg3LTE1LjU0NSw0NS4wNi0zNi4xMThoNi4yMTkgIGMxNi4yMDEsMCwzMC41NjktMTMuMTcxLDMyLjAyOS0yOS4zNmw2LjA5NC02Ny41MDZjMC4wMDgtMC4wOTEsMC4wMDQtMC4xODEsMC4wMS0wLjI3M2MwLjAxLTAuMTM5LDAuMDI5LTAuMjc1LDAuMDMzLTAuNDE1ICBDNDIyLjUyLDIxNS41ODksNDIyLjUxMiwyMTUuNTA4LDQyMi41MTIsMjE1LjQyNHogTTEwOS41OTcsMzI5LjM0NWMtMTMuNzg1LDAtMjQuNzA3LTExLjIxNC0yNC4zNDYtMjQuOTk5ICBjMC4zNjEtMTMuNzg2LDExLjg3LTI1LjAwMSwyNS42NTUtMjUuMDAxYzEzLjc4NSwwLDI0LjcwNiwxMS4yMTUsMjQuMzQ1LDI1LjAwMUMxMzQuODksMzE4LjEzMSwxMjMuMzgyLDMyOS4zNDUsMTA5LjU5NywzMjkuMzQ1eiAgIE0zMzMuNTk3LDMyOS4zNDVjLTEzLjc4NSwwLTI0LjcwNi0xMS4yMTQtMjQuMzQ2LTI0Ljk5OWMwLjM2MS0xMy43ODYsMTEuODctMjUuMDAxLDI1LjY1NS0yNS4wMDEgIGMxMy43ODUsMCwyNC43MDcsMTEuMjE1LDI0LjM0NSwyNS4wMDFDMzU4Ljg5LDMxOC4xMzEsMzQ3LjM4MiwzMjkuMzQ1LDMzMy41OTcsMzI5LjM0NXogTTM5Ni40NTcsMjgyLjU4OCAgYy0wLjUyLDUuNzY3LTUuODIzLDEwLjYzOS0xMS41OCwxMC42MzloLTYuNzI3Yy00LjQ1NC0xOS40NTMtMjEuNzQ0LTMzLjg4Mi00Mi43MjEtMzMuODgyYy0yMC45NzcsMC0zOS4wMjIsMTQuNDI5LTQ0LjQ5NCwzMy44ODIgIGgtMi4wNTljLTIuNTQyLDAtNC44MS0wLjk1My02LjM4OS0yLjY4NWMtMS41ODktMS43NDItMi4zMzctNC4xMTMtMi4xMDYtNi42NzZsMTIuNjA5LTEzOS42OTFsMjguOTU5LDAuMDA2bC00LjU5LDUwLjg1MiAgYy0wLjczNSw4LjEzNywxLjc4LDE1LjgyMSw3LjA4MywyMS42MzdjNS4yOTIsNS44MDYsMTIuNjg1LDkuMDA0LDIwLjgxMyw5LjAwNGg1Ni4zMzhMMzk2LjQ1NywyODIuNTg4eiIgZmlsbD0iIzAwMDAwMCIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                        ที่อยู่ในการจัดส่งสินค้า
                    </h1>

                </div>
                <div class="col-md-12">
                    <form class="form-horizontal" id="myform" enctype="multipart/form-data"   method="POST" action="<?php echo ADDRESS ?>shipping">
                        <h4>
                            ข้อมูลการโอนเงิน
                        </h4>

                        <div class="row">
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">ชื่อ <em>*</em></label>
                                <span>
                                    <input type="text" class="form-control" name="first_name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>" data-validation="required" >
                                </span> 
                            </div>
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">นามสกุล <em>*</em></label>
                                <span>
                                    <input type="text" class="form-control" name="last_name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>" data-validation="required" >
                                </span> 
                            </div>
                            <div class="col-md-12"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">ที่อยู่<em>*</em></label>
                                <span>
                                    <textarea class="form-control" rows="3" name="address" data-validation="required"><?= isset($_POST['address']) ? $_POST['address'] : '' ?></textarea>

                                </span> 
                            </div>
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">จังหวัด<em>*</em></label>
                                <span>
                                    <input type="text" class="form-control" name="province" value="<?= isset($_POST['province']) ? $_POST['province'] : '' ?>" data-validation="required">

                                </span> 
                            </div>
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">รหัสไปรษณีย์<em>*</em></label>
                                <span>
                                    <input type="text" class="form-control" name="zipcode" value="<?= isset($_POST['zipcode']) ? $_POST['zipcode'] : '' ?>" data-validation="number,required">

                                </span> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">เบอร์โทร <em>*</em></label>
                                <span>
                                    <input type="text" class="form-control" name="tel" value="<?= isset($_POST['tel']) ? $_POST['tel'] : '' ?>" data-validation="number,required">
                                </span> 
                            </div>
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <label for="inputHelpBlock">Email <em>*</em></label>
                                <span>
                                    <input type="text" name="email" class="form-control" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>"  data-validation="required,email">
                                </span> 
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6"  style="padding-bottom:10px;">

                                <label for="inputHelpBlock">รายละเอียดเพิ่มเติม <em></em></label>
                                <textarea class="form-control" rows="3" name="comment"><?= isset($_POST['comment']) ? $_POST['comment'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"  style="padding-bottom:10px;">
                                <div class="g-recaptcha" data-sitekey="6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="submit_bt" class="btn btn-success" name="submit_bt" value="บันทึกข้อมูล"><i class="fa fa-save"></i>&nbsp;บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
        <?php
    } else {

        //  header("location:" . ADDRESS . "verify");
        // die();
    }
    ?>

<?php } ?>



<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>

<script>
    //$.validate();

    // echo " $.blockUI({message: '<h3> Loading...</h3>'});";

    $.validate({
        onSuccess: function ($form) {
            $.blockUI({message: '<h3> Loading...</h3>'});
        },
    });

</script>  