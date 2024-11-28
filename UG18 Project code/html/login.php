<?php
session_start();
require __DIR__ . "/database/database.php";

// Setting basic variables
$email = "";
$password = "";
$error = "";
$noErrors = 0;

// Referance: https://www.w3schools.com/php/php_form_required.asp
// Validating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["email-input"])) { 
		$error = "Email and password are required";
	}
	else {
		$email = security($_POST["email-input"]);
		$email = mysqli_real_escape_string($db, $email);
		$query = "SELECT Email FROM accounts WHERE email = '".$email."'";
		$result = $db->query($query);
		
        if($result->num_rows > 0) {
			$noErrors++;
		}
		else {
			$error = "Email or password is incorrect";
		}
	}

	if (empty($_POST["password-input"])) {
		$error = "Email and password are required";
	} 
	else {
		$password = mysqli_real_escape_string($db, $_POST["password-input"]);
		$password = md5(security($password));
		$query = "SELECT Password FROM accounts WHERE Password = '".$password."' and Email = '".$email."'";
		$result = $db->query($query);

        if ($result->num_rows > 0){
			$noErrors++;
		}
		else {
			$error = "Email or password is incorrect";
		}

	}

	// If there are no errors
	if ($noErrors ==2) {
        // Set session and go to main page
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
		<title>Meeting Maker - Login</title>

        <!-- Linking the css to the html file -->
        <link rel="stylesheet" href="../css/register.css" type="text/css">
	</head>

	<body> 
        <!-- Div containing all the registration labels and inputs -->
        <div class="registration-form">

            <!-- Creating a title for the from -->
            <div class="title">
                <header class="header-title">
                    <h1>
                        Login
                    </h1>
                </header>

                <!-- Creating the form to login to an account -->
                <form action="login.php" method="post">

                    <!-- Email text field -->
                    <div class="input">
                        <label for="email">Email:</label>
                        <input type="text" name="email-input" id="email-input">
                    </div>

                    <!-- Password text field -->
                    <div class="input">
                        <label for="password">Password:</label>
                        <input type="password" name="password-input" id="password-input">
                        <div><span class="error"><?php echo $error;?></span></div>
                    </div>
                    <div class="input">
                        <button class="register-button">
                            Login
                        </button>
                    </div>
                    
                </form>
                <div class="input">
                    <a href="register.php">
                        <button class="register-button">
                            Register
                        </button>
                     </a>
                </div>
            </div>
        </div>
	</body>
</html>