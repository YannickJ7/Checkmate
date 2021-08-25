<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Lists.php");
require_once(__DIR__ . "/classes/Upload.php");

$user = new classes\User($_SESSION['user']);
$list = new classes\Lists();
$taskClass = new classes\Task();
$upload = new classes\Upload();

$lists = $list->getLists($user);
$users = $user->getUsers($user);
$uploads = $upload->save_upload();

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

if(!empty($_POST['delete_list'])){
    $user = new classes\User($_SESSION['user']);
    $list = new classes\Lists();
    $list->deleteList($user, $_POST['list_id']);
}

if(!empty($_POST['done_task'])){
    $user = new classes\User($_SESSION['user']);
    $taskClass = new classes\Task();
    $taskClass->doneTask($user, $_POST['task_id']);
}

if(!empty($_POST['todo_task'])){
    $user = new classes\User($_SESSION['user']);
    $taskClass = new classes\Task();
    $taskClass->toDoTask($user, $_POST['task_id']);
}

if(!empty($_GET['order_task'])){
    $user = new classes\User($_SESSION['user']);
    $taskClass = new classes\Task();
    $taskClass->orderTasks($user, $_POST['task_id']);
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
    <link rel="icon" href="./img/favicon.png" type="image/png">

    <title>Checkmate | Home</title>
</head>

<body>

<header>
<h2>Home </h2>

<a class="logout" href="./php/auth/logout.php">LOG OUT</a>

<a class="headerbutton" href="./php/lists/create_list.php">MAKE LIST</a>





    <?php if($user->getIsAdmin() == 1){ ?>

        <a class="headerbutton" href="./statistics.php">STATISTICS</a>

        <a class="headerbutton" href="./php/admins/create_admin.php">MAKE ADMIN</a>


    <?php } ?>


</header>

<ul class="row col-md-12">

<?php

foreach ($lists as $list) :?>

    <div id="list-decoration-search" class="col-md-4">
            <div class="container">
                <div class="card h-100 breed">
                        <div class="card-body">
                            <h5 class="card-title"><strong><?= htmlspecialchars($list->title); ?></strong></h5>
                            <p class="card-text"><?= htmlspecialchars($list->description); ?></p>

                            <p class="card-text"><strong>Deadline:  </strong><?= htmlspecialchars($list->deadline);?></p>
                            
                            <p class="status"><strong>TO DO </strong></p>


                    <?php $tasks = $taskClass->getTasks($user, $list->id);

                    foreach ($tasks as $task) :
                    ?>

                        <?php if($task->status == 'to do'){ ?>

                            <div class="task">
                            <h5 class="card-title"><strong><?= htmlspecialchars($task->title); ?></strong></h5>
                            <p class="card-text"><strong>Geplande uren:  </strong><?= htmlspecialchars($task->hours); ?></p>
                            <p class="card-text"><strong>Tegen:  </strong><?= htmlspecialchars($task->deadline);?></p>

                            <?php
/*
                            //A: RECORDS TODAY'S Date And Time
                            $today = time();
                            
                            $timestamp = date("Y/m/d", $today); 

                            //B: RECORDS Date And Time OF YOUR EVENT
                            $event = $task->deadline;


                            //C: COMPUTES THE DAYS UNTIL THE EVENT.
                            $countdown = round(($today -  $event)/86400);

                            //D: DISPLAYS COUNTDOWN UNTIL EVENT
                            echo "$event Dagen tot deadline";*/


                            ?>

                            <form action="#" method="post" enctype="multipart/form-data" >
                                <h3 class="uploadTitle">Upload File</h3>
                                <input type="file" name="myfile"> <br>
                                <button type="submit" name="save">upload</button>
                            </form>

                            <form action="" method="post">
                                    <input type="hidden" name="task_id"
                                        value="<?= htmlspecialchars($task->id);?>" placeholder="naam" />
                                    <input id="task" type="submit" name="delete_task"
                                        value="Verwijder Taak" />
                            </form>

                            <form action="" method="post">
                                    <input type="hidden" name="task_id"
                                        value="<?= htmlspecialchars($task->id);?>" placeholder="naam" />
                                    <input id="doneTask" type="submit" name="done_task"
                                        value="Done" />
                            </form>

                            </div>
                        <?php } ?>

                    <?php endforeach ?>


                    <p class="status"><strong>DONE </strong></p>

                    <?php $tasks = $taskClass->getTasks($user, $list->id);

                        foreach ($tasks as $task) :
                        ?>

                            <?php if($task->status == 'done'){ ?>

                                <div class="task">
                                <h5 class="card-title"><strong><?= htmlspecialchars($task->title); ?></strong></h5>
                                <p class="card-text"><strong>Geplande uren:  </strong><?= htmlspecialchars($task->hours); ?></p>

                                <p class="card-text"><strong>Tegen:  </strong><?= htmlspecialchars($task->deadline);?></p>
                                <form action="" method="post">
                                        <input type="hidden" name="task_id"
                                            value="<?= htmlspecialchars($task->id);?>" placeholder="naam" />
                                        <input id="task" type="submit" name="delete_task"
                                            value="Verwijder Taak" />
                                </form>

                                <form action="" method="post">
                                        <input type="hidden" name="task_id"
                                            value="<?= htmlspecialchars($task->id);?>" placeholder="naam" />
                                        <input id="toDoTask" type="submit" name="todo_task"
                                            value="To Do" />
                                </form>

                                </div>
                            <?php } ?>

                        <?php endforeach ?>


                        
                    <form action="" method="post">
                        <div>
                            <input type="hidden" name="list_id"
                                   value="<?= htmlspecialchars($list->id);?>" placeholder="naam" />
                            <input id="task" type="submit" name="create_task"
                                   value="ADD TASK" />
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="list_id"
                                   value="<?= htmlspecialchars($list->id);?>" placeholder="naam" />
                            <input id="list" type="submit" name="delete_list"
                                   value="Verwijder Lijst" />
                    </form>
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
