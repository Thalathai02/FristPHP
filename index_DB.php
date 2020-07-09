<?php
session_start();
include('server.php');

        $query_Post = "SELECT * FROM Post";
   $result_Post = mysqli_query($conn, $query_Post);
   while ($Post = mysqli_fetch_array($result_Post)) {
       $_SESSION['post_id'] = $Post['id'];
       $_SESSION['username_post'] = $Post['username'];
       $_SESSION['text_post'] = $Post['text_post'];
       $_SESSION['Img_post'] = $Post['Img_post'];
       $_SESSION['Date_post'] = $Post['post_date'];
   }

if (isset($_POST['submit_Post'])) {
    $text_post = mysqli_real_escape_string($conn, $_POST['text_Post']);
    $username=$_SESSION['username'];
    $post_date = date('y-m-d');
    $errors = array();  
    $temppic = $_FILES["image_Post"]["tmp_name"];
    $Namepic = $_FILES["image_Post"]["name"];
    $uploads_dir = "img_post/$Namepic";
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
    $imgExt = strtolower(pathinfo($Namepic,PATHINFO_EXTENSION));
    if (empty($text_post)) {
        array_push($errors, "Text post is required");
    }
    if(empty( $Namepic)){

        $temppic = $_FILES["image_Post"]["tmp_name"];
        $Namepic = $_FILES["image_Post"]["name"];
    }
    if (count($errors) == 0) {
        if(in_array($imgExt, $valid_extensions)){
            move_uploaded_file($temppic, $uploads_dir);
            $sql = "INSERT INTO Post (username, text_post,Img_post,post_date) VALUES ('$username', '$text_post','$Namepic','$post_date')";
            mysqli_query($conn, $sql);
            $_SESSION['success'] = "You are now post";
            header("location: index.php");
        }else{
            array_push($errors, "Image already exists");
            $_SESSION['error'] = "Image already exists";
            header("location: index.php");
        }
        
       
    } else {
        array_push($errors, "Text already exists");
        $_SESSION['error'] = "Text already exists";
        header("location: index.php");
    }
}