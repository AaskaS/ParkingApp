/*This files handles all client side validation of the webpages. As well as adding a map to the pages*/



//allows the browser to get the user's current location (lat & long), if user gives permission
function getLocation() {
	//if the browser supports geolocation
	if (navigator.geolocation) {
		//if successful -> userLoc
		//otherwise it outputs error
		navigator.geolocation.getCurrentPosition(userLoc, err);	
    }
}

//determines the user's lat + long and fills it into the respective textboxes 
function userLoc(position){
	lat = position.coords.latitude;
    long = position.coords.longitude;
	document.getElementById("lat").value = lat;	
	document.getElementById("long").value = long;
}

//if the user deny's location service or any other error is triggered, the error is outputted to the console
function err(error){
	console.log("Location Unavailable " + error);
}


//the validation for the registration (register.html)
function registerVal(form){
	// first name, last name must not be left blank
    if (form.firstname.value == "") {
    	 window.alert("Name must be filled out");
         return false;
    }

    if (form.lastname.value == "") {
    	 window.alert("Name must be filled out");
         return false;
    }

    // the email must contain a '@'. as well as a '.' at the end
    if(!(/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(form.useremail.value))){
 		window.alert("Email must be filled out correctly");
        return false;
    }

    //phone number and date must be of correct length
    if(form.phone.value.length != 10){
    	window.alert("Incorrect phone number format");
    	return false;
    }
 	if(form.userbirthday.value.length != 10){
 		window.alert("Incorrect date format");
 		return false;

 	}

 	//the password length must be greater than 8 as well as must match with the confirm password
	if(form.userpassword.value.length < 8){
		window.alert("Password not long enough. Must be at least 8 characters.");
		return false;
	}

  	if(form.userpassword.value != form.userpasswordconf.value){
 		window.alert("Passwords do not match");
        return false;
    }

    return true;
}

//validation for the signin page (signin.html)
function signinVal(form){

	// the email must contain a '@'. as well as a '.' at the end
    if(!(/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(form.useremail.value))){
		window.alert("Email must be filled out correctly");
    	return false;
    }
    //password must be of correct length
    if(form.userpassword.value.length < 8){
		window.alert("Incorrect password.")
		return false;
	}

}


//validation for the submission page (submission.html)
function submissionVal(form){
	
	//the lat and long must be formatted correctly and must be valid
	if(!(/^[-+]?[0-9]+.[0-9]+?$/.test(form.latitude.value))){
		window.alert("Incorrect Latitude Format");
		return false;
	}
	if(!(/^[-+]?[0-9]+.[0-9]+?$/.test(form.longitude.value))){
		window.alert("Incorrect Longitude Format");
		return false;
	}

	// the price point cannot be less than 0 or greater than 1000
	if(form.price.value > 1000 || form.price.value <= 0){
		window.alert("Price value incorrect");
		return false;
	}
	

}

//validation for the search page (search.html)
function searchVal(form){
	//the lat and long must be formatted correctly and must be valid
	if(!(/^[-+]?[0-9]+.[0-9]+?$/.test(form.latitude.value))){
		window.alert("Incorrect Latitude Format");
		return false;
	}
	if(!(/^[-+]?[0-9]+.[0-9]+?$/.test(form.longitude.value))){
		window.alert("Incorrect Longitude Format");
		return false;
	}

	//the distance cannot be greater than 12km
	if(form.distance.value >= 12){
		window.alert("Distance value incorrect");
		return false;
	}

	//the serach price point must be greater than 0
	if(form.rg_disp.value <= 0){
		window.alert("Enter Price");
		return false;
	}


}



