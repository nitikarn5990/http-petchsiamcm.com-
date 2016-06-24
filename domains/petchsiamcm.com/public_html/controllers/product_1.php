<?php
if ($_POST['bt_submit'] == "Add to cart") {

    if ($_SESSION['customer_id'] == '') {
        //$url = ADDRESS . "sign.html";
    	
        echo "<script>$(document).ready(function() {  alert('กรูณาเข้าสุ่ระบบเพื่อทำการสั่งซื้อค่ะ');   });   </script>";
        ?>
        
        <div class="alert alert-danger" role="alert"> 
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="sr-only">Error:</span> กรูณาเข้าสู่ระบบหรือลงทะเบียนเพื่อสั่งซื้อค่ะ 
            <a href="<?php echo ADDRESS ?>signin.html" class="btn btn-primary" style="  color: #6C6C6C;background-color: #F4F4F4;border-color: #ccc;font-weight: bold;">เข้าสู่ระบบ</a>
      		<a href="<?php echo ADDRESS ?>register.html" class="btn btn-primary" style="  color: #6C6C6C;background-color: #F4F4F4;border-color: #ccc;font-weight: bold;">ลงทะเบียน</a>
        </div>
        
        <?php 
    } else {
    	
        ?>
        <div class="alert alert-success" role="alert"> 
            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> <span class="sr-only">Success:</span> เพิ่มลงในตระกร้าสินค้าแล้ว 
            <a href="<?php echo ADDRESS ?>cart.html" class="btn btn-primary" style="  color: #6C6C6C;background-color: #F4F4F4;border-color: #ccc;font-weight: bold;">View cart</a>
        </div>
        <?php
        if (!isset($_SESSION["intLine"])) {

            $_SESSION["intLine"] = 0;
            $_SESSION["strProductID"][0] = $_POST['product_id'];
            $_SESSION["strQty"][0] = $_POST['qty'];
        } else {

            $key = array_search($_POST['product_id'], $_SESSION["strProductID"]);
            if ((string) $key != "") {
                $_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + $_POST['qty'];
            } else {

                $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
                $intNewLine = $_SESSION["intLine"];
                $_SESSION["strProductID"][$intNewLine] = $_POST['product_id'];
                $_SESSION["strQty"][$intNewLine] = $_POST['qty'];
            }
        }
///////////////////////
    }
}
?>
<?php if ($_GET['controllers'] != '' && $_GET['catID'] == '' && $_GET['productID'] == '') { ?>

    <!--Show All Product-->

    <div class="row" style="  margin-bottom: 40px;">
        <div class="col-md-3">
    <?php include "inc/side_category.php"; ?>
        </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $txt_search = trim($_POST['search'] . $_POST['search2']);

        if ($txt_search != '') {
            ?>
                <div class="col-md-9">
                    <article>
                        <header class="page-title category-title">
                            <h1 class="title-bar" style="text-transform:uppercase;">All Product
                                <div class="title-border"></div>
                            </h1>
                        </header>
                        <div class="category-description">
                            <p>&nbsp;</p>
                <?php //echo $category->getDataDesc("category_detail","category_name_ref = '" . $_GET['catID'] . "'")?>
                        </div>
                        <section class="category-products">
            <?php
            // $cat_id =  $category->getDataDesc("id","category_name_ref = '" . $_GET['catID'] . "'");

            $sql = "SELECT * FROM " . $products->getTbl() . " WHERE  (product_name LIKE '%" . $txt_search . "%') OR (product_title  LIKE '%" . $txt_search . "%') OR (product_detail  LIKE '%" . $txt_search . "%') AND status = 'ใช้งาน'";

            //echo $sql;
            $query = $db->Query($sql);
            while ($row = $db->FetchArray($query)) {
                $cat_ref = $category->getDataDesc("category_name_ref", "id = " . $row['category_id'] . "");
                ?>
                                <form action="" method="post">
                                    <div class="col-md-4" style="  margin-bottom: 15px;">
                                        <div class="col-md-12"> <a href="<?php echo ADDRESS . "product/" . $cat_ref . "/" . $row['product_name_ref'] ?>.html" class="product-image"> <img src="<?php echo ADDRESS_GALLERY . $row['products_file_name_cover'] ?>"  alt="<?php echo $product_files->getDataDesc("alt_tag", "file_name = '" . $row['products_file_name_cover'] . "'") ?>" > </a></div>
                                        <div class="col-md-12">
                                            <h2 class="product-name"> <a href="<?php echo ADDRESS . "product/" . $cat_ref . "/" . $row['product_name_ref'] ?>.html" title="<?php echo $row['product_name'] ?>"><?php echo $row['product_name'] ?> </a> </h2>
                                        </div>
                                        <div class="col-md-12"> <span class="price color-black">ราคา <?php echo $row['product_cost'] ?> บาท</span> </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="qty" name="qty" type="number" value="1"  class="form-control">
                                                    <span class="input-group-btn">
                                                        <input class="btn btn-primary" type="submit" name="bt_submit" value="Add to cart" id="bt_submit">
                                                    </span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
            <?php } ?>
                        </section>
                    </article>
                </div>
        <?php } else { ?>
                <div class="col-md-9">
                    <article>
                        <header class="page-title category-title">
                            <h1 class="title-bar" style="text-transform:uppercase;">All Product
                                <div class="title-border"></div>
                            </h1>
                        </header>
                        <div class="category-description">
                            <p>&nbsp;</p>
                <?php //echo $category->getDataDesc("category_detail","category_name_ref = '" . $_GET['catID'] . "'") ?>
                        </div>

                        <section class="category-products">
            <?php
            // $cat_id =  $category->getDataDesc("id","category_name_ref = '" . $_GET['catID'] . "'");

            $sql = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' ORDER BY category_id ASC ";

            $query = $db->Query($sql);
            while ($row = $db->FetchArray($query)) {
                $cat_ref = $category->getDataDesc("category_name_ref", "id = " . $row['category_id'] . "");
                ?>
                                <form action="" method="post">
                                    <div class="col-md-4" style="  margin-bottom: 15px;">
                                        <div class="col-md-12"> <a href="<?php echo ADDRESS . "product/" . $cat_ref . "/" . $row['product_name_ref'] ?>.html" class="product-image"> <img src="<?php echo ADDRESS_GALLERY . $row['products_file_name_cover'] ?>"  alt="<?php echo $product_files->getDataDesc("alt_tag", "file_name = '" . $row['products_file_name_cover'] . "'") ?>" > </a></div>
                                        <div class="col-md-12">
                                            <h2 class="product-name"> <a href="<?php echo ADDRESS . "product/" . $cat_ref . "/" . $row['product_name_ref'] ?>.html" title="<?php echo $row['product_name'] ?>"><?php echo $row['product_name'] ?> </a> </h2>
                                        </div>
                                        <div class="col-md-12"> <span class="price color-black">ราคา <?php echo $row['product_cost'] ?> บาท </span> </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="qty" name="qty" type="number"   class="form-control" value="1">
                                                    <input id="product_id" name="product_id" type="hidden"  value="<?php echo $row['id'] ?> " class="form-control">
                                                    <span class="input-group-btn">
                                                        <input class="btn btn-primary" type="submit" name="bt_submit" value="Add to cart" id="bt_submit">
                                                    </span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
            <?php } ?>
                        </section>
                    </article>
                </div>
        <?php }
    } else {
        ?>
            <div class="col-md-9">
                <article>
                    <header class="page-title category-title">
                        <h1 class="title-bar" style="text-transform:uppercase;">All Product
                            <div class="title-border"></div>
                        </h1>
                    </header>
                    <div class="category-description">
                        <p>&nbsp;</p>
            <?php //echo $category->getDataDesc("category_detail","category_name_ref = '" . $_GET['catID'] . "'")?>
                    </div>
                    <section class="category-products">
        <?php
        // $cat_id =  $category->getDataDesc("id","category_name_ref = '" . $_GET['catID'] . "'");

        $sql = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' ORDER BY category_id ASC ";

        $query = $db->Query($sql);

        while ($row = $db->FetchArray($query)) {
            $cat_ref = $category->getDataDesc("category_name_ref", "id = " . $row['category_id'] . "");
            ?>
                            <form action="" method="post">
                                <div class="col-sm-4 col-xs-12" style="  margin-bottom: 15px;">
                                    <div class="col-md-12"> <a href="<?php echo ADDRESS . "product/" . $cat_ref . "/" . $row['product_name_ref'] ?>.html" class="product-image"> <img src="<?php echo ADDRESS_GALLERY . $row['products_file_name_cover'] ?>"  alt="<?php echo $product_files->getDataDesc("alt_tag", "file_name = '" . $row['products_file_name_cover'] . "'") ?>" width="222" height="222"> </a></div>
                                    <div class="col-md-12">
                                        <h2 class="product-name"> <a href="<?php echo ADDRESS . "product/" . $cat_ref . "/" . $row['product_name_ref'] ?>.html" title="<?php echo $row['product_name'] ?>"><?php echo $row['product_name'] ?> </a> </h2>
                                    </div>
                                    <div class="col-md-12"> <span class="price color-black">ราคา <?php echo $row['product_cost'] ?> บาท</span> </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input id="qty" name="qty" type="number"   class="form-control" value="1" >
                                                <input id="product_id" name="product_id" type="hidden"  value="<?php echo $row['id'] ?> " class="form-control">
                                                <span class="input-group-btn">
                                                    <input class="btn btn-primary" type="submit" name="bt_submit" value="Add to cart" id="bt_submit">
                                                </span> </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
        <?php } ?>
                    </section>
                </article>
            </div>
    <?php } ?>
    </div>
