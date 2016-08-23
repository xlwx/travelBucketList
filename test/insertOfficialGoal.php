<?php
session_start();
define('TRO_BUCKETLIST',true);
include('../init.php');
/**************************************Upload Image************************************************/
$dir = GOAL_DIR . '/';
$pic = upload($dir); // direcory of the image file
$img = GOAL_URL .'/'. $pic[0];
/**************************************Insert personal profile************************************/
//set up the data for insert function
$table = "OfficialGoal";
$fields = array("GoalContent","Photo","Liked","Category");
$temps = array(":goal",":photo",":liked",':category');
$values = array($_POST['goal'],$img,'0',$_POST['category']);

if($pic[1]){
	insert($table,$fields,$temps,$values);
}
?>