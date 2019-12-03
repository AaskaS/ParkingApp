<!DOCTYPE html>
<!--Constitutes the code that produces the sign in page of the app - the place where the user will use to get access to their account.
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


		<title> Sign In </title>

	</head >
	<!-- The Sign In page includes two inputs - email & password. After the user enters their credentials, the "Log In" button will lead them to their profile-->
	<body >
		<?php
			$useremailErr = "";
			$userpasswordErr="";
			/* this is where the user input is validated before allowing them to log in
				it checks for the correct username as well as the correct hash of the salt and the user-inputted password
				after a successful validation, the user is taken to their profile */
			if(isset($_POST['login'])){
				
				$uname = "mostafa";
				$pass = "test";
				$pdo = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
		        	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$email = $_POST['user'];
				
				$userpass = $_POST['userpassword'];
				$result = $pdo->prepare("SELECT * FROM comp4ww3.users WHERE username=?");
				$result->execute([$email]);
		        	$row = $result->fetch();
				
				$salt = $row['salt'];
				$passhash = $row['passwordhash'];
	
				if(sizeof($row) == 1){
					$useremailErr = "* Username+Password Combo unmatched";
				}
				if(empty($email)){
					$useremailErr = "* Please enter email";
				}
				if(empty($passhash)){
					$userpasswordErr = "* Please enter password";
				}
				else{	
					if( (hash("sha256", $userpass.$salt)) != $passhash){
						$userpasswordErr = "* Username+Password Combo unmatched";
					}
					else{
						session_start();
						$_SESSION['isLoggedIn'] = true;
						$_SESSION['user'] = $email;
						header('Location: https://shaha8.comp4ww3.com/userprofile.php');
						
					}
				}	
					
				
			}
			
				
		
		

		?>
			<header class="h1Global" >
			<div>	
				<h1> Sign In </h1>		
			</div>
		</header>

		<form method="POST" onsubmit="return signinVal(this)" action="signin.php">
			
				<div>
					<label class="label">Email</label>
					<input class="input" type="email" name="user" required value="<?php if(isset($_POST['user'])){echo htmlspecialchars($_POST['user']);} ?>"><span class="spanErr"> <?php echo $useremailErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Password</label>
					<input class="input" type="password" name="userpassword" ><span class="spanErr"> <?php echo  $userpasswordErr;?></span><br>
				</div>
				<input class="button" type="submit" name="login"  value="Log In" ><br> 
			
		</form>



	</body>

</html>
