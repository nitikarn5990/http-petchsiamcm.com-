<?php  include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php'); ?>
<link rel="stylesheet" href="<?php echo ADDRESS_PLUGINS ."zoom/"?>css/smoothproducts.css">
<div class="sp-loading"><img src="<?php echo ADDRESS_PLUGINS ."zoom/"?>images/sp-loading.gif" alt=""><br>
    LOADING IMAGES
</div>
<div class="sp-wrap">
    <?php 
		
		
			   $product_id =  $products->getDataDesc("id","product_name_ref = '" . $_GET['productID'] . "'");
				
				$sql = "SELECT * FROM " . $product_files->getTbl() . " WHERE product_id = ".PRO_ID."";
					
				$query = $db->Query($sql);
				while($row = $db->FetchArray($query)){ ?>
    				<a href="<?php echo ADDRESS_GALLERY . $row['file_name']?>"><img src="<?php echo ADDRESS_GALLERY . $row['file_name']?>" alt="<?php echo $row['alt_tag']?>"></a>
    
	
			<?php }?>
</div>

<!-- JS ======================================================= --> 
<script type="text/javascript" src="<?php echo ADDRESS_PLUGINS ."zoom/"?>js/jquery-2.1.3.min.js"></script> 
<script type="text/javascript" src="<?php echo ADDRESS_PLUGINS ."zoom/"?>js/smoothproducts.min.js"></script> 
<script type="text/javascript">
	/* wait for images to load */
	$(window).load(function() {
		$('.sp-wrap').smoothproducts();
	});
	</script> 
