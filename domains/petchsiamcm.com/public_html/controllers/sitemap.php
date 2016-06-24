

<!--Show All Product-->

<div class="row" style="margin-bottom: 40px;">

	<div class="col-md-3">
        <?php include "inc/side_category.php" ;?>
    </div>

	<div class="col-md-9">
		<div class="row">
			<div class="col-md-12">
				<div class="product-name">
					<h2 class="title-bar" style="float: left;">
						Site Map
						<div class="title-border"></div>
					</h2>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<h3>หน้าทั้งหมด</h3>
			<ul>
				<li><a href="<?php echo ADDRESS?>">Home</a></li>
				<li><a href="<?php echo ADDRESS?>product.html">All Product</a></li>
				<li><a href="<?php echo ADDRESS?>best-offer.html">Best offer</a></li>
				<li><a href="<?php echo ADDRESS?>order-pay.html">Order & Pay</a></li>
				<li><a href="<?php echo ADDRESS?>payment-confirm.html">Payment Confirm</a></li>
				<li><a href="<?php echo ADDRESS?>about-us.html">About Us</a></li>
				<li><a href="<?php echo ADDRESS?>blog.html">Blog</a></li>
			</ul>
		</div>
		<div class="col-md-12">
			<h3>หมวดหมู่</h3>
			<ul>
				<?php $sql = "SELECT * FROM " . $category->getTbl() . " ORDER BY id";
					
					$query = $db->Query($sql);
					while($row = $db->FetchArray($query)){ 
						//$cat_ref =  $category->getDataDesc("category_name_ref","id = " . $row['category_id'] . "");
					?>
					<li><a href="<?php echo ADDRESS . $row['category_name_ref']?>.html"><?php echo $row['category_name']?></a></li>
				
					
				<?php }?>
			</ul>
		</div>
		<div class="col-md-12">
			<h3>ป้ายกำกับสินค้า</h3>
			<ul>
				<?php $sql = "SELECT * , COUNT(`tag_title`) AS cnt   FROM ".$tag->getTbl()." GROUP BY `tag_title`";
					
					$query = $db->Query($sql);
					while($row = $db->FetchArray($query)){ 	
						
						$link_to = $row['link_to'];
						$arr_link_to = explode("-", $link_to);
						$cnt = "  [".$row['cnt']."] ";
						
						if($arr_link_to[0] == 'category'){ 
							
						  $url_category_id = $category->getDataDesc("category_name_ref", "id =". $arr_link_to[1]); ?>
 
					     <li><a href="<?php echo ADDRESS . "tag/". $url_category_id?>.html"><?php echo $row['tag_title'] . $cnt ?></a></li>
<?php 
						}
					    if($arr_link_to[0] == 'product'){ 
					       $category_id = $products->getDataDesc("category_id", "id =". $arr_link_to[1]); 
					       $url_category_id = $category->getDataDesc("category_name_ref", "id =". $category_id);
					       $url_product_id = $products->getDataDesc("product_name_ref", "id =". $arr_link_to[1]); ?>
					       <li><a href="<?php echo ADDRESS ."tag/". $url_category_id . "/" . $url_product_id?>.html"><?php echo $row['tag_title'] . $cnt ?></a></li>
					
					<?php } ?>
					
					
					
					
					
				<?php }?>
			</ul>
		</div>
		<div class="col-md-12">
			<h3>หมวดหมู่บทความ</h3>
			<ul>
				<?php $sql = "SELECT * FROM ".$blog_category->getTbl()."";
					
					$query = $db->Query($sql);
					while($row = $db->FetchArray($query)){ 	?>
						  <li><a href="<?php echo ADDRESS . "blog/". $row['category_name_ref']?>.html"><?php echo $row['category_name'] ?></a></li>
					
				<?php } ?>
				
			</ul>
		</div>
		<div class="col-md-12">
			<h3>ป้ายกำกับบทความ</h3>
			<ul>
				<?php $sql = "SELECT * FROM ".$blog->getTbl()."";
					
					$query = $db->Query($sql);
					while($row = $db->FetchArray($query)){ 	
						
						if( $row['tags'] != ''){
						$tags = explode(",", $row['tags']);
							foreach ($tags as $arr_tag){
							$blog_name_ref = $blog_category->getDataDesc("category_name_ref","id = ".$row['blog_category_id']); ?>
							
						     <li><a href="<?php echo ADDRESS . "blog/". $blog_name_ref ."/". $row['blog_name_ref']?>.html"><?php echo $arr_tag ?></a></li>
							
					   
						<?php } ?>
					<?php } ?>
				<?php } ?>
				
			</ul>
		</div>
	</div>


</div>

<style>
<!--
h3 {
	font-size: 14px;
	color: #575757;
}
-->
</style>
