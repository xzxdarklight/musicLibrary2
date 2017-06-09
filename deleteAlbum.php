<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Album</title>
</head>
<body>
<?php

    if (!empty($_GET['albumID']) ) {

        $albumID = $_GET['albumID'];
        //Step 1 - connect to the database
        require_once('db.php');

        //Step 2 - create the SQL statement
        $sql = "DELETE FROM albums
                WHERE albumID = :albumID";

        //Step 3 - prepare and execute the sql statement
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':albumID', $albumID, PDO::PARAM_INT);
        $cmd->execute();

        //Step 4 - disconnect from the DB
        $conn = null;
    }

    //step 5 - redirect back to the albums.php page
    header('location:albums.php');
?>
</body>
</html>

