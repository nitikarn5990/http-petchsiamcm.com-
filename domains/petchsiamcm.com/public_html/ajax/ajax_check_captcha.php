
<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/lib/application.php');



$recaptcha_secret = "6LeMxSITAAAAAEPNFj9C3VJifv8yAUH3HDLkgRuW";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['recaptcha']);
$response = json_decode($response, true);

if ($response["success"] === true) {
    

    $arr = array(
   
        'captcha' => 'success',
    );
}else{
     $arr = array(
        'captcha' => 'error',
       
    );
}

echo json_encode($arr);
?>