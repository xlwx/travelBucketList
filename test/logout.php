<?
define('TRO_BUCKETLIST',true);
include('../init.php');

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
header("Location:" . BASE_URL . "signin.php");
?>