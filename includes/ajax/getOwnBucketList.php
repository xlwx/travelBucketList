<?
session_start();
define('TRO_BUCKETLIST',true);
include('../../init.php');

$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$goaltype = $request->goaltype;

$userID = $_SESSION['id']; 

$sql= "select * from Goal where CreatedBy=:ID and GoalDone=:goalDone";
$db->query($sql);
$db->bind(":ID", $userID, PDO::PARAM_STR);
$db->bind(":goalDone",'N', PDO::PARAM_STR);
$db->execute();
$row1 = $db->resultset();
$activeNum = count($row1);

$sql= "select * from Goal where CreatedBy=:ID and GoalDone=:goalDone";
$db->query($sql);
$db->bind(":ID", $userID, PDO::PARAM_STR);
$db->bind(":goalDone",'Y', PDO::PARAM_STR);
$db->execute();
$row2 = $db->resultset();
$completeNum = count($row2);

if($goaltype == 'active'){
	$row = $row1;
}else{
	$row = $row2;
}
 

$goals = array();
$j = 0;
while($j < count($row)){
	$ID = $row[$j]['ID'];
	$goal = $row[$j]['GoalContent'];
	$picture = $row[$j]['Photo'];
	$goalDone = $row[$j]['GoalDone'];
	$targetDate = $row[$j]['TargetDate'];
	$goals[] = array(
    		'ID' => $ID,
			'goal' => $goal,
			'picture' => $picture,
    		'goalDone' => $goalDone,
    		'targetDate' => $targetDate,
    		'activeNum' => $activeNum,
    		'completeNum' => $completeNum
		);
	$j++;
}
echo json_encode($goals);


?>