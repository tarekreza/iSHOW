<?php

require 'dbconnect.php';
if (isset($_SESSION['login'])) {
    $_SESSION['loginAlert'] = $_SESSION['name'] . " you are already logged in";
} else {
    if (isset($_POST["submit"])) {
        $Username = $_POST["username"];
        $Password = $_POST["password"];
        if ($Username != null && $Password != null) {
            $sql = "SELECT * FROM ishow where username='$Username' AND password =  '$Password'";
            $result = mysqli_query($conn, $sql);
            $name = mysqli_fetch_assoc($result);
            $num = mysqli_num_rows($result);
            if ($num > 0) {
                $_SESSION["login"] = true;
                $_SESSION['name'] = $name['name'];
                header("Location:index.php");
            } else {
              $_SESSION['emailCheck'] = "Please enter valid email and password";
            }
        } else {
            $_SESSION['R-field'] = "Please fill all required fields";
        }
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>iShow</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">iSHOW</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php">signup</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <h1><b>Login Here</b></h1>
<!-- show alert -->
    <h1><b>
      <?php
if (isset($_SESSION['R-field'])) {
    echo $_SESSION['R-field'];
    unset($_SESSION['R-field']);
}
if (isset($_SESSION['emailCheck'])) {
    echo $_SESSION['emailCheck'];
    unset($_SESSION['emailCheck']);
}
if (isset($_SESSION['loginAlert'])) {
    echo $_SESSION['loginAlert'];
    unset($_SESSION['loginAlert']);
}
?>
    </b></h1>
<!-- FORM -->
<form action="" method="POST">
  <label for="">Username</label>
  <input type="text" name="username" placeholder="Enter your username">
  <br>
  <label for="">password</label>
  <input type="password" name="password" placeholder="Enter your password">
  <br>
  <button type="submit" name="submit">Login</button>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
