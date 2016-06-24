<?php
// Prerequisites
session_start();
include_once ($_SERVER ["DOCUMENT_ROOT"] . '/lib/application.php');
if ($_SESSION ['admin_id'] == "") {

    header('location:' . ADDRESS_ADMIN . 'login.php');
}
?>
<html lang="en">
    <head>


        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Keywords" content="">
        <meta name="Description" content="">



        <link rel="stylesheet"
              href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <!-- Bootstrap Stylesheet -->

        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"
              media="screen">

        <!-- Theme Stylesheet -->

        <link rel="stylesheet" href="assets/css/dandelion.theme.css"
              media="screen">

        <!-- Icon Stylesheet -->

        <link rel="stylesheet" href="assets/css/fonts/glyphicons/style.css"
              media="screen">

        <!--  Main Stylesheet -->

        <link rel="stylesheet" href="assets/css/dandelion.min.css"
              media="screen">
        <link rel="stylesheet" href="assets/css/customizer.css" media="screen">

        <!-- Demo Stylesheet -->

        <link rel="stylesheet" href="assets/css/demo.css" media="screen">

        <!-- Plugin Stylesheet -->

        <link rel="stylesheet"
              href="assets/js/plugins/wizard/dandelion.wizard.css" media="screen">

        <!-- JS Libs -->

        <script src="assets/js/libs/jquery-1.8.3.min.js"></script>
        <script src="assets/js/libs/jquery.placeholder.min.js"></script>
        <script src="assets/js/libs/jquery.mousewheel.min.js"></script>

        <!-- JS Bootstrap -->

        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- jQuery-UI JavaScript Files -->

        <script src="assets/jui/js/jquery-ui-1.9.2.min.js"></script>
        <script src="assets/jui/jquery.ui.timepicker.min.js"></script>
        <script src="assets/jui/jquery.ui.touch-punch.min.js"></script>
        <link rel="stylesheet" type="text/css"
              href="assets/jui/css/jquery.ui.all.css" media="screen">

        <!-- JS Plugins -->

        <!-- Validation Plugin -->

        <script src="plugins/validate/jquery.validate.min.js"></script>

        <!-- DataTables Plugin -->

        <script src="plugins/datatables/jquery.dataTables.min.js"></script>

        <!-- Flot Plugin -->

        <!--[if lt IE 9]>
                
                <script src="assets/js/libs/excanvas.min.js"></script>
                
                <![endif]-->

        <script src="plugins/flot/jquery.flot.min.js"></script>
        <script src="plugins/flot/plugins/jquery.flot.tooltip.min.js"></script>
        <script src="plugins/flot/plugins/jquery.flot.resize.min.js"></script>

        <!-- Circular Stat Plugin -->

        <script
        src="assets/js/plugins/circularstat/dandelion.circularstat.min.js"></script>

        <!-- Wizard Plugin -->

        <script src="assets/js/plugins/wizard/dandelion.wizard.min.js"></script>
        <script src="assets/js/libs/jquery.form.min.js"></script>

        <!-- Fullcalendar Plugin -->

        <script src="plugins/fullcalendar/fullcalendar.min.js"></script>
        <script src="plugins/fullcalendar/gcal.js"></script>
        <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.css"
              media="screen">
        <link rel="stylesheet"
              href="plugins/fullcalendar/fullcalendar.print.css" media="print">

        <!-- Select2 Plugin -->

        <script src="plugins/select2/select2.js"></script>
        <link rel="stylesheet" href="plugins/select2/select2.css" media="screen">

        <!-- Editor -->

        <script type="text/javascript"
        src="plugins/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

        <!-- Picklist Plugin -->

        <script src="assets/js/plugins/picklist/picklist.min.js"></script>
        <link rel="stylesheet" href="assets/js/plugins/picklist/picklist.css"
              media="screen">

        <!-- Colorpicker Plugin -->

        <script src="plugins/colorpicker/colorpicker.js"></script>
        <link rel="stylesheet" href="plugins/colorpicker/colorpicker.css"
              media="screen">

        <!-- elRTE Plugin -->

        <script src="plugins/elrte/js/elrte.full.js"></script>
        <link rel="stylesheet" href="plugins/elrte/css/elrte.css" media="screen">

        <!-- elFinder Plugin -->

        <script src="plugins/elfinder/js/elfinder.min.js"></script>
        <link rel="stylesheet" href="plugins/elfinder/css/elfinder.css"
              media="screen">

        <!-- iButton Plugin -->

        <script src="plugins/ibutton/jquery.ibutton.min.js"></script>
        <style type="text/css"></style>
        <link rel="stylesheet" href="plugins/ibutton/jquery.ibutton.css"
              media="screen">

        <!-- Autosize Plugin -->

        <script src="plugins/autosize/jquery.autosize.min.js"></script>

        <!-- FilInput Plugin -->

        <script src="assets/js/plugins/fileinput/jquery.fileinput.js"></script>

        <!-- JS Demo -->

        <script src="assets/js/demo/demo.validation.js"></script>
        <script src="assets/js/demo/demo.dashboard.js"></script>
        <script src="assets/js/demo/demo.tables.js"></script>
        <script src="assets/js/demo/demo.form.js"></script>

        <!-- JS Login -->

        <script src="assets/js/core/dandelion.login.js"></script>

        <!-- JS Template -->

        <script src="assets/js/core/dandelion.core.js"></script>

        <!-- JS Customizer -->

        <script src="assets/js/core/dandelion.customizer.js"></script>
        
        <!-- Input Tag -->
        <script src="assets/input_tags/bootstrap-tagsinput-angular.js"></script>
        <script src="assets/input_tags/bootstrap-tagsinput.js"></script>
         <link rel="stylesheet" href="assets/input_tags/bootstrap-tagsinput.css">
         <style>
		 ul li.actived{
					  background:#CCC;	
					}
		 </style>
        
    </head>

    <body cz-shortcut-listen="true">

        <!-- Main Wrapper. Set this to 'fixed' for fixed layout and 'fluid' for fluid layout' -->
        <div id="da-wrapper">

            <!-- Header -->
            <div id="da-header">
                <div id="da-header-top">

                    <!-- Container -->
                    <div class="da-container clearfix">

                        <!-- Logo Container. All images put here will be vertically centere -->
                        <div id="da-logo-wrap">
                            <div id="da-logo">
                                <div id="da-logo-img">
                                    
