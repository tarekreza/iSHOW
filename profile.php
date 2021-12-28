<?php
session_start();
require 'dbconnect.php';

  $id = $_SESSION['id'];
  $obj = new profile();

  if (isset($_POST['submit'])) {
    $profile_picture = $_FILES['image']['tmp_name'];
    $name = time().'.jpg';
    $name_path = 'img/'. $name;
    $obj->insert_img_into_db($name,$id);
    move_uploaded_file($profile_picture,$name_path);

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
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
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
   
 <form class = "my-5" action="" method="POST" enctype="multipart/form-data">
   <input type="file" name="image" class = "form-control">
   <button type="submit" name="submit">Submit</button>
  </form>

  <div class="text-center">
<!-- show profile picture -->
    <!--                            GOT ERROR                             -->
    <img src="img/<?php $_SESSION['profile_picture']?>" height="200" width ="200" alt="Profile picture"> 
    <!--                            GOT ERROR                             -->
    <!-- show name -->
    <h1><b><?=$_SESSION['name']?></b></h1>
 </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>

<?php
  class profile{
    public $dbconnection;
    public function __construct()
    {
        // database connection
        $dbobj = new dbconnect;
        $this->dbconnection = $dbobj->connection();
    }
    // insert name into db
    function insert_img_into_db($name,$id){
      $sql = "UPDATE ishow SET profile_picture = '$name' WHERE id = '$id'";
      $this->dbconnection->query($sql);
      // get name from db 
      $sql = "SELECT * FROM ishow where id='$id'";
        $result = $this->dbconnection->query($sql);
        $name = mysqli_fetch_assoc($result);
        $_SESSION['profile_picture'] = $name['profile_picture'];
    }
  }
?>