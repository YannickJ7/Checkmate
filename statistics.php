<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Lists.php");
require_once(__DIR__ . "/classes/Task.php");


$user = new classes\User($_SESSION['user']);
$list = new classes\Lists();
$task = new classes\Task();


$lists = $list->getLists($user);
$countlists = $list->countLists();
$countusers = $user->countUsers();
$averagehours = $task->averageHours($user);
$averagelists = $list->averageLists($user);

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

<p class="stat"> Er zijn momenteel <strong> <?php echo $countusers; ?> gebruikers.</strong> </p>

<p class="stat"> Er zijn momenteel <strong> <?php echo $countlists; ?> lijsten.</strong>  </p>

<p class="stat"> Er zijn momenteel gemiddeld <strong> <?php echo round($averagehours,1); ?> uren gepland per gebruiker.</strong> </p>

<p class="stat"> Er zijn momenteel gemiddeld <strong> <?php echo round($averagelists); ?> lijsten per gebruiker.</strong> </p>

<script src="/js/jquery.min.js"></script>


</body>

</html>
