<?php




error_reporting(0);



set_time_limit(3600);



error_reporting(E_ALL ^ E_NOTICE); // Disable Error Notice



date_default_timezone_set('Asia/Bangkok');



ob_start();



$mode = 'dev';







switch ($mode) {



    case 'production':



        define('LOGGING', false);



        define('DEBUG', false);



        define('DEBUG_QUERY', false);



        define('DEBUG_LOG', false);



        define('USE_CACHE', true);



        define('USE_ENUM', true);



        define('QUERY_CACHE', true);



        define('DB_SESSIONS', true);







        break;



    case 'dev':



    case 'testing':



    default:



        define('LOGGING', false);



        define('DEBUG', false);



        define('DEBUG_QUERY', false);



        define('DEBUG_LOG', false);



        define('USE_CACHE', false);



        define('USE_ENUM', false);



        define('QUERY_CACHE', false);



        define('DB_SESSIONS', false);







        break;
}





// Basic Information


define('PRO_ID', $_GET['productID']);
define('ADDRESS_ASSETS', 'http://' . $_SERVER['SERVER_NAME'] . '/admin/assets/images/');

define('ADDRESS_ADMIN', 'http://' . $_SERVER['SERVER_NAME'] . '/admin/');



define('ADDRESS', 'http://' . $_SERVER['SERVER_NAME'] . '/');



define('ADDRESS_FILE', 'http://' . $_SERVER['SERVER_NAME'] . '/files/');



define('ADDRESS_GALLERY', 'http://' . $_SERVER['SERVER_NAME'] . '/files/gallery/');



define('ADDRESS_PERSONNEL', 'http://' . $_SERVER['SERVER_NAME'] . '/files/gallery/personnel/');



define('ADDRESS_SLIDES', 'http://' . $_SERVER['SERVER_NAME'] . '/img/');



define('ADDRESS_ADS', 'http://' . $_SERVER['SERVER_NAME'] . '/files/ads/');

define('ADDRESS_BILL', 'http://' . $_SERVER['SERVER_NAME'] . '/files/receipt/');

define('ADDRESS_COVER', 'http://' . $_SERVER['SERVER_NAME'] . '/files/cover_img/');



define('ADDRESS_HEAD', 'http://' . $_SERVER['SERVER_NAME'] . '/files/head/');



define('ADDRESS_BANNER', 'http://' . $_SERVER['SERVER_NAME'] . '/files/banner/');

define('ADDRESS_IMGES', 'http://' . $_SERVER['SERVER_NAME'] . '/images/');

define('ADDRESS_ADMIN_CONTROL', ADDRESS_ADMIN . 'index.php?controllers=');

define('ADDRESS_PLUGINS', ADDRESS . 'plugins/');

define('ADDRESS_CONTROL', ADDRESS . '?controllers=');



define('TITLE', '');







define("DATE", date('Y-m-d'));



define("DATE_TIME", date('Y-m-d H:i:s'));

define("DATE_TIME_2", date('Y/m/d H:i:s'));

define("DATE_TIME_FILE", date('YmdHis'));


define("RUN_ORDER", date('Ymd'));




define("SETTING_ID", 1);

define('NO_IMAGE', ADDRESS.'images/placeholder.png');





// Directories
// Always Include trailing slash "/" in Direcories



define('DIR_ABS', $_SERVER["DOCUMENT_ROOT"] . '/');



define('DIR_LIB', 'lib/');



define('DIR_CONTROL', 'controller/');



define('DIR_PLUGINS', 'assets/plugins/');



define('DIR_ROOT_IMAGES', DIR_ABS . 'images/');

define('DIR_ROOT_IMG', DIR_ABS . 'img/');

define('DIR_ROOT_FILES', DIR_ABS . 'files/');



define('DIR_ROOT_GALLERY', DIR_ABS . 'files/gallery/');

define('DIR_ROOT_BILL', DIR_ABS . 'files/receipt/');




define('DIR_ROOT_PERSONNEL', DIR_ABS . 'files/gallery/personnel/');



define('DIR_ROOT_COVER', DIR_ABS . 'files/cover_img/');



define('DIR_ROOT_SLIDES', DIR_ABS . 'img/');

define('DIR_ROOT_ADS', DIR_ABS . 'files/ads/');



define('DIR_ROOT_HEAD', DIR_ABS . 'files/head/');



define('DIR_IMAGES', 'images/');



define('DIR_ADMIN_IMAGES', '../images/');
define('ROOT_KEY', '0881545990');






//Theme



define("THEME_NEME", "");



define("THEME_PATH", "themes/" . THEME_NEME . "/");



define("THEME_PATH_LAYOUTS", THEME_PATH . "/pages/");



define("THEME_PATH_FILES", THEME_PATH . "/files/");



define("THEME_PATH_IMAGES", THEME_PATH . "/images/");



define("THEME_PATH_HTML", THEME_PATH . "/pages/html/");



define("THEME_PATH_NAV", THEME_PATH . "/pages/navigations/");







// Simpl Directories
// Change this to where simpl is installed on your server



define('FS_LIB', DIR_ABS . 'lib/');



define('FS_SIMPL', DIR_ABS . 'simpl/');



define('FS_CACHE', DIR_ABS . 'cache/');




 


// Database Connection Options

define('DB_USER', 'petchsia_db');

define('DB_PASS', '123456');

define('DB_HOST', 'localhost');

define('DB_DEFAULT', 'petchsia_db'); 
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DEFAULT);


    
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}
?>