<?php } ?>
<?php if ($_GET['controllers'] != '' && $_GET['catID'] != '' && $_GET['productID'] == '') { ?>
    <div class="row" style="  margin-bottom: 40px;">
        <div class="col-md-3">
    <?php include "inc/side_category.php"; ?>
        </div>
        <div class="col-md-9">
            <article>
                <header class="page-title category-title">
                    <h1 class="title-bar" style="text-transform:uppercase;"><?php echo $category->getDataDesc("category_name", "category_name_ref = '" . $_GET['catID'] . "'") ?>
                        <div class="title-border"></div>
                    </h1>
                </header>
                <div class="category-description">
                    <p>&nbsp;</p>
    <?php echo $category->getDataDesc("category_detail", "category_name_ref = '" . $_GET['catID'] . "'") ?> </div>
                <section class="category-products">
            <?php
            $cat_id = $category->getDataDesc("id", "category_name_ref = '" . $_GET['catID'] . "'");

            $sql = "SELECT * FROM " . $products->getTbl() . " WHERE category_id = " . $cat_id . " ORDER BY sort ASC ";

            $query = $db->Query($sql);
            while ($row = $db->FetchArray($query)) {
                ?>
                        <form action="" method="post">
                            <div class="col-md-4">
                                <div class="col-md-12"> <a href="<?php echo ADDRESS . "product/" . $_GET['catID'] . "/" . $row['product_name_ref'] ?>.html" class="product-image"> <img src="<?php echo ADDRESS_GALLERY . $row['products_file_name_cover'] ?>"  alt="<?php echo $product_files->getDataDesc("alt_tag", "file_name = '" . $row['products_file_name_cover'] . "'") ?>" ></a> </div>
                                <div class="col-md-12">
                                    <h2 class="product-name"> <a href="<?php echo ADDRESS . "product/" . $_GET['catID'] . "/" . $row['product_name_ref'] ?>.html" title="<?php echo $row['product_name'] ?>"><?php echo $row['product_name'] ?> </a> </h2>
                                </div>
                                <div class="col-md-12"> <span class="price color-black">ราคา <?php echo $row['product_cost'] ?> บาท</span> </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="qty" name="qty" type="number"   class="form-control" value="1">
                                            <input id="product_id" name="product_id" type="hidden"  value="<?php echo $row['id'] ?> " class="form-control">
                                            <span class="input-group-btn">
                                                <input class="btn btn-primary" type="submit" name="bt_submit" value="Add to cart" id="bt_submit">
                                            </span> </div>
                                    </div>
                                </div>
                            </div>
                        </form>
    <?php } ?>
                </section>
            </article>
        </div>
    </div>
<?php } ?>
<?php if ($_GET['controllers'] != '' && $_GET['catID'] != '' && $_GET['productID'] != '') {
    ?>
    <div class="row">
        <div class="col-md-3">
    <?php include "inc/side_category.php"; ?>
        </div>
        <div class="col-md-9">
            <div class="row" style="  margin-bottom: 40px;">
                <div class="col-md-5">
   
                    <link rel="stylesheet" href="<?php echo ADDRESS_PLUGINS . "zoom/" ?>css/smoothproducts.css">
                    <div class="sp-loading"><img src="<?php echo ADDRESS_PLUGINS . "zoom/" ?>images/sp-loading.gif" alt=""><br>
                        LOADING IMAGES </div>
                    <div class="sp-wrap" style="width: 100%;">
    <?php
    $product_id = $products->getDataDesc("id", "product_name_ref = '" . $_GET['productID'] . "'");

    $sql = "SELECT * FROM " . $product_files->getTbl() . " WHERE product_id = " . $product_id . " ORDER BY id ASC";

    $query = $db->Query($sql);
    while ($row = $db->FetchArray($query)) {
        ?>
                            <a href="<?php echo ADDRESS_GALLERY . $row['file_name'] ?>"> <img src="<?php echo ADDRESS_GALLERY . $row['file_name'] ?>" alt="<?php echo $row['alt_tag'] ?>"> </a>
                    <?php } ?>
                    </div>

                
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-name">
                                <h1 class="title-bar"><?php echo $products->getDataDesc("product_name", "product_name_ref = '" . $_GET['productID'] . "'") ?>
                                    <div class="title-border"></div>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="short-description  border-bottom-grey">
                                <div class="std">
                                    <h2 class="color-black">รายละเอียดย่อ:</h2>
                                    <p><?php echo $products->getDataDesc("product_title", "product_name_ref = '" . $_GET['productID'] . "'") ?> <strong></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="color-black">ราคา : <?php echo $products->getDataDesc("product_cost", "product_name_ref = '" . $_GET['productID'] . "'") ?> บาท</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> <span class="price-left color-black">น้ำหนัก : <?php echo $products->getDataDesc("product_weight", "product_name_ref = '" . $_GET['productID'] . "'") ?> กรัม </span> </div>
                    </div>
                    <div class="row">
                        <form action="" method="post">
                        <div class="col-md-6 col-xs-6">
                           
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="qty" name="qty" type="number"   class="form-control" value="1">
                                        <input id="product_id" name="product_id" type="hidden"  value="<?php echo $product_id ?> " class="form-control">
                                        <span class="input-group-btn">
                                            <input class="btn btn-primary" type="submit" name="bt_submit" value="Add to cart" id="bt_submit">
                                        </span> 

                                    </div> 

                                </div>

                        </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-name">
                            <h2 class="title-bar">รายละเอียดสินค้า
                                <div class="title-border"></div>
                            </h2>
                        </div>
                        <p>&nbsp;</p>
                    </div>
                    <div class="col-md-12">
    <?php
    $product_Detail = $products->getDataDesc("product_detail", "product_name_ref = '" . $_GET['productID'] . "'");
    $product_Detail2 = str_replace("../files", "../../files", $product_Detail);

    $html = preg_replace('/(width|height)="\d*"\s/', "", $product_Detail2);
    echo $html;


    // echo str_replace("../files","../../files", $product_Detail); 
    ?>
                    </div>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
                    <?php } ?>
    <style>
        img{
            max-height:100% !important; 
            max-width:100% !important;
        }


    </style>
    <script> //dropdrop when hover
        $('.dropdown').hover(function () {
            $('.dropdown-toggle', this).trigger('click');
            $(this).addClass("open");
        });
        $('.dropdown').mouseleave(function () {

            $(this).removeClass("open")
        });


        $("#all_product").click(function (e) {
            // window.location = "product.html";
        });


        $(document).ready(function () {
            $('label.tree-toggler').click(function () {
                $(this).parent().children('ul.tree').toggle(300);
            });
        });




    </script> 
    <!-- JS ======================================================= --> 
                    <script type="text/javascript" src="<?php echo ADDRESS_PLUGINS . "zoom/" ?>js/jquery-2.1.3.min.js"></script> 
                    <script type="text/javascript" src="<?php echo ADDRESS_PLUGINS . "zoom/" ?>js/smoothproducts.min.js"></script> 
                    <script type="text/javascript">
                        /* wait for images to load */
                        $(window).load(function () {
                            $('.sp-wrap').smoothproducts();
                        });
                    </script> 