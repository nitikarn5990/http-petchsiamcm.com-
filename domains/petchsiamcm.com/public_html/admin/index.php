<?php
// Prerequisites
session_start();
//include_once ( '../lib/application.php');


include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');
if ($_SESSION ['admin_id'] == "") {


    header('location:' . ADDRESS_ADMIN . 'login.php');
}
if ($_SESSION['admin_id'] == 'demo') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_GET['action'] == 'del') {
        SetAlert('DEMO MODE ไม่สามารถกระทำรายการได้');
        header('location:' . ADDRESS_ADMIN_CONTROL . 'demo');
        exit();
    }
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
        <link rel="stylesheet" href="plugins/elfinder/css/elfinder.min.css"  media="screen">

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


            .bg-success{
                background-color: rgba(139, 195, 74, 0.27) !important;
            }
            .bg-warning{
                background-color: rgba(255, 235, 59, 0.27) !important;
            }
            .hidden{
                display: none !important;
            }

        </style>

        <!-- Switch -->
        <script src="js/jquery-1.12.2.min.js"></script>
        <script src="plugins/switch/js/on-off-switch.js"></script>
        <script src="plugins/switch/js/on-off-switch-onload.js"></script>
        <link rel="stylesheet" href="plugins/switch/css/on-off-switch.css">

        <!-- Date Picker -->
        <link rel="stylesheet" href="plugins/datepicker/css/datepicker.min.css">
        <script src="plugins/datepicker/js/datepicker.min.js"></script>
        <script src="plugins/datepicker/js/i18n/datepicker.en.js"></script>

        <!-- Validate -->
        <link rel="stylesheet" href="js/jquery-ui.css">

        <script src="js/jquery-ui.js"></script>

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

                                    <img src="images/admin2.png" alt="" style="width: 156px;"> 

                                </div>
                            </div>
                        </div>

                        <!-- Header Toolbar Menu -->
                        <div id="da-header-toolbar" class="clearfix">
                            <div id="da-user-profile-wrap">
                                <div id="" data-toggle="" class="clearfix">

                                    <div id="da-user-info">
                                        <a target="" href="<?= ADDRESS ?>"><span class="da-user-title"> 
                                                <img title="ไปยังเว็บหลัก" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDY0IDY0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA2NCA2NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIzMnB4IiBoZWlnaHQ9IjMycHgiPgo8Zz4KCTxwYXRoIGQ9Ik02Myw1NmgtM1YxOWgtMC4wMjZDNjAuNjA5LDE4LjE2Miw2MSwxNy4xMyw2MSwxNnYtM1YxYzAtMC41NTItMC40NDgtMS0xLTFINEMzLjQ0OCwwLDMsMC40NDgsMywxdjEydjMgICBjMCwxLjEzLDAuMzkxLDIuMTYyLDEuMDI2LDNINHYzN0gxYy0wLjU1MiwwLTEsMC40NDgtMSwxdjJjMCwyLjc1NywyLjI0Myw1LDUsNWg1NGMyLjc1NywwLDUtMi4yNDMsNS01di0yICAgQzY0LDU2LjQ0OCw2My41NTIsNTYsNjMsNTZ6IE01LDE0aDZ2MmMwLDEuNjU0LTEuMzQ2LDMtMywzcy0zLTEuMzQ2LTMtM1YxNHogTTQ1LDEyVjJoNnYxMEg0NXogTTQzLDEyaC02VjJoNlYxMnogTTM1LDEyaC02VjJoNiAgIFYxMnogTTI3LDEyaC02VjJoNlYxMnogTTE5LDEyaC02VjJoNlYxMnogTTEzLDE0aDZ2MmMwLDEuNjU0LTEuMzQ2LDMtMywzcy0zLTEuMzQ2LTMtM1YxNHogTTIxLDE0aDZ2MmMwLDEuNjU0LTEuMzQ2LDMtMywzICAgcy0zLTEuMzQ2LTMtM1YxNHogTTI5LDE0aDZ2MmMwLDEuNjU0LTEuMzQ2LDMtMywzcy0zLTEuMzQ2LTMtM1YxNHogTTM3LDE0aDZ2MmMwLDEuNjU0LTEuMzQ2LDMtMywzcy0zLTEuMzQ2LTMtM1YxNHogTTQ1LDE0aDZ2MiAgIGMwLDEuNjU0LTEuMzQ2LDMtMywzcy0zLTEuMzQ2LTMtM1YxNHogTTUzLDE0aDZ2MmMwLDEuNjU0LTEuMzQ2LDMtMywzcy0zLTEuMzQ2LTMtM1YxNHogTTU5LDEyaC02VjJoNlYxMnogTTUsMmg2djEwSDVWMnogICAgTTYsMjAuNTc2QzYuNjE0LDIwLjg0Niw3LjI4OCwyMSw4LDIxYzEuNjQxLDAsMy4wODgtMC44MDYsNC0yLjAzMUMxMi45MTIsMjAuMTk0LDE0LjM1OSwyMSwxNiwyMXMzLjA4OC0wLjgwNiw0LTIuMDMxICAgQzIwLjkxMiwyMC4xOTQsMjIuMzU5LDIxLDI0LDIxczMuMDg4LTAuODA2LDQtMi4wMzFDMjguOTEyLDIwLjE5NCwzMC4zNTksMjEsMzIsMjFjMS42NDEsMCwzLjA4OC0wLjgwNiw0LTIuMDMxICAgQzM2LjkxMiwyMC4xOTQsMzguMzU5LDIxLDQwLDIxczMuMDg4LTAuODA2LDQtMi4wMzFDNDQuOTEyLDIwLjE5NCw0Ni4zNTksMjEsNDgsMjFzMy4wODgtMC44MDYsNC0yLjAzMSAgIEM1Mi45MTIsMjAuMTk0LDU0LjM1OSwyMSw1NiwyMWMwLjcxMiwwLDEuMzg2LTAuMTU0LDItMC40MjRWNTZoLTJWMjNjMC0wLjU1Mi0wLjQ0OC0xLTEtMUg5Yy0wLjU1MiwwLTEsMC40NDgtMSwxdjd2MnYyNEg2VjIwLjU3NiAgIHogTTEwLDMyaDQ0djI0SDEwVjMyeiBNMTAsMzB2LTZoNDR2NkgxMHogTTYyLDU5YzAsMS42NTQtMS4zNDYsMy0zLDNINWMtMS42NTQsMC0zLTEuMzQ2LTMtM3YtMWgzaDRoNDZoNGgzVjU5eiIgZmlsbD0iI0ZGRkZGRiIvPgoJPHBhdGggZD0iTTE0LDQ2aDEzYzAuNTUyLDAsMS0wLjQ0OCwxLTF2LTljMC0wLjU1Mi0wLjQ0OC0xLTEtMUgxNGMtMC41NTIsMC0xLDAuNDQ4LTEsMXY5QzEzLDQ1LjU1MiwxMy40NDgsNDYsMTQsNDZ6IE0xNSwzN2g1djJoMiAgIHYtMmg0djdIMTVWMzd6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8cGF0aCBkPSJNMzAuMjkzLDM3LjI5M0MzMC4xMDUsMzcuNDgsMzAsMzcuNzM1LDMwLDM4djEwSDEzdjJoMi4zNTFDMTUuMTMzLDUwLjQ1NiwxNSw1MC45NjEsMTUsNTEuNWMwLDEuOTMsMS41NywzLjUsMy41LDMuNSAgIHMzLjUtMS41NywzLjUtMy41YzAtMC41MzktMC4xMzMtMS4wNDQtMC4zNTEtMS41aDIuNzAyQzI0LjEzMyw1MC40NTYsMjQsNTAuOTYxLDI0LDUxLjVjMCwxLjkzLDEuNTcsMy41LDMuNSwzLjVzMy41LTEuNTcsMy41LTMuNSAgIGMwLTAuNTM5LTAuMTMzLTEuMDQ0LTAuMzUxLTEuNUgzMWMwLjU1MiwwLDEtMC40NDgsMS0xVjM4LjQxNGwyLjcwNy0yLjcwN2wtMS40MTQtMS40MTRMMzAuMjkzLDM3LjI5M3ogTTIwLDUxLjUgICBjMCwwLjgyNy0wLjY3MywxLjUtMS41LDEuNVMxNyw1Mi4zMjcsMTcsNTEuNXMwLjY3My0xLjUsMS41LTEuNVMyMCw1MC42NzMsMjAsNTEuNXogTTI5LDUxLjVjMCwwLjgyNy0wLjY3MywxLjUtMS41LDEuNSAgIFMyNiw1Mi4zMjcsMjYsNTEuNXMwLjY3My0xLjUsMS41LTEuNVMyOSw1MC42NzMsMjksNTEuNXoiIGZpbGw9IiNGRkZGRkYiLz4KCTxyZWN0IHg9IjEyIiB5PSIyNiIgd2lkdGg9IjIiIGhlaWdodD0iMiIgZmlsbD0iI0ZGRkZGRiIvPgoJPHJlY3QgeD0iMTYiIHk9IjI2IiB3aWR0aD0iMiIgaGVpZ2h0PSIyIiBmaWxsPSIjRkZGRkZGIi8+Cgk8cmVjdCB4PSIyMCIgeT0iMjYiIHdpZHRoPSIyIiBoZWlnaHQ9IjIiIGZpbGw9IiNGRkZGRkYiLz4KCTxyZWN0IHg9IjI0IiB5PSIyNiIgd2lkdGg9IjIwIiBoZWlnaHQ9IjIiIGZpbGw9IiNGRkZGRkYiLz4KCTxwYXRoIGQ9Ik01MC43NzgsNDguNDM5YzAuMjM4LTAuMjM4LDAuMzQtMC41NzksMC4yNzItMC45MDhjLTAuMDY3LTAuMzI5LTAuMjk2LTAuNjAzLTAuNjA4LTAuNzI4bC03LjA3MS0yLjgyOSAgIGMtMC4zNzEtMC4xNDctMC43OTYtMC4wNjItMS4wNzksMC4yMjJjLTAuMjgzLDAuMjgzLTAuMzcsMC43MDctMC4yMjIsMS4wNzlsMi44MjksNy4wNzFjMC4xMjUsMC4zMTIsMC4zOTgsMC41NDEsMC43MjgsMC42MDggICBjMC4wNjcsMC4wMTQsMC4xMzQsMC4wMjEsMC4yMDEsMC4wMjFjMC4yNjMsMCwwLjUxOC0wLjEwNCwwLjcwNy0wLjI5M2wxLjQxNC0xLjQxNGwzLjAzNSwzLjAzNWwxLjQxNC0xLjQxNGwtMy4wMzUtMy4wMzUgICBMNTAuNzc4LDQ4LjQzOXogTTQ2LjE5NCw1MC4xOTZsLTEuMzk5LTMuNDk3bDMuNDk3LDEuMzk5TDQ2LjE5NCw1MC4xOTZ6IiBmaWxsPSIjRkZGRkZGIi8+Cgk8cGF0aCBkPSJNNDAsMzljMS42NTQsMCwzLDEuMzQ2LDMsM2gyYzAtMi43NTctMi4yNDMtNS01LTVzLTUsMi4yNDMtNSw1czIuMjQzLDUsNSw1di0yYy0xLjY1NCwwLTMtMS4zNDYtMy0zUzM4LjM0NiwzOSw0MCwzOXoiIGZpbGw9IiNGRkZGRkYiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                                <span class="">  </span></span></a>
                                    </div>
                                </div>

                            </div>
                            <div id="da-user-profile-wrap">
                                <div id="da-user-profile" data-toggle="dropdown" class="clearfix">
                                    <div id="da-user-avatar"></div>
                                    <div id="da-user-info">
                                        <?= $_SESSION['admin_id'] == 'demo' ? 'Demo' : 'Admin Administrator' ?>  <span class="da-user-title"><?= $_SESSION['admin_id'] == 'demo' ? 'Demo' : 'Admin Administrator' ?> </span>
                                    </div>
                                </div>
                                <ul class="dropdown-menu">

                                    <li><a
                                            href="<?php echo ADDRESS_ADMIN_CONTROL ?>profile&action=edit&id=1">เปลี่ยนรหัสผ่าน</a></li>
                                </ul>
                            </div>
                            <div id="da-header-button-container" >
                                <ul>
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
                            <?php if ($_SESSION['group'] == 'admin') { ?>
                                <ul>

                                    <li class="<?= PAGE_CONTROLLERS == 'home' || PAGE_CONTROLLERS == 'slides' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"> <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDQ2MC4yOTggNDYwLjI5NyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDYwLjI5OCA0NjAuMjk3OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTIzMC4xNDksMTIwLjkzOUw2NS45ODYsMjU2LjI3NGMwLDAuMTkxLTAuMDQ4LDAuNDcyLTAuMTQ0LDAuODU1Yy0wLjA5NCwwLjM4LTAuMTQ0LDAuNjU2LTAuMTQ0LDAuODUydjEzNy4wNDEgICAgYzAsNC45NDgsMS44MDksOS4yMzYsNS40MjYsMTIuODQ3YzMuNjE2LDMuNjEzLDcuODk4LDUuNDMxLDEyLjg0Nyw1LjQzMWgxMDkuNjNWMzAzLjY2NGg3My4wOTd2MTA5LjY0aDEwOS42MjkgICAgYzQuOTQ4LDAsOS4yMzYtMS44MTQsMTIuODQ3LTUuNDM1YzMuNjE3LTMuNjA3LDUuNDMyLTcuODk4LDUuNDMyLTEyLjg0N1YyNTcuOTgxYzAtMC43Ni0wLjEwNC0xLjMzNC0wLjI4OC0xLjcwN0wyMzAuMTQ5LDEyMC45MzkgICAgeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik00NTcuMTIyLDIyNS40MzhMMzk0LjYsMTczLjQ3NlY1Ni45ODljMC0yLjY2My0wLjg1Ni00Ljg1My0yLjU3NC02LjU2N2MtMS43MDQtMS43MTItMy44OTQtMi41NjgtNi41NjMtMi41NjhoLTU0LjgxNiAgICBjLTIuNjY2LDAtNC44NTUsMC44NTYtNi41NywyLjU2OGMtMS43MTEsMS43MTQtMi41NjYsMy45MDUtMi41NjYsNi41Njd2NTUuNjczbC02OS42NjItNTguMjQ1ICAgIGMtNi4wODQtNC45NDktMTMuMzE4LTcuNDIzLTIxLjY5NC03LjQyM2MtOC4zNzUsMC0xNS42MDgsMi40NzQtMjEuNjk4LDcuNDIzTDMuMTcyLDIyNS40MzhjLTEuOTAzLDEuNTItMi45NDYsMy41NjYtMy4xNCw2LjEzNiAgICBjLTAuMTkzLDIuNTY4LDAuNDcyLDQuODExLDEuOTk3LDYuNzEzbDE3LjcwMSwyMS4xMjhjMS41MjUsMS43MTIsMy41MjEsMi43NTksNS45OTYsMy4xNDJjMi4yODUsMC4xOTIsNC41Ny0wLjQ3Niw2Ljg1NS0xLjk5OCAgICBMMjMwLjE0OSw5NS44MTdsMTk3LjU3LDE2NC43NDFjMS41MjYsMS4zMjgsMy41MjEsMS45OTEsNS45OTYsMS45OTFoMC44NThjMi40NzEtMC4zNzYsNC40NjMtMS40Myw1Ljk5Ni0zLjEzOGwxNy43MDMtMjEuMTI1ICAgIGMxLjUyMi0xLjkwNiwyLjE4OS00LjE0NSwxLjk5MS02LjcxNkM0NjAuMDY4LDIyOS4wMDcsNDU5LjAyMSwyMjYuOTYxLDQ1Ny4xMjIsMjI1LjQzOHoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                            </span> หน้าแรก
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'slides' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>slides">ภาพสไลด์</a></li>
                                            <li class="<?= PAGE_CONTROLLERS == 'home' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>home&action=edit&id=1">รายละเอียด</a></li>

                                        </ul>
                                    </li>
                                    <li class="<?= PAGE_CONTROLLERS == 'social' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDUxMCA1MTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMCA1MTA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0icG9zdC1mYWNlYm9vayI+CgkJPHBhdGggZD0iTTQ1OSwwSDUxQzIyLjk1LDAsMCwyMi45NSwwLDUxdjQwOGMwLDI4LjA1LDIyLjk1LDUxLDUxLDUxaDQwOGMyOC4wNSwwLDUxLTIyLjk1LDUxLTUxVjUxQzUxMCwyMi45NSw0ODcuMDUsMCw0NTksMHogICAgIE00MzMuNSw1MXY3Ni41aC01MWMtMTUuMywwLTI1LjUsMTAuMi0yNS41LDI1LjV2NTFoNzYuNXY3Ni41SDM1N1Y0NTloLTc2LjVWMjgwLjVoLTUxVjIwNGg1MXYtNjMuNzUgICAgQzI4MC41LDkxLjgsMzIxLjMsNTEsMzY5Ljc1LDUxSDQzMy41eiIgZmlsbD0iIzAwMDAwMCIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                                            </span> Social
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'social' ? 'actived' : '' ?>"><a
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>social&action=edit&id=1">Facebook, Twitter</a></li>


                                        </ul>
                                    </li>
                                    <li class="<?= PAGE_CONTROLLERS == 'customer' || PAGE_CONTROLLERS == 'transfer_money' || PAGE_CONTROLLERS == 'history_transfer' || PAGE_CONTROLLERS == 'transfer_money_history' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"> <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDgwLjEzIDgwLjEzIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA4MC4xMyA4MC4xMzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxwYXRoIGQ9Ik00OC4zNTUsMTcuOTIyYzMuNzA1LDIuMzIzLDYuMzAzLDYuMjU0LDYuNzc2LDEwLjgxN2MxLjUxMSwwLjcwNiwzLjE4OCwxLjExMiw0Ljk2NiwxLjExMiAgIGM2LjQ5MSwwLDExLjc1Mi01LjI2MSwxMS43NTItMTEuNzUxYzAtNi40OTEtNS4yNjEtMTEuNzUyLTExLjc1Mi0xMS43NTJDNTMuNjY4LDYuMzUsNDguNDUzLDExLjUxNyw0OC4zNTUsMTcuOTIyeiBNNDAuNjU2LDQxLjk4NCAgIGM2LjQ5MSwwLDExLjc1Mi01LjI2MiwxMS43NTItMTEuNzUycy01LjI2Mi0xMS43NTEtMTEuNzUyLTExLjc1MWMtNi40OSwwLTExLjc1NCw1LjI2Mi0xMS43NTQsMTEuNzUyUzM0LjE2Niw0MS45ODQsNDAuNjU2LDQxLjk4NCAgIHogTTQ1LjY0MSw0Mi43ODVoLTkuOTcyYy04LjI5NywwLTE1LjA0Nyw2Ljc1MS0xNS4wNDcsMTUuMDQ4djEyLjE5NWwwLjAzMSwwLjE5MWwwLjg0LDAuMjYzICAgYzcuOTE4LDIuNDc0LDE0Ljc5NywzLjI5OSwyMC40NTksMy4yOTljMTEuMDU5LDAsMTcuNDY5LTMuMTUzLDE3Ljg2NC0zLjM1NGwwLjc4NS0wLjM5N2gwLjA4NFY1Ny44MzMgICBDNjAuNjg4LDQ5LjUzNiw1My45MzgsNDIuNzg1LDQ1LjY0MSw0Mi43ODV6IE02NS4wODQsMzAuNjUzaC05Ljg5NWMtMC4xMDcsMy45NTktMS43OTcsNy41MjQtNC40NywxMC4wODggICBjNy4zNzUsMi4xOTMsMTIuNzcxLDkuMDMyLDEyLjc3MSwxNy4xMXYzLjc1OGM5Ljc3LTAuMzU4LDE1LjQtMy4xMjcsMTUuNzcxLTMuMzEzbDAuNzg1LTAuMzk4aDAuMDg0VjQ1LjY5OSAgIEM4MC4xMywzNy40MDMsNzMuMzgsMzAuNjUzLDY1LjA4NCwzMC42NTN6IE0yMC4wMzUsMjkuODUzYzIuMjk5LDAsNC40MzgtMC42NzEsNi4yNS0xLjgxNGMwLjU3Ni0zLjc1NywyLjU5LTcuMDQsNS40NjctOS4yNzYgICBjMC4wMTItMC4yMiwwLjAzMy0wLjQzOCwwLjAzMy0wLjY2YzAtNi40OTEtNS4yNjItMTEuNzUyLTExLjc1LTExLjc1MmMtNi40OTIsMC0xMS43NTIsNS4yNjEtMTEuNzUyLDExLjc1MiAgIEM4LjI4MywyNC41OTEsMTMuNTQzLDI5Ljg1MywyMC4wMzUsMjkuODUzeiBNMzAuNTg5LDQwLjc0MWMtMi42Ni0yLjU1MS00LjM0NC02LjA5Ny00LjQ2Ny0xMC4wMzIgICBjLTAuMzY3LTAuMDI3LTAuNzMtMC4wNTYtMS4xMDQtMC4wNTZoLTkuOTcxQzYuNzUsMzAuNjUzLDAsMzcuNDAzLDAsNDUuNjk5djEyLjE5N2wwLjAzMSwwLjE4OGwwLjg0LDAuMjY1ICAgYzYuMzUyLDEuOTgzLDEyLjAyMSwyLjg5NywxNi45NDUsMy4xODV2LTMuNjgzQzE3LjgxOCw0OS43NzMsMjMuMjEyLDQyLjkzNiwzMC41ODksNDAuNzQxeiIgZmlsbD0iIzAwMDAwMCIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                                            </span> สมาชิก
                                        </a>
                                        <ul>

                                            <li class="<?= PAGE_CONTROLLERS == 'customer' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>customer">จัดการสมาชิก</a></li>
                                            <li class="<?= PAGE_CONTROLLERS == 'transfer_money' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money">คำขอถอนเงิน</a></li>
                                            <li class="<?= PAGE_CONTROLLERS == 'transfer_money_history' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>transfer_money_history">ประวัติการเงิน</a></li>

                                        </ul>
                                    </li>
                                    <li class="<?= PAGE_CONTROLLERS == 'products_message' || PAGE_CONTROLLERS == 'product' || PAGE_CONTROLLERS == 'product' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"> <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDMwOS4wMjMgMzA5LjAyMyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMzA5LjAyMyAzMDkuMDIzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxnPgoJPHBhdGggZD0iTTIyMS42MjEsNTAuNjQ3Yy0wLjI3Ni0yLjQ5Ni0xLjgzNy00LjcxNi00LjExLTUuODY3TDE1Ny45MDEsMTQuNThjLTIuMTMxLTEuMDgtNC42NDgtMS4wOC02Ljc3OSwwTDkxLjUxLDQ0Ljc3OCAgIGMtMi41MjEsMS4yNzctNC4xMSwzLjg2My00LjExLDYuNjl2MC4wMDF2MC4wMDF2NTAuMzEyTDQuMjgsMTQyLjIxNWMtMi40OTYsMS4xODctNC4xMzgsMy42NS00LjI3Miw2LjQxMSAgIGMtMC4xMzQsMi43NjIsMS4yNjIsNS4zNzIsMy42MzIsNi43OTRsNTIuNDExLDMxLjQ0OXY1NC45MzhjMCwyLjgzLDEuNTkzLDUuNDE5LDQuMTE4LDYuNjk0bDkwLjk2LDQ1Ljk0NiAgIGMxLjA2MywwLjUzNywyLjIyMywwLjgwNiwzLjM4MiwwLjgwNmMxLjE1OSwwLDIuMzE4LTAuMjY5LDMuMzgyLTAuODA2bDkwLjk1OS00NS45NDZjMi41MjUtMS4yNzUsNC4xMTgtMy44NjQsNC4xMTgtNi42OTR2LTU0LjkzOCAgIGw1Mi40MTEtMzEuNDQ5YzIuMzcxLTEuNDIyLDMuNzY3LTQuMDMyLDMuNjMzLTYuNzk0Yy0wLjEzNC0yLjc2MS0xLjc3NS01LjIyNC00LjI3MS02LjQxbC04My4xMjItNDAuNDM4VjUwLjY0N3ogTTIyOC44NTUsMTIyLjMgICBsLTcuMjMzLDMuNjMydi03LjMxN0wyMjguODU1LDEyMi4zeiBNMTU0LjUxMiwyOS42NzhsNDMuMDE0LDIxLjc5MmwtNDMuMDE0LDIxLjc5MWwtNDMuMDE2LTIxLjc5M0wxNTQuNTEyLDI5LjY3OHogICAgTTg3LjM5OSwxMTguNjE2djcuMzE0bC03LjIzLTMuNjNMODcuMzk5LDExOC42MTZ6IE0yMy4zNTYsMTQ5Ljc1OGw0MC4xMDQtMTkuMDYxbDc2LjA0OCwzOC4xOGwtNDAuMzAyLDI2LjM5NUwyMy4zNTYsMTQ5Ljc1OHogICAgTTE0Ny4wMTIsMjc1LjU2M2wtNzUuOTYtMzguMzdWMTk1Ljg3bDI0LjQ3MSwxNC42ODRjMS4xODksMC43MTQsMi41MjUsMS4wNjksMy44NTksMS4wNjljMS40MzMsMCwyLjg2My0wLjQxLDQuMTA5LTEuMjI2ICAgbDQzLjUyMS0yOC41MDNWMjc1LjU2M3ogTTE1NC41MTIsMTU5LjYyNGwtNTIuMTEyLTI2LjE2M1Y2My42NzVsNDguNzIzLDI0LjY4NGMxLjA2NSwwLjU0LDIuMjI3LDAuODEsMy4zOSwwLjgxICAgYzEuMTYyLDAsMi4zMjQtMC4yNywzLjM5LTAuODFsNDguNzItMjQuNjgydjY5Ljc4NUwxNTQuNTEyLDE1OS42MjR6IE0yMzcuOTcxLDIzNy4xOTNsLTc1Ljk1OSwzOC4zN3YtOTMuNjY4bDQzLjUxOSwyOC41MDMgICBjMS4yNDYsMC44MTYsMi42NzcsMS4yMjYsNC4xMDksMS4yMjZjMS4zMzQsMCwyLjY3LTAuMzU1LDMuODU5LTEuMDY5bDI0LjQ3Mi0xNC42ODVWMjM3LjE5M3ogTTIwOS44MTQsMTk1LjI3MmwtNDAuMzAxLTI2LjM5NSAgIGw3Ni4wNDgtMzguMTgxbDQwLjEwNSwxOS4wNjFMMjA5LjgxNCwxOTUuMjcyeiIgZmlsbD0iIzAwMDAwMCIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                                            </span> สินค้า
                                        </a>
                                        <ul>

                                            <li class=" <?= PAGE_CONTROLLERS == 'products_message' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>products_message&action=edit&id=1">รายละเอียด</a></li>
                                            <li class="<?= PAGE_CONTROLLERS == 'product' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product">จัดการสินค้า</a></li>
                                        </ul></li>
                                    <li class="<?= PAGE_CONTROLLERS == 'ordered' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDQwOS4yMjEgNDA5LjIyMSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgNDA5LjIyMSA0MDkuMjIxIiB3aWR0aD0iMzJweCIgaGVpZ2h0PSIzMnB4Ij4KICA8cGF0aCBkPSJtMjUyLjczOCwzMTAuODIzYzAsNS41MjMtNC40NzcsMTAtMTAsMTBoLTc2LjI1NGMtNS41MjMsMC0xMC00LjQ3Ny0xMC0xMHM0LjQ3Ny0xMCAxMC0xMGg3Ni4yNTRjNS41MjMsMCAxMCw0LjQ3NyAxMCwxMHptLTk0LjYxNy0xNjAuOTE0YzAtMTkuMjQ4IDIwLjQyMS0zNC4zMjYgNDYuNDktMzQuMzI2czQ2LjQ4OSwxNS4wNzggNDYuNDg5LDM0LjMyNi0yMC40MiwzNC4zMjYtNDYuNDg5LDM0LjMyNi00Ni40OS0xNS4wNzgtNDYuNDktMzQuMzI2em0yMCwwYzAsNi43NjIgMTEuMzI5LDE0LjMyNiAyNi40OSwxNC4zMjZzMjYuNDg5LTcuNTYzIDI2LjQ4OS0xNC4zMjYtMTEuMzI4LTE0LjMyNi0yNi40ODktMTQuMzI2LTI2LjQ5LDcuNTY0LTI2LjQ5LDE0LjMyNnptMTc0Ljc5My05OC44Mzd2MzQ4LjE0OGMwLDUuNTIzLTQuNDc3LDEwLTEwLDEwaC0yNzYuNjA3Yy01LjUyMywwLTEwLTQuNDc3LTEwLTEwdi0zNDguMTQ4YzAtNS41MjMgNC40NzctMTAgMTAtMTBoNzkuNjUxdi02Ljc0N2MwLTUuNTIzIDQuNDc3LTEwIDEwLTEwaDE1LjgxMWM0LjI5Mi0xNC4wNjQgMTcuMzktMjQuMzI1IDMyLjg0LTI0LjMyNXMyOC41NSwxMC4yNjEgMzIuODQxLDI0LjMyNmgxNS44MTNjNS41MjMsMCAxMCw0LjQ3NyAxMCwxMHY2Ljc0N2g3OS42NWM1LjUyNC0wLjAwMSAxMC4wMDEsNC40NzYgMTAuMDAxLDkuOTk5em0tMTg2Ljk1NiwyMS45MDdoNzcuMzA1di0yOC42NTNoLTE0LjMyN2MtNS41MjMsMC0xMC00LjQ3Ny0xMC0xMCAwLTcuODk5LTYuNDI2LTE0LjMyNi0xNC4zMjYtMTQuMzI2aC0wLjAwMWMtNy44OTksMC0xNC4zMjYsNi40MjYtMTQuMzI2LDE0LjMyNiAwLDUuNTIzLTQuNDc3LDEwLTEwLDEwaC0xNC4zMjZ2MjguNjUzem0tMzkuNzYzLDI2Ny41ODloMTU2LjgzMnYtMjc5LjQ5NmgtMTkuNzYzdjIxLjkwN2MwLDUuNTIzLTQuNDc3LDEwLTEwLDEwaC05Ny4zMDVjLTUuNTIzLDAtMTAtNC40NzctMTAtMTB2LTIxLjkwN2gtMTkuNzY0djI3OS40OTZ6bTIwNi43Mi0yNzkuNDk2aC0yOS44ODh2Mjg5LjQ5NmMwLDUuNTIzLTQuNDc3LDEwLTEwLDEwaC0xNzYuODMyYy01LjUyMywwLTEwLTQuNDc3LTEwLTEwdi0yODkuNDk2aC0yOS44ODd2MzI4LjE0OGgyNTYuNjA2di0zMjguMTQ4em0tMTA5LjIzOSwyMTEuMDk4YzUuNTIzLDAgMTAtNC40NzcgMTAtMTBzLTQuNDc3LTEwLTEwLTEwaC0zOC4xMjdjLTUuNTIzLDAtMTAsNC40NzctMTAsMTBzNC40NzcsMTAgMTAsMTBoMzguMTI3em0xOS4wNjQtNTEuNzc0aC03Ni4yNTRjLTUuNTIzLDAtMTAsNC40NzctMTAsMTBzNC40NzcsMTAgMTAsMTBoNzYuMjU0YzUuNTIzLDAgMTAtNC40NzcgMTAtMTBzLTQuNDc3LTEwLTEwLTEweiIgZmlsbD0iIzAwMDAwMCIvPgo8L3N2Zz4K" />
                                            </span> ข้อมูลการสั่งซื้อ
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'ordered' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>ordered">ข้อมูลการสั่งซื้อ</a></li>

                                        </ul>
                                    </li>
                                    <li class="<?= PAGE_CONTROLLERS == 'payment_confirm_detail' || PAGE_CONTROLLERS == 'payment_confirm' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"> <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDI0NC42ODMgMjQ0LjY4MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjQ0LjY4MyAyNDQuNjgzIiB3aWR0aD0iMzJweCIgaGVpZ2h0PSIzMnB4Ij4KICA8Zz4KICAgIDxwYXRoIGQ9Im0yNDQuMDU0LDExOC41ODdsLTI1LjQxNy03OS4yMzJjLTEuMDczLTMuMzQ0LTMuMzg0LTYuMDctNi41MDgtNy42NzYtMy4xMjMtMS42MDUtNi42ODUtMS44OTgtMTAuMDI5LTAuODI3bC0xMjkuMjEsNDEuNDVjLTYuOTA0LDIuMjE1LTEwLjcxOCw5LjYzMy04LjUwNCwxNi41MzdsNS4xNzEsMTYuMTJoLTU2LjQwOWMtNy4yNSwwLTEzLjE0OCw1Ljg5OC0xMy4xNDgsMTMuMTQ4djgzLjIwOWMwLDcuMjUgNS44OTgsMTMuMTQ4IDEzLjE0OCwxMy4xNDhoMTQ0LjY5NWM3LjI1LDAgMTMuMTQ4LTUuODk4IDEzLjE0OC0xMy4xNDh2LTQ1LjQ4Mmw2NC41NTgtMjAuNzFjNi45MDQtMi4yMTQgMTAuNzE5LTkuNjMyIDguNTA1LTE2LjUzN3ptLTg2LjIxLDgzLjg3OGgtMTQ0LjY5NmMtMC42MzMsMC0xLjE0OC0wLjUxNS0xLjE0OC0xLjE0OHYtODMuMjA5YzAtMC42MzMgMC41MTUtMS4xNDggMS4xNDgtMS4xNDhoMTQ0LjY5NWMwLjYzMywwIDEuMTQ4LDAuNTE1IDEuMTQ4LDEuMTQ4djgzLjIwOWMwLjAwMSwwLjYzMy0wLjUxNCwxLjE0OC0xLjE0NywxLjE0OHptNDguNzk3LTE2MC4xMTRjMC4xOTMsMC4wOTkgMC40NDgsMC4yOTYgMC41NjgsMC42N2w1LjA3MiwxNS44MS0xMzEuMzk2LDQyLjE1My01LjA3Mi0xNS44MTFjLTAuMTk0LTAuNjAzIDAuMTQtMS4yNTEgMC43NDMtMS40NDRsMTI5LjIwOS00MS40NWMwLjEyNi0wLjA0MSAwLjI0NS0wLjA1NyAwLjM1NC0wLjA1NyAwLjIxNSw3LjEwNTQzZS0xNSAwLjM5NCwwLjA2MyAwLjUyMiwwLjEyOXptLTQ4Ljc5Nyw2Mi42MDhoLTUwLjA2NGwxMDguMTY3LTM0LjcgMTYuNjgsNTEuOTk0YzAuMTkzLDAuNjA0LTAuMTQsMS4yNTItMC43NDMsMS40NDVsLTYwLjg5MiwxOS41MzR2LTI1LjEyNWMtMi44NDIxN2UtMTQtNy4yNS01Ljg5OC0xMy4xNDgtMTMuMTQ4LTEzLjE0OHoiIGZpbGw9IiMwMDAwMDAiLz4KICAgIDxwYXRoIGQ9Im01Ni41NCwxMzQuNzEyaC0yNS42NjZjLTMuMzEzLDAtNiwyLjY4Ny02LDZzMi42ODcsNiA2LDZoMjUuNjY2YzMuMzEzLDAgNi0yLjY4NyA2LTZzLTIuNjg2LTYtNi02eiIgZmlsbD0iIzAwMDAwMCIvPgogICAgPHBhdGggZD0ibTg1LjIwNywxNDYuNzEyYzMuMzEzLDAgNi0yLjY4NyA2LTZzLTIuNjg3LTYtNi02aC05LjMzM2MtMy4zMTMsMC02LDIuNjg3LTYsNnMyLjY4Nyw2IDYsNmg5LjMzM3oiIGZpbGw9IiMwMDAwMDAiLz4KICAgIDxwYXRoIGQ9Im0xNDkuMjA3LDE2MC43MTJjMC0zLjMxMy0yLjY4Ny02LTYtNmgtMjkuMzMzYy0zLjMxMywwLTYsMi42ODctNiw2djI2YzAsMy4zMTMgMi42ODcsNiA2LDZoMjkuMzMzYzMuMzEzLDAgNi0yLjY4NyA2LTZ2LTI2em0tMTIsNnYxNGgtMTcuMzMzdi0xNGgxNy4zMzN6IiBmaWxsPSIjMDAwMDAwIi8+CiAgPC9nPgo8L3N2Zz4K" />
                                            </span> การแจ้งโอนเงิน
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'payment_confirm_detail' ? 'actived' : '' ?>"><a
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>payment_confirm_detail&action=edit&id=1">รายละเอียด
                                                </a> 
                                            </li>
                                            <li class="<?= PAGE_CONTROLLERS == 'payment_confirm' ? 'actived' : '' ?>"><a
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>payment_confirm">แจ้งการชำระเงิน
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="<?= PAGE_CONTROLLERS == 'contact' || PAGE_CONTROLLERS == 'contact_message' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"> <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHZlcnNpb249IjEuMSIgdmlld0JveD0iMCAwIDQ0IDQ0IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA0NCA0NCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CiAgPGc+CiAgICA8Zz4KICAgICAgPGc+CiAgICAgICAgPHBhdGggZD0iTTQzLDZIMUMwLjQ0Nyw2LDAsNi40NDcsMCw3djMwYzAsMC41NTMsMC40NDcsMSwxLDFoNDJjMC41NTIsMCwxLTAuNDQ3LDEtMVY3QzQ0LDYuNDQ3LDQzLjU1Miw2LDQzLDZ6IE00MiwzMy41ODEgICAgIEwyOS42MTIsMjEuMTk0bC0xLjQxNCwxLjQxNEw0MS41OSwzNkgyLjQxbDEzLjM5Mi0xMy4zOTJsLTEuNDE0LTEuNDE0TDIsMzMuNTgxVjhoNDBWMzMuNTgxeiIgZmlsbD0iIzAwMDAwMCIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgICA8Zz4KICAgICAgPGc+CiAgICAgICAgPHBhdGggZD0iTTM5Ljk3OSw4TDIyLDI1Ljk3OUw0LjAyMSw4SDJ2MC44MDdMMjEuMjkzLDI4LjFjMC4zOTEsMC4zOTEsMS4wMjMsMC4zOTEsMS40MTQsMEw0Miw4LjgwN1Y4SDM5Ljk3OXoiIGZpbGw9IiMwMDAwMDAiLz4KICAgICAgPC9nPgogICAgPC9nPgogIDwvZz4KPC9zdmc+Cg==" />
                                            </span> ติดต่อเรา
                                        </a>
                                        <ul>

                                            <li class="<?= PAGE_CONTROLLERS == 'contact_message' ? 'actived' : '' ?>"><a
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>contact_message">ข้อความ</a></li>

                                            <li class="<?= PAGE_CONTROLLERS == 'contact' ? 'actived' : '' ?>"><a
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>contact&action=edit&id=1">รายละเอียด</a></li>

                                        </ul>
                                    </li>


                                    <li class="<?= PAGE_CONTROLLERS == 'footer' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDQ3MC41ODYgNDcwLjU4NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDcwLjU4NiA0NzAuNTg2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTMyNy4wODEsMEg5MC4yMzRjLTE1LjksMC0yOC44NTMsMTIuOTU5LTI4Ljg1MywyOC44NTl2NDEyLjg2M2MwLDE1LjkyNCwxMi45NTMsMjguODYzLDI4Ljg1MywyOC44NjNIMzgwLjM1ICAgYzE1LjkxNywwLDI4Ljg1NS0xMi45MzksMjguODU1LTI4Ljg2M1Y4OS4yMzRMMzI3LjA4MSwweiBNMzMzLjg5MSw0My4xODRsMzUuOTk2LDM5LjEyMWgtMzUuOTk2VjQzLjE4NHogTTM4NC45NzIsNDQxLjcyMyAgIGMwLDIuNTQyLTIuMDgxLDQuNjI5LTQuNjM1LDQuNjI5SDkwLjIzNGMtMi41NDcsMC00LjYxOS0yLjA4Ny00LjYxOS00LjYyOVYyOC44NTljMC0yLjU0OCwyLjA3Mi00LjYxMyw0LjYxOS00LjYxM2gyMTkuNDExdjcwLjE4MSAgIGMwLDYuNjgyLDUuNDQzLDEyLjA5OSwxMi4xMjksMTIuMDk5aDYzLjE5OFY0NDEuNzIzeiBNMTExLjU5MywzNTkuODcxaDIzNi4wNTJ2NDguNDIxSDExMS41OTNWMzU5Ljg3MXoiIGZpbGw9IiMwMDAwMDAiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                            </span> Footer
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'footer' ? 'actived' : '' ?>"><a
                                                    href="<?php echo ADDRESS_ADMIN_CONTROL ?>footer&action=edit&id=1">รายละเอียด</a></li>


                                        </ul>
                                    </li>



                                </ul>

                            <?php } else { ?>
                                <ul>


                                    

                                    <li class="<?= PAGE_CONTROLLERS == 'member_customer' ? 'active' : ''?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon">
                                                <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDMxLjkzOSAzMS45MzkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMxLjkzOSAzMS45Mzk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNMTUuNTgsMTguMzMyaC0wLjc3N2MtMC40MDMsMC0wLjczLTAuMzI2LTAuNzMtMC43MjljMC0wLjE0OSwwLjA2LTAuMjkzLDAuMTY3LTAuMzk3YzAuNDUyLTAuNDM5LDAuODMyLTEuMDMsMS4xMDctMS42NjcgICAgYzAuMDU2LDAuMDQxLDAuMTE2LDAuMDcxLDAuMTg0LDAuMDcxYzAuNDM2LDAsMC45NS0wLjk2NCwwLjk1LTEuNjIxYzAtMC42NTctMC4wNjEtMS4xOS0wLjQ5OC0xLjE5ICAgIGMtMC4wNTIsMC0wLjEwNiwwLjAwOS0wLjE2MiwwLjAyM2MtMC4wMzEtMS43ODItMC40ODEtNC4wMDUtMy4yMDItNC4wMDVjLTIuODM5LDAtMy4xNywyLjIxOS0zLjIwMiwzLjk5OSAgICBjLTAuMDQtMC4wMDgtMC4wOC0wLjAxNy0wLjExNy0wLjAxN2MtMC40MzcsMC0wLjQ5NywwLjUzMy0wLjQ5NywxLjE5YzAsMC42NTcsMC41MTIsMS42MjEsMC45NDksMS42MjEgICAgYzAuMDU0LDAsMC4xMDQtMC4wMTUsMC4xNTEtMC4wNDJjMC4yNzQsMC42MjcsMC42NDksMS4yMDYsMS4wOTQsMS42NDFjMC4xMDcsMC4xMDQsMC4xNjcsMC4yNDYsMC4xNjcsMC4zOTYgICAgYzAsMC40MDMtMC4zMjcsMC43My0wLjczLDAuNzNIOS42NTZjLTEuNjYyLDAtMy4wMDksMS4zNDctMy4wMDksMy4wMDl2MC44MzRjMCwwLjUyNCwwLjQyNSwwLjk1LDAuOTUsMC45NWgxMC4wNDIgICAgYzAuNTI0LDAsMC45NDktMC40MjYsMC45NDktMC45NXYtMC44MzRDMTguNTg5LDE5LjY4LDE3LjI0MiwxOC4zMzIsMTUuNTgsMTguMzMyeiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yNC41ODksMTAuMDc3aC04LjQyMWMwLjI0MywwLjUzOCwwLjQxNywxLjIsMC40ODksMi4wMTljMC4xOCwwLjExMSwwLjMxNSwwLjI5LDAuNDI1LDAuNTA2aDcuNTA3ICAgIGMwLjM5LDAsMC43MDQtMC4zMTUsMC43MDQtMC43MDR2LTEuMTE3QzI1LjI5MywxMC4zOTMsMjQuOTc5LDEwLjA3NywyNC41ODksMTAuMDc3eiIgZmlsbD0iIzAwMDAwMCIvPgoJCTxwYXRoIGQ9Ik0yNC41ODksMTQuNjc4aC03LjMzNWMtMC4xOTksMC43NTItMC42ODksMS41MzktMS4zNjgsMS43NDljLTAuMDIsMC4wMzctMC4wNDMsMC4wNjktMC4wNjQsMC4xMDZ2MC42N2g4Ljc2NiAgICBjMC4zODksMCwwLjcwNC0wLjMxNSwwLjcwNC0wLjcwNXYtMS4xMTZDMjUuMjkzLDE0Ljk5MywyNC45NzksMTQuNjc4LDI0LjU4OSwxNC42Nzh6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPHBhdGggZD0iTTI0LjU4OSwxOS4yNzloLTUuNzI2YzAuMzc4LDAuNTk4LDAuNiwxLjMwMywwLjYsMi4wNjJ2MC40NjNoNS4xMjZjMC4zOSwwLDAuNzA0LTAuMzE1LDAuNzA0LTAuNzA0di0xLjExNyAgICBDMjUuMjkzLDE5LjU5NCwyNC45NzksMTkuMjc5LDI0LjU4OSwxOS4yNzl6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPHBhdGggZD0iTTI3LjYxNSwzLjA1N0g0LjMyNUMxLjkzNiwzLjA1NywwLDQuOTkzLDAsNy4zODJ2MTcuMTc2YzAsMi4zOSwxLjkzNiw0LjMyNSw0LjMyNSw0LjMyNWgyMy4yOSAgICBjMi4zODksMCw0LjMyNC0xLjkzNiw0LjMyNC00LjMyNVY3LjM4MkMzMS45MzksNC45OTMsMzAuMDA0LDMuMDU3LDI3LjYxNSwzLjA1N3ogTTI5Ljg5OCwyNC41NThjMCwxLjI1OS0xLjAyNCwyLjI4My0yLjI4MywyLjI4MyAgICBINC4zMjVjLTEuMjU5LDAtMi4yODMtMS4wMjQtMi4yODMtMi4yODNWNy4zODJjMC0xLjI1OSwxLjAyNC0yLjI4MywyLjI4My0yLjI4M2gyMy4yOWMxLjI1OSwwLDIuMjgzLDEuMDI0LDIuMjgzLDIuMjgzVjI0LjU1OHoiIGZpbGw9IiMwMDAwMDAiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                            </span> ข้อมูลส่วนตัว
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'member_customer' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>member_customer">แก้ไขข้อมูล</a></li> 

                                        </ul>
                                    </li>
                                     <li class="<?= PAGE_CONTROLLERS == 'member_ordered' ? 'active' : ''?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon">
                                                <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ4My42ODggNDgzLjY4OCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDgzLjY4OCA0ODMuNjg4OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxnPgoJPHBhdGggZD0iTTQ3My42LDkyLjQzYy04LjctMTAuNi0yMS45LTE2LjUtMzUuNi0xNi41SDE0MC43Yy04LjUsMC0xNi42LDIuNC0yMy42LDYuN2wtMTUuMi01My4xYy0yLjUtOC43LTEwLjQtMTQuNy0xOS40LTE0LjdINTkuNCAgIEgxNS4zYy04LjQsMC0xNS4zLDYuOC0xNS4zLDE1LjN2MS42YzAsOC40LDYuOCwxNS4zLDE1LjMsMTUuM2g1Ny44bDI5LjUsMTA0LjNsNDAuNiwxNDMuOWMtMjMuMSw1LjgtNDAuMiwyNi43LTQwLjIsNTEuNSAgIGMwLDI4LjEsMjEuOSw1MS4yLDQ5LjYsNTNjLTIuMyw2LjYtMy40LDEzLjktMi44LDIxLjRjMiwyNS40LDIyLjcsNDUuOSw0OC4xLDQ3LjZjMzAuMywyLjEsNTUuNi0yMiw1NS42LTUxLjhjMC02LTEtMTEuNy0yLjktMTcuMSAgIGg2MC44Yy0yLjUsNy4xLTMuNSwxNS0yLjYsMjMuMWMyLjgsMjQuNiwyMy4xLDQ0LDQ3LjksNDUuOGMzMC4zLDIuMSw1NS43LTIxLjksNTUuNy01MS44YzAtMjguOS0yNC01Mi01Mi44LTUySDE1Ni41ICAgYy05LjksMC0xOC4zLTcuNy0xOC43LTE3LjVjLTAuNC0xMC40LDcuOS0xOC45LDE4LjItMTguOWgzMC41aDE2NS4zaDQ2LjVjMjAuNiwwLDM4LjYtMTQuMSw0My42LTM0LjFsNDAuNC0xNjIuNiAgIEM0ODUuOCwxMTcuODMsNDgyLjYsMTAzLjUzLDQ3My42LDkyLjQzeiBNMzYwLjUsMzk5LjczYzkuNCwwLDE3LjEsNy43LDE3LjEsMTcuMXMtNy43LDE3LjEtMTcuMSwxNy4xcy0xNy4xLTcuNy0xNy4xLTE3LjEgICBTMzUxLDM5OS43MywzNjAuNSwzOTkuNzN6IE0yMDEuNiwzOTkuNzNjOS40LDAsMTcuMSw3LjcsMTcuMSwxNy4xcy03LjcsMTcuMS0xNy4xLDE3LjFjLTkuNCwwLTE3LjEtNy43LTE3LjEtMTcuMSAgIEMxODQuNSw0MDcuNDMsMTkyLjEsMzk5LjczLDIwMS42LDM5OS43M3ogTTEzOC44LDE1MS4xM2wtNy44LTI3LjVjLTEuMi00LjIsMC41LTcuMywxLjctOC44YzEuMS0xLjUsMy43LTQsOC00aDMyLjZsOC45LDQwLjQgICBoLTQzLjRWMTUxLjEzeiBNMTQ4LjYsMTg1LjkzaDQxLjJsOC4yLDM3LjRoLTM4LjlMMTQ4LjYsMTg1LjkzeiBNMTg2LjUsMjkzLjUzYy00LjUsMC04LjUtMy05LjctNy40bC03LjktMjhoMzYuN2w3LjgsMzUuM2gtMjYuOSAgIFYyOTMuNTN6IE0yNzMuNiwyOTMuNTNIMjQ5bC03LjgtMzUuM2gzMi4zdjM1LjNIMjczLjZ6IE0yNzMuNiwyMjMuMzNoLTQwbC04LjItMzcuNGg0OC4yVjIyMy4zM3ogTTI3My42LDE1MS4xM2gtNTUuOGwtOC45LTQwLjQgICBoNjQuN1YxNTEuMTN6IE0zMzYsMjkzLjUzaC0yNy41di0zNS4zaDM0LjlMMzM2LDI5My41M3ogTTM1MC44LDIyMy4zM2gtNDIuM3YtMzcuNGg1MC4yTDM1MC44LDIyMy4zM3ogTTMwOC41LDE1MS4xM3YtNDAuNGg2NiAgIGwtOC41LDQwLjRIMzA4LjV6IE00MDguMiwyODUuOTNjLTEuMSw0LjUtNS4xLDcuNy05LjgsNy43aC0yNi44bDcuNS0zNS4zaDM2TDQwOC4yLDI4NS45M3ogTTQyMy43LDIyMy4zM2gtMzcuM2w3LjktMzcuNEg0MzMgICBMNDIzLjcsMjIzLjMzeiBNNDQ4LjUsMTIzLjIzbC02LjksMjcuOGgtNDBsOC41LTQwLjRoMjguNmM0LjMsMCw2LjgsMi40LDcuOSwzLjlDNDQ3LjgsMTE2LjAzLDQ0OS42LDExOS4xMyw0NDguNSwxMjMuMjN6IiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                                            </span> ประวัติการสั่งซื้อ
                                        </a>
                                        <ul>
                                            <li class="<?= PAGE_CONTROLLERS == 'member_ordered' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>member_ordered">การสั่งซื้อ</a></li> 

                                        </ul>
                                    </li>
                                    <li class="<?= PAGE_CONTROLLERS == 'member_transfer_money_history' ? 'active' : '' ?>"><a href="#"> <!-- Icon Container --> <span
                                                class="da-nav-icon"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ5MCA0OTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQ5MCA0OTA7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMzJweCIgaGVpZ2h0PSIzMnB4Ij4KPGc+Cgk8Zz4KCQk8Zz4KCQkJPHBhdGggZD0iTTQ2NS42LDM5MC40Yy0yMy4yLTguOC0zNy0xNy45LTM3LTE3LjlsLTE3LjgsNTYuNGwtMi40LDcuN2wtOC0yMi42YzE4LjQtMjUuNi0xLjQtMjYuOC00LjgtMjYuOWwwLDBjMCwwLDAsMC0wLjEsMCAgICAgYzAsMCwwLDAtMC4xLDBjMCwwLDAsMC0wLjEsMGMwLDAsMCwwLTAuMSwwbDAsMGMtMy40LDAtMjMuMiwxLjItNC44LDI2LjlsLTgsMjIuNmwtMi40LTcuN2wtMTcuOC01Ni40YzAsMC03LjgsNS4xLTIxLjUsMTEuNCAgICAgYy0zLjQtMi42LTcuNC00LjctMTIuMy02LjVjLTI3LjUtMTAuNS00My45LTIxLjItNDMuOS0yMS4ybC0yMS4yLDY3bC0yLjksOS4xbC05LjUtMjYuOWMyMS44LTMwLjQtMS43LTMxLjktNS43LTMxLjlsMCwwICAgICBjMCwwLDAsMC0wLjEsMGMwLDAsMCwwLTAuMSwwYzAsMCwwLDAtMC4xLDBjMCwwLDAsMC0wLjEsMGwwLDBjLTQuMSwwLTI3LjUsMS41LTUuNywzMS45bC05LjUsMjYuOWwtMi45LTkuMWwtMjEuMi02NyAgICAgYzAsMC0xNi41LDEwLjctNDMuOSwyMS4yYy00LjksMS44LTksMy45LTEyLjMsNi41Yy0xMy43LTYuMy0yMS41LTExLjQtMjEuNS0xMS40TDExMCw0MjguOWwtMi40LDcuN2wtOC0yMi42ICAgICBjMTguNC0yNS42LTEuNC0yNi44LTQuOC0yNi45bDAsMGMwLDAsMCwwLTAuMSwwYzAsMCwwLDAtMC4xLDBjMCwwLDAsMC0wLjEsMGMwLDAsMCwwLTAuMSwwbDAsMGMtMy40LDAtMjMuMiwxLjItNC44LDI2LjkgICAgIGwtOCwyMi42bC0yLjQtNy43bC0xNy44LTU2LjRjMCwwLTEzLjksOS0zNywxNy45Qy0xLjEsMzk5LjcsMC41LDQyMC43LDAsNDYwaDk0LjVoMC4yaDM3LjloNTYuNmg1NS42aDAuM2g1NS42aDU2LjZoMzcuOWgwLjIgICAgIEg0OTBDNDg5LjUsNDIwLjcsNDkxLjEsMzk5LjcsNDY1LjYsMzkwLjR6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPC9nPgoJCTxnPgoJCQk8cGF0aCBkPSJNMTk3LjEsMzEzLjNjMi40LDE1LjcsMTQuNiwzNS44LDM0LjUsNDIuOGM4LjIsMi45LDE3LjIsMi45LDI1LjMtMC4xYzE5LjYtNy4xLDMyLjItMjcsMzQuNi00Mi43ICAgICBjMi42LTAuMiw2LjEtMy45LDkuOS0xNy4yYzUuMS0xOC4xLTAuMy0yMC44LTQuOS0yMC40YzAuOS0yLjUsMS41LTUsMi03LjRjNy44LTQ2LjktMTUuMy00OC41LTE1LjMtNDguNXMtMy44LTcuNC0xMy45LTEyLjkgICAgIGMtNi44LTQtMTYuMi03LjEtMjguNi02Yy00LDAuMi03LjgsMS0xMS40LDIuMmwwLDBjLTQuNiwxLjUtOC43LDMuOC0xMi41LDYuNGMtNC42LDIuOS05LDYuNS0xMi45LDEwLjYgICAgIGMtNi4xLDYuMi0xMS42LDE0LjMtMTMuOSwyNC40Yy0yLDcuNS0xLjUsMTUuNCwwLjEsMjMuOGwwLDBjMC40LDIuNSwxLjEsNSwyLDcuNGMtNC42LTAuNC0xMCwyLjItNC45LDIwLjQgICAgIEMxOTEsMzA5LjQsMTk0LjUsMzEzLjEsMTk3LjEsMzEzLjN6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPC9nPgoJCTxnPgoJCQk8cGF0aCBkPSJNMzQ3LjEsMzIyLjVjMy4yLDExLjIsNi4xLDE0LjQsOC40LDE0LjVjMi4xLDEzLjMsMTIuMywzMC4zLDI5LjIsMzYuMmM2LjksMi40LDE0LjUsMi40LDIxLjUsMCAgICAgYzE2LjYtNiwyNy4zLTIyLjksMjkuMy0zNi4yYzIuMi0wLjIsNS4yLTMuMyw4LjQtMTQuNWM0LjMtMTUuMy0wLjMtMTcuNi00LjItMTcuMmMwLjgtMi4xLDEuMy00LjIsMS43LTYuMyAgICAgYzYuNi0zOS43LTEyLjktNDEuMS0xMi45LTQxLjFzLTMuMi02LjItMTEuOC0xMC45Yy01LjctMy40LTEzLjctNi0yNC4yLTUuMWMtMy40LDAuMi02LjYsMC44LTkuNiwxLjhsMCwwICAgICBjLTMuOSwxLjMtNy40LDMuMi0xMC42LDUuNGMtMy45LDIuNS03LjYsNS41LTEwLjksOWMtNS4yLDUuMy05LjgsMTIuMS0xMS44LDIwLjdjLTEuNyw2LjQtMS4zLDEzLDAuMSwyMC4ybDAsMCAgICAgYzAuNCwyLjEsMC45LDQuMiwxLjcsNi4zQzM0Ny4zLDMwNC45LDM0Mi43LDMwNy4xLDM0Ny4xLDMyMi41eiIgZmlsbD0iIzAwMDAwMCIvPgoJCTwvZz4KCQk8Zz4KCQkJPHBhdGggZD0iTTU0LjYsMzM3YzIuMSwxMy4zLDEyLjMsMzAuMywyOS4yLDM2LjJjNi45LDIuNCwxNC41LDIuNCwyMS41LDBjMTYuNi02LDI3LjMtMjIuOSwyOS4zLTM2LjJjMi4yLTAuMiw1LjItMy4zLDguNC0xNC41ICAgICBjNC4zLTE1LjMtMC4zLTE3LjYtNC4yLTE3LjJjMC44LTIuMSwxLjMtNC4yLDEuNy02LjNjNi42LTM5LjctMTIuOS00MS4xLTEyLjktNDEuMXMtMy4yLTYuMi0xMS44LTEwLjljLTUuNy0zLjQtMTMuNy02LTI0LjItNS4xICAgICBjLTMuNCwwLjItNi42LDAuOC05LjYsMS44bDAsMGMtMy45LDEuMy03LjQsMy4yLTEwLjYsNS40Yy0zLjksMi41LTcuNiw1LjUtMTAuOSw5Yy01LjIsNS4zLTkuOCwxMi4xLTExLjgsMjAuNyAgICAgYy0xLjcsNi40LTEuMywxMywwLjEsMjAuMmwwLDBjMC40LDIuMSwwLjksNC4yLDEuNyw2LjNjLTMuOS0wLjQtOC41LDEuOS00LjIsMTcuMkM0OS40LDMzMy43LDUyLjMsMzM2LjgsNTQuNiwzMzd6IiBmaWxsPSIjMDAwMDAwIi8+CgkJPC9nPgoJCTxnPgoJCQk8Zz4KCQkJCTxwYXRoIGQ9Ik0zMjkuOSwxODMuOGMtMy41LDcuNS05LjUsMTYuOC0xOSwyMS40Yy0zLjEsMS41LTIuNCw2LjIsMSw2LjhjMTAuNCwxLjYsMjUuMy0wLjIsMzkuMS0xMC43bDAuMiwwLjIgICAgICBjMzUuMywyMC43LDgxLjQsMTYsMTExLjctMTQuM2MzNi0zNiwzNi05NC4yLDAtMTMwLjJjLTM1LjgtMzYtOTQuMS0zNi0xMzAsMGMtMzQuNywzNC42LTM1LjksODkuOS0zLjksMTI2TDMyOS45LDE4My44eiAgICAgICBNMzY4LjEsMTU1LjhjMC44LTIuOCwxLjUtNS42LDIuNC04LjRjMS0zLjIsMS45LTMuNiw0LjktMi4xYzUuMSwyLjYsMTAuNSw0LjEsMTYuMSw0LjhjMy42LDAuNSw3LjIsMC4xLDEwLjYtMS40ICAgICAgYzYuMy0yLjcsNy4zLTEwLDItMTQuNGMtMS44LTEuNS0zLjktMi42LTYtMy41Yy01LjUtMi40LTExLjMtNC4zLTE2LjUtNy40Yy04LjQtNS4xLTEzLjgtMTItMTMuMi0yMi4zICAgICAgYzAuNy0xMS42LDcuMy0xOC45LDE3LjktMjIuN2M0LjQtMS42LDQuNC0xLjUsNC40LTYuMWMwLTEuNiwwLTMuMSwwLTQuN2MwLjEtMy41LDAuNy00LjEsNC4xLTQuMmMxLjEsMCwyLjEsMCwzLjIsMCAgICAgIGM3LjMsMCw3LjMsMCw3LjQsNy4zYzAsNS4yLDAsNS4yLDUuMiw2YzQsMC42LDcuNywxLjgsMTEuNCwzLjRjMiwwLjksMi44LDIuMywyLjIsNC40Yy0wLjksMy4yLTEuOCw2LjQtMi44LDkuNSAgICAgIGMtMSwzLTEuOSwzLjQtNC44LDJjLTUuNy0yLjgtMTEuNy0zLjktMTguMS0zLjZjLTEuNywwLjEtMy4zLDAuMy00LjgsMWMtNS41LDIuNC02LjQsOC40LTEuNywxMi4yYzIuNCwxLjksNSwzLjMsNy44LDQuNCAgICAgIGM0LjgsMiw5LjcsMy45LDE0LjMsNi41YzE0LjYsOC4xLDE4LjYsMjYuNSw4LjMsMzljLTMuNyw0LjUtOC42LDcuNi0xNC4yLDkuMWMtMi41LDAuNy0zLjYsMi0zLjUsNC41czAsNSwwLDcuNiAgICAgIGMwLDIuMy0xLjIsMy41LTMuNCwzLjVjLTIuNywwLjEtNS40LDAuMS04LjEsMGMtMi40LDAtMy41LTEuNC0zLjUtMy43YzAtMS44LDAtMy43LTAuMS01LjVjMC00LjEtMC4yLTQuMi00LjEtNC45ICAgICAgYy01LTAuOC05LjktMS45LTE0LjUtNC4yQzM2Ny41LDE2MC41LDM2Ny4xLDE1OS42LDM2OC4xLDE1NS44eiIgZmlsbD0iIzAwMDAwMCIvPgoJCQk8L2c+CgkJPC9nPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" /> 
                                            </span> การถอนเงิน
                                        </a>
                                        <ul>


                                            <li class="<?= PAGE_CONTROLLERS == 'member_transfer_money_history' ? 'actived' : '' ?>"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>member_transfer_money_history">ถอนเงิน / ประวัติการเงิน</a></li> 



                                        </ul>
                                    </li>


                                </ul>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Main Content Wrapper -->
                    <div id="da-content-wrap" class="clearfix">

                        <!-- Content Area -->
                        <div id="da-content-area">
                            <?php
                            if (PAGE_CONTROLLERS == '') {
                                // include ("controllers/slides.php");
                                header("location:" . ADDRESS_ADMIN_CONTROL . 'product');
                            } else {
                                include ("controllers/" . PAGE_CONTROLLERS . ".php");
                            }
                            ?>
                        </div>
                    </div>
<!--                    <script src="assets/js/verify.notify.min.js"></script>-->
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
                    <p>Copyright 2016.</p>
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
        <!-- nortification การแจ้งเตือน -->
<!--        <script src="js/notie.js"></script>-->



    </body>
</html>