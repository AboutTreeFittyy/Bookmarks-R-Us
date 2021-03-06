 <!doctype html>
<html lang="en">
<meta charset="utf-8">
<head>	
	<title>Bookmarks R Us</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="shortcut icon" href="#">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<div class="container"> 
		<span class = "column"><a href="index.php"><img src = "imgs/bru.png" alt="Bookmarks R Us"/></span><span class = "column"><a href="signup.htm"><img src = "imgs/sup.png" alt="Sign Up"/></a></span><span class = "column"><a href="signin.htm"><img src = "imgs/sin.png" alt="Sign In"/></a></span>
	</div>	
	
	<div class="container">
		<h1>Welcome to Bookmarks R Us!</h1>
		<h2>Ten most popular sites:</h2>
		<div id="list"></div>
		<h2>New user? Start here:</h2>
		<p><a href="signup.htm">Sign Up</a></p>
		<h2>Already a member? Sign in here:</h2>
		<p><a href="signin.htm">Sign In</a></p>
	</div>
</body>
</html>
<script>
//retrieves the top ten urls and displays them
$(document).ready(function(){
	$.ajax({
		url:'php/topurls.php',
		method:'POST',
		success:function(response){
			//console.log(response);
			if(response){
				console.log("URLs Retrieved");
				document.getElementById('list').innerHTML = response;
			}else{
				console.log("Failed to get URLs");
			}
		}
	});
});
</script>