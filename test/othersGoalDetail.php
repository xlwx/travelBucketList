<html>
<head>	
<!--CSS-->
	<!--bootstrap-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	
<!--JavaScraip-->
	<!--jquery-->
    <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
	<!--bootstrap-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<style>

br{
	border: 1px solid #eee;
}

.box{
	border: 1px solid #ddd;
	box-shadow: 0 0 6px #ccc;
    border-radius: 5px;
    float:left;
    padding: 20px;
}

.left-container{
	width:60%;
	background: #fff;
}

.right-container{
	width:40%;
	background: #eae8e8;

}


.box-right, .box-left{
	padding: 20px;
}
.btn-list-item{
	width:90%;
	height:50px;
	margin-top: 10px;
}
.info>div{
	float: left;
	margin-left: 20;
}
.info{
	width:100%;
}

</style>
	
</head>

<?
define('TRO_BUCKETLIST',true);
include('../init.php');
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$sql="select * from Goal where GoalContent = :goal";


$sql="select * from User where UserName = :username";
$db->query($sql);
$db->bind(":username",$username, PDO::PARAM_STR);
$db->execute();
$row=$db->single();
?>

<body>


<div class='left-container box'>
	<div class='box-left'>
		<div class='info'>
			<div><img src='0455.jpg'></div>
			<div>name</div>
			<div>follower</div>
		</div>
	</div>
	
	<br>
	<div class='box-left'>
		<p>description</p>
	</div>
	
	<br>
	<div class='box-left'>
		<div>comment</div>
		<div class="row">
			<div class="col-md-3">					
				<img src='1.jpg'>
			</div>
			<div class="col-md-6">					
				<input type="text" name="comment" placeholder='Add a comment'>
			</div>
			<div class="col-md-3">					
				<input class='btn btn-primary' type="submit" value="Post">
			</div>
		</div>
	</div>
	<!--Comment result-->
	<div class='box-left'>
		
	</div>
</div>

<div class='right-container box'>
	<div class='box-rignt'>
		<input type='button' class='btn btn-success btn-list-item' value='Add to your bucket list'>
		<input type='button' class='btn btn-info btn-list-item' value='Mark as done'>
		<input type='button' class='btn btn-primary btn-list-item' value='Like this idea'>
	</div>
</div>


<body>
</html>
