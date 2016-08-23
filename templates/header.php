<?
//session_start();
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if(!isset($_SESSION['id'])){
	header("Location:".BASE_URL."signin.php");
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$pageTitle?></title>	
<!--Animate-->
	<link rel="stylesheet" href="<? echo CSS_URL; ?>/animate.min.css">	
<!--CSS-->
	<!--bootstrap-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!--angularJS waterfull-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.0.4/angular-material.css'>
<?
templateRenderStyleSheet($addStyleSheet);
templateRenderStyle($addStyle);
?>   

<!--JavaScraip-->
	<!--jquery-->
    <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
	<!---validation-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
	<!--bootstrap-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?
templateRenderScript($addScript);
templateRenderJavaScript($addJavaScript);
?>

<?
	$addGoal = 'insertGoal.php';

	$db = new pdo_Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
	$sql = "SELECT * FROM User WHERE UserName=:username ";
	$db->query($sql);
	$db->bind(':username', $username, PDO::PARAM_STR);
	$db->execute();
	$row = $db->single();
	$picture = $row['Picture'];
	
	$mybucketlist = BASE_URL  .  'test/myBucketList.php';
	$addgoal = BASE_URL  .  'test/addGoal.php';
	$editprofile = BASE_URL . 'test/editprofile.php';
	$logout = BASE_URL  .  'test/logout.php';
	$changepw = BASE_URL  .  'test/changepw.php';
 
?>
  
  </head>
  <body >
  <!-- Static navbar -->
      <nav class="navbar navbar-inverse  navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
           
          </div>
         
      		<ul class="nav navbar-nav navbar-right">
            	 <li class="dropdown">
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?echo $username;?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?echo $mybucketlist;?>">My Bucket List</a></li>
                  <li ><a href="<?echo $addgoal;?>">Add a Goal</a></li>
                  <li><a href="#">Following</a></li>
                  <li><a href="<?echo $editprofile;?>">Edit Profile</a></li>
                  <li><a href="#">Change Password</a></li>
                  <li><a href="<?echo $logout;?>">Log out</a></li>
                </ul>
              	</li>
            	
      		</ul>			
			 <form class="navbar-form navbar-right list-search" role="search" id="searchForm">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search" id="search-input" name="searchinput">
				</div>
				<button type="submit" class="btn btn-default" id="search">Submit</button>
			</form> 
        <button class="btn btn-success"  data-toggle="modal" data-target="#myModal">Add a Goal</button>
        <img scr="<?echo $picture;?>" class="img-circle" alt="photo" width="30" height="30">
        </div><!--/.container-fluid -->
      </nav>
 
  
  <script>
  
  	var url = window.location;
	// Will only work if string in href matches with location
	$('ul.nav a[href="'+ url +'"]').parent().addClass('active');

	// Will also work for relative and absolute hrefs
	$('ul.nav a').filter(function() {
    	return this.href == url;
	}).parent().addClass('active');
  
  	$('ul.dropdown-menu  a[href="'+ url +'"]').parent().parent().parent().addClass('active');
  	
  </script>
  <!-------------------------------------Model------------------------------------------------------------>
 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add a Goal</h4>
      </div>
      <div class="modal-body">
        <!-- --------------------------------------------------------------------------------------- -->
      	<div class="container">
 
	
		<form id="addGoal" method="post" action="<? echo $addGoal; ?>">

			<div class="row">
				<div class="col-md-6">
					<div class="input-group">		
						<input type="text" name="goal" id="goal" placeholder='add your goal'  class="form-control"  aria-describedby="basic-addon1">
					</div>
				</div>
			</div>

		
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">	
						<input type="text" name="category" id="category" placeholder='select the category' class="form-control"  aria-describedby="basic-addon1" >
					</div>
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">			
						<input type="text" name="location" id="location" placeholder='enter the location' class="form-control"  aria-describedby="basic-addon1" >
					</div>
				</div>
			</div>
        
        	<div class="row">
				<div class="col-md-6">
					<div class="input-group">		
						<input type="text" name="targetDate" id="targetDate" placeholder='target date'  class="form-control"  aria-describedby="basic-addon1">
					</div>
				</div>
			</div>

		
			<div class="row">
				<div class="col-md-6">				
						<input type="file" name="fileToUpload" id="fileToUpload">
				</div>
			</div>
			
        	<div class="row">
            	<div class="col-md-6">
    				<textarea name='describe' rows="4" cols="50" placeholder="describe your goal"></textarea>
                </div>
    		</div>

	</form>
	</div>  <!-- end of container-->
      
      	<!-- --------------------------------------------------------------------------------------- -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="myFormSubmit" type="submit" class="btn btn-primary">Submit</button>
      	<script>
      		$(function(){
    			$('#myFormSubmit').click(function(e){         
                	e.preventDefault();
                	$.post(<? echo "'".$addGoal."'"; ?>, 
               		$('#addGoal').serialize(), 
         	   			function(data, status, xhr){
        				
        				location.reload();
         	   		});
    		});
		});
        </script>
      </div>
    </div>
  </div>
</div>
  <!-------------------------------------Model End-------------------------------------------------------->
  
<!-- EH -->
