<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle?></title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>
<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="default.php" class="navbar-brand">Music Library</a></li>
        <li><a href="albums.php">Albums</a></li>

        <?php
        //only show these links if the user is NOT logged in
        session_start();
        if (empty($_SESSION['email'])){
          echo '<li><a href="registration.php">Register Now</a></li>
                <li><a href="login.php">Login</a></li>';
        }
        else{
            //These are links for logged in users
            echo '<li><a href="albumDetails.php">Add a new album</a></li> 
                  <li><a href="logout.php">Logout</a> </li>';
        }


?>
    </ul>
</nav>
