<form action="<?php echo ADDRESS ?>product.html" method="POST" class="form-inline" role="form">
<div class="row">    
    <div class="" id="mySearch">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" id="search" name="search" value="<?=$_POST['search']!=''?$_POST['search']:''?>" placeholder="กรุณาใส่ชื่อสินค้า">
            <button type="submit" class="btn btn-primary btn-full-width"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
        </div>
    
    </div>
</div>
</form>
<p>&nbsp;</p>
<div class="row">
    <div class="col-md-12">
        <div class="product-name">
            <h2 class="title-bar" style="float:left;">หมวดสินค้า
                <div class="title-border"></div>
            </h2>
        </div>
    </div>
</div>
<div class="well" style="">
    <div style="">
        <ul class="nav nav-list">
            <li>
                <label class="tree-toggler nav-header"><a href="<?php echo ADDRESS ?>product.html" style="  color: #898989;
                                                          text-decoration: none;">สินค้าทั้งหมด </a></label>
            </li>
            <?php
            $sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";

            //$result_list = array();
            $query = $db->Query($sql);
            while ($row = $db->FetchArray($query)) {
                ?>
                <li>
                    <label class="tree-toggler nav-header"><a href="<?php echo ADDRESS . "product/" . $row['category_name_ref'] ?>.html" style="  color: #898989;
                                                              text-decoration: none;"><?php echo $row['category_name']; ?> </a></label>
                    <ul class="nav nav-list tree">
                        <?php
                        $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' AND category_id = " . $row['id'] . "";

                        //$result_list = array();
                        $query2 = $db->Query($sql2);
                        while ($row2 = $db->FetchArray($query2)) {
                            ?>
                            <li><a href="<?php echo ADDRESS . "product/" . $row['category_name_ref'] . "/" . $row2['product_name_ref'] ?>.html"><?php echo $row2['product_name']; ?></a></li>
                        <?php } ?>

                    </ul>
                </li>
                <li class="divider"></li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <a href="<?=ADDRESS?>admin"><img src="<?=ADDRESS?>images/theme/admin_login.gif"></a>
    </div>
</div>







<style>
    ul.nav.nav-list.tree li a{ padding:5px 10px !important; }
</style>