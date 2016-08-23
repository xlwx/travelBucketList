<?
session_start();
define('TRO_BUCKETLIST',true);
include('../../init.php');
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$goal = $request->goal;

$sql= "select * from Goal where GoalContent=:goal and GoalDone=:goalDone";
$db->query($sql);
$db->bind(":goal", $goal, PDO::PARAM_STR);
$db->bind(":goalDone",'Y', PDO::PARAM_STR);
$db->execute();
$row = $db->resultset();
 

$goals = array();
$j = 0;
while($j < count($row)){
	$ID = $row[$j]['ID'];
	$userID = $row[$j]['CreatedBy'];
	$picture = $row[$j]['Photo'];
	$goals[] = array(
    		'ID' => $ID,
    		'userID' => $userID,
			'picture' => $picture,
		);
	$j++;
}
echo json_encode($goals);


?>