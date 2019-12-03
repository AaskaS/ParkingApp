<!DOCTYPE html>
<!--Constitutes the code that produces the register page of the app - the place where the user will use create an account.
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


		<title> Registration Successful </title>

	</head >
	<!-- The registration page success page appears once the user's new account is made, it let's them either go to the login page or to the home screen -->
	<body >
		<header class="h1Global" >
			<div>	
				<h1> Registration Successful </h1>		
			</div>
		</header>
			
		
		
			<div >
				<input class="button" type="submit" value="Log In" onclick="location.href='signin.php'" >
				<input class="button" type="submit" value="Home"  onclick="location.href='welcome.html'" > 
			</div><br>
		
		


	</body>
	<script type="text/javascript" src="javascript.js"></script>
</html>
