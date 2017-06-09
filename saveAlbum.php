<?php ob_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving Album</title>
</head>
<body>
<?php
    $albumID = $_POST['albumID'];
    $title = $_POST['title'];
    $year = $_POST['year'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $coverFileName = $_FILES['coverFile']['name']; //using the "$_files" array to get the image that was uploaded.
    $coverFileType = $_FILES['coverFile']['type'];
    $coverFileTmpLocation = $_FILES['coverFile']['tmp_name'];

    echo 'File name:'.$coverFileName.'<br />';
    echo 'File type:'.$coverFileType.'<br />';
    echo 'File temp name:'.$coverFileTmpLocation.'<br />';
    echo'The real file type is: '.mime_content_type($coverFileTmpLocation);

    //Check to ensure that the file uploaded is an image
    $validFileTypes = ['image/jpg','image/png','image/svg','image/gif','image/jpeg'];
    $fileType = mime_content_type($coverFileTmpLocation);

    //store the file on our server
    if(in_array($fileType, $validFileTypes))
    {//had to use uniqid  so that the images are unique even have the same name.
        $fileName ="uploads/".uniqid("",true).$coverFileName;
        move_uploaded_file($coverFileTmpLocation, $fileName);
    }

    //Step 1 - connect to the DB
    $conn = new PDO('mysql:host=aws.computerstudi.es;dbname=gc200318170', 'gc200318170', 'UU0vTl-Syo');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Step 2 - create a SQL command
    if (!empty($albumID))
    {
        $sql = "UPDATE albums
                SET title = :title, year = :year, artist = :artist, genre = :genre, coverFile = :coverFile
                WHERE albumID = :albumID";

    }
    else {
        $sql = "INSERT INTO albums (title, year, artist, genre, coverFile) 
            VALUES (:title, :year, :artist, :genre, :coverFile)";
    }

    //Step 3 - prep the command and bind the parameters to avoid SQL injection
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':title', $title, PDO::PARAM_STR, 50);
    $cmd->bindParam(':year', $year, PDO::PARAM_INT, 4);
    $cmd->bindParam(':artist', $artist, PDO::PARAM_STR, 50);
    $cmd->bindParam(':genre', $genre, PDO::PARAM_STR, 20);
    $cmd->bindParam(':coverFile', $fileName, PDO::PARAM_STR, 100);

    if (!empty($albumID))
    {
        $cmd->bindParam(':albumID',$albumID, PDO::PARAM_INT);
    }

    //Step 4 - execute the command
    $cmd->execute();

    //Step 5 - disconnect from the DB
    $conn = null;

    //Step 6 - redirect to another page
    header('location:albums.php');
?>
</body>
</html>
<?php ob_flush(); ?>
