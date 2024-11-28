<?php
session_start();
$db = require __DIR__ . "/../database/database.php";

// Getting the email from the session
$email = $_SESSION['email'];

// Redirecting if no session is set
if(!isset($_SESSION['email'])){
    header("location: register.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Responsive Behaviour for Mobile users -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Linking Bootstrap to the html file -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        
        <!-- Linking the css styling to the html file -->
        <link rel="stylesheet" href="../../css/index.css">

        <title>Meeting Scheduler - Attendee List</title>
    </head>

    <body>
        <!-- Create a side navigation bar -->
        <div class="navigation-bar">
            <nav class="nav">

                <!-- Logo -->
                <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['fname'];?>
                        </a>
                    
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="../database/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>

                <!-- List of all different accessible pages -->
                <div class="items-list">

                    <!-- Dashboard -->
                    <a href="dashboard.php" class="items">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg>
                        
                        <p class="items-title">
                            Dashboard
                        </p>
                    </a>

                    <!-- Meeting -->
                    <a href="meetings.php" class="items">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5zm11.5 5.175 3.5 1.556V4.269l-3.5 1.556v4.35zM2 4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H2z"/>
                        </svg>

                        <p class="items-title">
                            Create Meetings
                        </p>
                    </a>

                    <!-- History -->
                    <a href="history.php" class="items">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>

                        <p class="items-title">
                            History
                        </p>
                    </a>
                </div>
            </nav>
        </div>

		<!-- Title of the page -->
        <h1>Attendee List</h1>

		<!-- Creating a table for the attendee details -->
        <h1 class="modal-title fs-5" id="exampleModalLabel">Meeting Attendees</h1>
        <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">First</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Attended</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $detailsQuery = "SELECT a.Firstname, a.Lastname, a.Email, s.AttendanceStatus FROM accounts a JOIN attendee s ON s.MeetingMeetingID = '".$_SESSION['MeetingID']."' AND s.AccountsUserID = a.UserID;";
                    $details = $db->query($detailsQuery); 
                    ?>
                    
                    <?php while ($col = mysqli_fetch_array($details)) { ?>
                        <tr>
                            <td><?php echo $col['Firstname']; ?></td>
                            <td><?php echo $col['Lastname']; ?></td>
                            <td><?php echo $col['Email']; ?></td>
                            <td><?php echo $col['AttendanceStatus']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>