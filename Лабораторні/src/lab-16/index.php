<?php
include "core/config.php";
include "core/connection.php";
include "core/Model.php";
include "models/User.php";

// Отримання всіх користувачів
$users = new User($pdo);

if (isset($_GET["id"])) {
    $users->find($_GET["id"]);
    echo "<h1>Список користувачів</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Ім'я користувача</th><th>Email</th></tr>";

    echo "<tr>";
    echo "<td>" . $users->columns->id . "</td>";
    echo "<td>" . $users->columns->username . "</td>";
    echo "<td>" . $users->columns->email . "</td>";
    echo "</tr>";

    echo "</table>";
} else {


    if (count($users->all()) > 0) {
        echo "<h1>Список користувачів</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Ім'я користувача</th><th>Email</th></tr>";

        foreach ($users->all() as $user) {
            echo "<tr>";
            echo "<td>" . $user->columns->id . "</td>";
            echo "<td>" . $user->columns->username . "</td>";
            echo "<td>" . $user->columns->email . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "У базі даних немає користувачів.";
    }
}
