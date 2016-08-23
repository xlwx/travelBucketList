<?php
session_start();
define('TRO_BUCKETLIST',true);
include('../../init.php');

$table = "Goal";
$field = "ID";
$temp = ":ID";
$value = $_POST['goalID'];
echo $value;
delete($table,$field,$temp,$value);

?>

