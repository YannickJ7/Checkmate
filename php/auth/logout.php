<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");

//Remove session variables
unset($_SESSION["user"]);

//Destroy session
session_destroy();

//Redirect to homepage
header("Location: /checkmate/index.php");
