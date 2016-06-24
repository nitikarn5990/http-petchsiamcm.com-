<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');

$txt_username = $_POST['username'];



if ($customer->CountDataDesc("login_email", "login_email = '" . $txt_username . "'") > 0) {
    $res = 'error';
} else {
    $res = 'success';
}

$arr = array(
    'status' => $res
);
echo json_encode($arr);
?>


