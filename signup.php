<?php
require 'dbconnect.php';
$dbobj = new dbconnect;
$value = $dbobj->connection();

if (isset($_POST["submit"])) {
    $Name = $_POST["name"];
    $Username = $_POST["username"];
    $Email = $_POST["email"];
    $Password = $_POST["password"];
    $Cpassword = $_POST["cpassword"];
    if ($Name != null && $Username != null && $Email != null && $Password != null) {
        $sql = "SELECT * FROM ishow where email='$Email'";
        $check = $value->query($sql);
        $num = mysqli_num_rows($check);
        if ($num >= 1) {
            $_SESSION['checkAccount'] = "You already have an account with this email";
        } else {
            if ($Password === $Cpassword) {
                if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                    $sql = "INSERT INTO ishow (name,username, email, password) VALUES ('$Name','$Username','$Email','$Password')";

                    if ($value->query($sql)) {
                        header("Location:login.php");
                    }
                } else {
                    $_SESSION['emailCheck'] = "Please enter a valid email";
                }
            } else {
                $_SESSION['passwordCheck'] = "Password didn't match";
            }
        }
    } else {
        $_SESSION['allfields'] = 'Please fill all required fields';
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
    <!-- NAVBAR -->
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
              <a class="nav-link" href="login.php">User Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="text-center">
    <h1><b>Signup Here</b></h1>

    <h1><b>

<?php

if (isset($_SESSION['allfields'])) {
    echo $_SESSION['allfields'];
    unset($_SESSION['allfields']);
}
if (isset($_SESSION['checkAccount'])) {
    echo $_SESSION['checkAccount'];
    unset($_SESSION['checkAccount']);
}

if (isset($_SESSION['passwordCheck'])) {
    echo $_SESSION['passwordCheck'];
    unset($_SESSION['passwordCheck']);
}
if (isset($_SESSION['emailCheck'])) {
    echo $_SESSION['emailCheck'];
    unset($_SESSION['emailCheck']);
}
?>
  </b></h1>
  </div>
    <!-- FORM -->
    <form action="" method="POST">
        <label for="">Name</label>
        <input type="text" name="name" placeholder="Enter your Name">
        <br>
        <label for="">Username</label>
        <input type="text" name="username" placeholder="Enter your username">
        <br>
        <label for="">Email</label>
        <input type="email" name="email" placeholder="Enter your email">
        <br>
        <label for="">password</label>
        <input type="password" name="password" placeholder="Enter your password">
        <br>
        <label for="">Confirm Password</label>
        <input type="password" name="cpassword" placeholder="Confirm password">
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>




<!-- no change -->