<?
	define('TRO_BUCKETLIST',true);
	include('init.php');
	session_start();
/*
	if(isset($_SESSION['id'])){
    	header("Location:".BASE_URL."coverpage.php");
    }
*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="chenqi_zhang">
    

    <title>Travel Bucket List</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<? echo CSS_URL; ?>/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<!--Animate-->
	<link rel="stylesheet" href="<? echo CSS_URL; ?>/animate.min.css">
    <!-- Custom styles for this template -->
    <link href="<? echo CSS_URL; ?>/signin.css" rel="stylesheet">
	
  </head>
  <body>

    <div class="container">

      <form class="form-signin" >
        <h2 class="form-signin-heading">Please sign in</h2>
      	<p id="add_err" style="color:red"></p>
        <label for="username" class="sr-only">User Name</label>
        <input id="username" class="form-control" placeholder="UserName" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button id="signin" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<button class="btn btn-lg btn-success btn-block" type="button" onclick="register()">Register</button>
      </form>    	
    </div> <!-- /container -->
	<script>
  		function register(){
			 window.location.href='<? echo BASE_URL; ?>test/addUser.html';
		}   
	</script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<? echo JS_URL; ?>/ie10-viewport-bug-workaround.js"></script>
	<script src="<? echo JS_URL; ?>/signin.js"></script>
  </body>
</html>
