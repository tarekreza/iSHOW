<?php
session_start();
require 'dbconnect.php';

if (isset($_POST["submit"])) {
    $Name = $_POST["name"];
    $Email = $_POST["email"];
    $Password = $_POST["password"];
    $Cpassword = $_POST["cpassword"];

    $signup_obj = new signup;

    $signup_obj->check_allfield($Name, $Email, $Password, $Cpassword);
    if ($_SESSION['allfield']) {
        unset($_SESSION['allfield']);
        $signup_obj->check_unique_email($Email);
        if (isset($_SESSION['checkAccount'])) {
            if ($_SESSION['checkAccount']) {
                unset($_SESSION['checkAccount']);
                $signup_obj->password_check($Password, $Cpassword);
                if ($_SESSION['passwordCheck']) {
                    unset($_SESSION['passwordCheck']);
                    $signup_obj->store_data($Name, $Email, $Password);
                }
            }
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
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="text-center">
      <h1><b>Signup Here</b></h1>
      <h3><b>
          <?php
if (isset($_SESSION['allfield'])) {
    if (!($_SESSION['allfield'])) {

        echo 'Please fill all required fields';
        unset($_SESSION['allfield']);
    }
}
if (isset($_SESSION['passwordCheck'])) {
    if (!$_SESSION['passwordCheck']) {
        echo "Password didn't match";
        unset($_SESSION['passwordCheck']);
    }
}
if (isset($_SESSION['emailCheck'])) {
    if (!$_SESSION['emailCheck']) {
        echo "Please enter a valid email";
        unset($_SESSION['emailCheck']);
    }
}
if (isset($_SESSION['checkAccount'])) {
    if (!$_SESSION['checkAccount']) {
        echo "You already have an account with this email";
        unset($_SESSION['checkAccount']);
    }
}
if (isset($_SESSION['insert_error'])) {
    if (!$_SESSION['insert_error']) {
        echo "Can't insert data into database. please contact out support team";
        unset($_SESSION['insert_error']);
    }
}
?>
  </b></h3>
</div>

    <!-- FORM -->
    <form action="" method="POST">
        <label for="">Name</label>
        <input type="text" name="name" placeholder="Enter your Name">
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

<?php
class signup
{
    public $dbconnection;

    public function __construct()
    {
        // database connection
        $dbobj = new dbconnect;
        $this->dbconnection = $dbobj->connection();

    }

    // check name, email, password and confirm password are null or not
    public function check_allfield($name, $email, $password, $Cpassword)
    {

        if ($name != null && $email != null && $password != null && $Cpassword) {
            $_SESSION['allfield'] = true;
        } else {
            $_SESSION['allfield'] = false;
        }
    }
    public function check_unique_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // $_SESSION['emailCheck'] = true;
            // TODO:unset($_SESSION['emailCheck']);
            $sql = "SELECT email FROM ishow where email='$email'";
            $result = $this->dbconnection->query($sql);
            $num = mysqli_num_rows($result);
            if ($num == 0) {
                // if user don't have any account with this email then checkaccount = true
                $_SESSION['checkAccount'] = true;
            } else {
                $_SESSION['checkAccount'] = false;
            }
        } else {
            $_SESSION['emailCheck'] = false;
        }
    }
    // check passwords and confirm passwords are same or not
    public function password_check($pass, $cpass)
    {
        if ($pass == $cpass) {
            $_SESSION['passwordCheck'] = true;
        } else {
            $_SESSION['passwordCheck'] = false;
        }
    }
    public function store_data($name, $email, $pass)
    {
        $sql = "INSERT INTO ishow (name, email, password) VALUES ('$name','$email','$pass')";
        if ($this->dbconnection->query($sql)) {
            header("Location:login.php");
        } else {
            $_SESSION['insert_error'] = false;
        }
    }
}

?>