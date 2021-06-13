<?php
include_once(__DIR__ . "/../includes/bootstrap.include.php");
require_once(__DIR__ . "/../../classes/Db.php");
require_once(__DIR__ . "/../../classes/User.php");
require_once(__DIR__ . "/../../classes/Lists.php");
require_once(__DIR__ . "/../../classes/Task.php");

if (!empty($_POST['task'])) {
    $user = new classes\User($_SESSION['user']);
    $list = new classes\Lists();
    $task = new classes\Task();


    //Put $_POST variables into variables
    //Convert the email string to lowercase, case sensitivity does not matter here
    $user_id = $user->getId();
    $list_id =  $_SESSION['list_id'];
    $title = $_POST['title'];
    $hours = $_POST['hours'];
    $deadline = $_POST['deadline'];

    $task->setUserId($user_id);
    $task->setListId($list_id);
    $task->setTitle($title);
    $task->setHours($hours);
    $task->setDeadline($deadline);



    try {
        $task->save_task();
        header('Location: ../../index.php');

    } catch (\Throwable $th) {
        $error = $th->getMessage();
    }


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Checkmate | Taak aanmaken</title>
</head>
<body>
<div>
    <h2 class="hoofdtitel">Voeg een taak toe</h2>
</div>

<div>

    <form class="create-list" enctype="multipart/form-data" action="" method="post">

        <div class="form-list">
            <input type="text" name="title" id="title" class="form-control" placeholder="Titel" required>

        </div>

        <div class="form-sell">
            <input type="time" name="hours" id="hours" class="form-control" placeholder="Werkuren">
        </div>

        <div class="form-sell">
            <input type="date" class="select-items-select-price"  name="deadline"  placeholder="Deadline" required>
        </div>


        <?php if (isset($error)) : ?>
            <div><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-group">
            <input type="submit" class="list" value="Maak taak" name="task">
        </div>
        <div id="result"> </div>
    </form>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.js"></script>

</body>

</html>


