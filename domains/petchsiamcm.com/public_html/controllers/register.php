<?php
if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {

//    $recaptcha_secret = "6LeMxSITAAAAAEPNFj9C3VJifv8yAUH3HDLkgRuW";
//    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
//    $response = json_decode($response, true);

    $captcha = "";
    if (isset($_POST["g-recaptcha-response"]))
        $captcha = $_POST["g-recaptcha-response"];

    if (!$captcha)
    // echo "not ok";
    // handling the captcha and checking if it's ok
        $secret = "6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV";
    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER["REMOTE_ADDR"]), true);

    // if the captcha is cleared with google, send the mail and echo ok.
//    if ($response["success"] != false) {
//        // send the actual mail
//        @mail($email_to, $subject, $finalMsg);
//
//        // the echo goes back to the ajax, so the user can know if everything is ok
//        echo "ok";
//    } else {
//        echo "not ok";
//    }

    if ($response["success"] === true) {

        if ($customer->CountDataDesc("id", "login_email = '" . $_POST['login_email'] . "'") > 0) {
            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    alert('มีผู้ใช้นี้แล้ว ลองใหม่อีกครั้ง');
                });
            </script>


            <?php
        } else {
            $redirect = false;
            $arrData = array();
            $arrData = $functions->replaceQuote($_POST);
            $customer->SetValues($arrData);
            $customer->SetValue('status', 'ใช้งาน');
            $customer->SetValue('login_password', $functions->encode_login($_POST['login_password_encryt']));
            if ($customer->GetPrimary() == '') {
                $customer->SetValue('created_at', DATE_TIME);
                $customer->SetValue('updated_at', DATE_TIME);
                $customer->SetValue('register_date', DATE_TIME);
            } else {
                $customer->SetValue('updated_at', DATE_TIME);
            }
            if ($customer->Save()) {
                echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว')</script>";
                header('location:' . ADDRESS . 'register/success.html');
                die();
            }
        }
    } else {
        echo 'error';
        die();
    }
}
?>



