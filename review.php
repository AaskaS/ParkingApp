<!DOCTYPE html>
<!--Constitutes the code that produces the review page of the app - the page that contains the form 
	used to review a parking spot
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


		<title> Review </title>

	</head >
	<!-- Review page contains a navigation bar that let's them access pages as a user or as an owner. Review page 
  		includes input of the user's opinion on the parking spot they used such as User's Name, the Name of the Spot, their Rating, 
  		and a writen review of the spot. The page also contains a "Sign Out" button, which will lead the user back 
  		to the Welcome page.-->
	<body >
		<?php require 'loggedInCheck.inc.php'; ?>
		<header class="h1Global">
			<div>
				<button class="signout" onclick="location.href='logout.php'">Sign Out</button> 	
				<h1> Review </h1>		
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
			/*this gets the user's name so they don't have to fill out that field in the form*/
					
				if(isset($_SESSION['isLoggedIn'])){
					$email = $_SESSION['user'];	
					$pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
	                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	       
	                $result = $pdo->prepare("SELECT fname FROM comp4ww3.register WHERE username =?");
	                $result->execute([$email]);
					$row = $result->fetch();
			  		$fname = $row['fname'];
			
					}
				}

				catch(PDOException $e){
				 	echo $e->getMessage();
				}
		?>
		<?php
        /*this gets the parking spot name (using GET from url) so the user doesn't have to fill out that field in the form*/
		    $id = $_GET["id"];	
        	    $pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
        	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	            $result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE id=? ");
		    $result->execute([$id]);
		    $row = $result->fetch();	
		    $spotname = $row['name'];
		 ?>              
	
		<?php
			try{
		/*this insert their review into the databases*/
			if(isset($_POST["review"])){
				$uname = 'mostafa';
				$pass = 'test';
	            $conn = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
	            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	            $current = $id;
	            $in = "INSERT INTO comp4ww3.reviews (p_id, value, customer, description) VALUES (?,?,?,?) " ;       
				$stmt = $conn->prepare($in);
				$review = $_POST['Stars'];
				$description = $_POST['description'];
	            $stmt->execute([$current, (int)$review, $fname, $description]);							
				
				}		
					
			}

			catch(PDOException $e){
			 	echo $e->getMessage();
			}
		?>

		<form method="post" action='review.php?id=<?php echo $id; ?>'>
		
			<div >
				<label class="label">Your Name</label> 
				<input class="input" type="text" name="username" required value ="<?php echo htmlspecialchars($fname); ?>"><br> 
			</div><br>
			<div >
				<label class="label">Name of Spot</label> 
				<input class="input" type="text" name="spotName" required value = "<?php echo htmlspecialchars($spotname); ?>"><br> 
			</div><br>
			<div>
				<label class="label">Stars</label>				
				<select class="input" name="Stars">
					
					<option value="1">1</option>
					
					<option value="2">2</option>
					
					<option value="3">3</option>
					
					<option value="4">4</option>
					
					<option value="5">5</option>
				</select><br>
			</div><br>

			<div>
				<label class="label">Description</label>
				<textarea class="textarea" rows="4" name="description"><?php if(isset($_POST['description'])){echo htmlspecialchars($_POST['description']);} ?></textarea>
			</div>
			<input class="button" type="submit" name="review"  value="Submit">
		

		</form>
		<!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
		<?php include 'footer.inc.php'?>
		

	</body>



</html>
