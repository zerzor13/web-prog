<?php


class GroupController extends Controller
{
    public function index()
    {
        global $pdo;
        $groups = Group::all($pdo);
        echo "<h1>Список груп</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Група</th></tr>";

        foreach ($groups as $group) {
            echo "<tr>";
            echo "<td>" . $group->columns->id . "</td>";
            echo "<td>" . $group->columns->title . "</td>";

            echo "</tr>";
        }

        echo "</table>";
    }

    public function show($id)
    {
        global $pdo;
        $group = Group::find($pdo, $id);
        echo "<h1>Список груп</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Група</th></tr>";


        echo "<tr>";
        echo "<td>" . $group->columns->id . "</td>";
        echo "<td>" . $group->columns->title . "</td>";

        echo "</tr>";
        echo "</table>";

        echo "<h1>Список студентів групи</h1>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Ім'я користувача</th></tr>";

        foreach ($group->students() as $user) {
            echo "<tr>";
            echo "<td>" . $user->columns->id . "</td>";
            echo "<td>" . $user->columns->fullname . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}