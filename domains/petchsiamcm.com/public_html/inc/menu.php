<nav class="navbar navbar-default navbar-main navbar-center" role="navigation" id="navbar-main" style="box-shadow: 0 4px 2px -2px rgba(128, 128, 128, 0.4);"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo ADDRESS?>"> หน้าหลัก </a>
            <li>
            <li class="dropdown"> <a id="all_product" href="<?php echo ADDRESS?>product.html" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" aria-expanded="false">สินค้า <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php 

		$sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";
		
		$query = $db->Query($sql);
        while($row = $db->FetchArray($query)){ ?>
                    <li><a href="<?php echo ADDRESS ."product/" .$row['category_name_ref']?>.html"><?php echo $row['category_name']?></a></li>
                    <?php }?>
                </ul>
            </li>
            <li><a href="<?php echo ADDRESS?>promotion.html">โปรโมชั่น</a></li>
            <li><a href="<?php echo ADDRESS?>order-pay.html">วิธีการสั่งซื้อ</a></li>
            <li><a href="<?php echo ADDRESS?>payment-confirm.html">แจ้งการโอนเงิน</a></li>
            <li><a href="<?php echo ADDRESS?>about-us.html">เกี่ยวกับเรา</a></li>
       
            <li><a href="<?php echo ADDRESS?>contact-us.html">ติดต่อเรา</a></li>
        </ul>
    </div>
</nav>
<script> //dropdrop when hover
$('.dropdown').hover(function(){ 
  $('.dropdown-toggle', this).trigger('click'); 
  	$(this).addClass( "open" );
});
$('.dropdown').mouseleave(function(){
	
	$(this).removeClass( "open" )
});


$("#all_product").click(function(e) {
    // window.location = "<?php // echo ADDRESS?>product.html";
});
</script>