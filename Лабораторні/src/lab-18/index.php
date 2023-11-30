<?php
include "bootstrap.php";

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "users":
            $controller = new UserController($pdo);
            break;
        case "students":
            $controller = new StudentController($pdo);
            break;
        case "groups":
            $controller = new GroupController($pdo);
            break;
        default:
            die("Невірна дія");
    }
} else {
    die("Немає дії");
} ?>
<!DOCTYPE html>
<html lang="ua">

<head>

</head>

<body>
    <?php
    if (isset($_GET["id"])) {
        $controller->show($_GET["id"]);
    } else {
        $controller->index();
    }
    ?>
</body>

</html>