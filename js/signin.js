$(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	 $("#signin").click(function(){	
		  username=$("#username").val();
		  password=$("#password").val();
     	  $('#username').removeClass('animated shake');
     	  $('#password').removeClass('animated shake');
		  $.ajax({
			type: "POST",
			url: 'includes/ajax/signin-check.php',
			data: "username="+username+"&password="+password,
			success: function(userInfo){    
				if(userInfo == 'true')    {
				 //$("#add_err").html("right username or password");
				 //window.location.href='coverpage.php?username='+username;
                   window.location.href='../test/editprofile.php';
				}
				else    {
					$("#add_err").css('display', 'inline', 'important');
				 	$("#add_err").html("Wrong username or password");
                	$('#username').addClass('animated shake');
                	$('#password').addClass('animated shake');
				}
			}
		});
		return false;
	});
});