<?php
    $pageTitle = 'Album Details';
    require_once('header.php')
?>

<main class="container">


<h1>Album Details</h1>

    <?php
        //check the URL for an albumID to determine if this is a new or edit album
        if (!empty($_GET['albumID']))
            $albumID = $_GET['albumID'];
        else
            $albumID = null;
        $title = null;
        $year = null;
        $artist = null;
        $genrePicked = null;

        //to decide if the album is an edit, we look at the albumID
        if (!empty($albumID))
        {
            //Step 1 connect to the DB
            require('db.php');

            //Step 2 create the SQL query
            $sql = "SELECT * FROM albums WHERE albumID = :albumID";

            //Step 3 prepare and execute the SQL
            $cmd = $conn->prepare($sql);
            $cmd->bindParam(':albumID', $albumID, PDO::PARAM_INT);

            //Step 4 update the variables
            $cmd->execute();
            $album = $cmd->fetch();
            $title = $album['title'];
            $year = $album['year'];
            $artist = $album['artist'];
            $genrePicked =$album['genre'];

            //Step 5 close the DB connection
            $conn=null;
        }
    ?>


<form method="post" action="saveAlbum.php" enctype="multipart/form-data">
    <fieldset class="form-group">
        <label for="title" class="col-sm-2">Title: *</label>
        <input name="title" id="title" required placeholder="Album Title"
                value="<?php echo $title?>"/>
    </fieldset>
    <fieldset class="form-group">
        <label for="year" class="col-sm-2">Year: </label>
        <input name="year" id="year" type="number" min="1900" placeholder="Year released"
           value="<?php echo $year ?>"/>
    </fieldset>
    <fieldset class="form-group">
        <label for="artist" class="col-sm-2">Artist: *</label>
        <input name="artist" id="artist" required placeholder="Artist name"
            value="<?php echo $artist?>"/>
    </fieldset>
    <fieldset class="form-group">
        <label for="genre" class="col-sm-2">Genre: *</label>
        <select name="genre" id="genre">
            <?php
                //Step 1 - connect to the DB
                require('db.php');

                //Step 2 - create a SQL script
                $sql = "SELECT * FROM genres";

                //Step 3 - prepare and execute the SQL script
                $cmd = $conn->prepare($sql);
                $cmd->execute();
                $genres = $cmd->fetchAll();

                //Step 4 - display the results
                foreach($genres as $genre)
                {
                    if ($genrePicked == $genre['genre']){
                        echo '<option selected>'.$genre['genre'].'</option>';
                    }
                    else {
                        echo '<option>'.$genre['genre'].'</option>';
                    }

                }

                //Step 5 - disconnect from the DB
                $conn=null;
            ?>
        </select>
    </fieldset>
    <fieldset class="form-group">
        <label for="coverFile" class="col-sm-2">Cover Image:</label>
        <!-- type="file" allows you to choose a file -->
        <input name="coverFile" id="coverFile" type="file"/>
    </fieldset>
    <input name="albumID" id="albumID" value="<?php echo $albumID?>" type="hidden"/>
    <button class="btn btn-success col-sm-offset-2">Save</button>
</form>
</main>
<?php require_once('footer.php') ?>
