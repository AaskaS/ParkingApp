<?php

	session_start();
	unset($_SESSION['user']);
 	unset($_SESSION['isLoggedIn']);
	header("Location: https://shaha8.comp4ww3.com/welcome.html");
    	exit();
?>
