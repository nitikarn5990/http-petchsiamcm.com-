<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');



//echo trim($_POST['username']);
$username = trim($_POST['username']);
$pass = trim($_POST['pass']);



//
//customer_name
//customer_lastname
//customer_tel
//customer_email
//
//bank_name
//bank_company
//bank_number
//bank_branch
//bank_type_account
//txt_user_refer

$id = 352;

$image_bank = 'error';
$image_idcard = 'error';

function check_refer_user($user_refer_id) {
    if ($user_refer_id != '') {

        if ($customer->CountDataDesc("login_email", "id = 684") == 0) {
            return("0");
        } else {
            return("1");
        }
    } else {
        return("1");
    }
}

$res = '';
$res_user_refer = '';

if ($customer->CountDataDesc("login_email", "login_email = '" . $username . "'") > 0) {

    $res = 'error';
}

$txt_user_refer = trim($_POST['txt_user_refer']);
if ($txt_user_refer != '') {
    if ($customer->CountDataDesc("login_email", "id = ".$txt_user_refer) == 0) {
        $res_user_refer = 'error';
    }
}

if ($res != 'error' && $res_user_refer != 'error') {


    $res = 'success';
    $res_user_refer = 'success';
    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);

    $customer->SetValues($arrData);

    $customer->SetValue('status', 'ใช้งาน');

    $customer->SetValue('login_email', $username);
    $customer->SetValue('login_password', $functions->encode_login($pass));

    if ($customer->GetPrimary() == '') {

        $customer->SetValue('created_at', DATE_TIME);

        $customer->SetValue('updated_at', DATE_TIME);

        $customer->SetValue('register_date', DATE_TIME);
    } else {

        $customer->SetValue('updated_at', DATE_TIME);
    }
     $customer->SetValue('precode', 'pcsc');

    if ($customer->Save()) {

        if (isset($_FILES['file_bank'])) {

            for ($i = 0; $i < count($_FILES['file_bank']['tmp_name']); $i++) {

                if ($_FILES["file_bank"]["name"][$i] != "") {

                    $targetPath = DIR_ROOT_IMG . "/";

                    $ext = explode(".", $_FILES['file_bank']['name'][$i]);
                    $extension = $ext[count($ext) - 1];
                    $rand = mt_rand(1, 100000);

                    $newImage = DATE_TIME_FILE . $rand . "." . $extension;
                    //  $newImage = DATE_TIME_FILE . $rand . $_FILES['file_bank']['name'][$i];
                    // echo $newImage;
                    // $newImage = DATE_TIME_FILE .".jpg";
                    $cdir = getcwd(); // Save the current directory

                    chdir($targetPath);

                    copy($_FILES['file_bank']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   

                    $customer->UpdateSQL(array('image_bank' => $newImage), array('id' => $customer->GetPrimary()));

                    $image_bank = 'success';
                }
            }
        }

        if (isset($_FILES['file_idcard'])) {

            for ($i = 0; $i < count($_FILES['file_idcard']['tmp_name']); $i++) {

                if ($_FILES["file_idcard"]["name"][$i] != "") {

                    $targetPath = DIR_ROOT_IMG . "/";

                    $ext = explode(".", $_FILES['file_idcard']['name'][$i]);
                    $extension = $ext[count($ext) - 1];
                    $rand = mt_rand(1, 100000);

                    $newImage = DATE_TIME_FILE . $rand . "." . $extension;
                    //  $newImage = DATE_TIME_FILE . $rand . $_FILES['file_idcard']['name'][$i];
                    // echo $newImage;
                    // $newImage = DATE_TIME_FILE .".jpg";
                    $cdir = getcwd(); // Save the current directory

                    chdir($targetPath);

                    copy($_FILES['file_idcard']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   

                    $customer->UpdateSQL(array('image_idcard' => $newImage), array('id' => $customer->GetPrimary()));

                    $image_idcard = 'success';
                }
            }
        }
    }
}

$arr = array(
    'username' => $res,
    'user_refer' => $res_user_refer,
    'image_idcard' => $image_idcard,
    'image_bank' => $image_bank,
);

echo json_encode($arr);
?>