<?php
session_start();
$db = require __DIR__ . "/../database/database.php";

// Getting the email from the session
$email = $_SESSION['email'];

// Redirecting if no session is set
if(!isset($_SESSION['email'])){
   header("location: register.php");
}

// Unsetting attendee sessions from create meeting page
unset($_SESSION['attendees']);

// Setting basic variables
$ID = 0;
$status= "";
$fname = "";
$_SESSION['fname'] = "";

// Fetching the users id
$IDquery = "SELECT UserID FROM accounts WHERE Email='".$email."';";
$IDUpdate = $db->query($IDquery);

while ($row = mysqli_fetch_array($IDUpdate)) { 
    $ID=$row['UserID'];
}


// Fetching the users firstname
$Namequery = "SELECT Firstname FROM accounts WHERE Email='".$email."';";
$NameUpdate = $db->query($Namequery);

while ($row = mysqli_fetch_array($NameUpdate)) { 
    $fname=$row['Firstname'];
    $_SESSION['fname'] = $fname;
}

// Add firstname to the session
$fname = $_SESSION['fname'];

// Start the meeting
if(isset($_POST['start'])) {
    $startQuery = "UPDATE meeting SET MeetingStatus = 'In Progress' WHERE MeetingID = '".$_POST['start']."';";
    $startUpdate = $db->query($startQuery);
    
    unset($_POST['start']);
}

// End the meeting
if(isset($_POST['finish'])){
    $finishQuery = "UPDATE meeting SET MeetingStatus = 'Finished' WHERE MeetingID = '".$_POST['finish']."';";
    $finishUpdate = $db->query($finishQuery);
    
    unset($_POST['finish']);
}

// Cancel the meeting
if(isset($_POST['cancel'])) {
    $cancelQuery = "DELETE FROM attendee WHERE MeetingMeetingID = '".$_POST['cancel']."';";
    $cancelResult = $db->query($cancelQuery);
    
    $cancelQuery2 = "DELETE FROM meeting WHERE MeetingID = '".$_POST['cancel']."';";
    $canceResult2 = $db->query($cancelQuery2);
    
    unset($_POST['cancel']);
}

// Marking the attendance of the user
if(isset($_POST['mark'])) {
    $userIDQuery = "SELECT UserID as user FROM accounts WHERE Email = '".$email."';";
    $userIDResult = $db->query($userIDQuery);
    $userID = mysqli_fetch_array($userIDResult);
    
    $markQuery = "UPDATE attendee SET AttendanceStatus = 'Attended' WHERE AccountsUserID = '".$userID['user']."' AND MeetingMeetingID = '".$_POST['mark']."';";
    $markUpdate = $db->query($markQuery);
    unset($_POST['mark']);
}

