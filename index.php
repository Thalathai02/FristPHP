<?php

session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['Img_Profile']);
    header('location: login.php');
}
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style.scss">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark nav">
        <a class="navbar-brand">หน้าแรก</a>
        <div class="form-inline">
            <a href="#" class="mr-sm-2">
                <img src="<?php echo "img/" . $_SESSION['profile']; ?>" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                Welcome <?php echo $_SESSION['username'];?>
            </a>
            <a class="navbar-brand my-2 my-sm-0" href="index.php?logout='1'" style="color: red;">Logout</a>
        </div>
    </nav>

    
    <form class="container" style="max-width: 40rem;" action="index_DB.php" method="post" enctype="multipart/form-data">
    <?php include('errors.php'); ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
  <div class="form-group">
    <div class="row-1"><label class="col-6" for="">สร้างโพสต์</label>
    <textarea class="form-control" rows="3" name="text_Post"></textarea>
    </div><br>
    <div class="row">
            <input type="file" name="image_Post" class="col-9">
            <button type="submit"class="btn btn-primary col-2" name="submit_Post">โพสต์</button>
    </div>
   
  </div>
</form>
<?php
$query_Post = "SELECT * FROM Post  ORDER BY id DESC";
$result_Post = mysqli_query($conn, $query_Post);
while ($Post = mysqli_fetch_array($result_Post)) {
    $_SESSION['post_id'] = $Post['id'];
    $username_post = $Post['username'];
    $_SESSION['text_post'] = $Post['text_post'];
    $_SESSION['Img_post'] = $Post['Img_post'];
    $_SESSION['Date_post'] = $Post['post_date'];

    $query_Profile_Img = "SELECT * FROM user  WHERE username = '$username_post' ";
    $result_Profile_Img = mysqli_query($conn, $query_Profile_Img);
    while ($Profile_Img_post = mysqli_fetch_array($result_Profile_Img)) {
        $face_user = $Profile_Img_post['Img'];
    } ?>
<?php if ($username_post == $_SESSION['username']) :?>
<br>
<div class="container">
<div class="card mb-3 row " style="max-width: 70rem;">
  <div class="card-header bg-primary text-white row  justify-content-between ">
  <img src="<?php echo "img_post/" . $face_user; ?>" class="col-1 align-self-start " width="10" height="50" class="d-inline-block align-top" alt="" loading="lazy">
  <div class='col-3'><?php echo $username_post ; ?></div>
  <div class="col-7"></div>
  <div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   . . .
  </button>
  <div class="dropdown-menu" aria-labelledby="">
    <a class="dropdown-item " href="#">Edit</a>
    <a class="dropdown-item" href="#">Del</a>
  </div>
</div>
</div>
  <div class="card-body row">
  <img src="<?php echo "img_post/" . $_SESSION['Img_post']; ?>" class="col-4" width="200" height="200" class="d-inline-block align-top" alt="" loading="lazy">
    <p class="col card-text"><?php echo $_SESSION['text_post'] ?></p>
  </div>
</div>
</div>
<?php endif ?>
<?php if ($username_post != $_SESSION['username']) :?>
    <br>
<div class="container">
<div class="card mb-3" style="max-width: 70rem;">
  <div class="card-header bg-primary text-white">
  <img src="<?php echo "img_post/" . $face_user; ?>" class="col-1" width="10" height="50" class="d-inline-block align-top" alt="" loading="lazy">
  <?php echo $username_post ; ?></div>
  <div class="card-body row">
  <img src="<?php echo "img_post/" . $_SESSION['Img_post']; ?>" class="col-4" width="200" height="200" class="d-inline-block align-top" alt="" loading="lazy">
    <p class="col card-text"><?php echo $_SESSION['text_post'] ?></p>
  </div>
</div>
</div>
<?php endif ?>
<?php
} ?>
</body>

</html>