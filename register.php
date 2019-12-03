
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


		<title> Register </title>

	</head >
	<!-- The registration page includes input of the user's basic information such  as Full Name, Email, Phone Number, Birthday and the 
		Password they would like to use for the app. The <form> tag allows a proper user input format -->
	<body >
	    <?php
	    /* the inputs are validated and it's ensured that the email doesn't already have an account associated with it */
	    $canInsert = 0;
 	    $insertPass = 0;     
      	$fnameErr =$lnameErr = $emailErr = $phoneErr = $birthdayErr = $userpasswordErr =$userpasswordconfErr = "";
      	$fname = $_POST["firstname"];
      	$lname = $_POST["lastname"];
      	$email = $_POST["useremail"];
      	$phone = $_POST["phone"];
      	$birthday = $_POST["userbirthday"];
      	$userpassword = $_POST["userpassword"];
      	$userpasswordconf = $_POST["userpasswordconf"];

      	if(isset($_POST["register"])){ 
      		/* the length of the first & last name must be only as long as the database would provide & must be filled in */
      		if(empty($fname) || strlen($fname) > 20){ 
      			$canInsert = $canInsert + 1;
      			$fnameErr = "First name error";
      		}   	

      		if(empty($lname) || strlen($lname) > 30){
      			$canInsert = $canInsert + 1;
      			$lnameErr = "Last name error";
      		}      		
      		/* email must be filled in and must not be longer than the databases can provide */
      		if(empty($email) || strlen($email) > 320){
      			$canInsert = $canInsert + 1;
      			$emailErr = "Email is required";
      		}
      		/* the phone number must be filled out and can only be 10 digits*/
      		if(empty($phone) || strlen($phone) != 10 ){
      			$canInsert = $canInsert + 1;
      			$phoneErr = "Phone is required, please use correct format";
      		}
    		/* the birthday must be filled out and can only be length of 10*/  		
      		if(empty($birthday) || strlen($birthday) != 10){
      			$canInsert = $canInsert + 1;
      			$birthdayErr = "Birthday is Required, please use correct format";
      		}
      		/* the password must be filled out and greater than 8 letters, must also match the confirm password*/
      		if(empty($userpassword) || strlen($userpassword) < 8){
      			$canInsert = $canInsert + 1;
      			$userpasswordErr = "Password is Required, please use correct format";
      		}
      		if (empty($userpasswordconf)) {
      			$canInsert = $canInsert + 1;
      			$userpasswordconfErr = "Confirmation is Required";
      		}
      		if($userpassword!=$userpasswordconf){
      			$canInsert = $canInsert + 1;
      			$userpasswordconfErr = "Passwords do not match";
      		}

      		/* this validates the email to ensure the account doesn't already exist */
      	
      		$uname = "mostafa";
	        $pass = "test";	       
        	$pdo = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
	        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $result = $pdo->prepare("SELECT * FROM comp4ww3.parkings WHERE email =?;");
			$result->execute([$email]);
	        $row = $result->fetch();
	        if(sizeof($row) > 1){
	        	$canInsert = $canInsert + 1;
	        	$emailErr = "Account exists under this email";
	        }
	}

	?>

	<?php
	/*if there are no validation errors, the new user object is inserted into the registration table (without their password information)*/
		if(isset($_POST["register"])){
			if($canInsert==0){
				$uname = "mostafa";
	        	$pass = "test";	       
        		$conn = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
	       		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        	$in = "INSERT INTO comp4ww3.register (username, fname, lname, phone, birthday) VALUES (?,?,?,?,?) " ;            
	       		 $stmt = $conn->prepare($in);
			$stmt->execute([$_POST['useremail'], $_POST['firstname'],$_POST['lastname'], $_POST['phone'], $_POST['userbirthday']]);	  
	        	$insertPass = 1;
	        
	       }
          }
       
       
    ?>
	<?php
	/*if there was a successful insertion into the registration table, the password is hashed and put into the user table & the user is taken to the success page for futher choices*/
		if($insertPass == 1){

			$uname = "mostafa";
			$pass = "test";
			$conn = new PDO('mysql:localhost; dbname=comp4ww3', $uname, $pass);
			$in = "INSERT INTO comp4ww3.users (username, salt, passwordhash) VALUES (?,?,?)" ;
			$stmt = $conn->prepare($in);
			$salt = 'WebDev2018';
			$stmt->execute([$email, $salt, hash("sha256",  $userpasswordconf.$salt)]); 
			header('Location: https://shaha8.comp4ww3.com/success.php');

		}
	?>
		<header class="h1Global" >
			<div>	
				<h1> Register </h1>		
			</div>
		</header>

		<form  method="post" name="register" onsubmit="return registerVal(this)" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
			
				<div >
					<label class="label">First Name</label> 
					<input class="input" type="text" name="firstname" required value="<?php if(isset($_POST['firstname'])){echo htmlspecialchars($_POST['firstname']);} ?>"><span class="spanErr">* <?php echo $fnameErr;?></span><br> 
				</div><br>
				<div>
					<label class="label">Last Name</label>
					<input class="input" type="text" name="lastname" required value="<?php if(isset($_POST['lastname'])){echo htmlspecialchars($_POST['lastname']);} ?>">><span class="spanErr">* <?php echo $lnameErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Email</label>
					<input class="input" type="email" name="useremail" required value="<?php if(isset($_POST['useremail'])){echo htmlspecialchars($_POST['useremail']);} ?>"><span class="spanErr">* <?php echo $emailErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Phone Number</label>
					<input class="input" type="tel" id="phonenum" name="phone" required value="<?php if(isset($_POST['phone'])){echo htmlspecialchars($_POST['phone']);} ?>"><span class="spanErr">* <?php echo $phoneErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Birthday</label>
					<input class="input" type="date"  name="userbirthday" required value="<?php if(isset($_POST['userbirthday'])){echo htmlspecialchars($_POST['userbirthday']);} ?>"><span class="spanErr">* <?php echo $birthdayErr;?></span><br>
				</div><br>
				<div>
					<label class="label">Password</label>
					<input class="input" type="password" name="userpassword" required ><span  class="spanErr">*<?php echo $userpasswordErr  ?></span><br>
				</div><br>
				<div>
					<label class="label">Confirm Password</label>
					<input class="input" type="password" name="userpasswordconf" required ><span  class="spanErr">*<?php echo  $userpasswordconfErr  ?></span><br>
				</div><br>
				<input class="button" name='register' type="submit" value="Register" >

		</form>
		


	</body>
	<script type="text/javascript" src="javascript.js"></script>
</html>
