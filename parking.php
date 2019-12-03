<!DOCTYPE html>
<!--Constitutes the code that produces the mock parking page of the app - this is a mock page of 
	a potential parking spot that fits within the parameter of the set user input. This page also doubles 
	as an item that the owner (user) has submitted, which mean it will show up under MyPostings page.
   All classes used are defined in the style.css file-->
<html lang="en">
	<head>
	<!-- This imports the style sheets used for the formatting of the page as well as the icons-->
		<link rel="stylesheet" type="text/css" href="reset.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/> 
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" 
   integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin=""></script>

		<!-- declares the view of the user depending on the type of device they're using-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0"/>


	
		<title> Parking Spot </title>

	</head >

  <!-- Parking page contains a navigation bar that let's them access pages as a user or as an owner. 
	  The parking spot shows a picture of the place (if available), location, the average review, and the individual 
	  reviews (and comments) given by the previous users. TThe page also contains a "Sign Out" and "Request This Spot"button. 
	  Sign out button will lead the user back to the Welcome page.-->

	<body >
		<?php require 'loggedInCheck.inc.php'; ?>
		<?php
		/* the parking page is dynamically rendered depending on the id received by the "GET" method, pulled from the parkings databases*/
				try{
					$pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
				  	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 	$id = $_GET['id'];
				  	$result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE id=?" );
				    $result->execute([$id]); 
					$row=$result->fetch();
	
				    $name = $row['name'];
        			$lat = $row['latitude'];
        			$long = $row['longitude'];
        			$price = $row['price'];
        			$img = $row['imageurl'];
        			$rating = $row['rating'];
        			$description = $row['description'];					
				  	
				}
				catch(PDOException $e){
				 	echo $e->getMessage();
				}
			?>			
		<header class="h1Global">
			<div>	
				<button class="signout" onclick="location.href='logout.php'">Sign Out</button>
				<h1><?php echo $row['name'] ?> </h1>		
			</div>

		</header>

	    <!--Profile - allows them to return to their profile (main page)
		Search - allows the search for parking spots
	    Past Spots - allows them to look at all the places they've used
	    Submission - allows them to submit their parking space for rent
	    My Postings - allows them to see and manage the postings they've made
	    Requests - allows them to see the requests they have for the postings they've made. -->
		<?php include 'nav.inc.php'?>

		<div class="parkingdiv">
					
			<label class="parkinglabel">Average User Ratings</label>
				<?php
				/*the rating is pulled from the parkings databases*/
					for($i=0; $i<$row['rating']; $i++){
						echo "<i class='fas fa-star i'></i>";
					}
				?>
					
		</div>

		<img class="img" src=<?php echo $img ?> alt="Picture of the parking spot"/>
		<div class="parkinglocation" id="mapid"  ></div> 
		<!--<img  class="parkinglocation" src="https://www.google.ca/maps/vt/data=sC7NzukVoXLy3iO-ObCMU5B4T_HuShQDMEkLpXiAf-rg-mUBn2dkIdYS8NPdz9Q0td8T-gZt_LAHIgEHtgeLB3tg80BiCEQzQqDiC3n9c0GdaebMyJtQSGvFGbA4keJYgj5kSicQ0mktQHfk7qyHtQ-I5w" alt="Location of the parking spot on a map"/> -->


		<dl class="reviewList">
			<?php
			/* the parking page reviews are rendered depending on the id of the posting and pulled from the reviews databases */
				try{
					$pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
				  	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				 
				  	$result = $pdo->prepare("SELECT * FROM comp4ww3.reviews WHERE p_id =?");
					$result->execute([$row['id']]);
				  
				  	while($row=$result->fetch()){
				  	
						echo "<dt>";
						echo "<i class='fas fa-car car'></i>";
						for($i=0; $i < $row['value']; $i++){
							echo "<i class='fas fa-star i parkingreviewI'></i>";
						}
						echo "</dt>";
						echo "<dd class='p'>", $row['customer'], " -</dd>";
						echo "<dd class='p'>", $row['description'], "</dd>";
				  	}
				}
				catch(PDOException $e){
				 	echo $e->getMessage();
				}
			?>

		</dl>

		<?php
			try{
				/* the name of the user is pulled from the register databases to use for the request query*/
					
				if(isset($_SESSION['isLoggedIn'])){
					$email = $_SESSION['user'];			
					$pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
	                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	       
	                $result = $pdo->prepare("SELECT *  FROM comp4ww3.register WHERE username =?");
					$result->execute([$email]);
	                $row = $result->fetch();
	  				$fname = $row['fname'];
					$lname = $row['lname'];		
					
				}
			}	

			catch(PDOException $e){
			 	echo $e->getMessage();
			}

		?>
		<?php
			try{
				/*allows the user to request the parking spot*/
				if(isset($_POST["request"])){
					$uname = 'mostafa';
					$pass = 'test';
			        $conn = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
			        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			        $current = $_GET['id'];
			        $in = "INSERT INTO comp4ww3.requests (r_id, customer, email) VALUES (?,?,?) " ;            
					$stmt = $conn->prepare($in);
					$full = $fname." ".$lname;
			        $stmt->execute([$current, $full , $email]);		            					
					echo "<form  method=post action=parking.php?id=" , $id , ">";
					echo "<input class=requestparking type=submit name=request  value=RequestSubmitted>";
					}
				else{
					echo "<form  method=post action=parking.php?id=" , $id , ">";
					echo "<input class=requestparking type=submit name=request  value=Request>";
				}
				/*allows the user to write a review for this posting*/
				echo '<br><a href=review.php?id=', $id,'>Write A Review</a>';
					
			}

			catch(PDOException $e){
			 	echo $e->getMessage();
			}
		?>

         

		<!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
		<?php include 'footer.inc.php'?>

	</body>

	
		

	<script type="text/javascript">
	// the php variables are converted to js variables and outputted to the marker pop up
		var lati = "<?php echo $lat; ?>"; 
		var longi = "<?php echo $long; ?>";
		var price = "<?php echo $price; ?>";
		var rating = "<?php echo $rating;?>";
		var name = "<?php echo $name; ?>";
		console.log(lati + " WHY WON'T YOU WORK");

		var mymap = L.map("mapid", {
		center: [lati, longi],
		zoom: 12
		});

		//access token is unique to the programmer's account
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			maxZoom: 20,
			id: 'mapbox.streets',
			accessToken: 'pk.eyJ1IjoiYWFza2EiLCJhIjoiY2pueTFtNWtnMHo3ZDN3a2JtdHR0cTBqcSJ9.TRapLHZGoxyC5B87Xnw7hA'
		}).addTo(mymap);

		function marker(lat, long, place ){
			//places the marker on the map & on click shows a pop up with info
			var marker = L.marker([lat, long]).addTo(mymap); 
			    
			marker.bindPopup(place);
		}
		// the posting's location shows up as a marker on a dynamic map
		if(document.getElementById("mapid")){
			marker(lati,longi, '<label>'+name + '</label><br>'+ '<label>Rating:' + rating+ '</label><br>' + '<label>Price:' + price + '</label>');

		}

	</script>

</html>
