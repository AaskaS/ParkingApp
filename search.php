<!DOCTYPE html>
<!--Constitutes the code that produces the search page of the app - this is the place that allows the user to filter their searches for a parking space.
	 All classes used are defined in the style.css file-->
<html lang="en">
	<head>
		<!-- This imports the style sheets used for the formatting of the page as well as the icons-->
		<link rel="stylesheet" type="text/css" href="reset.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		<script type="text/javascript" src="javascript.js"></script>
 
   		 

		<!-- declares the view of the user depending on the type of device they're using-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0"/>


		<title> Search </title>

	</head >

	<!-- Search page contains a navigation bar that let's them access pages as a user or as an owner. 
		The form allows the user to filter through the postings based on the distance to the location, the price range of the space,
		 and the relative ratings the spot has received. After the selections have been made, the "Search" button will take them to 
		 see their results. The page also contains a "Sign Out" button, which will lead the user back to the Welcome page. -->
	<body >
		<?php require 'loggedInCheck.inc.php'; ?>
		<header class="h1Global">
			<div>	
				<button class="signout" onclick="location.href='logout.php'">Sign Out</button>
				<h1> Search </h1>		
			</div>

		</header>
		<!-- Profile - allows them to return to their profile (main page)
		Search - allows the search for parking spots
		Past Spots - allows them to look at all the places they've used
		Submission - allows them to submit their parking space for rent
		My Postings - allows them to see and manage the postings they've made
		Requests - allows them to see the requests they have for the postings they've made. -->
		<?php include 'nav.inc.php'?>

		<form method="post" name="search" onsubmit="return searchVal(this)" action='results.php'>
				<div>
					<label class="label">Latitude</label>
					<input class="input" type="text" name="latitude" id="lat" required><br>
				</div><br>
				<div>
					<label class="label">Longitude</label>
					<input class="input" type="text" name="longitude" id="long" required>
				</div>

				<button class ="complete" type="button" name="Location" onclick="getLocation()">Detect Location</button> <br> <br>
				<div >
					<label class="label">Distance (km)</label> 
					<input class="input" type="number" name="distance" required><br> 
				</div><br>
				<div>
					<label class="label">Rating (Up to 5)</label>
					<select class="input" id="Stars" name="Stars">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select><br>
				</div><br>
				<div>
					<label class="label">Price Range</label>
					<input class=" slide-wrapper" type="range" id="rg" name="searchRange" min="0" max="1000" step="1" data-show-value="true" value="50" oninput="rg_disp.value = rg.value"><br>
				</div><br>
				<div>
					<output  class="output" name="searchRange" id = "rg_disp" onchange="rg_disp.value"></output>
				</div><br>
				
				<input class="button2" type="submit"  value="Search" ><br>
			 	

		</form>
		
		<!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
		<?php include 'footer.inc.php'?>

	</body>



</html>
