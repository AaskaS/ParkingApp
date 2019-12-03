<!DOCTYPE html>
<!--Constitutes the code that produces the owner's (user's) submission page of the app - the page that contains 
    the form used to create a posting for a parking spot.
   All classes used are defined in the style.css file-->
<html lang="en">
  <head>
	    <!-- This imports the style sheets used for the formatting of the page as well as the icons-->
	    <link rel="stylesheet" type="text/css" href="reset.css">
	    <link rel="stylesheet" type="text/css" href="style.css">
	    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	    <!-- declares the view of the user depending on the type of device they're using-->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0"/>
		

		<title> Spot Submission </title>

	</head >

  <!-- Submission page contains a navigation bar that let's them access pages as a user or as an owner. Submissions page 
  		includes input of the spot's basic information such as Name, Geographical Location, Price, Image(if available), and Descriptin of the spot. 
  		The page also contains a "Sign Out" button, which will lead the user back to the Welcome page.-->
	<body >
	<?php require 'loggedInCheck.inc.php'; ?>

	<?php
		$canInsert = 0;
 	    $insertPass = 0;     
      	$nameErr =$latErr = $longErr = $priceErr = "";
      	/* this validates the new parking spot inputted byt the user*/

      	if(isset($_POST["submit"])){
	      	$name = $_POST["spotName"];
      		$lat = $_POST["latitude"];
      		$long = $_POST["longitude"];
      		$price = $_POST["price"];
      		/*the name must be filled out*/
      		if(empty($name)){
      			$canInsert = $canInsert + 1;
      			$nameErr = "Spot name error";
      		}   
      		/*the latitude must be filled out and be within the proper range*/
      		if(empty($lat) || ($lat < -90.00 || $lat>90.00)){
      			$canInsert = $canInsert + 1;
      			$latErr = "Latitude error";
      		}	
      		/*the longitude must be filled out and be within the proper range*/
      		if(empty($long) || ($long< -180.00 || $long>180.00)){
      			$canInsert = $canInsert + 1;
      			$longErr = "Longitude error";
      		}
      		/*the price must be filled out and be within the proper range*/
      		if(empty($price) || ($price > 1000.00 || $price < 0.00)){
      			$canInsert = $canInsert + 1;
      			$priceErr = "Price error";
      		}	
      	}

	?>

		<header class="h1Global">
			<div>	
				<button class="signout" onclick="location.href='logout.php'">Sign Out</button>
				<h1> Spot Submission </h1>		
			</div>

		</header>

		<!-- Profile - allows them to return to their profile (main page)
		Search - allows the search for parking spots
		Past Spots - allows them to look at all the places they've used
		Submission - allows them to submit their parking space for rent
		My Postings - allows them to see and manage the postings they've made
		Requests - allows them to see the requests they have for the postings they've made. -->
		<?php include 'nav.inc.php'?>
		<?php

			try{
				/* inserts the user inputted information into the parking databases once validation has succeeded */
				if(isset($_SESSION['isLoggedIn'])){
					$email = $_SESSION['user'];	
				if(isset($_POST["submit"]) && $canInsert==0){
					$uname = 'mostafa';
					$pass = 'test';

	                $conn = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
	                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                	$in = "INSERT INTO comp4ww3.parkings (name, latitude, longitude, imageurl, description, price, rating,  email) VALUES (?,?,?,?,?,?,?,?) " ;           
					$stmt = $conn->prepare($in);
                	$stmt->execute([$_POST['spotName'], floatval($_POST['latitude']),floatval($_POST['longitude']), $_POST['img'], $_POST['descrip'], floatval($_POST['price']), (int)5, $email]);
               			header('Location: https://shaha8.comp4ww3.com/submitted.php');
		}	
				}
                
	         }
              catch(PDOException $e){
                echo $e->getMessage();
              }
		?>
		<form method="post" name="submission" onsubmit="return submissionVal(this)" action="submission.php">
			<!-- the error messages are inputted so the user can correct their mistake(s), as well as their previously inputted values are retained -->
				<div >
					<label class="label">Name of Spot</label> 
					<input id="name" class="input" type="text" name="spotName" required value="<?php if(isset($_POST['spotName'])){echo htmlspecialchars($_POST['spotName']);} ?>"><span class="spanErr">* <?php echo $nameErr;?></span><br> 
				</div><br>
				<div>
					<label class="label">Latitude</label>
					<input class="input" type="text" name="latitude" id="lat" required value="<?php if(isset($_POST['latitude'])){echo htmlspecialchars($_POST['latitude']);} ?>"><span class="spanErr">* <?php echo $latErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Longitude</label>
					<input class="input" type="text" name="longitude" id="long" required value="<?php if(isset($_POST['longitude'])){echo htmlspecialchars($_POST['longitude']);} ?>"><span class="spanErr">* <?php echo $longErr;?></span>
				</div>

				<button class ="button" type="button" name="Location" onclick="getLocation()">Detect Location</button> <br> <br>

				<div>
					<label class="label">Price</label>
					<input id="price" class="input" type="number" name="price" required value="<?php if(isset($_POST['price'])){echo htmlspecialchars($_POST['price']);} ?>"><span class="spanErr">* <?php echo $priceErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Image Upload</label>
					<input name="img" class="input" type="file" name="image"><br>
				</div><br>
				<div>
					<label class="label">Description</label>
					<textarea name="descrip" class="textarea" rows="4" ><?php if(isset($_POST['descrip'])){echo htmlspecialchars($_POST['descrip']);} ?></textarea>
				</div>
				<input class="button" type="submit" value="Post" name="submit">
			

		</form>
		<!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
		<?php include 'footer.inc.php'?>

	</body>

	<script type="text/javascript" src="javascript.js"></script>

</html>
