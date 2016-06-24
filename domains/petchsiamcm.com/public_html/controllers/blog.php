<?php if($_GET['controllers'] != '' &&  $_GET['catID'] != '' &&  $_GET['productID'] == '' ) { ?>

<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="title-bar">BLOG CATEGORY
                    <div class="title-border"></div>
                </h1>
                <p>&nbsp; </p>
            </div>
            <?php
			     $cat_id = $blog_category->getDataDesc("id",  "category_name_ref =  '".  $_GET['catID'] ."'");
             	 $sql = "SELECT * FROM " . $blog->getTbl() . " WHERE blog_category_id = " . $cat_id ;
			 	 $query = $db->Query($sql);
				 while ($row = $db->FetchArray($query)){ ?>
                 
            <div id="blog-article" class="col-xs-12">
                <div class="col-xs-12 blog-title">
                    <div class="col-xs-12"><a href="<?php echo ADDRESS ."blog/". $_GET['catID'] . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $row['blog_name'] ?>"> <?php echo $row['blog_cover'] ?> </a></div>
                    <div class="col-xs-12"> <a href="<?php echo ADDRESS ."blog/". $_GET['catID'] . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $row['blog_name'] ?>" style="text-decoration:none;">
                        <h2> <?php echo $row['blog_name'] ?></h2>
                        </a></div>
                    <div class="col-xs-12" style="  padding-bottom: 15px;"> <?php echo $row['blog_short_detail'] ?> </div>
                    <div class="col-xs-12" style="  border-top: 1px solid#EDEDED; padding-top: 10px;  padding-left: 0px;
  padding-right: 0px;">
                        <div class="col-xs-9"> <i class="fa fa-folder-open"></i> <a href="<?php echo ADDRESS ."blog/". $_GET['catID'] .  ".html"?>" title="<?php echo $_GET['catID'] ?>"> <?php echo $blog_category->getDataDesc('category_name',"id = " . $row['blog_category_id']); ?> </a> </div>
                        <div class="col-xs-3 text-right">
                     
                            <a class="btn btn-primary " href="<?php echo ADDRESS ."blog/". $_GET['catID'] . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $_GET['catID'] ?>"> Read more</a>
                            
                        </div>
                    </div>
                </div>
                <p>&nbsp; </p>
            </div>
            
            <?php  }  ?>
            <p>&nbsp; </p>
        </div>
    </div>
    <div class="col-md-3">
        <?php include "inc/side_category.php" ;?>
    </div>
</div>
<?php }?>
<?php if($_GET['controllers'] != '' &&  $_GET['catID'] != '' &&  $_GET['productID'] != '' ) { ?>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="title-bar">BLOG DESCRIPTION
                    <div class="title-border"></div>
                </h1>
                <p>&nbsp; </p>
            </div>
            <?php
           
			     $blog_id = $blog->getDataDesc("id",  "blog_name_ref =  '".  $_GET['productID'] ."'");
			    // echo $_GET['productID'] ;
			     
			    
             	 $sql = "SELECT * FROM " . $blog->getTbl() . " WHERE id = " . $blog_id ;
             	
             	
			 	 $query = $db->Query($sql);
				 while ($row = $db->FetchArray($query)){ ?>
            <div id="blog-article" class="col-xs-12">
                <div class="col-xs-12 blog-title">
                    <div class="col-xs-12"><a href="<?php echo ADDRESS ."blog/". $_GET['catID'] . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $row['blog_name'] ?>">
                        <?php 
			 $blog_cover = str_replace("../files","../../files",  $row['blog_cover'] ); 	
			 $html_blog_cover = preg_replace( '/(width|height)="\d*"\s/', "", $blog_cover  );
  			 echo $html_blog_cover;	 		 
			
			 ?>
                        </a> </div>
                    <div class="col-xs-12"> <a href="<?php echo ADDRESS ."blog/". $_GET['catID'] . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $row['blog_name'] ?>" style="text-decoration:none;">
                        <h2> <?php echo $row['blog_name'] ?></h2>
                        </a></div>
                    <div class="col-xs-12" style="  padding-bottom: 15px;">
                        <?php 
			 $blog_detail = str_replace("../files","../../files",  $row['blog_detail'] ); 		
			 
			  $html_blog_detail = preg_replace( '/(width|height)="\d*"\s/', "", $blog_detail  );
  			  echo $html_blog_detail;	 
		
			 ?>
                    </div>
                    <div class="col-xs-12" style="  border-top: 1px solid#EDEDED; padding-top: 10px;  padding-left: 0px;
  padding-right: 0px;">
                        <div class="col-xs-12"> <i class="fa fa-folder-open"></i> <a href="<?php echo ADDRESS ."blog/". $_GET['catID'] .  ".html"?>" title="<?php echo $_GET['productID'] ?>"> <?php echo $blog_category->getDataDesc('category_name',"id = " . $row['blog_category_id']); ?> </a> </div>
                        <!--<div class="col-xs-3 text-right">
                    <button type="submit" class="btn btn-primary ">Read more</button>
                </div>--> 
                    </div>
                </div>
                <p>&nbsp; </p>
            </div>
            <?php  }  ?>
            <p>&nbsp; </p>
        </div>
    </div>
    <div class="col-md-3">
        <?php include "inc/side_category.php" ;?>
    </div>
</div>
<?php }?>
<?php 
		
	$product_Detail = $products->getDataDesc("product_detail","product_name_ref = '" . $_GET['productID'] . "'");
	$product_Detail2 = str_replace("../files","../../files", $product_Detail); 

    $html = preg_replace( '/(width|height)="\d*"\s/', "", $product_Detail2 );
    echo $html;

	
	// echo str_replace("../files","../../files", $product_Detail); 
?>
<style>
      @media (min-width: 100px) and (max-width: 480px) {
		  .btn{
			  padding:5px !important;
			}
			
	  }


a > h2  { font-size:30px; text-decoration:none;}


.blog-title{
	
	  padding: 10px;
  border: 1px solid #EDEDED;
  -webkit-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  -moz-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  border-radius: 5px;
}
</style>
<style>
      @media (min-width: 100px) and (max-width: 480px) {
		  .btn{
			  padding:5px !important;
			}
			
	  }


a > h2  { font-size:30px; text-decoration:none;}


.blog-title{
	
	  padding: 10px;
  border: 1px solid #EDEDED;
  -webkit-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  -moz-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  border-radius: 5px;
}
</style>
