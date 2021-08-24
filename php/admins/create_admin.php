<?php

include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/User.php");

if (!empty($_POST['register'])) {

    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = strtolower($_POST['email']);
    if ($password == $confirmPassword) {
        $user = new classes\User($email);

        //Set the user's properties
        //setEmail returns an error message if the email is not a valid email or if it's not unique
        $valid_email = $user->setEmail($email);
        $user->setFullname($fullname);
        $user->setPassword($password);


        //If setEmail returns a string, show the error message
        if (gettype($valid_email) == "string") {
            $error = $valid_email;
        } else {

            //Save the user
            $user->save_admin();


            $user = new classes\User($email);

            

        }
    }

    $error = 'Wachtwoorden komen niet overeen';

    $confirmation = 'Gebruiker succesvol aangemaakt';

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="icon" href="../../img/favicon.png" type="image/png">

	<title>Checkmate | Make admin</title>
</head>
<body>
<div class="pattern">

        <header>
            <h2>Make an admin</h2>

            <a class="logout" href="./php/auth/logout.php">LOG OUT</a>

            <a class="headerbutton" href="../../index.php">BACK</a>

        </header>

        <form class="create-list" action="" method="post">

        <?php if (isset($succesfull)) : ?>
            <div style="font-size: 15px; background-color:#90EE90; padding:10px; border-radius:10px;">
                <?php echo $succesfull; ?></div>
        <?php endif; ?>
        <br>

        <div id="reg-form-buyer-flex"  class="form-group">
            <input id="label-fill" type="text" name="fullname" id="fullname" class="form-control" placeholder="Volledige naam"
                   required>
        </div>

        <div id="reg-form-buyer-flex" class="form-group">
            <input id="label-fill" type="email" name="email" class="form-control email" placeholder="Email"
                   pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required>
            <span id="availability"></span>
        </div>

        <div id="reg-form-buyer-flex" class="form-group">
            <input id="label-fill" type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord"
                   required>
        </div>

        <div id="reg-form-buyer-flex" class="form-group">
            <input id="label-fill" type="password" name="confirmPassword" id="confirmPassword" class="form-control"
                   placeholder="Wachtwoord bevestigen" required>
        </div>

        <div id="reg-form-buyer-flex" class="form-group">
            <input id="register" id="register" type="submit"  value="REGISTER" name="register">
        </div>

        <div id="result"> </div>

    </form>

		
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.js"></script>
</div>

</body>

</html>

