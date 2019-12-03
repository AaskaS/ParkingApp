<!DOCTYPE html>
<!--Constitutes the code that produces the user profile page of the app - the central place where the user manage 
	their account and navigate around to use the features.
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

		<title> Welcome User! </title>

	</head >

	<!-- User Profile, contains a navigation bar that let's them access pages as a user or as an owner. Shows them their basic information
			that they added when signing up for the account. This is also acts as the home page. The page also contains a "Sign Out" button, 
			which will lead the user back to the Welcome page. -->

	<body >
	  <?php require 'loggedInCheck.inc.php'; ?>

		<?php
		/*the profile is rendered dynamically dpending on whether it's the current user's profile or if it came from the another page which allows anyone's profile to be clicked
				the information is generated into a table and info is pulled from the register database*/
        	try{
				$uname = 'mostafa';
				$pass = 'test';
	            $pdo = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
	            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
				if(isset($_SESSION['isLoggedIn'])){
			
						
					if(!(empty($_POST['useremail']))){
						$email = $_POST['useremail'];			
					}
					else if(!(empty($_GET['useremail']))){
						$email = $_GET['useremail'];
					}
					else{
						$email = $_SESSION['user'] ;
					}
			        $result = $pdo->prepare("SELECT * FROM comp4ww3.register WHERE username=?" );
					$result->execute([$email]);
					$row = $result->fetch();
	            	$fname = $row['fname'];
	            	$lname = $row['lname'];
	            	$username = $row['username'];
	            	$phone = $row['phone'];
	            	$birthday = $row['birthday'];
				}		
          	}
	         catch(PDOException $e){
	            echo $e->getMessage();
	         }
        ?>
		<header class="h1Global">
			<div>	
				<button class="signout" onclick="location.href='logout.php'">Sign Out</button>	
				<h1 class="h1"><?php echo $fname,' ',  $lname; ?></h1>	
			</div>
		</header>

		<!--User Profile - allows the search for parking spots
		Past Spots - allows them to look at all the places they've used
		Submission - allows them to submit their parking space for rent
		My Postings - allows them to see and manage the postings they've made
		Requests - allows them to see the requests they have for the postings they've made. -->
		<?php include 'nav.inc.php'?>

		<div class="div"> 
		      
					
			      <table class="table">
        <tr>
          <th class="th">First Name</th>
          <th class="th"><?php echo $fname;?></th>
        </tr>
        <tr>
          <th class="th">Last Name</th>
          <th class="th"><?php echo $lname;?></th>
        </tr>
        <tr>
          <th class="th">Phone</th>
          <th class="th"><?php echo $phone;?></th>
        </tr>
        <tr>
          <th class="th">Email</th>
          <th class="th"><?php echo $email;?></th>
        </tr>
        <tr>
          <th class="th">Birthday</th>
          <th class="th"><?php echo $birthday;?></th>
        </tr>
      </table>
			

		</div>
		<!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
		<?php include 'footer.inc.php'?>

	</body>

</html>
