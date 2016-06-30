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
                    <script src="<?= ADDRESS ?>js/jquery.min.js"></script>
                    <script src="<?= ADDRESS ?>dist/slippry.min.js"></script>
                    <script src="//use.edgefonts.net/cabin;source-sans-pro:n2,i2,n3,n4,n6,n7,n9.js"></script>
                    <script src="https://use.fontawesome.com/3a8c8598a6.js"></script> 
                    <meta name="viewport" content="width=device-width">
                        <link rel="stylesheet" href="<?= ADDRESS ?>slide.css">
                            <link rel="stylesheet" href="<?= ADDRESS ?>dist/slippry.css">
                             <script src='https://www.google.com/recaptcha/api.js?hl=th'></script> 
                                </head>
                                <body>
                                    <div id="top">
                                        <div id="login-social">
                                            <?php if ($_SESSION['group'] == 'member') { ?>
                                                <div class="top-left" style="margin: 0px; padding: 9px 0 0 0;width: 797px;">
                                                    <section id="box-logged">

                                                        <p class="myfont" style="font-size: 19px;">สวัสดีคุณ, <?= $_SESSION['name'] ?>
                                                            <a href="<?= ADDRESS_ADMIN_CONTROL ?>member_customer"> | <img title="ไปหน้าจัดการ" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDU0OC4xNzIgNTQ4LjE3MiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTQ4LjE3MiA1NDguMTcyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTMzMy4xODYsMzc2LjQzOGMwLTEuOTAyLTAuNjY4LTMuODA2LTEuOTk5LTUuNzA4Yy0xMC42Ni0xMi43NTgtMTkuMjIzLTIzLjcwMi0yNS42OTctMzIuODMyICAgIGMzLjk5Ny03LjgwMyw3LjA0My0xNS4wMzcsOS4xMzEtMjEuNjkzbDQ0LjI1NS02Ljg1MmMxLjcxOC0wLjE5NCwzLjI0MS0xLjE5LDQuNTcyLTIuOTk0YzEuMzMxLTEuODE2LDEuOTkxLTMuNjY4LDEuOTkxLTUuNTcxICAgIHYtNTIuODIyYzAtMi4wOTEtMC42Ni0zLjk0OS0xLjk5MS01LjU2NHMtMi45NS0yLjYxOC00Ljg1My0yLjk5M2wtNDMuNC02LjU2N2MtMi4wOTgtNi40NzMtNS4zMzEtMTQuMjgxLTkuNzA4LTIzLjQxMyAgICBjMi44NTEtNC4xOSw3LjEzOS05LjkwMiwxMi44NS0xNy4xMzFjNS43MDktNy4yMzQsOS43MTMtMTIuMzcxLDExLjk5MS0xNS40MTdjMS4zMzUtMS45MDMsMS45OTktMy43MTMsMS45OTktNS40MjQgICAgYzAtNS4xNC0xMy43MDYtMjAuMzY3LTQxLjEwNy00NS42ODNjLTEuOTAyLTEuNTItMy45MDEtMi4yODEtNi4wMDItMi4yODFjLTIuMjc5LDAtNC4xODIsMC42NTktNS43MTIsMS45OTdMMjQ1LjgxNSwxNTAuOSAgICBjLTcuODAxLTMuOTk2LTE0LjkzOS02Ljk0NS0yMS40MTEtOC44NTRsLTYuNTY3LTQzLjY4Yy0wLjE4Ny0xLjkwMy0xLjE0LTMuNTcxLTIuODUzLTQuOTk3Yy0xLjcxNC0xLjQyNy0zLjYxNy0yLjE0Mi01LjcxMy0yLjE0MiAgICBoLTUzLjFjLTQuMzc3LDAtNy4yMzIsMi4yODQtOC41NjQsNi44NTFjLTIuMjg2LDguNzU3LTQuNDczLDIzLjQxNi02LjU2Nyw0My45NjhjLTguMTgzLDIuNjY0LTE1LjUxMSw1LjcxLTIxLjk4Miw5LjEzNiAgICBsLTMyLjgzMi0yNS42OTNjLTEuOTAzLTEuMzM1LTMuOTAxLTEuOTk3LTUuOTk2LTEuOTk3Yy0zLjYyMSwwLTExLjEzOCw1LjYxNC0yMi41NTcsMTYuODQ2ICAgIGMtMTEuNDIxLDExLjIyOC0xOS4yMjksMTkuNjk4LTIzLjQxMywyNS40MDljLTEuMzM0LDEuNTI1LTEuOTk3LDMuNDI4LTEuOTk3LDUuNzEyYzAsMS43MTEsMC42NjIsMy42MTQsMS45OTcsNS43MDggICAgYzEwLjY1NywxMi43NTYsMTkuMjIxLDIzLjcsMjUuNjk0LDMyLjgzMmMtMy45OTYsNy44MDgtNy4wNCwxNS4wMzctOS4xMzIsMjEuNjk4bC00NC4yNTUsNi44NDggICAgYy0xLjcxNSwwLjE5LTMuMjM2LDEuMTg4LTQuNTcsMi45OTNDMC42NjYsMjQzLjM1LDAsMjQ1LjIwMywwLDI0Ny4xMDV2NTIuODE5YzAsMi4wOTUsMC42NjYsMy45NDksMS45OTcsNS41NjQgICAgYzEuMzM0LDEuNjIyLDIuOTUsMi41MjUsNC44NTcsMi43MTRsNDMuMzk2LDYuODUyYzIuMjg0LDcuMjMsNS42MTgsMTUuMDM3LDkuOTk1LDIzLjQxMWMtMy4wNDYsNC4xOTEtNy41MTcsOS45OTktMTMuNDE4LDE3LjQxOCAgICBjLTUuOTA1LDcuNDI3LTkuODA1LDEyLjQ3MS0xMS43MDcsMTUuMTMzYy0xLjMzMiwxLjkwMy0xLjk5OSwzLjcxNy0xLjk5OSw1LjQyMWMwLDUuMTQ3LDEzLjcwNiwyMC4zNjksNDEuMTE0LDQ1LjY4NyAgICBjMS45MDMsMS41MTksMy44OTksMi4yNzUsNS45OTYsMi4yNzVjMi40NzQsMCw0LjM3Ny0wLjY2LDUuNzA4LTEuOTk1bDMzLjY4OS0yNS40MDZjNy44MDEsMy45OTcsMTQuOTM5LDYuOTQzLDIxLjQxMyw4Ljg0NyAgICBsNi41NjcsNDMuNjg0YzAuMTg4LDEuOTAyLDEuMTQyLDMuNTcyLDIuODUzLDQuOTk2YzEuNzEzLDEuNDI3LDMuNjE2LDIuMTM5LDUuNzExLDIuMTM5aDUzLjFjNC4zOCwwLDcuMjMzLTIuMjgyLDguNTY2LTYuODUxICAgIGMyLjI4NC04Ljk0OSw0LjQ3MS0yMy42OTgsNi41NjctNDQuMjU2YzcuNjExLTIuMjc1LDE0LjkzOC01LjIzNSwyMS45ODItOC44NDZsMzIuODMzLDI1LjY5MyAgICBjMS45MDMsMS4zMzUsMy45MDEsMS45OTUsNS45OTYsMS45OTVjMy42MTcsMCwxMS4wOTEtNS42NiwyMi40MTUtMTYuOTkxYzExLjMyLTExLjMxNywxOS4xNzUtMTkuODQyLDIzLjU1NS0yNS41NSAgICBDMzMyLjUxOCwzODAuNTMsMzMzLjE4NiwzNzguNzI0LDMzMy4xODYsMzc2LjQzOHogTTIzNC4zOTcsMzI1LjYyNmMtMTQuMjcyLDE0LjI3LTMxLjQ5OSwyMS40MDgtNTEuNjczLDIxLjQwOCAgICBjLTIwLjE3OSwwLTM3LjQwNi03LjEzOS01MS42NzgtMjEuNDA4Yy0xNC4yNzQtMTQuMjc3LTIxLjQxMi0zMS41MDUtMjEuNDEyLTUxLjY4YzAtMjAuMTc0LDcuMTM4LTM3LjQwMSwyMS40MTItNTEuNjc1ICAgIGMxNC4yNzItMTQuMjc1LDMxLjUtMjEuNDExLDUxLjY3OC0yMS40MTFjMjAuMTc0LDAsMzcuNDAxLDcuMTM1LDUxLjY3MywyMS40MTFjMTQuMjc3LDE0LjI3NCwyMS40MTMsMzEuNTAxLDIxLjQxMyw1MS42NzUgICAgQzI1NS44MSwyOTQuMTIxLDI0OC42NzUsMzExLjM0OSwyMzQuMzk3LDMyNS42MjZ6IiBmaWxsPSIjRkZGRkZGIi8+CgkJPHBhdGggZD0iTTUwNS42MjgsMzkxLjI5Yy0yLjQ3MS01LjUxNy01LjMyOS0xMC40NjUtOC41NjItMTQuODQ2YzkuNzA5LTIxLjUxMiwxNC41NTgtMzQuNjQ2LDE0LjU1OC0zOS40MDIgICAgYzAtMC43NTMtMC4zNzMtMS40MjQtMS4xNC0xLjk5NWMtMjIuODQ2LTEzLjMyMi0zNC42NDMtMTkuOTg1LTM1LjQwNS0xOS45ODVsLTEuNzExLDAuNTc0ICAgIGMtNy44MDMsNy44MDctMTYuNTYzLDE4LjQ2My0yNi4yNjYsMzEuOTc3Yy0zLjgwNS0wLjM3OS02LjY1Ni0wLjU3NC04LjU1OS0wLjU3NGMtMS45MDksMC00Ljc2LDAuMTk1LTguNTY5LDAuNTc0ICAgIGMtMi42NTUtNC03LjYxLTEwLjQyNy0xNC44NDItMTkuMjczYy03LjIzLTguODQ2LTExLjYxMS0xMy4yNzctMTMuMTM0LTEzLjI3N2MtMC4zOCwwLTMuMjM0LDEuNTIyLTguNTY2LDQuNTc1ICAgIGMtNS4zMjgsMy4wNDYtMTAuOTQzLDYuMjc2LTE2Ljg0NCw5LjcwOWMtNS45MDYsMy40MzMtOS4yMjksNS4zMjgtOS45OTIsNS43MTFjLTAuNzY3LDAuNTY4LTEuMTQ0LDEuMjM5LTEuMTQ0LDEuOTkyICAgIGMwLDQuNzY0LDQuODUzLDE3Ljg4OCwxNC41NTksMzkuNDAyYy0zLjIzLDQuMzgxLTYuMDg5LDkuMzI5LTguNTYyLDE0Ljg0MmMtMjguMzYzLDIuODUxLTQyLjU0NCw1LjgwNS00Mi41NDQsOC44NXYzOS45NjggICAgYzAsMy4wNDYsMTQuMTgxLDUuOTk2LDQyLjU0NCw4Ljg1YzIuMjc5LDUuMTQxLDUuMTM3LDEwLjA4OSw4LjU2MiwxNC44MzljLTkuNzA2LDIxLjUxMi0xNC41NTksMzQuNjQ2LTE0LjU1OSwzOS40MDIgICAgYzAsMC43NiwwLjM3NywxLjQzMSwxLjE0NCwxLjk5OWMyMy4yMTYsMTMuNTE0LDM1LjAyMiwyMC4yNywzNS40MDIsMjAuMjdjMS41MjIsMCw1LjkwMy00LjQ3MywxMy4xMzQtMTMuNDE5ICAgIGM3LjIzMS04Ljk0OCwxMi4xOC0xNS40MTMsMTQuODQyLTE5LjQxYzMuODA2LDAuMzczLDYuNjYsMC41NjQsOC41NjksMC41NjRjMS45MDIsMCw0Ljc1NC0wLjE5MSw4LjU1OS0wLjU2NCAgICBjMi42NTksMy45OTcsNy42MTEsMTAuNDYyLDE0Ljg0MiwxOS40MWM3LjIzMSw4Ljk0NiwxMS42MDgsMTMuNDE5LDEzLjEzNSwxMy40MTljMC4zOCwwLDEyLjE4Ny02Ljc1OSwzNS40MDUtMjAuMjcgICAgYzAuNzY3LTAuNTY4LDEuMTQtMS4yMzUsMS4xNC0xLjk5OWMwLTQuNzU3LTQuODU1LTE3Ljg5MS0xNC41NTgtMzkuNDAyYzMuNDI2LTQuNzUsNi4yNzktOS42OTgsOC41NjItMTQuODM5ICAgIGMyOC4zNjItMi44NTQsNDIuNTQ0LTUuODA0LDQyLjU0NC04Ljg1di0zOS45NjhDNTQ4LjE3MiwzOTcuMDk4LDUzMy45OSwzOTQuMTQ0LDUwNS42MjgsMzkxLjI5eiBNNDY0LjM3LDQ0NS45NjIgICAgYy03LjEyOCw3LjEzOS0xNS43NDUsMTAuNzE1LTI1LjgzNCwxMC43MTVjLTEwLjA5MiwwLTE4LjcwNS0zLjU3Ni0yNS44MzctMTAuNzE1Yy03LjEzOS03LjEzOS0xMC43MTItMTUuNzQ4LTEwLjcxMi0yNS44MzcgICAgYzAtOS44OTQsMy42MjEtMTguNDY2LDEwLjg1NS0yNS42OTNjNy4yMy03LjIzMSwxNS43OTctMTAuODQ5LDI1LjY5My0xMC44NDljOS44OTQsMCwxOC40NjYsMy42MTQsMjUuNywxMC44NDkgICAgYzcuMjI4LDcuMjI4LDEwLjg0OSwxNS44LDEwLjg0OSwyNS42OTNDNDc1LjA3OCw0MzAuMjE0LDQ3MS41MTIsNDM4LjgyMyw0NjQuMzcsNDQ1Ljk2MnoiIGZpbGw9IiNGRkZGRkYiLz4KCQk8cGF0aCBkPSJNNTA1LjYyOCw5OC45MzFjLTIuNDcxLTUuNTItNS4zMjktMTAuNDY4LTguNTYyLTE0Ljg0OWM5LjcwOS0yMS41MDUsMTQuNTU4LTM0LjYzOSwxNC41NTgtMzkuMzk3ICAgIGMwLTAuNzU4LTAuMzczLTEuNDI3LTEuMTQtMS45OTljLTIyLjg0Ni0xMy4zMjMtMzQuNjQzLTE5Ljk4NC0zNS40MDUtMTkuOTg0bC0xLjcxMSwwLjU3ICAgIGMtNy44MDMsNy44MDgtMTYuNTYzLDE4LjQ2NC0yNi4yNjYsMzEuOTc3Yy0zLjgwNS0wLjM3OC02LjY1Ni0wLjU3LTguNTU5LTAuNTdjLTEuOTA5LDAtNC43NiwwLjE5Mi04LjU2OSwwLjU3ICAgIGMtMi42NTUtMy45OTctNy42MS0xMC40Mi0xNC44NDItMTkuMjdjLTcuMjMtOC44NTItMTEuNjExLTEzLjI3Ni0xMy4xMzQtMTMuMjc2Yy0wLjM4LDAtMy4yMzQsMS41MjEtOC41NjYsNC41NjkgICAgYy01LjMyOCwzLjA0OS0xMC45NDMsNi4yODMtMTYuODQ0LDkuNzFjLTUuOTA2LDMuNDI4LTkuMjI5LDUuMzMtOS45OTIsNS43MDhjLTAuNzY3LDAuNTcxLTEuMTQ0LDEuMjM3LTEuMTQ0LDEuOTk5ICAgIGMwLDQuNzU4LDQuODUzLDE3Ljg5MywxNC41NTksMzkuMzk5Yy0zLjIzLDQuMzgtNi4wODksOS4zMjctOC41NjIsMTQuODQ3Yy0yOC4zNjMsMi44NTMtNDIuNTQ0LDUuODAyLTQyLjU0NCw4Ljg0OHYzOS45NzEgICAgYzAsMy4wNDQsMTQuMTgxLDUuOTk2LDQyLjU0NCw4Ljg0OGMyLjI3OSw1LjEzNyw1LjEzNywxMC4wODgsOC41NjIsMTQuODQ3Yy05LjcwNiwyMS41MS0xNC41NTksMzQuNjM5LTE0LjU1OSwzOS4zOTkgICAgYzAsMC43NTcsMC4zNzcsMS40MjYsMS4xNDQsMS45OTdjMjMuMjE2LDEzLjUxMywzNS4wMjIsMjAuMjcsMzUuNDAyLDIwLjI3YzEuNTIyLDAsNS45MDMtNC40NzEsMTMuMTM0LTEzLjQxOCAgICBjNy4yMzEtOC45NDcsMTIuMTgtMTUuNDE1LDE0Ljg0Mi0xOS40MTRjMy44MDYsMC4zNzgsNi42NiwwLjU3MSw4LjU2OSwwLjU3MWMxLjkwMiwwLDQuNzU0LTAuMTkzLDguNTU5LTAuNTcxICAgIGMyLjY1OSwzLjk5OSw3LjYxMSwxMC40NjYsMTQuODQyLDE5LjQxNGM3LjIzMSw4Ljk0NywxMS42MDgsMTMuNDE4LDEzLjEzNSwxMy40MThjMC4zOCwwLDEyLjE4Ny02Ljc1NywzNS40MDUtMjAuMjcgICAgYzAuNzY3LTAuNTcxLDEuMTQtMS4yMzcsMS4xNC0xLjk5N2MwLTQuNzYtNC44NTUtMTcuODg5LTE0LjU1OC0zOS4zOTljMy40MjYtNC43NTksNi4yNzktOS43MDcsOC41NjItMTQuODQ3ICAgIGMyOC4zNjItMi44NTMsNDIuNTQ0LTUuODA0LDQyLjU0NC04Ljg0OHYtMzkuOTcxQzU0OC4xNzIsMTA0LjczNyw1MzMuOTksMTAxLjc4Nyw1MDUuNjI4LDk4LjkzMXogTTQ2NC4zNywxNTMuNjA1ICAgIGMtNy4xMjgsNy4xMzktMTUuNzQ1LDEwLjcwOC0yNS44MzQsMTAuNzA4Yy0xMC4wOTIsMC0xOC43MDUtMy41NjktMjUuODM3LTEwLjcwOGMtNy4xMzktNy4xMzUtMTAuNzEyLTE1Ljc0OS0xMC43MTItMjUuODM3ICAgIGMwLTkuODk3LDMuNjIxLTE4LjQ2NCwxMC44NTUtMjUuNjk3YzcuMjMtNy4yMzMsMTUuNzk3LTEwLjg1LDI1LjY5My0xMC44NWM5Ljg5NCwwLDE4LjQ2NiwzLjYyMSwyNS43LDEwLjg1ICAgIGM3LjIyOCw3LjIzMiwxMC44NDksMTUuOCwxMC44NDksMjUuNjk3QzQ3NS4wNzgsMTM3Ljg1Niw0NzEuNTEyLDE0Ni40Nyw0NjQuMzcsMTUzLjYwNXoiIGZpbGw9IiNGRkZGRkYiLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                                                ไปหน้าจัดการ
                                                            </a>
                                                            <a href="<?= ADDRESS_ADMIN_CONTROL ?>logout"> | 
                                                                <img title="ออกจากระบบ" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUyOS4yODYgNTI5LjI4NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTI5LjI4NiA1MjkuMjg2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxnPgoJPGc+CgkJPGc+CgkJCTxwYXRoIGQ9Ik0zNTguMDk5LDc0LjYwNGMwLDAtMjguMDk3LTEyLjY0NC0yOC4wOTcsMTYuODk2czI3LjgzNyw0OS4zNjMsMjguMTksNDkuM2M0OS4xNDcsMzIuMDgxLDgxLjYyOSw4Ny41NTksODEuNjI5LDE1MC42MjkgICAgIGMwLDk3Ljc0Ni03OC4wMTYsMTc3LjI2OS0xNzUuMTc3LDE3OS43Yy05Ny4xNjEtMi40MzEtMTc1LjE3Ny04MS45NTQtMTc1LjE3Ny0xNzkuN2MwLTYzLjA3MSwzMi40ODMtMTE4LjU0Nyw4MS42MjktMTUwLjYyOSAgICAgYzAuMzUzLDAuMDYzLDI4LjE4OS0xOS43NjEsMjguMTg5LTQ5LjNzLTI4LjA5Ny0xNi44OTYtMjguMDk3LTE2Ljg5NkM4OC43LDExMS45NTgsMzEuMzEsMTk0Ljk4MywzMS4zMSwyOTEuNDI5ICAgICBjMCwxMjkuODY1LDEwNC4wNTMsMjM1LjQxMywyMzMuMzM0LDIzNy44NTdjMTI5LjI4MS0yLjQ0NSwyMzMuMzMyLTEwNy45OTIsMjMzLjMzMi0yMzcuODU3ICAgICBDNDk3Ljk3NywxOTQuOTgzLDQ0MC41ODcsMTExLjk1OCwzNTguMDk5LDc0LjYwNHoiIGZpbGw9IiNGRkZGRkYiLz4KCQkJPHBhdGggZD0iTTI2Ni4yNzgsMGMtMjYuMTQzLDAtMzQuMzEyLDE5LjE0MS0zNC4zMTIsMjYuNjI3djExNy4xNTl2MTE3LjE1OWMwLDcuNDg3LDguMTcsMjYuNjI3LDM0LjMxMiwyNi42MjcgICAgIGMyNi4xNDMsMCwzMS4wNDUtMTkuMTQxLDMxLjA0NS0yNi42MjdWMTQzLjc4NlYyNi42MjdDMjk3LjMyMiwxOS4xNCwyOTIuNDIxLDAsMjY2LjI3OCwweiIgZmlsbD0iI0ZGRkZGRiIvPgoJCTwvZz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KCTxnPgoJPC9nPgoJPGc+Cgk8L2c+Cgk8Zz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" width="16" height="16">
                                                                    ออกจากระบบ
                                                            </a>
                                                        </p>

                                                    </section>
                                                </div>
                                            <?php } else { ?>
                                                <div class="top-left">
                                                    <section id="box-login">
                                                        <form method="post" action="<?= ADDRESS ?>admin/login.php" name="" id="frm_login" class="form-send-msg">
                                                            <input type="hidden" name="group" value="<?= $functions->encode_login('member') ?>">
                                                                <span><input type="text" name="username" placeholder="username" class="form-control" required  style="width: 170px;display: inherit;height: 31px;"/></span> 
                                                                <span><input type="password" name="password" placeholder="password" class="form-control" required style="width: 170px;display: inherit;height: 31px;"/></span> 
                                                                <input id="submit_bt" name="submit_bt" type="submit" value="เข้าสู่ระบบ"  class="btn btn-default btn-sm" style="width: 80px;margin-bottom: 2px;"/> <span>

                                                                    <a href="<?= ADDRESS ?>register">สมัครสมาชิก</a></span>

                                                        </form>    
                                                    </section>
                                                </div>
                                            <?php } ?>
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
                                    <div  class="u-cart">
                                        <div class="unitShirt">
                                            <div class="product" textstyle="text">
                                                <a href="<?= ADDRESS ?>cart" onclick="">สินค้าในตะกร้า<br>
                                                        <div class="cart_info">
                                                            <span class="cart_quantity"><?= $_SESSION['count_cart'] != '' ? $_SESSION['count_cart'] : '0' ?></span> ชิ้น
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="unitShoe">
                                        </div>
                                    </div>
                                   

                                    <script src="http://malsup.github.io/jquery.form.js"></script>
                                    <script src="http://malsup.github.io/jquery.blockUI.js"></script>
                                    <script type="text/javascript" src="<?= ADDRESS ?>plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
                                    <script type="text/javascript" src="<?= ADDRESS ?>plugins/noty/themes/default.js"></script>
                                    <link href="<?= ADDRESS ?>custom_style.css" rel="stylesheet" type="text/css" />


                                    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
                                          rel="stylesheet" type="text/css" />
                                    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
                                    <script>
