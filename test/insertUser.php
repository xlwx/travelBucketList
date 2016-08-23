<?php

define('TRO_BUCKETLIST',true);
include('../init.php');
/**************************************Upload Image************************************************/
$dir = USER_DIR . '/';
$pic = upload($dir); // direcory of the image file
$img = USER_URL .'/'. $pic[0];
/**************************************Insert personal profile************************************/
//set up the data for insert function
$table = "User";
$fields = array("FirstName","LastName","Email","UserName","Password","Picture","Interests","About");
$temps = array(":firstname",":lastname",":email",":username",":password",":picture",":interests",":about");
$values = array($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['username'],$_POST['password'],$img,$_POST['interests'],$_POST['about']);
if($pic[1]){
	insert($table,$fields,$temps,$values);
}
?>