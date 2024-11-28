<?php
session_start();
require __DIR__ . "/database/database.php";

// Setting basic variables
$firstname = "";
$lastname = "";
$email = "";
$password = "";
$confirmpassword = "";

$firstnameErr = "";
$lastnameErr = "";
$emailErr = "";
$passwordErr = "";
$confirmpasswordErr = "";

$noerrors = 0;

// Referance: https://www.w3schools.com/php/php_form_required.asp
// Validating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["firstname-input"])) { 
		$firstnameErr = "First Name is required";
	}
	else {
		$firstname = security($_POST["firstname-input"]);
		$firstname = mysqli_real_escape_string($db, $firstname);
		
		if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
			$firstnameErr = "Only letters and white space allowed";
		}
		else {
			$noerrors++;
		}
	}
	
	if (empty($_POST["lastname-input"])) { 
		$lastnameErr = "Last name is required";
	}
	else {
		$lastname = security($_POST["lastname-input"]);
		$lastname = mysqli_real_escape_string($db, $lastname);
		
		if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
			$lastnameErr = "Only letters and white space allowed";
		}
		else {
			$noerrors++;
		}
	}
	
	if (empty($_POST["email-input"])) {
		$emailErr = "Email is required";
	} 
	else {
		$email = security($_POST["email-input"]);
		$email = mysqli_real_escape_string($db, $email);
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
		}
        
		$query = "SELECT email FROM accounts WHERE Email = '".$email."'";
		$result = $db->query($query);
		
		if($result->num_rows > 0) {
			$emailErr = "The email has already been taken.";
		}
		else {
			$noerrors++;
		}
	}
	
	if (empty($_POST["password-input"])) {
		$passErr = "Password is required and must match confirmation";
	} 
	else {
		$password = security($_POST["password-input"]);
		$password = mysqli_real_escape_string($db, $password);
		$confirmpassword = security($_POST["confirm-password-input"]);
		
		if (strcmp($password, $confirmpassword) != 0){
			$confirmpasswordErr = "Password doesn't match";
		}
		else {
			$noerrors++;
		}
			}

		// Continue to the main page and register
		
		if ($noerrors == 4) {
			$passHash = md5($password);
			$query = "INSERT INTO accounts(Password,Email,Firstname,Lastname) 
			VALUES ('$passHash','$email','$firstname','$lastname')";
			$result = $db->query($query);
			$_SESSION['email'] = $email;
			header('location: meetingmaker/dashboard.php');
		}
}


// Cleaning the data to prevent security issues, reference: https://www.w3schools.com/php/php_form_validation.asp
function security($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}	
?>

<!DOCTYPE html>
<html>
	<head>
        <!-- Title of the page -->
		<title>Meeting Maker - Register</title>

        <!-- Linking the css to the html file -->
        <link rel="stylesheet" href="../css/register.css" type="text/css">
	</head>

	<body> 
        <!-- Div containing all the registration labels and inputs -->
        <div class="registration-form">

            <!-- Creating a title for the register from -->
            <div class="title">
                <header class="header-title">
                    <h1>
                        Register
                    </h1>
                </header>

                <!-- Creating the form to register an account -->
                <form method="post" action="register.php" id="signup">

                    <!-- Firstname text field -->
                    <div class="input">
                        <label for="firstname">Firstname:</label>
                        <input type="text" name="firstname-input" id="firstname-input">
                        <div><span class="error"><?php echo $firstnameErr;?></span></div>
                    </div>

                    <!-- Lastname text field -->
                    <div class="input">
                        <label for="lastname">Lastname:</label>
                        <input type="text" name="lastname-input" id="lastname-input">
                        <div><span class="error"><?php echo $lastnameErr;?></span></div>
                    </div>

                    <!-- Email text field -->
                    <div class="input">
                        <label for="email">Email:</label>
                        <input type="text" name="email-input" id="email-input">
                        <div><span class="error"><?php echo $emailErr;?></span></div>
                    </div>

                    <!-- Password text field -->
                    <div class="input">
                        <label for="password">Password:</label>
                        <input type="password" name="password-input" id="password-input" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
				  			title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters">
                    <div><span class="error"><?php echo $passwordErr;?></span></div>
                    </div>
                    <!-- Confirm Password text field -->
                    <div class="input">
                        <label for="password">Confirm Password:</label>
                        <input type="password" name="confirm-password-input" id="confirm-password-input">
                        <div><span class="error"><?php echo $confirmpasswordErr;?></span></div>
                    </div>

                    <!-- Register button to create the account -->
                    <div class="input"> 
                        <button class="register-button" type="submit">
                            Register
                        </button>
                    </div>
                </form>
                <div class="input">
                    <a href="login.php">
                        <button class="register-button">
                            Login
                        </button>
                     </a>
                </div>
            </div>
        </div>
	</body>
</html>