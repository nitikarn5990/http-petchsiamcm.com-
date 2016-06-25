<div class="col-md-12 well">
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

    <?php if ($_GET['controllers'] != '' && $_GET['catID'] == '') { ?>

        <!--Show All Product-->
        <div id="contentproducts">

            <h1 style="margin-top: 0px;"><?= $products_message->getDataDesc('product_title', 'id = 1'); ?></h1>
            <?= $products_message->getDataDesc('product_detail', 'id = 1'); ?>

            <ul>
                <?php
                $sql = "SELECT * FROM " . $products->getTbl() . " WHERE status ='ใช้งาน'";

                $query = $db->Query($sql);

                if ($db->NumRows($query) > 0) {
                    while ($row = $db->FetchArray($query)) {

                        if ($_SESSION['group'] != '' && $_SESSION['group'] == 'member') {
                            $products_cost = $row['product_member_cost'];
                        } else {
                            $products_cost = $row['product_cost'];
                        }
                        ?>
                        <li>
                            <a href="<?= ADDRESS ?>product/<?= $row['id'] ?>_<?= $row['product_name_ref'] ?>"><img src="<?= ADDRESS_GALLERY . $row['image'] ?>" alt="<?= $row['alt'] ?>" class="contentproductsimg"></a>
                            <p style="text-align: center;margin-top: 5px;"><span class="item-cost">ราคา <?= $products_cost ?>.00 บาท</span></p>
                            <p style="text-align: center;"><a href="<?= ADDRESS ?>product/<?= $row['id'] ?>_<?= $row['product_name_ref'] ?>"><?= $row['product_name'] ?></a></p>

                            <p>
                            <form action="<?= ADDRESS ?>cart" method="POST">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="do" value="add">
                                <a href="<?= ADDRESS ?>cart/<?= $row['id'] ?>" title="หยิบใส่ตระกร้า" class="my-btn-cart hidden">
                                    <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE5LjI1IDE5LjI1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxOS4yNSAxOS4yNTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgo8Zz4KCTxnIGlkPSJMYXllcl8xXzEwN18iPgoJCTxnPgoJCQk8cGF0aCBkPSJNMTkuMDA2LDIuOTdjLTAuMTkxLTAuMjE5LTAuNDY2LTAuMzQ1LTAuNzU2LTAuMzQ1SDQuNDMxTDQuMjM2LDEuNDYxICAgICBDNC4xNTYsMC45NzksMy43MzksMC42MjUsMy4yNSwwLjYyNUgxYy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDEuNDAzbDEuODYsMTEuMTY0YzAuMDA4LDAuMDQ1LDAuMDMxLDAuMDgyLDAuMDQ1LDAuMTI0ICAgICBjMC4wMTYsMC4wNTMsMC4wMjksMC4xMDMsMC4wNTQsMC4xNTFjMC4wMzIsMC4wNjYsMC4wNzUsMC4xMjIsMC4xMiwwLjE3OWMwLjAzMSwwLjAzOSwwLjA1OSwwLjA3OCwwLjA5NSwwLjExMiAgICAgYzAuMDU4LDAuMDU0LDAuMTI1LDAuMDkyLDAuMTkzLDAuMTNjMC4wMzgsMC4wMjEsMC4wNzEsMC4wNDksMC4xMTIsMC4wNjVjMC4xMTYsMC4wNDcsMC4yMzgsMC4wNzUsMC4zNjcsMC4wNzUgICAgIGMwLjAwMSwwLDExLjAwMSwwLDExLjAwMSwwYzAuNTUzLDAsMS0wLjQ0NywxLTFzLTAuNDQ3LTEtMS0xSDYuMDk3bC0wLjE2Ni0xSDE3LjI1YzAuNDk4LDAsMC45Mi0wLjM2NiwwLjk5LTAuODU4bDEtNyAgICAgQzE5LjI4MSwzLjQ3OSwxOS4xOTUsMy4xODgsMTkuMDA2LDIuOTd6IE0xNy4wOTcsNC42MjVsLTAuMjg1LDJIMTMuMjV2LTJIMTcuMDk3eiBNMTIuMjUsNC42MjV2MmgtM3YtMkgxMi4yNXogTTEyLjI1LDcuNjI1djIgICAgIGgtM3YtMkgxMi4yNXogTTguMjUsNC42MjV2MmgtM2MtMC4wNTMsMC0wLjEwMSwwLjAxNS0wLjE0OCwwLjAzbC0wLjMzOC0yLjAzSDguMjV6IE01LjI2NCw3LjYyNUg4LjI1djJINS41OTdMNS4yNjQsNy42MjV6ICAgICAgTTEzLjI1LDkuNjI1di0yaDMuNDE4bC0wLjI4NSwySDEzLjI1eiIgZmlsbD0iI0ZGRkZGRiIvPgoJCQk8Y2lyY2xlIGN4PSI2Ljc1IiBjeT0iMTcuMTI1IiByPSIxLjUiIGZpbGw9IiNGRkZGRkYiLz4KCQkJPGNpcmNsZSBjeD0iMTUuNzUiIGN5PSIxNy4xMjUiIHI9IjEuNSIgZmlsbD0iI0ZGRkZGRiIvPgoJCTwvZz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                    &nbsp;&nbsp;หยิบใส่ตะกร้า
                                </a>
                                <button title="หยิบใส่ตระกร้า" data-product-id="<?= $row['id'] ?>" type="button" class="add-to-cart my-btn-cart"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE5LjI1IDE5LjI1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxOS4yNSAxOS4yNTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgo8Zz4KCTxnIGlkPSJMYXllcl8xXzEwN18iPgoJCTxnPgoJCQk8cGF0aCBkPSJNMTkuMDA2LDIuOTdjLTAuMTkxLTAuMjE5LTAuNDY2LTAuMzQ1LTAuNzU2LTAuMzQ1SDQuNDMxTDQuMjM2LDEuNDYxICAgICBDNC4xNTYsMC45NzksMy43MzksMC42MjUsMy4yNSwwLjYyNUgxYy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDEuNDAzbDEuODYsMTEuMTY0YzAuMDA4LDAuMDQ1LDAuMDMxLDAuMDgyLDAuMDQ1LDAuMTI0ICAgICBjMC4wMTYsMC4wNTMsMC4wMjksMC4xMDMsMC4wNTQsMC4xNTFjMC4wMzIsMC4wNjYsMC4wNzUsMC4xMjIsMC4xMiwwLjE3OWMwLjAzMSwwLjAzOSwwLjA1OSwwLjA3OCwwLjA5NSwwLjExMiAgICAgYzAuMDU4LDAuMDU0LDAuMTI1LDAuMDkyLDAuMTkzLDAuMTNjMC4wMzgsMC4wMjEsMC4wNzEsMC4wNDksMC4xMTIsMC4wNjVjMC4xMTYsMC4wNDcsMC4yMzgsMC4wNzUsMC4zNjcsMC4wNzUgICAgIGMwLjAwMSwwLDExLjAwMSwwLDExLjAwMSwwYzAuNTUzLDAsMS0wLjQ0NywxLTFzLTAuNDQ3LTEtMS0xSDYuMDk3bC0wLjE2Ni0xSDE3LjI1YzAuNDk4LDAsMC45Mi0wLjM2NiwwLjk5LTAuODU4bDEtNyAgICAgQzE5LjI4MSwzLjQ3OSwxOS4xOTUsMy4xODgsMTkuMDA2LDIuOTd6IE0xNy4wOTcsNC42MjVsLTAuMjg1LDJIMTMuMjV2LTJIMTcuMDk3eiBNMTIuMjUsNC42MjV2MmgtM3YtMkgxMi4yNXogTTEyLjI1LDcuNjI1djIgICAgIGgtM3YtMkgxMi4yNXogTTguMjUsNC42MjV2MmgtM2MtMC4wNTMsMC0wLjEwMSwwLjAxNS0wLjE0OCwwLjAzbC0wLjMzOC0yLjAzSDguMjV6IE01LjI2NCw3LjYyNUg4LjI1djJINS41OTdMNS4yNjQsNy42MjV6ICAgICAgTTEzLjI1LDkuNjI1di0yaDMuNDE4bC0wLjI4NSwySDEzLjI1eiIgZmlsbD0iI0ZGRkZGRiIvPgoJCQk8Y2lyY2xlIGN4PSI2Ljc1IiBjeT0iMTcuMTI1IiByPSIxLjUiIGZpbGw9IiNGRkZGRkYiLz4KCQkJPGNpcmNsZSBjeD0iMTUuNzUiIGN5PSIxNy4xMjUiIHI9IjEuNSIgZmlsbD0iI0ZGRkZGRiIvPgoJCTwvZz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />&nbsp;&nbsp;หยิบใส่ตะกร้า</button>
                            </form>
                            </p>

                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
         <script>
            var show_detail = 'no';
        </script>
    <?php } else { ?>
        <script>
            var show_detail = 'yes';
        </script>
        <?php
        $arr_product = explode('_', $_GET['catID']);

        $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE id = " . $arr_product[0] . " and status ='ใช้งาน'";

        $query2 = $db->Query($sql2);

        if ($db->NumRows($query2) > 0) {
            while ($row = $db->FetchArray($query2)) {

                if ($_SESSION['group'] != '' && $_SESSION['group'] == 'member') {
                    $products_cost = $row['product_member_cost'];
                } else {
                    $products_cost = $row['product_cost'];
                }
                ?>

                <h1 class="text-center"><?= $row['product_name'] ?></h1>
                <p class="text-center img-detail">
                    <a href="">
                        <img  src="<?= ADDRESS_GALLERY . $row['image'] ?>" alt="<?= $row['alt'] ?>" class="contentproductsimg">
                    </a>
                </p>
                <p class="text-center"><span class="item-cost">ราคา <?= $products_cost ?>.00 บาท</span></p>

                <p class="text-center" style="width: 170px;margin: auto;margin-bottom: 15px;">
                    <button title="หยิบใส่ตระกร้า" data-product-id="<?= $row['id'] ?>" type="button" class="add-to-cart my-btn-cart"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE5LjI1IDE5LjI1IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxOS4yNSAxOS4yNTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgo8Zz4KCTxnIGlkPSJMYXllcl8xXzEwN18iPgoJCTxnPgoJCQk8cGF0aCBkPSJNMTkuMDA2LDIuOTdjLTAuMTkxLTAuMjE5LTAuNDY2LTAuMzQ1LTAuNzU2LTAuMzQ1SDQuNDMxTDQuMjM2LDEuNDYxICAgICBDNC4xNTYsMC45NzksMy43MzksMC42MjUsMy4yNSwwLjYyNUgxYy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDEuNDAzbDEuODYsMTEuMTY0YzAuMDA4LDAuMDQ1LDAuMDMxLDAuMDgyLDAuMDQ1LDAuMTI0ICAgICBjMC4wMTYsMC4wNTMsMC4wMjksMC4xMDMsMC4wNTQsMC4xNTFjMC4wMzIsMC4wNjYsMC4wNzUsMC4xMjIsMC4xMiwwLjE3OWMwLjAzMSwwLjAzOSwwLjA1OSwwLjA3OCwwLjA5NSwwLjExMiAgICAgYzAuMDU4LDAuMDU0LDAuMTI1LDAuMDkyLDAuMTkzLDAuMTNjMC4wMzgsMC4wMjEsMC4wNzEsMC4wNDksMC4xMTIsMC4wNjVjMC4xMTYsMC4wNDcsMC4yMzgsMC4wNzUsMC4zNjcsMC4wNzUgICAgIGMwLjAwMSwwLDExLjAwMSwwLDExLjAwMSwwYzAuNTUzLDAsMS0wLjQ0NywxLTFzLTAuNDQ3LTEtMS0xSDYuMDk3bC0wLjE2Ni0xSDE3LjI1YzAuNDk4LDAsMC45Mi0wLjM2NiwwLjk5LTAuODU4bDEtNyAgICAgQzE5LjI4MSwzLjQ3OSwxOS4xOTUsMy4xODgsMTkuMDA2LDIuOTd6IE0xNy4wOTcsNC42MjVsLTAuMjg1LDJIMTMuMjV2LTJIMTcuMDk3eiBNMTIuMjUsNC42MjV2MmgtM3YtMkgxMi4yNXogTTEyLjI1LDcuNjI1djIgICAgIGgtM3YtMkgxMi4yNXogTTguMjUsNC42MjV2MmgtM2MtMC4wNTMsMC0wLjEwMSwwLjAxNS0wLjE0OCwwLjAzbC0wLjMzOC0yLjAzSDguMjV6IE01LjI2NCw3LjYyNUg4LjI1djJINS41OTdMNS4yNjQsNy42MjV6ICAgICAgTTEzLjI1LDkuNjI1di0yaDMuNDE4bC0wLjI4NSwySDEzLjI1eiIgZmlsbD0iI0ZGRkZGRiIvPgoJCQk8Y2lyY2xlIGN4PSI2Ljc1IiBjeT0iMTcuMTI1IiByPSIxLjUiIGZpbGw9IiNGRkZGRkYiLz4KCQkJPGNpcmNsZSBjeD0iMTUuNzUiIGN5PSIxNy4xMjUiIHI9IjEuNSIgZmlsbD0iI0ZGRkZGRiIvPgoJCTwvZz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />&nbsp;&nbsp;หยิบใส่ตะกร้า</button>
                </p>

                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a data-target="#home" data-toggle="tab" class=" text-bold" style="font-size: 14px;">รายละเอียดสินค้า</a></li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <div class="panel-body" style="background: #FFF;">

                            <?= $row['product_detail'] ?>
                        </div>
                    </div>

                </div>

            <?php } ?>
        <?php } ?>
    <?php } ?>

</div>


<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script>
    $('.add-to-cart').on('click', function () {
        
        var product_id = $(this).attr('data-product-id');
        var cart = $('.u-cart');
        //   var imgtodrag = $(this).parent('.item').find("img").eq(0);
        
        var h = '';
        if(show_detail == 'yes'){
            var imgtodrag = $(this).closest('.well').find('.img-detail img');
             h = '290px';
        }else{
            var imgtodrag = $(this).closest('li');
              h = '400px';
        }
        
        // console.log(imgtodrag);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                    .offset({
                        top: imgtodrag.offset().top,
                        left: imgtodrag.offset().left
                    })
                    .css({
                        'opacity': '0.3',
                        'text-decoration': 'none',
                        'list-style-type': 'none',
                        'position': 'absolute',
                        'height': h,
                        'width': '250px',
                        'z-index': '100'
                    })
                    .appendTo($('body'))
                    .animate({
                        'top': cart.offset().top + 20,
                        'left': cart.offset().left + 10,
                        'width': 20,
                        'height': 20
                    }, 1000, 'easeInOutExpo');

            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
                
              ajax_add_to_cart(product_id);
              
            }, 1500);

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach();
                
            });
        }
    });
</script>
<script>
    function ajax_add_to_cart(product_id) {
        
        $.ajax({
            type: 'POST',
            url: '<?=ADDRESS ?>ajax/ajax_cart.php',
            data: {
                product_id: product_id,
               // active_order_detail_id: active_order_detail_id_for_topping
            },
            success: function (data) {
                 //console.log(data);
                 $('.cart_quantity').text(data);
                // var obj = $.parseJSON(data);
                //  console.log(obj);

                // topping-list
            }
        });
    }
     ajax_add_to_cart();
    
    
</script>