<?php
include "php/config.php";
//Redirect to home page if not logged in
if(!isset($_SESSION['uname'])){
	header('Location: http://testsite.cyou/a2p1/index.php');
	exit();
}
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8">
<head>	
	<title>Bookmarks R Us</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<link rel="shortcut icon" href="#">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<div class="container"> 
		<span class = "column"><img src = "imgs/bru.png" alt="Bookmarks R Us"/></span><span class = "column"><a href="logout.php"><img src = "imgs/lo.png" alt="Logout"/></a></span>
	</div>	
	
	<div class="container">
		<h1>Welcome to Bookmarks R Us!</h1>
	</div>
	
	<div class="container">
		<h1>Your Bookmarks:</h1>
		<div class="bookmarks" id="bms"></div>
	</div>
	
	<div class="container">
		<h1>Add Bookmark:</h1>
		<div class="bookmarks">
			<form id="addurl">
				<label for="field">URL: </label>
				<input class="left" id="url" name="field">
				<button type="submit" id="addbutton">Save</button>
			</form>
		</div>
	</div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
//setup validator
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
//set the validator to check for urls when a new one is being added
$( "#addurl" ).validate({
  rules: {
    field: {
      required: true,
      url: true
    }
  }
});

function edit_click(id){
	var html = document.getElementById(id);
	var div = '<form id="editurl"><label>URL:</label><input class="left" name="field" value="'+id+'"type="text" id="url'+id+'"><button id="'+id+'">Save</button></form>';
	html.innerHTML = div;
	//Now add the validation check after its added to the DOM
	$( "#editurl" ).validate({
	  rules: {
		field: {
		  required: true,
		  url: true
		}
	  }
	});
} 

//this is needed since the list is added dynamically. 
//The on click is set for the parent which exists at start
//It will then execute for any button events inside this parent container
$('#bms').on('click', 'button', function() {
	var id = event.target.id;
	var newrl = document.getElementById('url'+id).value;
	//console.log("NEWURL: "+newrl);
	var name = "<?php echo $_SESSION['uname'] ?>";
	$.ajax({
		url:'php/editurl.php',
		method:'POST',
		data:{name:name,id:id,newrl:newrl},
		success:function(response){
			if(response){
				console.log("URL Updated");
				var div = '<a href="'+newrl+'">'+newrl+'</a><button onClick="edit_click(this.id)" id="'+newrl+'">Edit</button><button onClick="delete_click(this.id)" id="'+newrl+'">Delete</button>';
				document.getElementById(id).innerHTML = div;//update it back to normal list with the new value
			}else{
				console.log("Error Updating URL");
			}
		}
	});
});

//pretty straightforward, just posts data to the backend so it knows what to remove
//then it removes the element from the page on success so it doesn't need to be reloaded
function delete_click(id){
	//console.log("ID: "+id);
	var name = "<?php echo $_SESSION['uname'] ?>";
	$.ajax({
		url:'php/deleteurl.php',
		method:'POST',
		data:{name:name,id:id},
		success:function(response){
			if(response){
				console.log("URL Removed");
				document.getElementById(id).remove();//remove it from the list
			}else{
				console.log("Error Removing URL");
			}
		}
	});
} 

//retrieves the users list of urls and displays them to the page
$(document).ready(function(){	
	var name = "<?php echo $_SESSION['uname'] ?>";
	$.ajax({
		url:'php/geturls.php',
		method:'POST',
		data:{name:name},
		success:function(response){
			//console.log(response);
			if(response){
				console.log("URLs Retrieved");
				document.getElementById('bms').innerHTML = response;
			}else{
				console.log("Failed to get URLs");
			}
		}
	});
});

//adds the url when activated
$(document).ready(function(){
	$("#addbutton").click(function(){		
		var name = "<?php echo $_SESSION['uname'] ?>";
		//console.log(name);		
		var nurl=$("#url").val();
		$.ajax({
			url:'php/addurl.php',
			method:'POST',
			data:{nurl:nurl,name:name},
			success:function(response){
				//console.log(response);
				if(response == 1){
					console.log("URL added");
				}else{
					console.log("Failed to add URL");
				}
			}
		});
	});
});
</script>