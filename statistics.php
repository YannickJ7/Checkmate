<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Lists.php");

$user = new classes\User($_SESSION['user']);
$list = new classes\Lists();

$lists = $list->getLists($user);
$users = $user->getUsers($user);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" href="./img/favicon.png" type="image/png">

    <title>Checkmate | Statistics</title>
</head>

<body>

<header>
<h2>Statistics </h2>

<a class="logout" href="./php/auth/logout.php">LOG OUT</a>


<a class="headerbutton" href="./index.php">BACK</a>

</header>

<p class="stat">
<?php
$con=mysqli_connect("localhost","root","root","checkmate");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * FROM users ";

if ($result=mysqli_query($con,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  printf("Er zijn momenteel <strong> %d gebruikers </strong> .\n",$rowcount);
  // Free result set
  mysqli_free_result($result);
  }

mysqli_close($con);

?>
</p>

<p class="stat">
<?php
$con=mysqli_connect("localhost","root","root","checkmate");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * FROM lists ";

if ($result=mysqli_query($con,$sql))
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);

  printf("Er zijn momenteel <strong> %d lijsten </strong> .\n",$rowcount);
  
  // Free result set
  mysqli_free_result($result);
  }

mysqli_close($con);

?>
</p>


<script src="/js/jquery.min.js"></script>


</body>

</html>
