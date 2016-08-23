<?
session_start();
define('TRO_BUCKETLIST',true);
include('../../init.php');
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$category = $_GET['category'];
$userID = $_SESSION['id']; 
$num = $_GET['num'] *7;  
if($_GET['num'] != 0) $num +1;

$sql_count= "select * from OfficialGoal";
$db->query($sql_count);
$db->execute();
$rowCount = $db->rowCount();

$offset = ($num+7) > $rowCount ? ($rowCount-$num) : 7;

if($category == 'popular'){
	$sql= "select * from OfficialGoal order by Liked limit ".$num.",".$offset;
}else{
	$sql= "select * from OfficialGoal where Category like :category limit ".$num.",".$offset;
}


$db->query($sql);

if($category == 'popular'){
}else{
	$db->bind(":category",  '%' . $category . '%', PDO::PARAM_STR);
}

$db->execute();
$row = $db->resultset();

$ideas = array();
$j = 0;
while($j < count($row)){
	$ID = $row[$j]['ID'];
	$goal = $row[$j]['GoalContent'];
	$picture = $row[$j]['Photo'];
	$ideas[] = array(
			'title' => $goal,
			'image' => $picture,
    		'ID' => $ID
		);
	$j++;
}

echo json_encode($ideas);

?>