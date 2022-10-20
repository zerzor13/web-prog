[Перелік усіх робіт](README.md)

## Створення гостьової книги з механізмом авторизації

## Мета роботи

Створити гостьову книгу з наступними функціональними сторінками:

1\. Сторінка реєстрації користувача, що містить форму для реєстрації з наступними полями:

* login
* email
* first name
* last name
* password

2\. Сторінка авторизації користувача, що містить форму вводу логіна та пароля.

3\. Сторінка відображення коментарів, куди потрапить користувач після успішної авторизації. Сторінка повинна складатися з двох основних блоків:

* форма додавання нового коментара;
* блок з виводом попередніх коментарів усіх користувачів, нові коментарі повинні виводитися першими, коментарі поточного користувача повинні буди виділені поміж інших.

## Обладнання

Персональний комп'ютер. Пакет програм XAMPP. Текстовий редактор Sublime Text 3 або IDE NetBeans. Web-браузер Chrome, Firefox, Opera

## Хід роботи


1.  Уважно ознайомтеся з метою л/р.
2.  Заходимо в PHPmyAdmin за адресою `http://localhost/phpmyadmin/`, попередньо запустивши web-сервер Apache та СУБД MySQL у вікні прикладки XAMPP Control Panel. Створюємо БД «gbook». Далі створимо таблиці, переходимо на вкладку SQL і пишемо наступне:
```sql
CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(100) NOT NULL,
`email` varchar(150) NOT NULL,
`password` varchar(100) NOT NULL,
`first_name` varchar(80) NOT NULL,
`last_name` varchar(80) NOT NULL,
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`) )
ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `comments` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`comment` text NOT NULL,
`created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE )
ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
3.  Закінчивши роботу з БД перейдемо до створення файлів необхідних для роботи скрипта.

    Перший файл буде називатися «config.php». Для початку необхідно відкрити сесію функцією `session_start()`. Далі визначаємо константи та підключаємося до БД за допомогою PDO.

    ```php
    <?php define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DBNAME", "gbook");
    define("CHARSET", "utf8");
    define("SALT", "PoLiTeHSILA");
    $dsn = "mysql:host=" . HOST . "; dbname=" . DBNAME . ";charset=" . CHARSET;
    try { $dbConn = new PDO($dsn, USER, PASSWORD); }
    catch(PDOException $e) { die('Підключення не вдалося: ' . $e->getMessage()); }
    ```
4.  Тепер створимо сторінку реєстрації. У проекті створіть новий файл `register.php`.

5.  В першу чергу нам необхідно підключити файл `config.php`.

    `require_once("config.php");`

    Далі перевіримо чи авторизований користувач та у противному випадку виконаємо редирект на сторінку index.php у якій будуть зберігатися коментарі нашої гостьової книги та форма додавання кометарів.

    `if (!empty($_SESSION['user_id'])) { header("location: /index.php"); }`

    Ці дії необхідно буде виконати у кожному файлі проекту, лише з одною поправкою: у файлі `index.php` редиректити на `login.php`.

6.  Наступним представлений код для валідації полів форми. Перевіряємо кожне поле на непустоту та довжину поля, так як існують обмеження на довжину поля в БД.

    ```sql
    $errors = [];
    if (!empty($_POST)) {
    if (empty($_POST['user_name'])) { $errors[] = 'Введіть логін'; }
    if (empty($_POST['email'])) { $errors[] = 'Введіть email'; }
    if (empty($_POST['first_name'])) { $errors[] = "Введіть ім'я"; }
    if (empty($_POST['last_name'])) { $errors[] = 'Введіть прізвище'; }
    if(empty($_POST['password'])) { $errors[] = 'Введіть пароль'; }
    if(empty($_POST['confirm_password'])) { $errors[] = 'Підтвердіть пароль'; }
    if(strlen($_POST['user_name']) > 100) { $errors[] = 'Логін перевищує допустимий розмір. Макс розмір 100 символів'; }
    if(strlen($_POST['first_name']) > 80) { $errors[] = 'Імя перевищує допустимий розмір. Макс розмір 100 символів'; }
    if(strlen($_POST['last_name']) > 150) { $errors[] = 'Прізвище перевищує допустимий розмір. Макс розмір 150 символів'; }
    if(strlen($_POST['password']) < 6) { $errors[] = 'Пароль повинен містити не менше 6 символів'; }
    if($_POST['password'] !== $_POST['confirm_password']) { $errors[] = 'Паролі не зпівпадають'; } } ?>```
7.  Після того як ми створили валідацію на серверній стороні, необхідно створити блок для відображення помилок, який буде розміщуватися зверху форми. Зверніть увагу на ізолювання php коду в html та форму запису оператора foreach.

    ```html
    <div style="color: red;">
    <?php foreach ($errors as $error) :?>
    <p><?php echo $error;?></p>
    <?php endforeach; ?> </div>```
8.  Сама Html-форма

    ```html
    <!DOCTYPE html>
    <html>
    <head>
    <title>Гостьова книга</title>
    <meta charset="UTF-8">
    </head>
    <body>
    <h1>Реєстрація</h1>
    <div>
    <form method="POST">
    <div style="color: red;"> <?php foreach ($errors as $error) :?>
    <p><?php echo $error;?></p> <?php endforeach; ?> </div>
    <div>
    <label>Логін:</label>
    <div> <input type="text" name="user_name" id="username" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : '');?>"/>
    <span id="username_error" style="color: red;"></span> </div>
    </div>
    <div>
    <label>Електронна пошта:</label>
    <div> <input type="email" name="email" id="email" required="" value="<?php echo (!empty($_POST['email']) ? $_POST['email'] : '');?>"/>
    <span id="email_error" style="color: red;"></span> </div>
    </div>
    <div>
    <label>Ім'я:</label>
    <div> <input type="text" name="first_name" required="" value="<?php echo (!empty($_POST['first_name']) ? $_POST['first_name'] : '');?>"/> </div>
    </div>
    <div>
    <label>Прізвище:</label>
    <div> <input type="text" name="last_name" required="" value="<?php echo (!empty($_POST['last_name']) ? $_POST['last_name'] : '');?>"/> </div>
    </div>
    <div>
    <label>Пароль:</label>
    <div> <input type="password" name="password" required="" value=""/> </div>
    </div>
    <div>
    <label>Підтвердіть пароль:</label>
    <div> <input type="password" name="confirm_password" required="" value=""/> </div>
    </div>
    <div> <br/><input type="submit" name="submit" id="submit" required="" value="Зареєструватися"> </div>
    </form>
    </div>
    </body>
    </html>
    ```

    ```php
    <?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : '');?>
    ```
    \- дана конструкція в атрибуті `value` дозволяє при неуспішній відправці форми не втратити раніше введені значення. Вона використувується для всіх input, окрім пароля, так як стандартною практикою є при виникненні помилки під час відправки форми пароль та його підтвердження необхідно вводити заново.

9.  Після того як валідація була проведена, необхідно написати код додавання користувача в БД. Виконувати його потрібно після перевірки на непустоту суперглобального масива _POST та без наявності помилок при введенні даних.

    ```sql
    if(empty($errors)) { $stmt = $dbConn->prepare('INSERT INTO users(`username`, `email`, `password`, `first_name`, `last_name`) VALUES(:username, :email, :password, :first_name, :last_name)');
    $stmt->execute(array('username' => $_POST['user_name'], 'email' => $_POST['email'], 'password' => sha1($_POST['password'].SALT), 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name']));
    //header("location: /login.php"); }
    ```

    Під час додавання пароля в базу використовується хеш-функція SHA-1, якій передається введений пароль та відбувається конкатенація з константою, що містить сіль.

    До закоментованого рядка редиректу ми повернемося пізніше.

10. Збережіть та перевірте працездатність форми реєстрації, спробувавши заповнити поля тестовими даними.
11. Створимо сторінку авторизації коритувачів. Додамо новий файл до нашого проекту з назвою `login.php`.

12. Далі необхідно створити html-сторінку, що мало відрізняється від форми реєстрації. Ця форма буде вміщувати тільки два поля.

    ```html
    <!DOCTYPE html>
    <html>
    <head>
    <title>Гостьова книга</title>
    <meta charset="UTF-8">
    </head>
    <body>
    <h1>Вхід</h1>
    <div> <form method="POST">
    <div style="color: red;"> <?php foreach ($errors as $error): ?>
    <p><?php echo $error; ?></p> <?php endforeach; ?> </div>
    <div>
    <label>Логін / Електронна пошта:</label>
    <div> <input type="text" name="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : ''); ?>"/> </div>
    </div>
    <div>
    <label>Пароль:</label>
    <div> <input type="password" name="password" required="" value=""/> </div>
    </div>
    <div> <br/> <input type="submit" name="submit" value="Увійти"> </div>
    </form>
    </div>
    </body>
    </html>
    ```
13. Далі необхідно написати код для валідації цієї форми, тобто поля перервіряються на непустоту.
```sql
if (!empty($_POST)) { if (empty($_POST['user_name'])) { $errors[] = 'Будь-ласка введіть логін / email'; }
if (empty($_POST['password'])) { $errors[] = 'Будь-ласка введіть пароль'; } }
```
14. Далі перевіряється відсутність помилок валідації. Потрібно перевірити правильність вводу логіна та пароля. Для цього виконуємо запит на вибірку, отримуючи id з таблиці користувачів, де отриманий логін зпівпадає з полем login та email, і звичайно повинні зпівпадати паролі. Функцією `fetchColumn()`дістаємо значення одного стовпця виконаного запиту, тобто значення id.

    ```sql
    if (empty($errors)) { $stmt = $dbConn->prepare('SELECT id FROM users WHERE (username = :username or email = :username) and password = :password');
    $stmt->execute(array( 'username' => $_POST['user_name'],
    sha1('password' => $_POST['password'].SALT) ));
    $id = $stmt->fetchColumn();
    if (!empty($id)) { $_SESSION['user_id'] = $id;
    die("Ви успішно авторизовані"); }
    else { $errors[] = 'Будь-ласка введіть правильні дані'; } }
    ```
    Якщо це поле не пусте, то користувач коректно ввів свій логін та пароль, і можна зберегти його id в сесію. Це необхідно для перевірки успішної авторизації користувача.

15. Тепер повернемося до коду сторінки реєстрації та розкоментуємо хедер для редиректу після реєстрації на сторінку авторизації. Також потрібно додати до рядка параметр для відображення на сторінці авторизації повідомлення про успішну реєстрацію. `header("location: /login.php?registration=1");`

    У файлі `login.php` необхідно дописати код, який приймає з суперглобального масиву GET цей параметр і у випадку його виявлення буде виводитися потрібне повідомлення.

    ```sql
    $isRegistered = 0;
    if (!empty($_GET['registration'])) { $isRegistered = 1; }```
16. І тепер в html перед заголовком можна виконати перевірку та вивід повідомлення

    ```html
    <?php if (!empty($isRegistered)): ?>
    <h2>Ви успішно зареєструвалися. Використайте дані для входу</h2> <?php endif; ?>
    ```
17. Збережіть обидва файли та перевірте редирект на сторінку авторизації, зареєструвавши нового користувача.
18. Залишилося створити сторінку для додавання та відображення коментарів. Створіть файл `index.php`.
19. Для початку необхідно підключити файл з настройками та перевірити чи користувач авторизований. Аналогічний код представлений на початку попередніх файлів, тільки з поправкою: редирект на сторінку авторизації.
20. Далі необхідно перевірити суперглобальний масив POST та вивести коментарі з БД за спаданням (нові коменти виводяться зверху). Так як відбувається сабміт тільки одного поля (коментар), то достатньо перевірити цей масив по ключу comment на непустоту - це зпрощує код валідації.

    ```sql
    if (!empty($_POST['comment'])) { $stmt = $dbConn->prepare("INSERT INTO comments(`user_id`, `comment`) VALUES (:user_id, :comment)");
    $stmt->execute(array('user_id' => $_SESSION['user_id'], 'comment' => $_POST['comment'])); }
    $stmt = $dbConn->prepare("SELECT * FROM comments ORDER BY id DESC");
    $stmt->execute(); $comments = $stmt->fetchAll();```
21. Далі розглянемо код html-сторінки з коментарями. Використовується 2 основних блоки: форма додавання коментаря та їх вивід. Для вводу коментаря використовується тег `textarea` так як коментар може перебільшувати довжину поля 255 символів, і в БД використовується тип поля TEXT.

    ```html
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <title>Коментарі</title>
    </head>
    <body>
    <div id="comments-header">
    <h1>Коментарі</h1> </div>
    <div id="comments-form">
    <h3>Будь-ласка, залиште свій кометар</h3>
    <form method="POST">
    <div> <textarea name="comment"></textarea> </div>
    <div> <br> <input type="submit" name="submit" value="Відправити"> </div>
    </form>
    </div>
    <div id="comments-panel">
    <h3>Коментарі:</h3> <?php foreach ($comments as $comment) : ?>
    <p> <?php if ($comment['user_id'] == $_SESSION['user_id']) echo 'style="font-weight: bold;"'; ?>><?php echo $comment['comment'];?>
    <span class="comment-date">(<?php echo $comment['created_at'];?>)</span>
    </p> <?php endforeach; ?>
    </div>
    </body>
    </html>
    ```
22. Додамо css-стилі для виділення кордону блоків та зміщення контенту

    ```css
    <style>
    #comments-header{
        text-align: center;}
    #comments-form{
        border: 1px dotted black;
        width: 50%;
        padding-left: 20px;}
    #comments-form textarea{
        width: 70%;
        min-height: 100px;}
    #comments-panel{
        border: 1px dashed black;
        width: 50%;
        padding-left: 20px;
        margin-top: 20px;}
    .comment-date{
        font-style: italic}
    </style>
    ```
23. Далі необхідно написати код для перебору усіх коментарів з змінної `$comments` та виводити їх у блок. За метою л/р коментарі поточного користувача повинні буди виділені жирним шрифтом. Також виводиться час створення коментаря для відображення коментарів у порядку зпадання.

    ```html
    <h3>Коментарі:</h3> <?php foreach ($comments as $comment) : ?>
    <p> <?php if ($comment['user_id'] == $_SESSION['user_id']) echo 'style="font-weight: bold;"'; ?>><?php echo $comment['comment'];?>
    <span class="comment-date">(<?php echo $comment['created_at'];?>)</span>
    </p> <?php endforeach; ?>
    ```
24. Наостанок розглянемо код вставки коментаря в БД.

    ```sql
    $stmt = $dbConn->prepare("SELECT * FROM comments ORDER BY id DESC");
    $stmt->execute(); $comments = $stmt->fetchAll();
    ```
25. Перевірте працездатність файлу безпосередньо в браузері.
26. Весь код можна переглянути на github за посиланням: [https://github.com/BogdanGaybura/Guestbook](https://github.com/BogdanGaybura/Guestbook)

27. Для кожного етапу роботи зробити знімки екрану та додати їх у звіт з описом кожного скіншота
28. Додати програмний код завдання для самомтійного виконання
29. Дати відповіді на контрольні запитання
30. Зберегти звіт у форматі PDF

## Контрольні питання

1.  Навіщо виконувати валідацію як на серверній стороні так і на стороні браузера?
2.  Для чого використовується функція `strlen()`?
3.  Яка різниця між функціями `fetchColumn()` та `fetchAll()`?
4.  Як можна виконати редирект?
5.  За допомогою якого оператора можна виконати сортування результатів запиту вибірки?
