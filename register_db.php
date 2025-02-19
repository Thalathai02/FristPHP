<?php
session_start();
include('server.php');

// $errors = array();
// $Namepic = $_FILES["image"]["name"];
// $temppic = $_FILES["image"]["tmp_name"];
// $file_destination = "img/$Namepic";


if (isset($_POST['reg_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    $errors = array();   
    $temppic = $_FILES["image"]["tmp_name"];
    $Namepic = $_FILES["image"]["name"];
    $uploads_dir = "img/$Namepic";
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
    $imgExt = strtolower(pathinfo($Namepic,PATHINFO_EXTENSION));

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if (empty($Namepic)) {
        array_push($errors, "Profile is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    $user_check_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
    $query = mysqli_query($conn, $user_check_query);
    $result = mysqli_fetch_assoc($query);

    if ($result) { // if user exists
        if ($result['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($result['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    if (count($errors) == 0) {
        if(in_array($imgExt, $valid_extensions)){
            move_uploaded_file($temppic, $uploads_dir);
        $password = md5($password_1);
        $sql = "INSERT INTO user (username, email, password,Img) VALUES ('$username', '$email', '$password','$Namepic')";
        mysqli_query($conn, $sql);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: login.php');
        }
        else{
            array_push($errors, "Image already exists");
            $_SESSION['error'] = "Image already exists";
            header("location: register.php");

        }
        
    } else {
        array_push($errors, "Username or Email already exists");
        $_SESSION['error'] = "Username or Email already exists";
        header("location: register.php");
    }
}
