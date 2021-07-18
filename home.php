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
var addvalid = false;
var editvalid = false;

//set the validator to check for urls when a new one is being added
$( "#addurl" ).validate({
	rules: {
		field: {
			required: true,
			url: true
		}
	},
	success: function(label) {
    //document.getElementById("addurl").disabled = false;
	console.log("SUCCESS");
	addvalid = true;//set flag to allow for submission
  },
	invalidHandler: function(event, validator) {
    //document.getElementById("addurl").disabled = true;
	console.log("FAILURE");
	addvalid = false;//set flag to stop submitting form
  },
  submitHandler: function(){ 
		if(addvalid){
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
		}
	}
});

//just simple cancel functionality to cancel making changes to the url
function cancel_edit(id){
	var div = '<a href="'+id+'">'+id+'</a><button onClick="edit_click(this.id)" id="'+id+'">Edit</button><button name="delete" onClick="delete_click(this.id)" id="'+id+'">Delete</button>';
	document.getElementById("div"+id).innerHTML = div;//update it back to normal list with the new value
}

//handler for the edit button, hooks to make form for editing
function edit_click(id){
	var html = document.getElementById("div"+id);
	var div = '<form id="editurl"><label>URL:</label><input class="left" name="field" value="'+id+'"type="text" id="url'+id+'"><button id="'+id+'">Save</button><button onClick="cancel_edit(this.id)" id="'+id+'">Cancel</button></form>';
	html.innerHTML = div;
	//Now add the validation check after its added to the DOM
	$( "#editurl" ).validate({
		rules: {
			field: {
				required: true,
				url: true
			}
		},
		success: function(label) {
			console.log("SUCCESS");
			editvalid = true;//set flag to allow for submission
		},
		invalidHandler: function(event, validator) {
			console.log("FAILURE");
			editvalid = false;//set flag to stop submitting form
		},
		submitHandler: function(event){
			if(editvalid){
				//first check this isn't the delete button, as both will trigger this
				if(event.target.name != "delete"){
					var newrl = document.getElementById('url'+id).value;
					var name = "<?php echo $_SESSION['uname'] ?>";
					//first check for duplicate of this for further validation
					$.ajax({
						url:'php/checkurls.php',
						method:'POST',
						data:{name:name,newrl:newrl},
						dataType: 'JSON',
						success:function(response){
							if(!response){
								console.log("No Duplicate Response: "+response);
								//now try to update
								$.ajax({
									url:'php/editurl.php',
									method:'POST',
									data:{name:name,id:id,newrl:newrl},
									success:function(response){
										if(response){
											console.log("URL Updated");
											console.log("IDDDD:"+id);
											var div = '<a href="'+newrl+'">'+newrl+'</a><button onClick="edit_click(this.id)" id="'+newrl+'">Edit</button><button name="delete" onClick="delete_click(this.id)" id="'+newrl+'">Delete</button>';
											document.getElementById("div"+id).innerHTML = div;//update it back to normal list with the new value
											document.getElementById("div"+id).id = "div"+newrl;
										}else{
											console.log("Error Updating URL");
										}
									}
								});
							}else{					
								console.log("Duplicate Response: "+response);
							}
						}
					});					
				}
			}	}
	});
}

//pretty straightforward, just posts data to the backend so it knows what to remove
//then it removes the element from the page on success so it doesn't need to be reloaded
function delete_click(id){
	var name = "<?php echo $_SESSION['uname'] ?>";
	$.ajax({
		url:'php/deleteurl.php',
		method:'POST',
		data:{name:name,id:id},
		success:function(response){
			if(response){
				console.log("URL Removed");
				document.getElementById("div"+id).remove();//remove it from the list
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
</script>