<div class="col-md-12 well">
    <div class="col-md-12">
        <h1 style="margin-top: 0;">
            <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU5IDU5IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1OSA1OTsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6I0VDRjBGMTsiIGQ9Ik0xOC42MTMsNDIuNTUybC03LjkwNyw0LjMxM2MtMC40NjQsMC4yNTMtMC44ODEsMC41NjQtMS4yNjksMC45MDNDMTQuMDQ3LDUxLjY1NSwxOS45OTgsNTQsMjYuNSw1NCAgIGM2LjQ1NCwwLDEyLjM2Ny0yLjMxLDE2Ljk2NC02LjE0NGMtMC40MjQtMC4zNTgtMC44ODQtMC42OC0xLjM5NC0wLjkzNGwtOC40NjctNC4yMzNjLTEuMDk0LTAuNTQ3LTEuNzg1LTEuNjY1LTEuNzg1LTIuODg4di0zLjMyMiAgIGMwLjIzOC0wLjI3MSwwLjUxLTAuNjE5LDAuODAxLTEuMDNjMS4xNTQtMS42MywyLjAyNy0zLjQyMywyLjYzMi01LjMwNGMxLjA4Ni0wLjMzNSwxLjg4Ni0xLjMzOCwxLjg4Ni0yLjUzdi0zLjU0NiAgIGMwLTAuNzgtMC4zNDctMS40NzctMC44ODYtMS45NjV2LTUuMTI2YzAsMCwxLjA1My03Ljk3Ny05Ljc1LTcuOTc3cy05Ljc1LDcuOTc3LTkuNzUsNy45Nzd2NS4xMjYgICBjLTAuNTQsMC40ODgtMC44ODYsMS4xODUtMC44ODYsMS45NjV2My41NDZjMCwwLjkzNCwwLjQ5MSwxLjc1NiwxLjIyNiwyLjIzMWMwLjg4NiwzLjg1NywzLjIwNiw2LjYzMywzLjIwNiw2LjYzM3YzLjI0ICAgQzIwLjI5Niw0MC44OTksMTkuNjUsNDEuOTg2LDE4LjYxMyw0Mi41NTJ6Ii8+Cgk8Zz4KCQk8cGF0aCBzdHlsZT0iZmlsbDojNTU2MDgwOyIgZD0iTTI2Ljk1MywxLjAwNEMxMi4zMiwwLjc1NCwwLjI1NCwxMi40MTQsMC4wMDQsMjcuMDQ3Qy0wLjEzOCwzNS4zNDQsMy41Niw0Mi44MDEsOS40NDgsNDcuNzYgICAgYzAuMzg1LTAuMzM2LDAuNzk4LTAuNjQ0LDEuMjU3LTAuODk0bDcuOTA3LTQuMzEzYzEuMDM3LTAuNTY2LDEuNjgzLTEuNjUzLDEuNjgzLTIuODM1di0zLjI0YzAsMC0yLjMyMS0yLjc3Ni0zLjIwNi02LjYzMyAgICBjLTAuNzM0LTAuNDc1LTEuMjI2LTEuMjk2LTEuMjI2LTIuMjMxdi0zLjU0NmMwLTAuNzgsMC4zNDctMS40NzcsMC44ODYtMS45NjV2LTUuMTI2YzAsMC0xLjA1My03Ljk3Nyw5Ljc1LTcuOTc3ICAgIHM5Ljc1LDcuOTc3LDkuNzUsNy45Nzd2NS4xMjZjMC41NCwwLjQ4OCwwLjg4NiwxLjE4NSwwLjg4NiwxLjk2NXYzLjU0NmMwLDEuMTkyLTAuOCwyLjE5NS0xLjg4NiwyLjUzICAgIGMtMC42MDUsMS44ODEtMS40NzgsMy42NzQtMi42MzIsNS4zMDRjLTAuMjkxLDAuNDExLTAuNTYzLDAuNzU5LTAuODAxLDEuMDNWMzkuOGMwLDEuMjIzLDAuNjkxLDIuMzQyLDEuNzg1LDIuODg4bDguNDY3LDQuMjMzICAgIGMwLjUwOCwwLjI1NCwwLjk2NywwLjU3NSwxLjM5LDAuOTMyYzUuNzEtNC43NjIsOS4zOTktMTEuODgyLDkuNTM2LTE5LjlDNTMuMjQ2LDEzLjMyLDQxLjU4NywxLjI1NCwyNi45NTMsMS4wMDR6Ii8+Cgk8L2c+Cgk8Zz4KCQk8Y2lyY2xlIHN0eWxlPSJmaWxsOiM3MUMzODY7IiBjeD0iNDciIGN5PSI0NiIgcj0iMTIiLz4KCQk8cGF0aCBzdHlsZT0iZmlsbDojRkZGRkZGOyIgZD0iTTUzLDQ1aC01di01YzAtMC41NTItMC40NDgtMS0xLTFzLTEsMC40NDgtMSwxdjVoLTVjLTAuNTUyLDAtMSwwLjQ0OC0xLDFzMC40NDgsMSwxLDFoNXY1ICAgIGMwLDAuNTUyLDAuNDQ4LDEsMSwxczEtMC40NDgsMS0xdi01aDVjMC41NTIsMCwxLTAuNDQ4LDEtMVM1My41NTIsNDUsNTMsNDV6Ii8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg=="  width="32" height="32"/>&nbsp;สมัครสมาชิก
        </h1>
    </div>
    <div class="col-md-12 ">
        <form class="form-horizontal" id="myForm2" enctype="multipart/form-data"  method="POST" 
              action="<?php echo ADDRESS ?>ajax/ajax_register.php">
            <section class="my-panel">
                <h4 class="myfont font-22 text-bold"> ข้อมูลส่วนตัว</h4>

                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ชื่อ <em>*</em></label>
                        <span>
                            <input type="text" class="form-control" id="firstname" name="customer_name" data-validation="required" >
                        </span> 
                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">นามสกุล <em>*</em></label>
                        <span>
                            <input type="text" class="form-control" name="customer_lastname" data-validation="required" >
                        </span> 
                    </div>
                    <div class="col-md-12"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ที่อยู่ <em>*</em></label>
                        <span>
                            <textarea type="text" rows="3" class="form-control" name="customer_address"  data-validation="required"> </textarea>
                        </span> 
                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">เบอร์โทร <em>*</em></label>
                        <span>
                            <input type="text" class="form-control" name="customer_tel"  data-validation="number,required">
                        </span> 
                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">Email <em>*</em></label>
                        <span>
                            <input type="text" name="customer_email" class="form-control" id="email"  data-validation="required,email">
                        </span> 
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">แนบสำเนาบัตรประชาชน <em>*</em></label>

                        <input type="file" class="form-control" name="file_idcard[]" id="" data-validation="required">

                    </div>
                </div>
            </section>
            <section class="my-panel">
                <h4 class="myfont font-22 text-bold"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8Zz4KCTxnPgoJCTxnPgoJCQk8cGF0aCBzdHlsZT0iZmlsbDojNUQ2NDdGOyIgZD0iTTMyLDI5NmgyNDBjMTcuNjczLDAsMzItMTQuMzI3LDMyLTMyVjExMmMwLTE3LjY3My0xNC4zMjctMzItMzItMzJIMzJDMTQuMzI3LDgwLDAsOTQuMzI3LDAsMTEyICAgICBsMCwxNTJDMCwyODEuNjczLDE0LjMyNywyOTYsMzIsMjk2eiIvPgoJCTwvZz4KCQk8Zz4KCQkJPGc+CgkJCQk8cGF0aCBzdHlsZT0iZmlsbDojNUM1NDZBOyIgZD0iTTE2OCwyNjRoOTZjNC40MjIsMCw4LTMuNTgyLDgtOHMtMy41NzgtOC04LThoLTk2Yy00LjQyMiwwLTgsMy41ODItOCw4UzE2My41NzgsMjY0LDE2OCwyNjR6Ii8+CgkJCTwvZz4KCQk8L2c+CgkJPGc+CgkJCTxnPgoJCQkJPHBhdGggc3R5bGU9ImZpbGw6IzVDNTQ2QTsiIGQ9Ik0xNjgsMjMyaDMyYzQuNDIyLDAsOC0zLjU4Miw4LThzLTMuNTc4LTgtOC04aC0zMmMtNC40MjIsMC04LDMuNTgyLTgsOFMxNjMuNTc4LDIzMiwxNjgsMjMyeiIvPgoJCQk8L2c+CgkJPC9nPgoJCTxnPgoJCQk8Zz4KCQkJCTxwYXRoIHN0eWxlPSJmaWxsOiM1QzU0NkE7IiBkPSJNMTA0LDIzMmgzMmM0LjQyMiwwLDgtMy41ODIsOC04cy0zLjU3OC04LTgtOGgtMzJjLTQuNDIyLDAtOCwzLjU4Mi04LDhTOTkuNTc4LDIzMiwxMDQsMjMyeiIvPgoJCQk8L2c+CgkJPC9nPgoJCTxnPgoJCQk8Zz4KCQkJCTxwYXRoIHN0eWxlPSJmaWxsOiM1QzU0NkE7IiBkPSJNMTA0LDI2NGgzMmM0LjQyMiwwLDgtMy41ODIsOC04cy0zLjU3OC04LTgtOGgtMzJjLTQuNDIyLDAtOCwzLjU4Mi04LDhTOTkuNTc4LDI2NCwxMDQsMjY0eiIvPgoJCQk8L2c+CgkJPC9nPgoJCTxnPgoJCQk8Zz4KCQkJCTxwYXRoIHN0eWxlPSJmaWxsOiM1QzU0NkE7IiBkPSJNNDAsMjMyaDMyYzQuNDIyLDAsOC0zLjU4Miw4LThzLTMuNTc4LTgtOC04SDQwYy00LjQyMiwwLTgsMy41ODItOCw4UzM1LjU3OCwyMzIsNDAsMjMyeiIvPgoJCQk8L2c+CgkJPC9nPgoJCTxnPgoJCQk8Zz4KCQkJCTxwYXRoIHN0eWxlPSJmaWxsOiNCOEJBQzA7IiBkPSJNMjY0LDE5Mkg0MGMtNC40MjIsMC04LTMuNTgyLTgtOHMzLjU3OC04LDgtOGgyMjRjNC40MjIsMCw4LDMuNTgyLDgsOFMyNjguNDIyLDE5MiwyNjQsMTkyeiIvPgoJCQk8L2c+CgkJPC9nPgoJCTxnPgoJCQk8cmVjdCB4PSIwIiB5PSIxMTIiIHN0eWxlPSJmaWxsOiM1QzU0NkE7IiB3aWR0aD0iMzA0IiBoZWlnaHQ9IjQwIi8+CgkJPC9nPgoJPC9nPgoJPGc+CgkJPHBhdGggc3R5bGU9ImZpbGw6IzZDNzQ4RDsiIGQ9Ik00ODAsNDMySDI0MGMtMTcuNjczLDAtMzItMTQuMzI3LTMyLTMyVjI0OGMwLTE3LjY3MywxNC4zMjctMzIsMzItMzJoMjQwICAgIGMxNy42NzMsMCwzMiwxNC4zMjcsMzIsMzJ2MTUyQzUxMiw0MTcuNjczLDQ5Ny42NzMsNDMyLDQ4MCw0MzJ6Ii8+Cgk8L2c+Cgk8Zz4KCQk8cGF0aCBzdHlsZT0iZmlsbDojRkY0RjE5OyIgZD0iTTQyNC4wMDIsMzAxLjE2NUM0MTguMTM4LDMwNy44MDksNDA5LjU1OCwzMTIsNDAwLDMxMmMtMTcuNjczLDAtMzItMTQuMzI3LTMyLTMyczE0LjMyNy0zMiwzMi0zMiAgICBjOS41NjEsMCwxOC4xNDMsNC4xOTMsMjQuMDA3LDEwLjg0MiIvPgoJPC9nPgoJPGc+CgkJPHBhdGggc3R5bGU9ImZpbGw6I0ZGRDEwMDsiIGQ9Ik0zMDQsMzEyaC00OGMtOC44MzcsMC0xNi03LjE2My0xNi0xNnYtMzJjMC04LjgzNyw3LjE2My0xNiwxNi0xNmg0OGM4LjgzNywwLDE2LDcuMTYzLDE2LDE2djMyICAgIEMzMjAsMzA0LjgzNywzMTIuODM3LDMxMiwzMDQsMzEyeiIvPgoJPC9nPgoJPGc+CgkJPGc+CgkJCTxwYXRoIHN0eWxlPSJmaWxsOiNCOEJBQzA7IiBkPSJNMjgwLDM2OGgtMzJjLTQuNDIyLDAtOC0zLjU4Mi04LThzMy41NzgtOCw4LThoMzJjNC40MjIsMCw4LDMuNTgyLDgsOFMyODQuNDIyLDM2OCwyODAsMzY4eiIvPgoJCTwvZz4KCTwvZz4KCTxnPgoJCTxnPgoJCQk8cGF0aCBzdHlsZT0iZmlsbDojOEE4ODk1OyIgZD0iTTM0NCw0MDBoLTk2Yy00LjQyMiwwLTgtMy41ODItOC04czMuNTc4LTgsOC04aDk2YzQuNDIyLDAsOCwzLjU4Miw4LDhTMzQ4LjQyMiw0MDAsMzQ0LDQwMHoiLz4KCQk8L2c+Cgk8L2c+Cgk8Zz4KCQk8Zz4KCQkJPHBhdGggc3R5bGU9ImZpbGw6I0I4QkFDMDsiIGQ9Ik0zNDQsMzY4aC0zMmMtNC40MjIsMC04LTMuNTgyLTgtOHMzLjU3OC04LDgtOGgzMmM0LjQyMiwwLDgsMy41ODIsOCw4UzM0OC40MjIsMzY4LDM0NCwzNjh6Ii8+CgkJPC9nPgoJPC9nPgoJPGc+CgkJPGc+CgkJCTxwYXRoIHN0eWxlPSJmaWxsOiNCOEJBQzA7IiBkPSJNNDA4LDM2OGgtMzJjLTQuNDIyLDAtOC0zLjU4Mi04LThzMy41NzgtOCw4LThoMzJjNC40MjIsMCw4LDMuNTgyLDgsOFM0MTIuNDIyLDM2OCw0MDgsMzY4eiIvPgoJCTwvZz4KCTwvZz4KCTxnPgoJCTxnPgoJCQk8cGF0aCBzdHlsZT0iZmlsbDojOEE4ODk1OyIgZD0iTTQwOCw0MDBoLTMyYy00LjQyMiwwLTgtMy41ODItOC04czMuNTc4LTgsOC04aDMyYzQuNDIyLDAsOCwzLjU4Miw4LDhTNDEyLjQyMiw0MDAsNDA4LDQwMHoiLz4KCQk8L2c+Cgk8L2c+Cgk8Zz4KCQk8Zz4KCQkJPHBhdGggc3R5bGU9ImZpbGw6I0I4QkFDMDsiIGQ9Ik00NzIsMzY4aC0zMmMtNC40MjIsMC04LTMuNTgyLTgtOHMzLjU3OC04LDgtOGgzMmM0LjQyMiwwLDgsMy41ODIsOCw4UzQ3Ni40MjIsMzY4LDQ3MiwzNjh6Ii8+CgkJPC9nPgoJPC9nPgoJPGc+CgkJPGNpcmNsZSBzdHlsZT0iZmlsbDojRkZEMTAwOyIgY3g9IjQ0OCIgY3k9IjI4MCIgcj0iMzIiLz4KCTwvZz4KCTxnPgoJCTxwb2x5Z29uIHN0eWxlPSJmaWxsOiNGRjk1MDA7IiBwb2ludHM9IjI4MCwyNzIgMjgwLDI0OCAyNjQsMjQ4IDI2NCwzMTIgMjgwLDMxMiAyODAsMjg4IDMyMCwyODggMzIwLDI3MiAgICIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" width="32" height="32"/> ข้อมูลบัญชีธนาคาร</h4>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ชื่อบัญชี <em>*</em></label>

                        <input type="text" class="form-control" id="" name="bank_name" data-validation="required" >

                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ชื่อธนาคาร <em>*</em></label>


                        <select name="bank_company" class="form-control" data-validation="required" >
                            <option value="">---- เลือก ----</option>
                            <?php
                            $sql = "SELECT * FROM " . $bank_company->getTbl() . " ORDER BY bank_name ";

                            $query = $db->Query($sql);

                            if ($db->NumRows($query) > 0) {
                                ?>
                                <?php while ($row = $db->FetchArray($query)) { ?>
                                    <option value="<?= $row['bank_name'] ?>" <?= $customer->GetValue('bank_company') == $row['bank_name'] ? 'selected' : '' ?>><?= $row['bank_name'] ?></option>

                                <?php } ?>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">เลขที่บัญชี <em>*</em></label>

                        <input type="text" class="form-control" id="" name="bank_number" data-validation="required" >

                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">สาขา <em>*</em></label>

                        <input type="text" class="form-control" id="" name="bank_branch" data-validation="required" >

                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">ประเภทบัญชี <em>*</em></label>


                        <select name="bank_type_account" class="form-control" data-validation="required">
                            <option value="">---- เลือก ----</option>
                            <option value="เงินฝากออมทรัพย์"  <?= $customer->GetValue('bank_type_account') == 'เงินฝากออมทรัพย์' ? 'selected' : '' ?>>เงินฝากออมทรัพย์</option>
                            <option value="เงินฝากประจำ" <?= $customer->GetValue('bank_type_account') == 'เงินฝากประจำ' ? 'selected' : '' ?>>เงินฝากประจำ</option>
                            <option value="เงินฝากกระแสรายวัน" <?= $customer->GetValue('bank_type_account') == 'เงินฝากกระแสรายวัน' ? 'selected' : '' ?>>เงินฝากกระแสรายวัน</option>
                        </select>

                    </div>
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">แนบสำเนาหน้าสมุดบัญชี <em>*</em></label>

                        <input type="file" class="form-control" name="file_bank[]" id="" data-validation="required" >

                    </div>
                </div>
            </section>

            <section class="my-panel">
                <h4 class="myfont font-22 text-bold"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDQ3IDQ3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NyA0NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8Zz4KCTxnIGlkPSJMYXllcl8xXzExMF8iPgoJCTxnPgoJCQk8cGF0aCBkPSJNMTcuNTY3LDE1LjkzOGwtMi44NTktMi43MDJjMC4zMzMtMC42MDUsMC41MzktMS4yOSwwLjUzOS0yLjAyOWMwLTIuMzQyLTEuODk3LTQuMjM5LTQuMjQtNC4yMzkgICAgIGMtMi4zNDMsMC00LjI0MywxLjg5Ni00LjI0Myw0LjIzOWMwLDIuMzQzLDEuOSw0LjI0MSw0LjI0Myw0LjI0MWMwLjgyNiwwLDEuNTktMC4yNDYsMi4yNDItMC42NTRsMi44NTUsMi42OTkgICAgIEMxNi41MzYsMTYuOTIyLDE3LjAyMywxNi4zOTksMTcuNTY3LDE1LjkzOHoiIGZpbGw9IiMwMDAwMDAiLz4KCQkJPHBhdGggZD0iTTI5LjY2LDE1LjZsMy43OTktNi4zOTNjMC4zNzQsMC4xMDcsMC43NjIsMC4xODQsMS4xNjksMC4xODRjMi4zNDcsMCw0LjI0NC0xLjg5OCw0LjI0NC00LjI0MSAgICAgYzAtMi4zNDItMS44OTctNC4yMzktNC4yNDQtNC4yMzljLTIuMzQzLDAtNC4yMzksMS44OTYtNC4yMzksNC4yMzljMCwxLjE2MywwLjQ2OSwyLjIxNCwxLjIyNywyLjk4MWwtMy43ODcsNi4zNzUgICAgIEMyOC40OCwxNC44MDEsMjkuMDk0LDE1LjE2OSwyOS42NiwxNS42eiIgZmlsbD0iIzAwMDAwMCIvPgoJCQk8cGF0aCBkPSJNNDIuNzYyLDIwLjk1MmMtMS44MjQsMC0zLjM2OSwxLjE1OS0zLjk2OCwyLjc3NWwtNS4yNzgtMC41MjFjMCwwLjA0LDAuMDA2LDAuMDc4LDAuMDA2LDAuMTE3ICAgICBjMCwwLjY4OC0wLjA3NiwxLjM2LTAuMjEzLDIuMDA5bDUuMjc2LDAuNTIxYzAuMzE5LDIuMDI0LDIuMDYyLDMuNTc2LDQuMTc3LDMuNTc2YzIuMzQyLDAsNC4yMzgtMS44OTYsNC4yMzgtNC4yMzggICAgIEM0NywyMi44NSw0NS4xMDQsMjAuOTUyLDQyLjc2MiwyMC45NTJ6IiBmaWxsPSIjMDAwMDAwIi8+CgkJCTxwYXRoIGQ9Ik0yOC4xOTcsMzcuNjI0bC0xLjE4LTUuMTU2Yy0wLjY2NiwwLjIzMi0xLjM1OSwwLjM5OC0yLjA4MiwwLjQ4MWwxLjE4Miw1LjE1N2MtMS4zNTUsMC43MDktMi4yOSwyLjExLTIuMjksMy43NDYgICAgIGMwLDIuMzQyLDEuODk2LDQuMjM3LDQuMjQzLDQuMjM3YzIuMzQyLDAsNC4yMzgtMS44OTYsNC4yMzgtNC4yMzdDMzIuMzExLDM5LjU1MywzMC40NzksMzcuNjkyLDI4LjE5NywzNy42MjR6IiBmaWxsPSIjMDAwMDAwIi8+CgkJCTxwYXRoIGQ9Ik0xNC4zNTcsMjUuMzdsLTYuNTcsMi4yMDFjLTAuNzU4LTEuMTU4LTIuMDYzLTEuOTI2LTMuNTQ4LTEuOTI2QzEuODk2LDI1LjY0NSwwLDI3LjU0MiwwLDI5Ljg4NCAgICAgYzAsMi4zNDUsMS44OTYsNC4yNDIsNC4yMzksNC4yNDJjMi4zNDEsMCw0LjI0Mi0xLjg5Nyw0LjI0Mi00LjI0MmMwLTAuMDk4LTAuMDIxLTAuMTg4LTAuMDI5LTAuMjg0bDYuNTkxLTIuMjA3ICAgICBDMTQuNzQ2LDI2Ljc1MiwxNC41MSwyNi4wNzcsMTQuMzU3LDI1LjM3eiIgZmlsbD0iIzAwMDAwMCIvPgoJCQk8Y2lyY2xlIGN4PSIyMy44MyIgY3k9IjIzLjMyMyIgcj0iNy4yNzEiIGZpbGw9IiMwMDAwMDAiLz4KCQk8L2c+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" /> ผู้แนะนำ</h4>
                <div class="row">

                    <div class="col-md-4" style="padding-bottom:10px;">

                        <label for="inputHelpBlock">รหัสผู้แนะนำ <em>*</em></label>

                        <input type="text" placeholder="ถ้าไม่มีให้ว่างไว้" class="form-control" id="txt_user_refer" name="txt_user_refer" data-validation="">

                    </div>
                    <div class="col-md-2"  style="padding-top:17px;">
                        <button type="button" class="btn btn-primary btn-sm" name="" value="" id="check_user_refer"><i class="fa fa-search-minus"></i>&nbsp;ตรวจสอบชื่อ</button>

                    </div>

                </div>
            </section>
            <section class="my-panel">
                <h4 class="myfont font-22 text-bold"><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAzMjAgMzIwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzMjAgMzIwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCI+CjxnIGlkPSJYTUxJRF8xMl8iPgoJPHBhdGggaWQ9IlhNTElEXzEzXyIgZD0iTTE2OS4zOTIsMTk0LjM5NWMtNS44NTgsNS44NTgtNS44NTgsMTUuMzU1LDAsMjEuMjEzYzIuOTI5LDIuOTI5LDYuNzY4LDQuMzk0LDEwLjYwNiw0LjM5NCAgIGMzLjgzOSwwLDcuNjc4LTEuNDY0LDEwLjYwNi00LjM5NGw0NC45OTgtNDQuOTk3YzAuMzUtMC4zNTEsMC42ODMtMC43MTksMC45OTctMS4xMDNjMC4xMzctMC4xNjcsMC4yNTYtMC4zNDQsMC4zODUtMC41MTUgICBjMC4xNjUtMC4yMiwwLjMzNS0wLjQzNSwwLjQ4OC0wLjY2NGMwLjE0LTAuMjA5LDAuMjYxLTAuNDI2LDAuMzg5LTAuNjRjMC4xMjMtMC4yMDYsMC4yNTItMC40MDcsMC4zNjYtMC42MTkgICBjMC4xMTgtMC4yMiwwLjIxNy0wLjQ0NiwwLjMyMy0wLjY3YzAuMTA0LTAuMjE5LDAuMjEzLTAuNDM1LDAuMzA2LTAuNjU5YzAuMDktMC4yMTksMC4xNjMtMC40NDIsMC4yNDMtMC42NjQgICBjMC4wODctMC4yNCwwLjE3OC0wLjQ3NywwLjI1My0wLjcyMmMwLjA2Ny0wLjIyMiwwLjExNi0wLjQ0NywwLjE3Mi0wLjY3MmMwLjA2My0wLjI0OSwwLjEzMy0wLjQ5NywwLjE4NC0wLjc1MSAgIGMwLjA1MS0wLjI1OSwwLjA4Mi0wLjUyMSwwLjExOS0wLjc4MmMwLjAzMi0wLjIyMywwLjA3NS0wLjQ0MywwLjA5Ny0wLjY2OWMwLjA0OC0wLjQ4NCwwLjA3My0wLjk3MSwwLjA3NC0xLjQ1NyAgIGMwLTAuMDA3LDAuMDAxLTAuMDE1LDAuMDAxLTAuMDIyYzAtMC4wMDctMC4wMDEtMC4wMTUtMC4wMDEtMC4wMjJjLTAuMDAxLTAuNDg3LTAuMDI2LTAuOTczLTAuMDc0LTEuNDU4ICAgYy0wLjAyMi0wLjIyMy0wLjA2NC0wLjQ0LTAuMDk1LTAuNjYxYy0wLjAzOC0wLjI2NC0wLjA2OS0wLjUyOC0wLjEyMS0wLjc5Yy0wLjA1LTAuMjUyLTAuMTE5LTAuNDk2LTAuMTgyLTAuNzQzICAgYy0wLjA1Ny0wLjIyNy0wLjEwNy0wLjQ1Ni0wLjE3NS0wLjY4MWMtMC4wNzMtMC4yNDEtMC4xNjQtMC40NzQtMC4yNDktMC43MTFjLTAuMDgxLTAuMjI2LTAuMTU1LTAuNDUzLTAuMjQ3LTAuNjc1ICAgYy0wLjA5MS0wLjIyLTAuMTk5LTAuNDMxLTAuMy0wLjY0NWMtMC4xMDgtMC4yMjktMC4yMS0wLjQ2LTAuMzMtMC42ODVjLTAuMTEtMC4yMDUtMC4yMzUtMC40LTAuMzU0LTAuNTk5ICAgYy0wLjEzMi0wLjIyMS0wLjI1Ni0wLjQ0NC0wLjQtMC42NTljLTAuMTQ2LTAuMjE5LTAuMzA5LTAuNDI0LTAuNDY2LTAuNjM1Yy0wLjEzNi0wLjE4MS0wLjI2Mi0wLjM2OC0wLjQwNy0wLjU0NCAgIGMtMC4yOTktMC4zNjQtMC42MTYtMC43MTMtMC45NDgtMS4wNDhjLTAuMDE2LTAuMDE2LTAuMDI5LTAuMDM0LTAuMDQ1LTAuMDVsLTQ1LTQ1LjAwMWMtNS44NTgtNS44NTgtMTUuMzU1LTUuODU3LTIxLjIxMywwICAgYy01Ljg1OCw1Ljg1OC01Ljg1OCwxNS4zNTUsMCwyMS4yMTNsMTkuMzk0LDE5LjM5NUgxNWMtOC4yODQsMC0xNSw2LjcxNi0xNSwxNWMwLDguMjg0LDYuNzE2LDE1LDE1LDE1aDE3My43ODVMMTY5LjM5MiwxOTQuMzk1eiIgZmlsbD0iIzAwMDAwMCIvPgoJPHBhdGggaWQ9IlhNTElEXzE0XyIgZD0iTTMwNSwyNUgxMTVjLTguMjg0LDAtMTUsNi43MTYtMTUsMTV2NjBjMCw4LjI4NCw2LjcxNiwxNSwxNSwxNXMxNS02LjcxNiwxNS0xNVY1NWgxNjBWMjY1SDEzMHYtNDUuMDAxICAgYzAtOC4yODQtNi43MTYtMTUtMTUtMTVzLTE1LDYuNzE2LTE1LDE1VjI4MGMwLDguMjg0LDYuNzE2LDE1LDE1LDE1aDE5MGM4LjI4NCwwLDE1LTYuNzE2LDE1LTE1VjQwQzMyMCwzMS43MTUsMzEzLjI4NCwyNSwzMDUsMjV6ICAgIiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" /> ข้อมูลเข้าสู่ระบบ</h4>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">Username <em>*</em></label>

                        <input type="text" class="form-control" id="username" name="username" data-validation="required" >

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">Password <em>*</em></label>

                        <input type="password" class="form-control" id="" name="pass_confirmation" data-validation="required,strength" data-validation-strength="2">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"  style="padding-bottom:10px;">

                        <label for="inputHelpBlock">Confirm Password <em>*</em></label>

                        <input type="password" class="form-control" id="" name="pass" data-validation="required,confirmation" >

                    </div>
                </div>
            </section>
            <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
            <div class="g-recaptcha" data-sitekey="6LeMxSITAAAAAHn6FCGQNv47qSaAS3HGl7_tK0eV"></div>


            <p>&nbsp;</p>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="submit_bt" class="btn btn-success" name="submit_bt" value="บันทึกข้อมูล"><i class="fa fa-save"></i>&nbsp;บันทึกข้อมูล</button>

                </div>
            </div> 
            <p>&nbsp;</p>
        </form>
    </div>
</div>
<div id="op"></div>
<div id="bb22"></div>

<script>

// pre-submit callback 
    function showRequest(formData, jqForm, options) {

        $.blockUI({message: '<h3> Loading...</h3>'});
        var queryString = $.param(formData);

        return true;
    }
// post-submit callback 
    function showResponse(responseText, statusText, xhr, $form) {

        if (responseText.username == 'error' || responseText.user_refer == 'error') {
            //  alert('username นี้มีผู้ใช้แล้ว');
            if (responseText.username == 'error') {
                noty({
                    text: 'username นี้มีผู้ใช้แล้ว',
                    type: 'warning',
                    theme: 'relax', // or 'relax'
                    timeout: 3000,
                });
                $('#username').focus();
                //  ScriptManager.RegisterStartupScript(this, this.GetType(), "CaptchaReload", "$.getScript(\"https://www.google.com/recaptcha/api.js\", function () {});", true);
            }
            if (responseText.user_refer == 'error') {
                noty({
                    text: 'ไม่พบข้อมูล รหัสผู้แนะนำ ถ้าไม่มีให้เป็นค่าว่าง',
                    type: 'warning',
                    theme: 'relax', // or 'relax'
                    timeout: 5000,
                });
                $('#txt_user_refer').focus();
                //  ScriptManager.RegisterStartupScript(this, this.GetType(), "CaptchaReload", "$.getScript(\"https://www.google.com/recaptcha/api.js\", function () {});", true);
            }

        } else {
            noty({
                text: 'สมัครสมาชิกสำเร็จ',
                type: 'success',
                theme: 'relax', // or 'relax'
                timeout: 5000,
            });
            $('#myForm2')[0].reset();
        }
        grecaptcha.reset();

        $.unblockUI();
    }
    
    var status = '';
    function check_username_duplicate() {
        var txt_username = $('#username').val();
        //alert(txt_username);
        if (txt_username != '') {
            
            $.ajax({
                type: 'POST',
                url: '<?= ADDRESS ?>ajax/ajax_check_username_duplicate.php',
                dataType: 'json',
                data: {
                    username: txt_username
                },
                success: function (data) {

                    if (data === 'success') {
                        status = 'success';
                    } else {
                        status = 'error';
                    }
                }
            });
        }
    }
    
    $('#check_user_refer').click(function () {
    
        var txt_user_refer_id = $('#txt_user_refer').val();
        
        if (txt_user_refer_id != '') {
            //หาชื่อจริง จาก id ผู้แนะนำ
            $.ajax({
                type: 'POST',
                url: '<?= ADDRESS ?>ajax/ajax_users.php',
                data: {
                    user_refer_id: txt_user_refer_id
                },
                beforeSend: function () {
                    // setting a timeout
                    $.blockUI({message: '<h3> Loading...</h3>'});
                },
                success: function (data) {
                    ///  alert(data);
                    noty({
                        text: data,
                        type: 'information',
                        theme: 'relax', // or 'relax'
                        timeout: 3000,
                    });
                    $.unblockUI();
                }
            }).done(function () {
                $.unblockUI();
            }).fail(function () {
                $.unblockUI();
            }).always(function () {
                $.unblockUI();
            });
        } else {
            alert('กรุณาใส่รหัสผู้แนะนำ');
        }
    });
</script>

<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.23/theme-default.min.css"
      rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
<script>
    //  alert('The form ' + $form.attr('id') + ' is valid!');
    var options = {
        target: '#', // target element(s) to be updated with server response 
        //  dataType:  'json',  
        beforeSubmit: showRequest, // pre-submit callback 
        success: showResponse, // post-submit callback 
        dataType: 'json', // 'xml', 'script', or 'json' (expected server response type) 
        // clearForm: true,
        //  resetForm: true ,
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        // dataType:  'json'        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    };
    $.validate({
        modules: 'location, date, security, file',
        onModulesLoaded: function () {
            var optionalConfig = {
                fontSize: '12pt',
                padding: '4px',
                bad: 'Very bad',
                weak: 'Weak',
                good: 'Good',
                strong: 'Strong'
            };
            $('input[name="pass"]').displayPasswordStrength(optionalConfig);
        },
        onSuccess: function ($form) {

//console.log($('#g-recaptcha-response').val());
//          
//if ($('#g-recaptcha-response').val() != '') {

            $.ajax({
                type: 'POST',
                url: '<?= ADDRESS ?>ajax/ajax_check_captcha.php',
                dataType: 'json',
                data: {
                    recaptcha: $('#g-recaptcha-response').val()
                },
                success: function (data) {
                    if (data.captcha == 'error') {
                        noty({
                            text: 'Captcha Error',
                            type: 'warning',
                            theme: 'relax', // or 'relax'
                            timeout: 3000,
                        });
                    } else {
                        $('#myForm2').ajaxSubmit(options);
                    }

                    // console.log(data.captcha);
                    // $('#myForm2').ajaxSubmit(options);
                }
            });
            // }
            //  $('#myForm2').ajaxSubmit(options);
            return false; // Will stop the submission of the form
        },
    });
</script>