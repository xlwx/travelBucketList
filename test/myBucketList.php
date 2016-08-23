<?
define('TRO_BUCKETLIST',true);
include('../init.php');
$addScript[] = templateAddScript("https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js");
$addStyleSheet[] = templateAddStyleSheet(CSS_URL."/bucketlist.css");
include(TEMPLATE_DIR . '/header.php');


$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
$userID = $_SESSION['id']; 
$sql= "select * from User where ID=:userID";
$db->query($sql);
$db->bind(":userID", $userID, PDO::PARAM_STR);
$db->execute();
$row = $db->single();
$picture = $row['Picture'];
$name = $row['UserName'];
$about = $row['About'];
?>
<br>
<br>
<br>
<div class='container' ng-app="myApp" ng-controller="BucketList">
<div class='left-container box' >
	<div class='box-left'>
		<div class='info'>
			<div><img src='<?echo $picture;?>' style='width:50px;height:50px;'></div>
			<div><?echo $name;?></div>
		</div>
	</div>
	
	<br>
	<div class='box-left'>
		<p>About Me</p>
    	<div><?echo $about;?></div>
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
				<div>
					<img src='{{x.picture}}' style='width:100px;height:100px;'>
					<span>{{x.goal}}</span>
					<span><a class='btn btn-success' href= '<?echo BASE_URL;?>test/editgoal.php?goalID={{x.ID}}'>Edit</a></span>
					<span ng-if="x.goalDone === 'N'"><a class='btn btn-primary' href='<?echo BASE_URL;?>test/markdone.php?goalID={{x.ID}}'>Mark as done</a></span>
					<span><input type='button' value='Del' class='btn btn-danger' ng-click="delRow(x.ID)"/></span>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class='right-container box'>
	<div class='box-rignt'>
		<img src='<?echo $picture;?>' style='width:50px;height:50px;'>
		<span><?echo $name;?></span>
		<table style="width:100%">
			<tr>
				<td >{{activeNum}}<br>active goals</td>
				<td >{{completeNum}}<br>completed goals</td>
			<tr>
		</table>
	</div>
</div>
</div>
<script>
	var app = angular.module('myApp', []);
	app.controller('BucketList', function($scope, $http) {
    	$scope.goaltype = 'active';
		$scope.username = '1';
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
			url : "<?echo AJAX_URL;?>/getOwnBucketList.php",
			data: {
            	goaltype:$scope.goaltype
            }
			}).then(function mySucces(response) {
        		//console.log(response.data);
				$scope.myData = response.data;
            	$scope.activeNum =response.data[0].activeNum;
    			$scope.completeNum = response.data[0].completeNum;
			});
        }
    	
    	$scope.delRow = function(id){
        	if (confirm('Do you really want to delete this goal?')==true)
			{
				var index = -1;
				for (var i = 0; i < $scope.myData.length; i++){
   					if ($scope.myData[i].ID === id) {
        				index = i;
        				break;
    				}
				}
  				$scope.myData.splice(index, 1);     
            	var data = 'goalID='+id;
				$.ajax({
					type: 'POST',
					url: '<? echo AJAX_URL;?>/deleteGoal.php',
					data: data,
					success: function(e){ // this happens after we get results
						//alert(e);
					}
				});
			}
       }
		
	});

</script>

<?
include(TEMPLATE_DIR . '/footer.php');
?>