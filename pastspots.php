<!DOCTYPE html>
<!--Constitutes the code that produces the past spots page of the app - the page that contains 
    the historical data of the places the user has used 
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


    <title> Past Spots </title>

  </head >

  <!-- Past Spots page contains a navigation bar that let's them access pages as a user or as an owner. The Previously Used 
        page contains information of all the spots the user has booked. It contains a table of the spot's Name, Geographical Coordinates, 
        Price, Image (if available), Rating, and the option for the user to review the spot. The "Write a Review" portion is a clickable link
        that will redirect the user to a review form. The page also contains a "Sign Out" button, which will lead the user
        back to the Welcome page. -->

  <body >
    <?php require 'loggedInCheck.inc.php'; ?>
    <header class="h1Global">
      <div> 
        <button class="signout" onclick="location.href='logout.php'">Sign Out</button>
        <h1> Previously Used </h1>    
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
        <tr>
          <th class="th">Name</th>
          <th class="th">Latitude</th>
          <th class="th">Longitude</th>
          <th class="th">Price</th>
          <th class="th">Image</th>
          <th class="th">Rating</th>
          <th class="th">Review</th>
        </tr>
     
          <?php
            try{
              /*the corresponding id to parkings is pulled from the pastspots databases (so it can pull info based on which user is logged in) */
          		if(isset($_SESSION['isLoggedIn'])){
          		  $email = $_SESSION['user'];
                $pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
                $result = $pdo->prepare("SELECT s_id FROM comp4ww3.pastspots WHERE email =?" );
                $result->execute([$email]);
                $id = [];
                $i = 0;
		            while($row = $result->fetch()){
                  $id[$i] = $row['s_id'];
                  $i = $i + 1;                  
		          }
            }
}
            catch(PDOException $e){
              echo $e->getMessage();
            }
          ?>
            <?php
            try{
              /*the table renders depending on the amount of spots the user has used */
                $pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		            for($x = 0; $x < sizeof($id); $x++){
                $result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE id =?");
		            $result->execute([$id[$x]]);
                while($row = $result->fetch()){
                  $pid = $row['id'];
                  $name = $row['name'];
                  $lat = $row['latitude'];
                  $long = $row['longitude'];
                  $price = $row['price'];
                  $img = $row['imageurl'];
                  $description = $row['description'];
              
                  echo '<tr><td id=parkName class=td><a href="parking.php?id=', $pid, '">', $name, '</a></td>';
                  echo "<td id='resultLat' class='td'>", $lat, "</td>";
                  echo "<td id='resultLong' class='td'>", $long, "</td>";
                  echo "<td id='price' class='td'>", $price, "</td>";
                  echo "<td id='img' class='td'>", $img, "</td>";
                  echo "<td id='rating' class='td'>", $row['description'], "</td>";
		              echo '<td id=parkName class=td><a href=review.php?id=', $pid,'>Write A Review</a></button></td>';
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
