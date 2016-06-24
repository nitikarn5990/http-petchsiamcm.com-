<?php
session_start();
session_destroy();

 header( "location:". $_SERVER['PHP_SELF'] ."" );
die();

?>