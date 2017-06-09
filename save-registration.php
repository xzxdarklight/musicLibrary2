<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving User Registration</title>
</head>
<body>
<?php
    //after the client side validation is complete,
    //we need to perform server side validation as well.
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $ok = true;

    if (empty($email)){
        echo 'email cannot be empty <br />';
        $ok = false;
    }

    if (strlen($password) < 8){
        echo 'password must be greater than or equal to 8 characters';
        $ok = false;
    }

    if ($password != $confirm){
        echo 'password must match';
        $ok = false;
    }

    //if it looks like an ok user, save to the DB
    if ($ok)
    {
        require_once('db.php');

        $sql="INSERT INTO users (email, password) 
              VALUES (:email, :password)";

        //hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 50);
        $cmd->bindParam(':password', $password, PDO::PARAM_STR, 255);
        $cmd->execute();
        $conn=null;
    }
    header('location:login.php');
?>
</body>
</html>
