
  
   <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo $_GET['controllers']=='member'?'active':''?>"><a href="<?php echo ADDRESS?>member.html">แก้ไขชื่อและที่อยู่</a></li>
        <li class="hidden <?php echo $_GET['controllers']=='ordered'?'active':''?>"><a href="<?php echo ADDRESS?>ordered.html">ประวัติการสั่งซื้อ <span class="badge"> ทั้งหมด <?php echo $orders->CountDataDesc("id", "customer_id = ".$_SESSION['customer_id']."")?></span></a></li>
        <li class="<?php echo $_GET['controllers']=='ordered_status'?'active':''?>"><a href="<?php echo ADDRESS?>ordered_status.html">ประวัติการสั่งซื้อ <span class="badge hidden"> รอชำระเงิน <?php echo $orders->CountDataDesc("id", "customer_id = ".$_SESSION['customer_id']." AND status = 'รอการชำระเงิน'")?></span></a></li>
          <li class="<?php echo $_GET['controllers']=='shipping_status'?'active':''?>"><a href="<?php echo ADDRESS?>shipping_status.html">สถานะการส่งสินค้า </a></li>
        <li class="<?php echo $_GET['controllers']=='re-password'?'active':''?>"><a href="<?php echo ADDRESS?>re-password.html">เปลี่ยนรหัสผ่าน</a></li>
    </ul>