<!--    													 <img src="assets/images/logo.png" alt=""> -->
   									
                                </div>
                            </div>
                        </div>

                        <!-- Header Toolbar Menu -->
                        <div id="da-header-toolbar" class="clearfix">
                            <div id="da-user-profile-wrap">
                                <div id="da-user-profile" data-toggle="dropdown" class="clearfix">
                                    <div id="da-user-avatar"></div>
                                    <div id="da-user-info">
                                        Admin Administrator <span class="da-user-title">Administrator</span>
                                    </div>
                                </div>
                                <ul class="dropdown-menu">

                                    <li><a
                                            href="<?php echo ADDRESS_ADMIN_CONTROL ?>profile&action=edit&id=1">เปลี่ยนรหัสผ่าน</a></li>
                                </ul>
                            </div>
                            <div id="da-header-button-container">
                                <ul>
                                    <li class="da-header-button-wrap" title="มีการแจ้งชำระเงิน">


                                        <div class="da-header-button" data-toggle="dropdown">

                                            <?php if ($payment_confirm->CountDataDesc("id", "status = 'รอการชำระเงิน'") > 0) { ?>
                                                <span class="btn-count"><?php echo $payment_confirm->CountDataDesc("id", "status = 'รอการชำระเงิน'") ?></span>
                                            <?php } ?>

                                            <a href="#"><i
                                                    class="icon-circle-exclamation-mark"></i></a>


                                        </div>

                                        <ul class="dropdown-menu pull-right">
                                            <li><span class="da-dropdown-sub-title" style="  min-width: 200px;">แจ้งการชำระเงิน</span>


                                                <ul class="da-dropdown-sub">

                                                    <?php
                                                    $sql = "SELECT * FROM " . $payment_confirm->getTbl() . " WHERE  status = 'รอการชำระเงิน' ORDER BY id DESC LIMIT 0,4";

                                                    // echo $sql;
                                                    $query = $db->Query($sql);
                                                    while ($row = $db->FetchArray($query)) {
                                                        ?>
                                                        <li class="unread">


                                                    <a href="<?php echo ADDRESS_ADMIN_CONTROL?>payment_confirm&action=edit&id=<?=$row['id']?>">


                                                        <span class="thumbnail"><img src="assets/images/icon-payment.png" alt=""></span>


                                                        <span class="info" style="  padding-top: 5px;">


                                                            <span class="name">เลขที่สั่งซื้อ <?php echo $functions->padLeft($row['orders_id'], 5, "0") ?></span>


                                                            <span class="message">


                                                                ยอดเงินการแจ้งชำระ <?php echo $row['transfer_amount'] ?>


                                                            </span>


                                                            <span class="time">


                                                               <?php echo $functions->ShowDateThTime($row['created_at']) ?> 


                                                            </span>


                                                        </span>


                                                    </a>


                                                </li>
                                                        
                            



                                                    <?php } ?>

                                                </ul> <a
                                                    class="da-dropdown-sub-footer" href="<?php echo ADDRESS_ADMIN_CONTROL ?>payment_confirm">


                                                    ดูการแจ้งชำระเงินทั้งหมด </a></li>


                                        </ul>


                                    </li>
                                    <li class="da-header-button-wrap"
                                        title="ข้อความที่ยังไม่ได้อ่าน">


                                        <div class="da-header-button" data-toggle="dropdown">

                                            <?php if ($contact_message->CountDataDesc("id", "status = 'ยังไม่ได้อ่าน'") > 0) { ?>
                                                <span class="btn-count"><?php echo $contact_message->CountDataDesc("id", "status = 'ยังไม่ได้อ่าน'") ?></span>
                                            <?php } ?>

                                            <a href="#"><i
                                                    class="icon-envelope"></i></a>


                                        </div>

                                        <ul class="dropdown-menu pull-right">
                                            <li><span class="da-dropdown-sub-title">Messages</span> <a
                                                    class="da-dropdown-sub-footer"
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>contact_message">


                                                    View all messages </a></li>


                                        </ul>


                                    </li>

                                    <li class="da-header-button-wrap">
                                        <div class="da-header-button">
                                            <a href="javascript:void(0)"
                                               onclick="window.location = '<?php echo ADDRESS_ADMIN_CONTROL ?>logout'"
                                               title="ออกจากระบบ"><i class="icon-power"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="da-content">

                <!-- Container -->
                <div class="da-container clearfix">

                    <!-- Sidebar Separator do not remove -->
                    <div id="da-sidebar-separator"></div>

                    <!-- Sidebar -->
                    <div id="da-sidebar">

                        <!-- Navigation Toggle for < 480px -->
                        <div id="da-sidebar-toggle"></div>

                        <!-- Main Navigation -->
                        <div id="da-main-nav" class="btn-container">
                            <ul>
                                <li class="<?= PAGE_CONTROLLERS == 'slides' || PAGE_CONTROLLERS == 'ads' || PAGE_CONTROLLERS == 'home' 
								|| PAGE_CONTROLLERS == 'address' || PAGE_CONTROLLERS == 'address_map' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="../images/icon-home.png"
                                                                  width="32" height="32">
                                        </span> HOME
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'slides' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>slides">ภาพสไลด์</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'ads' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>ads">ads</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'home' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>home&action=edit&id=1">รายละเอียด</a></li>
                                        <!--  <li><a href="<?php //echo ADDRESS_ADMIN_CONTROL     ?>google_map&action=edit&id=1">แผนที่</a></li>-->
                                        <li class="<?= PAGE_CONTROLLERS == 'address' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>address&action=edit&id=1">ที่อยู่</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'address_map' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>address_map&action=edit&id=1">แผนที่</a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'customer' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="assets/images/icon-user.png"
                                                                  width="32" height="32">
                                        </span> Users
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'customer' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>customer">จัดการผู้ใช้งาน</a></li>
									
                                    </ul>
                                    </li>
                                <li class="<?= PAGE_CONTROLLERS == 'all_product' || PAGE_CONTROLLERS == 'category' || PAGE_CONTROLLERS == 'product' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="assets/images/icon-product.png"
                                                                  width="32" height="32">
                                        </span> PRODUCTS
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'all_product' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>all_product&action=edit&id=1">รายละเอียด</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'category' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>category">จัดการหมวดหมู่สินค้า</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'product' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product">จัดการสินค้า</a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'ordered' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="../images/icon-product.png"
                                                                  width="32" height="32">
                                        </span> ORDER
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'ordered' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>ordered">ข้อมูลการสั่งซื้อ</a></li>

                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'shipping' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="assets/images/icon-shipping.png"
                                                                  width="32" height="32">
                                        </span> SHIPPING
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'shipping' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>shipping">ตั้งค่า
                                                ค่าส่งของ</a></li>

                                    </ul></li>


                                <li class="<?= PAGE_CONTROLLERS == 'blog_category' || PAGE_CONTROLLERS == 'blog'? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="assets/images/icon-blog.png"
                                                                  width="32" height="32">
                                        </span> BLOG
                                    </a>
                                    <ul>

                                        <li class="<?= PAGE_CONTROLLERS == 'blog_category' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>blog_category">จัดการหมวดหมู่บล็อก</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'blog' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>blog">จัดการบล็อก</a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'best_offer' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="assets/images/icon-offer.png"
                                                                  width="32" height="32">
                                        </span> BEST OFFRER
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'best_offer' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>best_offer&action=edit&id=1">รายละเอียด</a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'shopping_guide' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="../images/icon-shopping.png"
                                                                  width="32" height="32">
                                        </span> ORDER & PAY
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'shopping_guide' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>shopping_guide&action=edit&id=1">รายละเอียด</a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'bank' ||  PAGE_CONTROLLERS == 'payment_confirm'? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="assets/images/icon-payment2.png"
                                                                  width="32" height="32">
                                        </span> PAYMENT CONFIRM
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'bank' ? 'actived':''?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>bank">จัดการธนาคาร</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'payment_confirm' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>payment_confirm">แจ้งการชำระเงิน
                                            </a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'about' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="../images/icon-about.png"
                                                                  width="32" height="32">
                                        </span> ABOUT US
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'about' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>about&action=edit&id=1">รายละเอียด</a></li>
                                    </ul></li>
                                <li class="<?= PAGE_CONTROLLERS == 'contact' || PAGE_CONTROLLERS == 'contact_message' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="../images/icon-contact.png"
                                                                  width="32" height="32">
                                        </span> CONTACT US
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'contact' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>contact&action=edit&id=1">รายละเอียด</a></li>
                                        <li class="<?= PAGE_CONTROLLERS == 'contact_message' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>contact_message">ข้อความ</a></li>
                                    </ul></li>
                                       <li class="<?= PAGE_CONTROLLERS == 'tag' ? 'active':''?>"><a href="#"> <!-- Icon Container --> <span
                                            class="da-nav-icon"> <img src="../images/icon-about.png"
                                                                  width="32" height="32">
                                        </span> Tag สินค้า
                                    </a>
                                    <ul>
                                        <li class="<?= PAGE_CONTROLLERS == 'tag' ? 'actived':''?>"><a
                                                href="<?php echo ADDRESS_ADMIN_CONTROL ?>tag">จัดการ Tag</a></li>
                                    </ul></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Main Content Wrapper -->
                    <div id="da-content-wrap" class="clearfix">

                        <!-- Content Area -->
                        <div id="da-content-area">
                            <?php
							if(PAGE_CONTROLLERS == ''){
                        			    include ("controllers/slides.php");
										header("location:".PAGE_CONTROLLERS.'slides');
							}else{
								    include ("controllers/" . PAGE_CONTROLLERS . ".php");
							}
                            ?>
                        </div>
                    </div>
                    <script type="text/javascript">
