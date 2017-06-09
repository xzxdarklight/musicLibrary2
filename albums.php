<?php
$pageTitle = 'Albums';
require_once('header.php')
?>

<main class="container">
    <h1>Albums</h1>
    <?php

        //Step 1 - connect to the DB
        require_once('db.php');

        //Step 2 - create a SQL command
        $sql = "SELECT * FROM albums";

        //Step 3 - prepare and execute the SQL command
        $cmd = $conn->prepare($sql);
        $cmd->execute();

        //Step 4 - store the results in a variable
        $albums = $cmd->fetchAll();

        //Step 5 - close the DB connection
        $conn=null;

        //Step 6 - display the results in a table
        echo '<table class="table table-striped table-hover"><tr>
                        <th>Title</th>
                        <th>Year</th>
                        <th>Artist</th>
                        <th>Genre</th>';

        if (!empty($_SESSION['email'])){
                  echo '<th>Edit</th>
                        <th>Delete</th>';
        }


        echo'</tr>';

        //loop over the $albums array to display each album as a new row
        foreach($albums as $album)
        {
            echo '<tr><td>'.$album['title'].'</td>
                      <td>'.$album['year'].'</td>
                      <td>'.$album['artist'].'</td>
                      <td>'.$album['genre'].'</td>';

            if (!empty($_SESSION['email'])){
                echo '<td><a href="albumDetails.php?albumID='.$album['albumID'].'"class="btn btn-primary"</a>Edit</td>
                      <td><a href="deleteAlbum.php?albumID='.$album['albumID'].'" class="btn btn-danger confirmation">Delete</td>';
            }

            echo '</tr>';
        }

    ?>

</main>
<?php require_once('footer.php') ?>