// Go to the attendees webpage
if(isset($_POST['attendees'])) {
    $_SESSION['MeetingID'] = $_POST['attendees'];
    header("location: attendeelist.php");
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

        <title>Meeting Scheduler - Dashboard</title>
    </head>

    <body>
        <!-- Create a side navigation bar -->
        <div class="navigation-bar">
            <nav class="nav">

                <!-- Logo -->
                <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $fname;?>
                        </a>
                    
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Account Info</a>
                            <a class="dropdown-item" href="../database/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>

                <!-- List of all different accessible pages -->
                <div class="items-list">

                    <!-- Dashboard -->
                    <a href="" class="items active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                        </svg>
                        
                        <p class="items-title">
                            Dashboard
                        </p>
                    </a>

                    <!-- Meeting -->
                    <a href="meetingsStepin.php" class="items">
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

		<!-- Title of the dashboard -->
        <h1>Dashboard</h1>

		<!-- Creating a table for the meeting details -->
        <table class="table caption-top">
            <caption>List of Meetings</caption>
            <thead>
                <tr>
                    <th scope="col">Meeting Name</th>
                    <th scope="col">Meeting Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Participants</th>
                    <th scope="col">Meeting Location</th>
                    <th scope="col">Information</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    $query = "SELECT MeetingName, MeetingStatus, MeetingTime, MeetingDate, MeetingLocation, MeetingID, AccountsUserID FROM meeting WHERE MeetingStatus != 'Finished' AND MeetingID IN (SELECT MeetingMeetingID FROM attendee WHERE AccountsUserID = '".$ID."');";
                    $result = $db->query($query);
                ?>

                <?php while ($row = mysqli_fetch_array($result)) { 
                    $MeetingID = $row['MeetingID'];
                    $Meetingstatus = $row['MeetingStatus'];
                    ?>
                    <tr>
                        <td><?php echo $row['MeetingName']; ?></td>
                        <td><?php echo $row['MeetingStatus']; ?></td>
                        <td><?php echo $row['MeetingDate']; ?></td>
                        <td><?php echo $row['MeetingTime']; ?></td>

                        <?php
                            $sql = "SELECT count(*) as total FROM attendee WHERE MeetingMeetingID = '".$row['MeetingID']."'";
                            $idCount = $db->query($sql);
                            $id = mysqli_fetch_array($idCount);
                            $detailsQuery = "SELECT a.Firstname, a.Lastname, a.Email, s.AttendanceStatus FROM accounts a JOIN attendee s ON s.MeetingMeetingID = '".$row['MeetingID']."' AND s.AccountsUserID = a.UserID;";
                            $details = $db->query($detailsQuery);
                        ?>

                        <td><?php echo $id['total']; ?></td>
                        <td><?php echo $row['MeetingLocation']; ?></td>
                        
                        <!-- Button trigger modal -->
                        <form method="post" >
                            <?php 
                               $statquery = "SELECT AttendanceStatus as att FROM attendee WHERE AccountsUserID = '".$ID."' AND MeetingMeetingID= '".$MeetingID."'";
                               $STATUpdate = $db->query($statquery);
                               $stat = mysqli_fetch_array($STATUpdate);
                                
                               if ($ID == $row['AccountsUserID']) {
                            ?>
                                <?php
                                    if($Meetingstatus=="Pending") {?>
                                        <td id="info-button"><button type="submit" class="btn btn-success" name="start" value=<?php echo $row['MeetingID'] ?>>Start Meeting</button></td>
                                <?php } ?>
                            
                                <?php 
                                    if($Meetingstatus=="In Progress"){ ?>
                                        <td id="info-button"><button type="submit" class="btn btn-success" name="finish" value=<?php echo $row['MeetingID'] ?>>Finish Meeting</button></td>
                                <?php } ?>
                                
                                <?php 
                                    if($Meetingstatus=="Pending"){ ?>
                                        <td id="info-button"><button type="submit" class="btn btn-danger" name="cancel" value=<?php echo $row['MeetingID'] ?>>Cancel Meeting</button></td>
                                <?php } ?>
                            
                            <?php } ?>
                            
                            <?php 
                                if($stat['att'] == "Unattended" && $Meetingstatus == "In Progress"){  ?>
                                    <td id="info-button"><button type="submit" class="btn btn-primary" name="mark" value=<?php echo $row['MeetingID'] ?>>Mark Attendance</button></td>
                            <?php } ?>
                            
                            <td id="info-button"><button type="submit" class="btn btn-primary" name="attendees" value=<?php echo $row['MeetingID'] ?> >Attendees</button></td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Meeting Details Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h1 class="modal-title text-center fs-5" id="exampleModalLabel">Account Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body text-center">
                        <?php
                            $fnameQuery = "SELECT Firstname as firstname FROM accounts WHERE Email = '".$email."';";
                            $fnameResult = $db->query($fnameQuery);
                            $fname = mysqli_fetch_array($fnameResult);

                            $lnameQuery = "SELECT Lastname as lastname FROM accounts WHERE Email = '".$email."';";
                            $lnameResult = $db->query($lnameQuery);
                            $lname = mysqli_fetch_array($lnameResult);
                        ?>

                        <!-- Display the users profile picture -->
                        <img src="../../assets/profile.jpg" width="100" height="100"/>

                        <!-- Displaying Users firstname -->
                        <h2 class="fs-5">Firstname</h2>
                        <p><?php echo $fname['firstname']?></p>

                        <!-- Displaying Users lastname -->
                        <h2 class="fs-5">Lastname</h2>
                        <p><?php echo $lname['lastname']?></p>

                        <!-- Displaying Users email address -->
                        <h2 class="fs-5">Email</h2>
                        <p><?php echo $email?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>