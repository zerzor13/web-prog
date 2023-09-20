<?php
require_once ("config.php");
if (!empty($_SESSION['user_id']))
{
    header("location: /index.php");
}

$errors = [];
$isRegistered = 0;
if (!empty($_GET['registration']))
{
    $isRegistered = 1;
}

if (!empty($_POST))
{
    if (empty($_POST['user_name']))
    {
        $errors[] = 'Будь-ласка введіть логін / email';
    }

    if (empty($_POST['password']))
    {
        $errors[] = 'Будь-ласка введіть пароль';
    }

    if (empty($errors))
    {
        $stmt = $dbConn->prepare('SELECT id FROM users WHERE (username = :username or email = :username) and password = :password');
        $stmt->execute(array(
            'username' => $_POST['user_name'],
            'password' => sha1($_POST['password'] . SALT)
        ));
        $id = $stmt->fetchColumn();
        if (!empty($id))
        {
            $_SESSION['user_id'] = $id;
            die("Ви успішно авторизовані");
        }
        else
        {
            $errors[] = 'Будь-ласка введіть правильні дані';
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Гостьова книга</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php if (!empty($isRegistered)): ?>
        <h2>Ви успішно зареєструвалися. Використайте дані для входу</h2>
        <?php
endif; ?>
        <h1>Вхід</h1>
        <div>
            <form method="POST">
                <div style="color: red;">
                    <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                    <?php
endforeach; ?>
                </div>
                <div>
                    <label>Логін / Електронна пошта:</label>
                    <div>
                        <input type="text" name="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : ''); ?>"/>
                    </div>
                </div>
                <div>
                    <label>Пароль:</label>
                    <div>
                        <input type="password" name="password" required="" value=""/>
                    </div>
                </div>
                <div>
                    <br/>
                    <input type="submit" name="submit" value="Увійти">
                </div>
            </form>
        </div>
    </body>
</html>
