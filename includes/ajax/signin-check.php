<?
session_start();
define('TRO_BUCKETLIST',true);
include('../../init.php');
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);

 
if(true) {
    // username exists, check the password
	$sql= "select * from User where UserName=:name and Password=:password";
	$db->query($sql);
	$db->bind(":name", $_POST['username'], PDO::PARAM_STR);
	$db->bind(":password", $_POST['password'], PDO::PARAM_STR);
	$db->execute();
	$row = $db->single();
	if($row){    
       // sessions are global variables that can be used in multiple pages until the brower is closed.	
    	$_SESSION['username'] = $row['UserName'];
    	$_SESSION['id'] = $row['ID'];
    	echo 'true';
	}else{
		//wrong password
		echo 'false';
	}
} else {
	// username doesn't exist
    echo 'false';
}

?>