//                                                //  alert('The form ' + $form.attr('id') + ' is valid!');
//                                                var options = {
//                                                    target: '#', // target element(s) to be updated with server response 
//                                                    //  dataType:  'json',  
//                                                    beforeSubmit: showRequest, // pre-submit callback 
//                                                    success: showResponse, // post-submit callback 
//                                                    dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
//                                                    // clearForm: true,
//                                                    //  resetForm: true ,
//                                                    // other available options: 
//                                                    //url:       url         // override for form's 'action' attribute 
//                                                    //type:      type        // 'get' or 'post', override for form's 'method' attribute 
//                                                    // dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
//                                                    //clearForm: true        // clear all form fields after successful submit 
//                                                    //resetForm: true        // reset the form after successful submit 
//                                                    // $.ajax options can be used here too, for example: 
//                                                    //timeout:   3000 
//                                                };
//                                                // pre-submit callback 
//                                                function showRequest(formData, jqForm, options) {
//
//                                                    $.blockUI({message: '<h3> Loading...</h3>'});
//                                                    var queryString = $.param(formData);
//
//                                                    return true;
//                                                }
//// post-submit callback 
//                                                function showResponse(responseText, statusText, xhr, $form) {
//
//                                                    if (responseText.username == 'error' || responseText.user_refer == 'error') {
//                                                        //  alert('username นี้มีผู้ใช้แล้ว');
//                                                        if (responseText.username == 'error') {
//                                                            noty({
//                                                                text: 'username นี้มีผู้ใช้แล้ว',
//                                                                type: 'warning',
//                                                                theme: 'relax', // or 'relax'
//                                                                timeout: 3000,
//                                                            });
//                                                            $('#username').focus();
//                                                        }
//                                                        if (responseText.user_refer == 'error') {
//                                                            noty({
//                                                                text: 'ไม่พบข้อมูล รหัสผู้แนะนำ',
//                                                                type: 'warning',
//                                                                theme: 'relax', // or 'relax'
//                                                                timeout: 3000,
//                                                            });
//                                                            $('#txt_user_refer').focus();
//                                                        }
//                                                    } else {
//                                                        noty({
//                                                            text: 'สมัครสมาชิกสำเร็จ',
//                                                            type: 'success',
//                                                            theme: 'relax', // or 'relax'
//                                                            timeout: 5000,
//                                                        });
//                                                        $('#myForm')[0].reset();
//                                                    }
//                                                    $.unblockUI();
//                                                }
//
//                                                $('#myForm').submit(function () {
//                                                    $(this).ajaxSubmit(options);
//                                                });


<?php if ($_GET['error'] == 'true') { ?>
                                            noty({
                                                layout: 'top',
                                                text: 'ไม่มีชื่อผู้ใช้นี้ กรุณาลองใหม่อีกครั้ง',
                                                type: 'error',
                                                theme: 'relax', // or 'relax'
                                                timeout: 3000,
                                            });

<?php } else if ($_GET['success'] == 'true') { ?>
                                            noty({
                                                layout: 'top',
                                                text: 'ยินดีต้อนรับ คุณ<?= $_SESSION['name'] ?>',
                                                type: 'success',
                                                theme: 'relax', // or 'relax'
                                                timeout: 3000,
                                            });

<?php } ?>
                                    </script>
                                    <style>
                                        #box-logged{
                                            color: #FFF;
                                        }
                                        #box-logged a{
                                            text-decoration: none;
                                        }
                                        #box-logged a:hover{
                                            color: white;
                                            position: relative;


                                        }
                                        #box-logged a:active{
                                            color: white;
                                            position: relative;
                                            top: 1px;

                                        }

                                        #box-logged a:focus{
                                            color: white;
                                        }
                                    </style>

                                </body>
                                </html>