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
$table = "Goal";
$fields = array("GoalContent","Category","Location","Photo","TargetDate","GoalDone","CreatedBy","GoalDescribe","Liked");
$temps = array(":goal",":category",":location",":photo",":targetdate",":goaldone",":createdby",":goaldescribe",":liked");
$values = array($_POST['goal'],$_POST['category'],$_POST['location'],$img,$_POST['targetDate'],$_POST['goalDone'],$_SESSION['id'],$_POST['describe'],'0');

if($pic[1]){
	insert($table,$fields,$temps,$values);
}
?>