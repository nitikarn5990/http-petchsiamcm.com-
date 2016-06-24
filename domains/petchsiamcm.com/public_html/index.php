<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>บริษัท เพชรสยามการเกษตร จำกัด</title>
        <meta name="description" content="บริษัท เพชรสยามการเกษตร จำกัด" />
        <meta name="keywords" content="บริษัท เพชรสยามการเกษตร จำกัด" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
            <link rel="stylesheet"
                  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <!--                <link rel="stylesheet" href="css/grid12.css" />-->
                <link href="<?= ADDRESS ?>style.css" rel="stylesheet" type="text/css" />
                <link rel="shortcut icon" href="<?= ADDRESS ?>images/icon.png">
<!--                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                    <script src="<?= ADDRESS ?>dist/slippry.min.js"></script>
                    <script src="//use.edgefonts.net/cabin;source-sans-pro:n2,i2,n3,n4,n6,n7,n9.js"></script>
                    <script src="https://use.fontawesome.com/3a8c8598a6.js"></script> 
                    <meta name="viewport" content="width=device-width">
                        <link rel="stylesheet" href="<?= ADDRESS ?>slide.css">
                            <link rel="stylesheet" href="<?= ADDRESS ?>dist/slippry.css">

                                </head>
                                <body>
                                    <div id="top">
                                        <div id="login-social">
                                            <div class="top-left">
                                                <form method="post" class="form-send-msg">
                                                    <span><input type="text" name="txt_name" placeholder="username" class="form-control" style="width: 170px;display: inherit;height: 31px;"/></span> 
                                                    <span><input type="text" name="txt_email" placeholder="password" class="form-control" style="width: 170px;display: inherit;height: 31px;"/></span> <input id="submit_bt" name="submit_bt" type="submit" value="เข้าสู่ระบบ"  class="btn btn-default btn-sm" style="width: 80px;margin-bottom: 2px;"/> <span><a href="<?= ADDRESS ?>register">สมัครสมาชิก</a></span>
                                                </form> 
                                            </div> 
                                            <div class="top-right"> 
                                                <a href="https://<?= $social->getDataDesc("facebook", "id = 1"); ?>" target="_blank"><img src="<?= ADDRESS ?>images/icon-facebook.jpg" /> </a>
                                                <a href="https://<?= $social->getDataDesc("twitter", "id = 1"); ?>" target="_blank"><img src="<?= ADDRESS ?>images/icon-twitter.jpg" /></a>
                                            </div>
                                        </div>  
                                    </div> 
                                    <div id="logo-menu">
                                        <div id="logo"><a href=""><img src="<?= ADDRESS ?>images/logo.png" /></a></div>
                                        <div id="menu">
                                            <ul>
                                                <li><a href="<?= ADDRESS ?>" title="หน้าหลัก" class="<?= PAGE_CONTROLLERS == 'index' || PAGE_CONTROLLERS == '' ? 'active' : '' ?>">หน้าหลัก</a></li>
                                                <li>|</li>
                                                <li><a href="<?= ADDRESS ?>product" title="ผลิตภัณฑ์" class="<?= PAGE_CONTROLLERS == 'product' ? 'active' : '' ?>">ผลิตภัณฑ์</a></li>
                                                <li>|</li>
                                                <li><a href="<?= ADDRESS ?>payment-confirm" title="แจ้งชำระเงิน" class="<?= PAGE_CONTROLLERS == 'payment-confirm' ? 'active' : '' ?>">แจ้งชำระเงิน</a></li>
                                                <li>|</li>
                                                <li><a href="<?= ADDRESS ?>contact" title="ติดต่อเรา" class="<?= PAGE_CONTROLLERS == 'contact' ? 'active' : '' ?>">ติดต่อเรา</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="slide">
                                        <div id="centerslide">
                                            <div class="txtslide"><img src="<?= ADDRESS ?>images/txtslide.png" /></div>
                                            <article class="demo_block">
                                                <ul id="demo1" style="list-style:none; position:0; margin:0;">

                                                    <?php
                                                    $sql = "SELECT * FROM " . $slides->getTbl() . " WHERE status = 'ใช้งาน' ORDER BY sort ASC";
                                                    $query = $db->Query($sql);

                                                    if ($db->NumRows($query) > 0) {
                                                        while ($row = $db->FetchArray($query)) {
                                                            ?>
                                                            <li><a href="#slide1"><img src="<?= ADDRESS ?>img/<?= $row['image'] ?>" /></a></li>
                                                        <?php } ?>
                                                    <?php } ?>

                                                </ul>
                                            </article>
                                            <script>
                                                $(function () {
                                                    var demo1 = $("#demo1").slippry({
                                                        transition: 'fade',
                                                        useCSS: true,
                                                        speed: 1000,
                                                        pause: 3000,
                                                        auto: true,
                                                        preload: 'visible'
                                                    });

                                                    $('.stop').click(function () {
                                                        demo1.stopAuto();
                                                    });

                                                    $('.start').click(function () {
                                                        demo1.startAuto();
                                                    });

                                                    $('.prev').click(function () {
                                                        demo1.goToPrevSlide();
                                                        return false;
                                                    });
                                                    $('.next').click(function () {
                                                        demo1.goToNextSlide();
                                                        return false;
                                                    });
                                                    $('.reset').click(function () {
                                                        demo1.destroySlider();
                                                        return false;
                                                    });
                                                    $('.reload').click(function () {
                                                        demo1.reloadSlider();
                                                        return false;
                                                    });
                                                    $('.init').click(function () {
                                                        demo1 = $("#demo1").slippry();
                                                        return false;
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div id="content">

                                        <?php
                                        if (PAGE_CONTROLLERS == '' || PAGE_CONTROLLERS == 'index') {

                                            include 'controllers/home.php';
                                        } else {

                                            include 'controllers/' . PAGE_CONTROLLERS . '.php';
                                        }
                                        ?>
                                    </div>
                                    <div id="footer"><?= $footer->getDataDesc("detail", "id = 1"); ?></div> 
           
                                    <script src="http://malsup.github.io/jquery.form.js" ></script>
                                    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
                                    <script type="text/javascript" src="<?= ADDRESS ?>plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
                                    <script type="text/javascript" src="<?= ADDRESS ?>plugins/noty/themes/default.js"></script>
                              
                                </body>
                                </html>
