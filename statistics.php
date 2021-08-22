<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Lists.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="./img/favicon.png" type="image/png">

    <title>Checkmate | Statistics</title>
</head>

<body>

<header>
<h2>Statistics </h2>

<a class="logout" href="./php/auth/logout.php">LOG OUT</a>

<a class="headerbutton" href="./php/lists/create_list.php">MAKE LIST</a>


</header>

<ul class="row col-md-12">


</ul>


<script src="/js/jquery.min.js"></script>


</body>

</html>
