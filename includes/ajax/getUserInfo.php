<?
session_start();
define('TRO_BUCKETLIST',true);
include('../../init.php');
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$userID = $request->userID;

$sql= "select * from User where ID=:userID";
$db->query($sql);
$db->bind(":userID", $userID, PDO::PARAM_STR);
$db->execute();
$row = $db->single();
 
$name = $row['UserName'];
$picture = $row['Picture'];

$users = array();
$users[] = array(
    'name' => $name,
	'picture' => $picture,
);

echo json_encode($users);


?>