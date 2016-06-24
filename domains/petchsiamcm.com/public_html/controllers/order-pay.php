<div class="row">
     <div class="col-md-3">
        <?php include "inc/side_category.php" ;?>
    </div>
    <div class="col-md-9">
        <div class="product-name">
            <h1 class="title-bar">วิธีการสั่งซื้อ
                <div class="title-border"></div>
            </h1>
            <p>&nbsp; </p>
            <?php $html_detail = str_replace("../files", "files", $shopping_guide->getDataDesc("guide_detail","id = 1")); ?>
            <article> <?php echo $html_detail;?> </article>
        </div>
        <p>&nbsp; </p>
    </div>
   
</div>
