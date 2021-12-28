<?php
session_start();
require 'dbconnect.php';

if (isset($_SESSION["login"])) {
    if ($_SESSION["login"]) {
        header("Location:index.php");
    }
} else {
    if (isset($_POST["submit"])) {
        $Email = $_POST["email"];
        $Password = $_POST["password"];
        $login_obj = new login();
        $login_obj->check_allfield($Email, $Password);
        if ($_SESSION['allfield']) {
            unset($_SESSION['allfield']);
            $login_obj->check($Email, $Password);
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

    <?php
if (isset($_SESSION['allfield'])) {?>
        <div class="alert alert-danger" role="alert">
            <?php
if (!($_SESSION['allfield'])) {

    echo 'Please fill all required fields';
    unset($_SESSION['allfield']);
}
    ?>
</div>
<?php
}
?>

<?php
if (isset($_SESSION['login'])) {?>
        <div class="alert alert-danger" role="alert">
            <?php
if (!($_SESSION['login'])) {

  echo "You entered wrong email or password";
    unset($_SESSION['login']);
}
    ?>
</div>
<?php
}
?>
    <div class="text-center">
    <h1><b>Login Here</b></h1>
    </div>
<!-- FORM -->
<form action="" method="POST">
  <label for="">email</label>
  <input type="text" name="email" placeholder="Enter your email">
  <br>
  <label for="">password</label>
  <input type="password" name="password" placeholder="Enter your password">
  <br>
  <button type="submit" name="submit">Login</button>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

<?php
class login
{
    public $dbconnection;

    public function __construct()
    {
        // database connection
        $dbobj = new dbconnect;
        $this->dbconnection = $dbobj->connection();
    }
    public function check_allfield($email, $password)
    {
        if ($email != null && $password != null) {
            $_SESSION['allfield'] = true;
        } else {
            $_SESSION['allfield'] = false;
        }
    }
    public function check($email, $pass)
    {
        $sql = "SELECT * FROM ishow where email='$email' AND password =  '$pass'";
        $result = mysqli_query($this->dbconnection, $sql);
        $name = mysqli_fetch_assoc($result);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $_SESSION["login"] = true;
            $_SESSION['id'] = $name['id'];
            $_SESSION['name'] = $name['name'];
            $_SESSION['username'] = $name['username'];
            $_SESSION['email'] = $name['email'];
        $_SESSION['password'] = $name['password'];
        $_SESSION['profile_picture'] = $name['profile_picture'];

            header("Location:index.php");
        } else {
            $_SESSION['login'] = false;
        }
    }

}

?>