<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Validating user</title>
</head>
<body>

<?php
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Step 1 - connect to the DB
    require_once('db.php');

    //Step 2 - create SQL query
    $sql = "SELECT email, password FROM users WHERE email = :email";

    //Step 3 - prepare and execute query
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':email', $email, PDO::PARAM_STR, 120);
    $cmd->execute();
    $user = $cmd->fetch();

    //Step 4 - validate the user
    if (password_verify($password, $user['password']))
    {
        session_start();
        $_SESSION['email'] = $user['email'];
        header('location:albums.php');
    }
    else
    {
        header('location:login.php?invalid=true');
    }

    //Step 5 - disconnect from the DB
?>

</body>
</html>
