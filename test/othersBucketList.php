<?
define('TRO_BUCKETLIST',true);
include('../init.php');
?>
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
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
<style>

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

table,td {
    border: 1px solid #e2d0d0;
    border-collapse: collapse;
}
td{
	text-align: center;
}

</style>
	
</head>

<body ng-app="myApp" ng-controller="BucketList">


<div class='left-container box'>
	<div class='box-left'>
		<div class='info'>
			<div><img src='images.jpg' style='height:50px;'></div>
			<div><?echo $_GET['username'];?></div>
			<div><input class='btn btn-success btn-xs' value='Follow'></div>
		</div>
	</div>
	
	<br>
	<div class='box-left'>
		<p>description</p>
	</div>
	
	<br>
	<div class='box-left'>
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle='tab' href="#" ng-click='changeList1()'>Active Goals</a></li>
		  <li><a data-toggle='tab' href="#" ng-click='changeList2()'>Completed</a></li>
		</ul>
	</div>
	<!--Comment result-->
	<div class='box-left'>
		<ul>
			<li ng-repeat="x in myData">
				<div style='margin-top:10px'>
					<img src='{{x.picture}}' style='width:100px;height:100px;'>
					<span>{{x.goal}}</span>
					<span><a class='btn btn-success' href= '<?echo BASE_URL;?>test/addGoal.php?goal={{x.goal}}'>Add</a></span>
					<span><a class='btn btn-primary' href='<?echo BASE_URL;?>test/addGoal.php?goal={{x.goal}}&goalDone=Y'>Mark as done</a></span>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class='right-container box'>
	<div class='box-rignt'>
		<img src='images.jpg' style='height:50px;'>
		<span><?echo $_GET['username'];?></span>
		<table style="width:100%">
			<tr>
				<td >{{activeNum}}<br>active goals</td>
				<td >{{completeNum}}<br>completed goals</td>
			<tr>
		</table>
	</div>
</div>

<script>
	var app = angular.module('myApp', []);
	app.controller('BucketList', function($scope, $http) {
    	$scope.goaltype = 'active';
		$scope.username = <?echo $_GET['username'];?>;
    	getData();	
    
		$scope.changeList1 = function(){
        	$scope.goaltype = 'active';
        	getData();	
		}
        
        $scope.changeList2 = function(){
        	$scope.goaltype = 'completed';
        	getData();	
		}
        
        function getData(){
        	$http({
			method : "POST",
			url : "../includes/ajax/getOthersBucketList.php",
			data: {
            	goaltype:$scope.goaltype,
            	username:$scope.username
            }
			}).then(function mySucces(response) {
        		//console.log(response.data);
				$scope.myData = response.data;
            	$scope.activeNum =response.data[0].activeNum;
    			$scope.completeNum = response.data[0].completeNum;
			});
        }
		
	});

</script>

</body>
</html>
