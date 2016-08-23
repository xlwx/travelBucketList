<?php
session_start();
define('TRO_BUCKETLIST',true);
include('../init.php');
/**************************************Upload Image************************************************/
$dir = GOAL_DIR . '/';
$pic = upload($dir); // direcory of the image file

$img = $pic[0] !='.jpg' ? GOAL_URL .'/'. $pic[0] : $_POST['img'];

/**************************************Insert personal profile************************************/
//set up the data for insert function
$table = "Goal";
$fields = array("Category","Location","Photo","TargetDate","GoalDone","CreatedBy","GoalDescribe","Liked");
$temps = array(":category",":location",":photo",":targetdate",":goaldone",":createdby",":goaldescribe",":liked");
$values = array($_POST['category'],$_POST['location'],$img,$_POST['targetDate'],$_POST['goalDone'],$_SESSION['id'],$_POST['describe'],'0');
//print_r($fields);
//print_r($temps);
//print_r($values);
update($table,$fields,$temps,$values,'ID',':ID',$_POST['ID']);

?>