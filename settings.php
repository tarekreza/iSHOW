<?php
session_start();
require 'dbconnect.php';

if (isset($_SESSION["login"])) {
    if ($_SESSION["login"]) {
        if (isset($_POST["submit"])) {
            $changedName = $_POST["change_name"];
            $changedEmail = $_POST["change_email"];
            $changedPassword = $_POST["change_password"];
            if (filter_var($changedEmail, FILTER_VALIDATE_EMAIL)) {
                $id = $_SESSION['id'];
                $obj = new profile();
                if ($changedName != null) {
                    $obj->name($changedName, $id);
                }
                if ($changedEmail != null) {
                    $obj->email($changedEmail, $id);
                }
                if ($changedPassword != null) {
                    $obj->password($changedPassword, $id);
                }
            } else {
                if ($changedEmail != null) {
                    $_SESSION['emailERROR'] = true;
                }
            }
        }
    }
} else {
    header("Location:login.php");
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
              <a class="nav-link" href="settings.php">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
if (isset($_SESSION['emailERROR'])) { ?>
    <div class="alert alert-danger" role="alert">
<?php
    if ($_SESSION['emailERROR']) {
        echo "Please enter correct email address <br>";
        unset($_SESSION['emailERROR']);
    }
?>
</div>
<?php
}
?>
    <div class="text-center">
    <h3><b>
<?php

echo "Your current name is : ";
echo $_SESSION['name'];
echo "<br>";
echo "Your current email is : ";
echo $_SESSION['email'];
echo "<br>";
echo "Your current password is : ";
echo $_SESSION['password'];

?>
  </b></h3>

        </div>
<!-- FORM -->
<form action="settings.php" method="POST">
<label for="">Name</label>
    <input type="text" name="change_name" placeholder="<?php echo $_SESSION['name']; ?>">
        <br>
  <label for="">email</label>
  <input type="text" name="change_email" placeholder="<?php echo $_SESSION['email']; ?>">
  <br>
  <label for="">password</label>
  <input type="password" name="change_password" placeholder="<?php echo $_SESSION['password']; ?>">
  <br>
  <button type="submit" name="submit">Submit</button>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
<?php
class profile
{
    public function __construct()
    {
        // database connection
        $dbobj = new dbconnect;
        $this->dbconnection = $dbobj->connection();
    }
    public function update($id)
    {
        $sql = "SELECT * FROM ishow where id='$id'";
        $result = $this->dbconnection->query($sql);
        $name = mysqli_fetch_assoc($result);
        $_SESSION['name'] = $name['name'];
        $_SESSION['email'] = $name['email'];
        $_SESSION['password'] = $name['password'];
    }
    public function name($changedName, $id)
    {
        $sql = "UPDATE ishow SET name='$changedName' WHERE id = '$id'";
        $this->dbconnection->query($sql);
        $this->update($id);
    }

    public function email($changedEmail, $id)
    {
        $sql = "UPDATE ishow SET email='$changedEmail' WHERE id = '$id'";
        $this->dbconnection->query($sql);
        $this->update($id);
    }

    public function password($changedPassword, $id)
    {
        $sql = "UPDATE ishow SET password='$changedPassword' WHERE id = '$id'";
        $this->dbconnection->query($sql);
        $this->update($id);
    }
}

?>