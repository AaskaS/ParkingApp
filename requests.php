<!DOCTYPE html>
<!--Constitutes the code that produces the owner's (user's) spot requests page of the app - the page that contains 
    the requests made by other users to rent the parking spot.
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


    <title> Parking Requests </title>

  </head >


  <!-- Request page contains a navigation bar that let's them access pages as a user or as an owner. Request page 
      includes a clickable link to the spot requested, a clickable link to the public profile of the user requesting the use of the spot, 
      the email of the requester as well as the owner's (user) ability to accept/request.The page also contains a "Sign Out" button, 
      which will lead the user back to the Welcome page.-->
  <body > 
    <?php require 'loggedInCheck.inc.php'; ?>
    <header class="h1Global">
      <div> 
        <button class="signout" onclick="location.href='logout.php'">Sign Out</button>
      <h1> Parking Requests </h1>    
    </div>

    </header>

    <!-- Profile - allows them to return to their profile (main page)
    Search - allows the search for parking spots
    Past Spots - allows them to look at all the places they've used
    Submission - allows them to submit their parking space for rent
    My Postings - allows them to see and manage the postings they've made
    Requests - allows them to see the requests they have for the postings they've made. -->    
    <?php include 'nav.inc.php'?>

    <div>

      <table class="table">
        <tr>
          <th class="th">Requested Spot</th>
          <th class="th">Requester Name</th>
          <th class="th">Requester Email</th>
          <th class="th">Accept</th>
          <th class="th">Reject</th>

        </tr>
        
          <?php
            try{
              /*gets the parking spot information from the "GET" values in the URL*/
                $pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       		      $spotID = $_GET["id"];
                $result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE id =? ");
               	$result->execute([$_GET["id"]]);
		            $row = $result->fetch();		
                $name = $row['name'];
              }
              catch(PDOException $e){
                echo $e->getMessage();
              }
          ?>

          <?php
            try{
              /*by using the parking name and id, it renders a table that shows all requests for that spot, can click on the person who requested and it will take you to their profile*/
                $pdo = new PDO('mysql:localhost; dbname=comp4ww3', 'mostafa', 'test');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   	          $nw = $name;       
                $result = $pdo->prepare("SELECT * FROM comp4ww3.requests WHERE r_id =? ");
		            $result->execute([$_GET["id"]]);
                while($row = $result->fetch()){
		              $id = $row['id'];
                  $customer = $row['customer'];
                  $email = $row['email'];
                  echo '<tr><td id=parkName class=td><a href="parking.php?id=', $spotID, '">', $name, '</a></td>';
                  echo '<td name=useremail class=td><a href="userprofile.php?useremail=', $email, '">', $customer, '</a></td>';
                  echo "<td id=custEm class=td>", $email, "</td>";
                  echo "<td class=td><button class=reButton>Accept</button></td>";
                  echo "<td class=td><button class=reButton>Reject</button></td></tr>";
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
