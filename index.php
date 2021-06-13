<?php

include_once(__DIR__ . "/php/includes/bootstrap.include.php");
require_once(__DIR__ . "/classes/Db.php");
require_once(__DIR__ . "/classes/User.php");
require_once(__DIR__ . "/classes/Lists.php");

$user = new classes\User($_SESSION['user']);
$list = new classes\Lists();

$lists = $list->getLists($user);

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

foreach ($lists as $list) :

    ?>

    <div id="list-decoration-search" class="col-md-4">
        <div class="itemId" data-id="<?= htmlspecialchars($list->id); ?> ">
            <div id="container-search" class="container">
                <div class="card h-100 breed">
                    <form action="" method="post">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($list->title); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($list->description); ?></p>

                            <p class="card-text"><?= htmlspecialchars($list->deadline);?></p>
                        </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</ul>
<script src="/js/jquery.min.js"></script>


</body>

</html>
