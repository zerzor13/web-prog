<?php
include "bootstrap.php";

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "users":
            $controller = new UserController();
            break;
        case "students":
            $controller = new StudentController();
            break;
        case "groups":
            $controller = new GroupController();
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