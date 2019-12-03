<!DOCTYPE html>
<!--Constitutes the code that produces the owner's (user's) postings page of the app - the page that contains 
    the list and information of the postings the user has made to the website.
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


    <title> My Postings </title>

  </head >

  <!-- My Postings page contains a navigation bar that let's them access pages as a user or as an owner. My Postings 
        page shows the postings the user has made available (as the owner). The contents are produced in a table format 
        and show information of the posting such as the post's Name, Geographical Location, Price, Image(if available), 
        Description, and the Reservation Requests that are pending. The Reservation Requests is a clickable link that will 
        lead user to the page that contains the requests. The page also contains a "Sign Out" button, which will lead the user
        back to the Welcome page.-->

  <body >   
  <?php require 'loggedInCheck.inc.php'; ?>


    <header class="h1Global">
      <div> 
        <button class="signout" onclick="location.href='logout.php'">Sign Out</button> 
      <h1> My Postings </h1>    
    </div>

    </header>
    <!--Profile - allows them to return to their profile (main page)
      Search - allows the search for parking spots
      Past Spots - allows them to look at all the places they've used
      Submission - allows them to submit their parking space for rent
      My Postings - allows them to see and manage the postings they've made
      Requests - allows them to see the requests they have for the postings they've made. -->
    <?php include 'nav.inc.php'?>

    <div>

      <table class="table">
        <tr >
          <th class="th">Name</th>
          <th class="th">Latitude</th>
          <th class="th">Longitude</th>
          <th class="th">Price</th>
          <th class="th">Image</th>
          <th class="th">Description</th>
          <th class="th">Reservation Requests</th>
        </tr>
        
	  <?php
    /* each posting made by the user is printed to the screen in the form of a table*/
            try{
            		
            		if(isset($_SESSION['isLoggedIn'])){
                    $pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		            $email = $_SESSION['user'];	 
                    $result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE email =?" );
		                $result->execute([$email]);
                    while($row = $result->fetch()){
                      $id = $row['id'];
                			$name = $row['name'];

    		              echo '<tr><td id=spotname class=td><a href="parking.php?id=', $id, '">', $name , ' </a></td>';
    				          echo "<td id='resultLat' class='td'>", $row['latitude'], "</td>";
              			  echo "<td id='resultLong' class='td'>", $row['longitude'], "</td>";
              			  echo "<td id='price' class='td'>", $row['price'], "</td>";
              			  echo "<td id='img' class='td'>", $row['imageurl'], "</td>";
              			  echo "<td id='description' class='td'>", $row['description'], "</td>";
                      echo '<td id=spotname class=td><a href="requests.php?id=', $id, '">Requests </a></td></tr>';
    	               }
		              }
              }
              catch(PDOException $e){
                echo $e->getMessage();
              }
            ?>
         

      </table>
    </div>

    <!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
    <?php include 'footer.inc.php'?>



  </body>


</html>
