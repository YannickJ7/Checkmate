<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Lists.php");

$user = new classes\User($_SESSION['user']);
$list = new classes\Lists();
$taskClass = new classes\Task();


$lists = $list->getLists($user);


if(!empty($_POST['create_task'])){
    $user = new classes\User($_SESSION['user']);

    session_status();
    $_SESSION['list_id'] = $_POST['list_id'];
    header('Location: php/tasks/create_task.php');
}

if(!empty($_POST['delete_task'])){
    $user = new classes\User($_SESSION['user']);
    $taskClass = new classes\Task();
    $taskClass->deleteTask($user, $_POST['task_id']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Checkmate | Home</title>
</head>

<body>

<h2>Home </h2>


<ul class="row col-md-12">

<?php

foreach ($lists as $list) :?>
    <div id="list-decoration-search" class="col-md-4">
            <div class="container">
                <div class="card h-100 breed">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($list->title); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($list->description); ?></p>

                            <p class="card-text"><?= htmlspecialchars($list->deadline);?></p>

                    <?php $tasks = $taskClass->getTasks($user, $list->id);

                    foreach ($tasks as $task) :
                    ?>
                    <div class="taak">
                    <h5 class="card-title"><?= htmlspecialchars($task->title); ?></h5>
                    <p class="card-text"><?= htmlspecialchars($task->hours); ?></p>

                    <p class="card-text"><?= htmlspecialchars($task->deadline);?></p>
                    <form action="" method="post">
                            <input type="hidden" name="task_id"
                                   value="<?= htmlspecialchars($task->id);?>" placeholder="naam" />
                            <input id="task" type="submit" name="delete_task"
                                   value="Verwijder Taak" />
                    </form>
                    </div>

                    <?php endforeach ?>
                    <form action="" method="post">
                        <div>
                            <input type="hidden" name="list_id"
                                   value="<?= htmlspecialchars($list->id);?>" placeholder="naam" />
                            <input id="task" type="submit" name="create_task"
                                   value="Maak een taak aan" />
                        </div>
                </form>
                </div>
            </div>
            </div>
    </div>


<?php endforeach ?>
</ul>
<script src="/js/jquery.min.js"></script>


</body>

</html>
