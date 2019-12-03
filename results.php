<!DOCTYPE html>
<!--Constitutes the code that produces the results page of the app - this is the place that produces the parking spots 
    that are within the parameters that the user has chosen from the search page as filters.
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


    <title> Results </title>

  </head >

  <!-- Results page contains a navigation bar that let's them access pages as a user or as an owner. The results page shows 
    all available postings that are within the user's search range. The contents are produced as a table and show information 
    such as "Name", "Latitude", "Longitude", "Price", "Image", "Rating", and "Description of the spot. All spots are shown on 
    the map at the bottom of the page. The page also contains a "Sign Out" button, which will lead the user back to the Welcome page.-->

  <body >
    <?php require 'loggedInCheck.inc.php'; ?>
    <header class="h1Global">
      <div> 
        <button class="signout" onclick="location.href='logout.php'">Sign Out</button>
        <h1> Results </h1>    
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
          <th class="th">Description</th>
        </tr>
        <?php
          /* the results are achieved by taking into account the user choice in price and rating, all the rows that match are printed into a table*/
            try{
          		$uname = 'mostafa';
          		$pass = 'test';
              $pdo = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 
              $result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE price <=?  AND rating=?");
	            $result->execute([$_POST["searchRange"], $_POST["Stars"]]);
          		$ids = [];
          		$names = [];
          		$lats = [];
          		$longs = [];
          		$prices = [];
          		$ratings = [];          	
          		$i = 0;

              while($row = $result->fetch()){
                /*arrays are initiated to hold all the information of every posting that matches user choices so they can show up on a dynamic map
                  can click on the parking spot and it will take you to that parking page*/
        				$id = $row['id'];
        				$ids[$i] = $id;
            		$names[$i] = $row['name'];
				        $lats[$i] = $row['latitude'];
          			$longs[$i] = $row['longitude'];
          			$prices[$i] = $row['price'];
          			$img = $row['imageurl'];
          			$ratings[$i] = $row['rating'];
            		
										
			
	              echo '<td id=spotname class=td><a href="parking.php?id=', $id, '">', $row['name'] , ' </a></td>';
			          echo "<td id=resultLat class=td>", $row['latitude'], "</td>";
        			  echo "<td id=resultLong class=td>", $row['longitude'], "</td>";
        			  echo "<td id=price class=td>", $row['price'], "</td>";
        			  echo "<td id=img class=td>", $row['imageurl'], "</td>";
        			  echo "<td id=rate class=td>", $row['rating'], "</td>";
        			  echo "<td id=description class=td>", $row['description'], "</td></tr>";
             		$i = $i + 1;
		          }
		        
            }
            catch(PDOException $e){
              echo $e->getMessage();
            }
        ?>


      </table>
    </div>
   

    <div class="resultimg" id="mapid" ></div> 
    <!-- The footer of the webpage, if clicked on it will send the user to the main page (their profile) -->
    <footer class="footer">   
      <button class="parkButton" onclick="location.href='userprofile.php'"><i class="fas fa-home pi"></i></button>
    </footer>


  </body>

  <script type="text/javascript">
  // the php arrays are converted to js arrays and outputted to the marker pop up
  	var lati = <?php echo json_encode($lats); ?>;
  	var longi = <?php echo json_encode($longs); ?>;
  	var price =  <?php echo json_encode($prices); ?>;
  	var rating = <?php echo json_encode($ratings); ?>;
  	var name = <?php echo json_encode($names); ?>;
  	var id = <?php echo json_encode($ids); ?>;
  	var newname = [];
  	var word = "";
  	for(var i = 0; i < name.length; i++){
  		if(name[i] != ',' && i != (name.length-1)){
  		  word = word + name[i];	
  		}	
  		else{
  			if(i==(name.length-1)){
  				word = word + name[i];
  			}
  		  newname.push(word);
  		  word = "";
  		}
  	}
  	console.log("LOL " + newname[2]);
  	var mymap = L.map("mapid", {
  	center: [parseFloat(lati[0]), parseFloat(longi[0])],
  	zoom: 10
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
	
	// all results are shown as markers on a dynamic map, can click on that parking spot and it will take you to it's page
	for(var i = 0; i < id.length; i++){
		if(document.getElementById("mapid")){
			marker(parseFloat(lati[i]),parseFloat(longi[i]),'<a href=parking.php?id='+id[i]+'>' + newname[i] + '</a><br>' +  
			   '<label>Rating: ' + rating[i] + '</label><br>' + '<label>Price: ' + price[i] + '</label><br>'  );
	 }
	}
	






</script>

</html>
