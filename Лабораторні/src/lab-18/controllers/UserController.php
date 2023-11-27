<?php


class UserController extends Controller
{
    public function index()
    {
        global $pdo;
        $users = User::all($pdo);
        echo "<h1>Список користувачів</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Ім'я користувача</th><th>Email</th></tr>";

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user->columns->id . "</td>";
            echo "<td>" . $user->columns->username . "</td>";
            echo "<td>" . $user->columns->email . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    public function show($id)
    {
        global $pdo;
        $user = User::find($pdo, $id);
        echo "<h1>Список користувачів</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Ім'я користувача</th><th>Email</th></tr>";


        echo "<tr>";
        echo "<td>" . $user->columns->id . "</td>";
        echo "<td>" . $user->columns->username . "</td>";
        echo "<td>" . $user->columns->email . "</td>";
        echo "</tr>";


        echo "</table>";
    }
}