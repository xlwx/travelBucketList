<?
define('TRO_BUCKETLIST',true);
include('../init.php');
$addScript[] = templateAddScript("https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js");
$addStyleSheet[] = templateAddStyleSheet(CSS_URL."/bucketlist.css");
include(TEMPLATE_DIR . '/header.php');

$goalID = $_GET['goalID'];
$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$sql="select * from OfficialGoal where ID = :goalID";
$db->query($sql);
$db->bind(":goalID",$goalID, PDO::PARAM_STR);
$db->execute();
$row=$db->single();

$goal = $row['GoalContent'];

?>
<br>
<br>
<br>
<div id='goalContent' class='container'><h1 align="center"><?echo $goal;?></h1></div>
<div class='container' ng-app="myApp" ng-controller="BucketList">
<div class='left-container box' >
	<div class='box-left'>
		<div class='info'>
			<div><img src='a.jpg' style='width:50px;height:50px;'></div>
			<div>Official Bucket List's Goal</div>
		</div>
	</div>
	
	<br>

	<br>
	<div class='box-left'>
		<p>Describe the Goal</p>
	</div>
	<!--Comment result-->
	<div class='box-left'>
		<ul>
			<li ng-repeat="x in myData" class='user'>
				<div class="row">
                	<!--Persional Info-->
                	<div class='col-md-4'>
                    	<a href="othersBucketList.php?username={{users[$index][0].name}}"><img src={{users[$index][0].picture}} style='height:50px;width:50px'/></a>
						<span>{{users[$index][0].name}}</span>
                	</div>
                	<!--Goal Info-->
                	<div class='col-md-8'><img src={{x.picture}} style='width:100px;height:100px' /></div>
				</div>
			</li>
		</ul>
	</div>

	<div style='background: #fff;
	width: 100%;
    height: 0;
	border: 1px solid #ddd;'></div>

	<div class='box-left'>
    	<h3>comment</h3>
    	<form id='comment' action='#' type='post' style='width:100%'>
    	<div >
        	<div style='width:8%;float:left'><img src='<?echo $picture;?>' style='width:50px;height:50px'></div>
            <div style='width:72%;float:left'><textarea name='content' style='width:100%;height:50px' placeholder="want to say something"></textarea></div>
            <div style='width:20%;float:left'><input class='btn btn-primary' value='Post' style='width:100px;height:50px'></div>
        	<input name='userID' value='<?echo $_SESSION['id'];?>' hidden>
        	<input name='goalID' value='<?echo $goalID;?>' hidden>
        </div>
        </form>
	</div>

</div>

<div class='right-container box'>
	<div class='box-rignt'>
		<input type='button' class='btn btn-success btn-list-item' value='Add to your bucket list' onclick="location.href='<?echo BASE_URL?>test/addGoal.php?goal=<?echo $goal;?>'" />
		<input type='button' class='btn btn-info btn-list-item' value='Mark as done' onclick="location.href='<?echo BASE_URL?>test/addGoal.php?goal=<?echo $goal;?>&goalDone=Y'">
		<input type='button' class='btn btn-primary btn-list-item' value='Like this idea'>
	</div>
</div>
</div>
<script>
	var app = angular.module('myApp', []);
	app.controller('BucketList', function($scope, $http) {
    	$scope.goal= $('#goalContent').text();
    	$scope.users = [];
    	getData();
    	
        function getData(){
        	$http({
			method : "POST",
			url : "<?echo AJAX_URL;?>/getOfficialBucketList.php",
			data: {
            	goal:$scope.goal
            }
			}).then(function mySucces(response) {
        		console.log(response.data);
				$scope.myData = response.data;
            	// get the corresponding users
            	angular.forEach($scope.myData, function(data) {
					var userID = data.userID;
					$http({
						method : "POST",
						url : "<?echo AJAX_URL;?>/getUserInfo.php",
						data: {
							userID:userID
						}
					}).then(function mySucces(user) {
						$scope.users.push(user.data);
					});
				});
			});
        }
    
    	
		
		
	});

</script>

<?
include(TEMPLATE_DIR . '/footer.php');
?>