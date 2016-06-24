<?php 
if($_POST['btn_news'] == 'สมัครรับข่าวสาร'){
	if($_POST['txt_email_news'] == ''){
		
		echo "<script> alert('กรุณากรอก E-mail !!'); </script>";
	}else{
		require_once('phpmailer/class.phpmailer.php');
		
		
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
		$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
		$mail->Port = 465; // set the SMTP port for the GMAIL server
		$mail->Username = "suthira.b@muangthai.co.th"; // GMAIL username
		$mail->Password = "12345678"; // GMAIL password
		$mail->From = "suthira.b@muangthai.co.th"; // "name@yourdomain.com";
		$mail->FromName = "!! ลูกค้าสนใจ รับข่าวสารและโปรโมชั่น เมืองไทยประกันชีวิต !!";  // set from Name
		$mail->Subject = "รับข่าวสารและโปรโมชั่น"; 
		$mail->CharSet = "utf-8";
		$mail->Body = "<table width='603' border='1'>
		<tr>
			<td width='324'><div align='right'>E- mail;*</div></td>
			<td width='239' style='color:blue;'>  ".$_POST['txt_email_news']. "</td>
		</tr>
	
		</table>";
		 
		$mail->AddAddress('suthira.b@muangthai.co.th'); // to Address
		 
		$mail->set('X-Priority', '1'); //Priority 1 = High, 3 = Normal, 5 = low
		
			if(!$mail->Send()) 
			{
				//echo 'Mailer Error: ' . $mail->ErrorInfo.'<br />';
					echo "<script> alert('ไม่สามารถทำรายการได้ ลองอีกครั้ง!!'); </script>";
			} 
			else 
			{
					echo "<script> alert('สำเร็จ เราจะอัพเดตโปรโมชั่นและส่งไปยังอีเมลล์ท่านทุกครั้งที่มีกิจกรรม ขอบคุณค่ะ'); </script>";
			}
		
		
	}
	
}

?>

<div id="columnLeft">
  <input type="hidden" id="interestRateActive" name="interestRateActive" value="01" />
  <div id="enews">
    <div class="t-center" style="margin-bottom: 10px;"><a href="<?php echo ADDRESS?>สมัครตัวแทน"><img src="<?php echo ADDRESS_MEDIA?>regis.gif" width="225" height="120"></a></div>
    <div class="formEnews" style="padding-top:10px;">
     
      <div class="t-center" style="padding-bottom:10px;"><a href="<?php echo ADDRESS?>แบบประกันยอดนิยม/โปรโมชั่น"><img src="<?php echo ADDRESS_MEDIA?>promotion.gif"></a></div>
      <div class="t-center"><a href="<?php echo ADDRESS?>กรอกข้อมูล"><img src="<?php echo ADDRESS_MEDIA?>call-back.png" style="width: 225px; margin-bottom:10px;"></a></div>
     <!-- <div class="t-center" style="margin-bottom: 10px;"><a href="<?php echo ADDRESS?>สมัครตัวแทน"><img src="<?php echo ADDRESS_MEDIA?>regis.gif" width="225" height="120"></a></div>-->
      <div class="t-center"><a href="<?php echo ADDRESS?>แบบประกันยอดนิยม/opd"><img src="<?php echo ADDRESS_MEDIA?>opd.jpg" style="width: 225px; margin-bottom:10px;"></a></div>
      <div class="t-center"><a href="<?php echo ADDRESS?>แบบประกันยอดนิยม/8555"><img src="<?php echo ADDRESS_MEDIA?>g20.jpg" style="width: 225px; margin-bottom:10px;"></a></div>
      <div class="t-center"><a href="<?php echo ADDRESS?>แบบประกันยอดนิยม/99-20"><img src="<?php echo ADDRESS_MEDIA?>99-20-side.png" style="width: 225px; margin-bottom:10px;"></a></div>
      <div class="t-center"><a href="http://www.thaimutualfundnews.com/program/tax.html"><img src="<?php echo ADDRESS_MEDIA?>tax.gif" style="width: 225px; margin-bottom:10px;"></a></div>
    </div>
  </div> 
  <div id="enews">
    <h1>สมัครรับข่าวสารและโปรโมชั่น</h1>
    <div class="formEnews">
      <label>อีเมล์</label>
      <form name='form1' action="" method="post">
        <input id="txt_email_news" name="txt_email_news" type="text"  placeholder="กรอกอีเมล์ของคุณ">
        <input type="submit" value="สมัครรับข่าวสาร" class="btnPink" name="btn_news" />
      </form>
    </div>
  </div>
  <div id="enews">
    <div class="formEnews" style="padding-top:10px;">
      <div class="t-center" style="padding-bottom: 10px;"><a href="http://www.muangthai.co.th/webmtl/Default.aspx?tabid=251&language=th-TH" rel="nofollow"><img src="<?php echo ADDRESS_MEDIA?>smileclub_member.gif" alt="smileclub"></a></div>
      <div class="t-center" style="padding-bottom:10px;"><a href="http://www.muangthai.co.th/webmtl/Default.aspx?tabid=281" rel="nofollow"><img src="<?php echo ADDRESS_MEDIA?>smileplus.gif"></a></div>
      <div class="t-center" style="padding-bottom:10px;"><a href="http://www.muangthai.co.th/SmileService/" rel="nofollow"><img src="<?php echo ADDRESS_MEDIA?>banner-smileservice02.gif"></a></div>
      <div class="t-center" style="padding-bottom:10px;"><a href="<?php echo ADDRESS?>โรงพยาบาลในเครือ-เมืองไทยประกันชีวิต"><img src="<?php echo ADDRESS_MEDIA?>hospital.png" style="width:98%;"></a></div>
      <div class="t-center"><a href="http://www.muangthai.co.th/webmtl/Default.aspx?tabid=217&language=en-US" rel="nofollow"><img src="<?php echo ADDRESS_MEDIA?>payment_1.png" width="225" height="120"></a></div>
      <br>
      <div class="t-center" ><img src="<?php echo ADDRESS_MEDIA?>callcenter.png" style="width:225px;"></div>
    </div>
  </div>
</div>
<style>
	.btnPink{
		color: #FFF !important;
		font-size: 14px !important;
		background: #ff0066;
		padding: 5px 12px 3px 12px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		
	}
	.btnPink:hover{cursor:pointer;}
	</style>