//$( document ).ready(function() {
                        function addfile() {
                            $("#filecopy:first").clone().insertAfter("div #filecopy:last");
                        }
                        function delfile() {
                            //$("#filecopy").clone().insertAfter("div #filecopy:last");
                            var conveniancecount = $("div #filecopy").length;
                            if (conveniancecount > 2) {
                                $("div #filecopy:last").remove();
                            }




                        }

//});

                    </script>
                    <script>
                        $(function () {
                            // $( "#datepicker" ).datepicker();
                            $("#activity_date").datepicker({dateFormat: "yy-mm-dd"}).val()
                        });


                    </script>
                    <style>
                        /*Colored Label Attributes*/
                        .label {
                            background-color: #BFBFBF;
                            border-bottom-left-radius: 3px;
                            border-bottom-right-radius: 3px;
                            border-top-left-radius: 3px;
                            border-top-right-radius: 3px;
                            color: #FFFFFF;
                            font-size: 9.75px;
                            font-weight: bold;
                            padding-bottom: 2px;
                            padding-left: 4px;
                            padding-right: 4px;
                            padding-top: 2px;
                            text-transform: uppercase;
                            white-space: nowrap;
                        }

                        .label:hover {
                            opacity: 80;
                        }

                        .label.success {
                            background-color: #46A546;
                        }

                        .label.success2 {
                            background-color: #CCC;
                        }

                        .label.success3 {
                            background-color: #61a4e4;
                        }

                        .label.warning {
                            background-color: #FC9207;
                        }

                        .label.failure {
                            background-color: #D32B26;
                        }

                        .label.alert {
                            background-color: #33BFF7;
                        }

                        .label.good-job {
                            background-color: #9C41C6;
                        }
						   tr {
						font-size: 12px;
					}
			
                    </style>
                </div>
            </div>

            <!-- Footer -->
            <div id="da-footer">
                <div class="da-container clearfix">
                    <p>Copyright 2015.</p>
                </div>
            </div>
        </div>
    </div>

</div>


<textarea tabindex="-1"
          style="position: absolute; top: -9999px; left: -9999px; right: auto; bottom: auto; border: 0px; box-sizing: content-box; word-wrap: break-word; overflow: hidden; height: 0px !important; min-height: 0px !important;"></textarea>
<div
    class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable"
    tabindex="-1" role="dialog" aria-labelledby="ui-id-1"
    style="display: none; outline: 0px; z-index: 1000;">
    <div
        class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
        <span id="ui-id-1" class="ui-dialog-title">Get CSS Style</span><a
            href="#" class="ui-dialog-titlebar-close ui-corner-all"
            role="button"><span class="ui-icon ui-icon-closethick">close</span></a>
    </div>
    <div id="da-customizer-dialog"
         class="ui-dialog-content ui-widget-content" style="">
        <textarea readonly id="da-customizer-css"></textarea>
    </div>
</div>
<!-- Localized -->

</body>
</html>