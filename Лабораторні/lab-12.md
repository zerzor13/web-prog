[Перелік усіх робіт](README.md)

## Читання та збереження даних в таблицях MySQL

## Мета роботи

Вивчити основи баз даних і навчитися їх створювати в СУБД MySQL

## Обладнання

Персональний комп'ютер. Пакет програм XAMPP. Текстовий редактор Sublime Text 3 або IDE NetBeans. Web-браузер Chrome, Firefox, Opera

## Хід роботи

1.  Запустіть web-сервер Apache та СУБД MySQL у вікні прикладки XAMPP Control Panel.
2.  Відкрийте браузер і в адресному рядку введіть наступну адресу: `http://localhost/phpmyadmin/`
3.  Створіть нову БД з ім'ям Products.
4.  Зробити створену базу даних активною, вибравши її ім'я в списку баз даних.
5.  Перейдіть на вкладку SQL та виконайте наступний скрипт.

    ```SQL
    CREATE TABLE IF NOT EXISTS `products` (
    `id` int(11) NOT NULL AUTO_INCREMENT, `product_code` varchar(60) NOT NULL, `product_name` varchar(60) NOT NULL, `product_desc` tinytext NOT NULL, `price` decimal(10,2) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `product_code` (`product_code`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=33; INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `price`) VALUES (1, 'PD1001', 'Android Phone FX1', 'Di sertakan secara rambang yang lansung tidak munasabah. Jika anda ingin menggunakan Lorem Ipsum, anda perlu memastikan bahwa tiada apa yang', 200.50), (2, 'PD1002', 'Television DXT', 'Ia menggunakan kamus yang mengandungi lebih 200 ayat Latin, bersama model dan struktur ayat Latin, untuk menghasilkan Lorem Ipsum yang munasabah.', 500.85), (3, 'PD1003', 'External Hard Disk', 'Ada banyak versi dari mukasurat-mukasurat Lorem Ipsum yang sedia ada, tetapi kebanyakkannya telah diubahsuai, lawak jenaka diselitkan, atau ayat ayat yang', 100.00);
    ```
6.  Перейти до каталогу `C:\xampp\htdocs\` та очистити його
7.  У зв'язку з припиненням підтримки PHP MySQL в 2011 році для роботи з базами даних все більш широке застосування знаходять PDO (PHP Data Objects) або MySqli.
8.  MySqli пропонує два способи з'єднання з базою даних: процедурний і об'єктно-орієнтований. Рекомендовано використовувати об'єктно-орієнтований. Процедурний схожий на (старий) MySql, тому для новачків його використання, можливо, буде краще, але варто пам'ятати, що їм користуватися не рекомендується.

    `//процедурний стиль $mysqli = mysqli_connect('host','username','password','database_name'); //об'єктно-орієнтований стиль (рекомендується) $mysqli = new mysqli('host','username','password','database_name');`
9.  Нижче показано відкриття з'єднання з базою даних об'єктно-орієнтованим способом. Цей спосіб буде використовуватися і в усіх наведених нижче прикладах.

    Отже, створіть файл config.php у який помістіть настпуний код:

    ```php
    <?php //Налаштування БД $database_host = 'localhost'; $database_username = 'root';
    $database_password = '';
    $database_name = 'Products';
    //Відкриваємо нове з'єднання з MySQL сервером $mysqli = new mysqli($database_host,
    $database_username,
    $database_password,
    $database_name);
    //Виводимо помилку з'єднання if ($mysqli->connect_error) { die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error); } ?>
    ```
10. Створіть файл index.php у якому підключіть файл з настройками БД та виконуте представлені приклади.
11. **Вибір (SELECT) результуючого ряду у вигляді асоціативного масиву.** `mysqli_fetch_assoc()`: в наведеному нижче коді відбувається вилучення результуючого ряду у вигляді асоціативного масиву. Масив, що повертається містить рядки, отримані з бази даних, де імена стовпців будуть ключем, що використовується для доступу до внутрішніх даних. Як показано нижче, дані відображаються у вигляді HTML таблиці.

    ```PHP
    <?php $mysqli = new mysqli('host','username','password','database_name');
    if ($mysqli->connect_error) { die('Error : ('. $mysqli->connect_errno .') '.
    $mysqli->connect_error); }
    $results = $mysqli->query("SELECT id, product_code, product_desc, price FROM products");
    print '<table border="1">';
    while($row = $results->fetch_assoc()) { print '<tr>';
    print '<td>'.$row["id"].'</td>';
    print '<td>'.$row["product_code"].'</td>';
    print '<td>'.$row["product_name"].'</td>';
    print '<td>'.$row["product_desc"].'</td>';
    print '<td>'.$row["price"].'</td>';
    print '</tr>'; } print '</table>';
    $results->free();
    $mysqli->close();
    ?>
    ```
12. **Вибір (SELECT) результуючого ряду у вигляді масиву (асоціативний, звичайний, або в обидва).** Фукнція `fetch_array()`: повертає масив з об'єднаним функціоналом `mysqli_fetch_row` і `mysqli_fetch assoc`. Ця функція є розширеною версією функції `mysqli_fetch_row()`; для доступу до даних можна використовувати як рядок, так і числа.

    ```PHP
    <?php $mysqli = new mysqli('host','username','password','database_name');
    if ($mysqli->connect_error) { die('Error : ('. $mysqli->connect_errno .') '.
    $mysqli->connect_error); }
    $results = $mysqli->query("SELECT id, product_code, product_desc, price FROM products");
    print '<table border="1"';
    while($row = $results->fetch_array()) { print '<tr>';
    print '<td>'.$row["id"].'</td>';
    print '<td>'.$row["product_code"].'</td>';
    print '<td>'.$row["product_name"].'</td>';
    print '<td>'.$row["product_desc"].'</td>';
    print '<td>'.$row["price"].'</td>';
    print '</tr>'; } print '</table>';
    $results->free(); $mysqli->close();
    ?>
    ```
13. **Вибір (SELECT) результуючого ряду у вигляді об'єкта.** `fetch_object()`: щоб отримати результуючий набір у вигляді об'єкта, потрібно скористатися MySqli `fetch_object()`. Атрибути об'єкта будуть відображати імена полів, знайдених всередині результуючого набору.

    ```PHP
    <?php $mysqli = new mysqli('host','username','password','database_name');
    if ($mysqli->connect_error) { die('Error : ('. $mysqli->connect_errno .') '.
    $mysqli->connect_error); }
    $results = $mysqli->query("SELECT id, product_code, product_desc, price FROM products");
    print '<table border="1">';
    while($row = $results->fetch_object()) { print '<tr>';
    print '<td>'.$row->id.'</td>';
    print '<td>'.$row->product_code.'</td>';
    print '<td>'.$row->product_name.'</td>';
    print '<td>'.$row->product_desc.'</td>';
    print '<td>'.$row->price.'</td>';
    print '</tr>'; } print '</table>'; $mysqli->close();
    ?>
    ```
14. **Вибір (SELECT) одиночного значення.** Одиночне значення отримати з бази даних можна за допомогою `fetch_object()`

    ```PHP
    <?php $mysqli = new mysqli('host','username','password','database_name');
    if ($mysqli->connect_error) { die('Error : ('.
    $mysqli->connect_errno .') '.
    $mysqli->connect_error); }
    $product_name = $mysqli->query("SELECT product_name FROM products WHERE id = 1")->fetch_object()->product_name;
    print $product_name; $mysqli->close();
    ?>
    ```
15. **Витягуємо (SELECT COUNT) кількість рядків в таблиці.** Іноді потрібно дізнатися кількість рядків у таблиці, особливо при нумерації сторінок.

    ```PHP
    <?php $mysqli = new mysqli('host','username','password','database_name');
    if ($mysqli->connect_error) { die('Error : ('.
    $mysqli->connect_errno .') '. $mysqli->connect_error); }
    $results = $mysqli->query("SELECT COUNT(*) FROM users");
    $get_total_rows = $results->fetch_row(); $mysqli->close();
    ?>
    ```
16. **Вибір (SELECT) за допомогою шаблонів (prepared statements).**

    **prepared statements** \- спеціальний інструмент СУБД, що дозволяє прискорити послідовне виконання повторюваних запитів, побудованих за одним і тим же шаблоном.

    Однією з особливостей MySqli є можливість використання вже написаних шаблонів: тобто запит досить написати один раз, після чого його можна багаторазово виконувати з різними параметрами. Використання вже написаних шаблонів покращує продуктивність для великих таблиць і складних запитів. Для запобігання попаданню шкідливого коду аналіз кожного запиту здійснюється сервером окремо.

    Код нижче використовує шаблон (Prepared statement), щоб отримувати дані з бази даних. Заповнювач `?` в запиті SQL грає роль маркера і буде заміщений параметром, який, в свою чергу, може бути рядком, цілим числом, double або blob. У нашому випадку це рядок `$search_product`.

    ```PHP
    <?php $search_product = "PD1001";
    //product id
    //Створення prepared statement
    $query = "SELECT id, product_code, product_desc, price FROM products WHERE product_code=?";
    $statement = $mysqli->prepare($query);
    //Параметри прив’язки для маркерів, де (s = string, i = integer, d = double, b = blob) $statement->bind_param('s', $search_product);
    //Виконання запиту $statement->execute();
    //Зв'язування результуючих змінних $statement->bind_result($id, $product_code, $product_desc, $price);
    print '<table border="1">';
    //Вивід записів while($statement->fetch()) { print '<tr>';
    print '<td>'.$id.'</td>';
    print '<td>'.$product_code.'</td>';
    print '<td>'.$product_desc.'</td>';
    print '<td>'.$price.'</td>';
    print '</tr>'; } print '</table>';
    //Закриття з'єднання $statement->close();
    ?>
    ```
17. Той самий запит із декількома параметрами:

    ```PHP
    <?php $search_ID = 1;
    $search_product = "PD1001";
    $query = "SELECT id, product_code, product_desc, price FROM products WHERE ID=? AND product_code=?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param('is', $search_ID, $search_product);
    $statement->execute();
    $statement->bind_result($id, $product_code, $product_desc, $price);
    print '<table border="1">';
    while($statement->fetch()) { print '<tr>';
    print '<td>'.$id.'</td>';
    print '<td>'.$product_code.'</td>';
    print '<td>'.$product_desc.'</td>';
    print '<td>'.$price.'</td>';
    print '</tr>'; } print '</table>';
    $statement->close();
    ?>
    ```
18. **Вставка (INSERT) запису.** Код нижче вставляє в таблицю новий запис.

    ```php
    <?php //Значення, які потрібно вставити в таблицю бази даних
    $product_code = '"'.
    $mysqli->real_escape_string('P1234').'"';
    $product_name = '"'.
    $mysqli->real_escape_string('42 inch TV').'"';
    $product_price = '"'.
    $mysqli->real_escape_string('600').'"';
    $insert_row = $mysqli->query("INSERT INTO products (product_code, product_name, price) VALUES($product_code, $product_name, $product_price)");
    if($insert_row){ print 'Запит успішно виконаний! ID останнього вставленого запису: ' .$mysqli->insert_id .'<br />'; }
    else{ die('Помилка: ('. $mysqli->errno .') '. $mysqli->error);
    } ?>
    ```
19. Фрагмент коду нижче вставляє ті ж значення за допомогою шаблонів (prepared statement). Як ми вже говорили, шаблони надзвичайно ефективні проти SQL ін'єкцій. Для наведеного прикладу їх використання є оптимальним варіантом.

    ```PHP
    <?php $product_code = 'P1234';
    $product_name = '42 inch TV';
    $product_price = '600';
    $query = "INSERT INTO products (product_code, product_name, price) VALUES(?, ?, ?)";
    $statement = $mysqli->prepare($query);
    $statement->bind_param('sss', $product_code, $product_name, $product_price);
    if($statement->execute()){ print 'Запит успішно виконаний! ID останнього вставленого запису: ' .$statement->insert_id .'<br />';
    }else{ die('Помилка: ('. $mysqli->errno .') '. $mysqli->error);
    } $statement->close();
    ?>
    ```
20. **Вставка (INSERT) декількох записів.** Вставка декількох рядків одночасно здійснюється шляхом включення ряду значень стовпців, де кожен ряд значень повинен бути у дужках і відділений від інших комою. Іноді потрібно дізнатися, скільки записів було вставлено, оновлено або видалено, для цього можна скористатися `$mysqli->affected_rows`.

    ```PHP
    <?php //product 1
    $product_code1 = '"'.
    $mysqli->real_escape_string('P1').'"';
    $product_name1 = '"'.
    $mysqli->real_escape_string('Google Nexus').'"';
    $product_price1 = '"'.
    $mysqli->real_escape_string('149').'"'; //product 2
    $product_code2 = '"'.
    $mysqli->real_escape_string('P2').'"';
    $product_name2 = '"'.
    $mysqli->real_escape_string('Apple iPad 2').'"';
    $product_price2 = '"'.
    $mysqli->real_escape_string('217').'"'; //product 3
    $product_code3 = '"'.
    $mysqli->real_escape_string('P3').'"';
    $product_name3 = '"'.
    $mysqli->real_escape_string('Samsung Galaxy Note').'"';
    $product_price3 = '"'.
    $mysqli->real_escape_string('259').'"'; //Insert multiple rows
    $insert = $mysqli->query("INSERT INTO products(product_code, product_name, price) VALUES ($product_code1, $product_name1, $product_price1), ($product_code2, $product_name2, $product_price2), ($product_code3, $product_name3, $product_price3)");
    if($insert){ print 'Запит успішно виконаний! Всього ' .
    $mysqli->affected_rows .' рядків додано.';
    }else{ die('Помилка: ('. $mysqli->errno .') '. $mysqli->error);
    } ?>
    ```
21. **Оновлення (Update)/видалення (Delete) записів.** Принцип оновлення і видалення записів такий самий. Достатньо замінити рядок запиту на UPDATE або DELETE

    ```PHP
    <?php //Запит на оновлення
    $results = $mysqli->query("UPDATE products SET product_name='52 inch TV', product_code='323343' WHERE ID=24"); //Запит на видалення
    $results = $mysqli->query("DELETE FROM products WHERE ID=24");
    if($results){ print 'Запит успішно виконаний! Запис оновлено/видалено';
    }else{ print 'Помилка: ('. $mysqli->errno .') '. $mysqli->error;
    } ?>
    ```
22. **Оновлення за допомогою шаблонів (prepared statements).** Приклад поновлення запису за допомогою шаблонів (prepared statements) наведено нижче.

    ```php
    <?php $product_name = '52 inch TV';
    $product_code = '9879798';
    $find_id = 24;
    $query = "UPDATE products SET product_name=?, product_code=? WHERE ID=?";
    $statement = $mysqli->prepare($query);
    $results = $statement->bind_param('ssi',
    $product_name, $product_code, $find_id);
    if($results){ print 'Запит успішно виконаний! Запис оновлено'; }else{ print 'Помилка: ('. $mysqli->errno .') '. $mysqli->error;
    } ?>
    ```
23. **Видалення старих записів.** Видаленню піддаються всі записи, що знаходяться на сервері більше 1 дня; кількість днів можна задати самому.
    ```php
    <?php //Запит на видалення
    $results = $mysqli-<query("DELETE FROM products WHERE added_timestamp > (NOW() - INTERVAL 1 DAY)");
    if($results){ print 'Запит успішно виконаний! Видалено одноденні записи';
    }else{ print 'Помилка: ('. $mysqli-<errno .') '. $mysqli-<error;
    } ?>```
24. Mysqli - ця бібліотека, яка за великим рахунком, не призначена для використання безпосередньо в коді. Вона може послужити доброю основою для створення бібліотеки вищого рівня. При роботі з mysqli слід також пам'ятати про забезпечення безпеки вашого застосування, зокрема про захист від SQL-ін'єкцій. У разі використання PDO (з його підготовленими запитами), такий захист йде вже "з коробки", головне правильно застосувати необхідні методи.
25. Тестова база даних з таблицею

    ```sql
    CREATE DATABASE `pdo-test`
    CHARACTER SET utf8 COLLATE utf8_general_ci;
    USE pdo-test;
    CREATE TABLE categories (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id),
    name VARCHAR(255) NOT NULL );
    INSERT INTO `categories` (`name`)
    VALUES ('Ноутбуки и планшеты'), ('Компьютеры и периферия'), ('Комплектующие для ПК'), ('Смартфоны и смарт-часы'), ('Телевизоры и медиа'), ('Игры и приставки'), ('Аудиотехника'), ('Фото-видеоаппаратура'), ('Офисная техника и мебель'), ('Сетевое оборудование'), ('Крупная бытовая техника'), ('Товары для кухни'), ('Красота и здоровье'), ('Товары для дома'), ('Инструменты'), ('Автотовары');```
26. Процес роботи з PDO не надто відрізняється від традиційного. У загальному випадку, процес використання PDO виглядає так:
    * підключення до бази даних;
    * за необхідності, підготовка запиту і зв'язування параметрів;
    * виконання запиту.
27. З'єднання встановлюються автоматично при створенні об'єкта PDO від його базового класу.
    ```PHP
    <?php
    $db = new PDO('mysql:host=localhost;dbname=pdo', 'root', 'password');
    ?>```

    При помилці підключення PHP видасть помилку: `Fatal error: Uncaught PDOException: ...`
    ```PHP
    <?php
    try { $dbh = new PDO('mysql:host=localhost;dbname=pdo', 'root', 'password');
    } catch (PDOException $e) { print "Помилка!: " . $e->getMessage();
    die();
    } ?>```

    У цьому прикладі підключення ми використали конструкцію try ... catch.

28. Як і в mysqli, PDO дозволяє отримувати дані в різних режимах. Для визначення режиму, клас PDO містить відповідні константи.

    * `PDO::FETCH_ASSOC` \- повертає масив, індексований по імені стовпця в таблиці бази даних;
    * `PDO::FETCH_NUM` \- повертає масив, індексований за номером стовпця;
    * `PDO::FETCH_OBJ` \- повертає анонімний об'єкт з іменами властивостей, відповідними іменами стовпців. Наприклад, `$row->id` буде містити значення із стовпця id.
    * `PDO::FETCH_CLASS` \- повертає новий екземпляр класу, із значеннями властивостей, відповідними даними з рядка таблиці. У разі, якщо зазначений параметр `PDO::FETCH_CLASSTYPE`, ім'я класу буде визначено зі значення першого стовпчика.
    * У PDO існує два способи виконання запитів:
        * **Прямий** \- складається з одного кроку;
        * **Підготовлений** \- складається з двох кроків.
    * **Прямі запити.**

        * `query()` використовується для операторів, які не вносять зміни, наприклад `SELECT`. Повертає об'єкт `PDOStatement`, з якого за допомогою методів `fetch()` або `fetchAll` витягуються результати запиту. Його можна порівняти з `mysql resource`, який повертала `mysql_query()`;

        * `exec()` використовується для операторів `INSERT, DELETE, UPDATE`. Повертає число оброблених запитом рядків.

        Прямі запити використовуються тільки в тому випадку, якщо в запиті відсутні змінні і є впевненість, що запит безпечний і правильно екранований.

        ```PHP
        <?php
        $stmt = $db->query("SELECT * FROM categories");
        while ($row = $stmt->fetch()) { echo '<pre>';
        print_r($row);
        } ?>
        ```
    * **Підготовлені запити.** Якщо у запит передається хоча б одна змінна, то цей запит в обов'язковому порядку повинен виконуватися тільки через підготовлені вирази. Це звичайний SQL запит, в якому замість змінної ставиться спеціальний маркер - плейсхолдер. PDO підтримує позиційні плейсхолдери (?). Для яких важливий порядок переданих змінних, і іменовані (:name), для яких порядок не важливий. Приклади:
        ```SQL
        `$sql = "SELECT name FROM categories WHERE id = ?";
        $sql = "SELECT name FROM categories WHERE name = :name";
        ```
    * Щоб виконати такий запит, спочатку його треба підготувати за допомогою методу `prepare()`. Він повертає PDO statement, але ще без даних. Щоб їх отримати, треба виконати цей запит, попередньо передавши в нього змінні. Передати можна за допомогою методу `execute()`, передавши йому масив зі змінними:

        Коли викликається `$connection->prepare()` створюється підготовлений запит. Підготовлені запити \- це здатність системи управління базами даних отримати шаблон запиту, скомпілювати його і виконати після отримання значень змінних, використаних в шаблоні. Схожим чином працюють шаблонизатори `Smarty` і `Twig`.

        ```PHP
        <?php
        $stmt = $pdo->prepare("SELECT `name` FROM categories WHERE `id` = ?");
        $stmt->execute([$id]);
        $stmt = $pdo->prepare("SELECT `name` FROM categories WHERE `name` = :name");
        $stmt->execute(['name' => $name]);
        ?>```
    * Як видно, у випадку іменованих плейсхолдерів в `execute()` повинен передаватися масив, в якому ключі повинні збігатися з іменами цих плейсхолдерів. Після цього можна витягти результати запиту:

        ```php
        <?php $id = 1;
        $stmt = $db->prepare("SELECT * FROM categories WHERE `id` = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_LAZY);
        echo '<pre>';
        print_r($category);
        ?>```
    * **Зауваження!** Підготовлені запити \- основна причина використовувати PDO, оскільки це єдиний безпечний спосіб виконання SQL запитів, в яких беруть участь змінні.
    * **Отримання даних. Метод `fetch().`** Вище ми познайомилися з методом `fetch()`, який служить для послідовного отримання рядків з БД. Цей метод є аналогом функції `mysq_fetch_array()` і їй подібних, але діє по-іншому: замість безлічі функцій тут використовується одна, але її поведінка задається переданим параметром. Рекомендовано застосовувати `fetch()` в режимі `FETCH_LAZY`

        ```php
        <?php $id = 1;
        $stmt = $db->prepare("SELECT * FROM categories WHERE `id` = ?"); $stmt->execute([$id]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) { echo 'Category name: '.$row->name;
        } ?>```

        У цьому режимі не витрачається зайва пам'ять, і до того ж до колонок можна звертатися будь\-яким з трьох способів \- через індекс, ім'я, або властивість (через `->`). Недоліком же даного режиму є те, що він не працює з `fetchAll()`

    * **Отримання даних. Метод `fetchColumn().`** Також у `PDO statement` є метод для отримання значення єдиної колонки. Дуже зручно, якщо ми запитуємо тільки одне поле \- в цьому випадку значно скорочується кількість коду:

        ```php
        <?php $id = 1;
        $stmt = $db->prepare("SELECT `name` FROM categories WHERE `id` = ?");
        $stmt->execute([$id]);
        $name = $stmt->fetchColumn();
        echo 'Category name: '.$name;
        ?>```
    * **Отримання даних. Метод `fetchAll().`** Також у `PDO statement` є метод для отримання значення єдиної колонки. Дуже зручно, якщо ми запитуємо тільки одне поле \- в цьому випадку значно скорочується кількість коду:

        ```php
        <?php
        $data = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $k => $v){ echo 'Category name: '.$v['name'].'<br>';
        } ?>```
    * **PDO и оператор LIKE.**Працюючи з підготовленими запитами, слід розуміти, що плейсхолдер може замінювати тільки рядок або число. Ні ключове слово, ні ідентифікатор, ні частину рядка або набір рядків через плейсхолдер підставити можна. Тому для LIKE необхідно спочатку підготувати рядок пошуку цілком, а потім її підставляти в запит:

        ```php
        <?php
        $search = 'комп';
        $query = "SELECT * FROM categories WHERE `name` LIKE ?";
        $params = ["%$search%"];
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;
        foreach ($data as $category){ echo $i++ . '. ' .
        $category['name'].'<br>';
        } ?>```

        **Зауваження!** Пошук може не працювати, тому що з БД приходять дані у неправильному кодуванні. Необхідно додати кодування до підключення, якщо воно там не вказано!

        `$db = new PDO('mysql:host=localhost;dbname=pdo;charset=utf8', 'root', '');`
    * **PDO и оператор LIMIT.**Зауваження! Коли PDO працює в режимі емуляції, всі дані, які були передані безпосередньо в `execute()`, форматуються як рядки, тобто, беруться у лапки. Тому `LIMIT ?,?` перетворюється в `LIMIT '10', '10'` і очевидним чином викликає помилку синтаксису і, відповідно, порожній масив даних.

        _Рішення 1_: Вийти з режиму емуляції:

        `$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);`

        _Рішення 2_: Обробляти ці цифри через `bindValue()`, примусово встановлюючи їм тип `PDO::PARAM_INT`

        `$limit = 3; $stm = $db->prepare('SELECT * FROM categories LIMIT ?'); $stm->bindValue(1, $limit, PDO::PARAM_INT); $stm->execute(); $data = $stm->fetchAll(); echo '<pre>'; print_r($data);`
    * **PDO и оператор IN**При вибірці з таблиці необхідно діставати записи, які відповідають усім значенням масиву.
        ```php
        <?php
        $arr = [1,3,6];
        $in = str_repeat('?,', count($arr) - 1) . '?';
        $sql = "SELECT * FROM categories WHERE `id` IN ($in)";
        $stm = $db->prepare($sql);
        $stm->execute($arr);
        $data = $stm->fetchAll();
        echo '<pre>';
        print_r($data);
        ?>```
    * **Додавання записів**
        ```php
        <?php
        $name = 'Нова категорія';
        $query = "INSERT INTO `categories` (`name`) VALUES (:name)";
        $params = [ ':name' => $name ];
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        ?>```
    * **Зміна записів**
        ```php
        <?php $id = 1;
        $name = 'Змінений запис';
        $query = "UPDATE `categories` SET `name` = :name WHERE `id` = :id";
        $params = [ ':id' => $id, ':name' => $name ];
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        ?>```
    * **Видалення записів**
        ```php
        <?php
        $id = 1;
        $query = "DELETE FROM `categories` WHERE `id` = ?";
        $params = [$id];
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        ?>```
    * Виконати індивідуальне завдання

    * Впевніться, що всі вихідні HTML-сторінки є валідними, використавши валідатор HTML-коду `https://validator.w3.org/`. За необхідності, виправити помилки та зауваження
    * Для кожного етапу роботи зробити знімки екрану та додати їх у звіт з описом кожного скіншота
    * Додати програмний код завдання для самомтійного виконання
    * Дати відповіді на контрольні запитання
    * Зберегти звіт у форматі PDF

## Контрольні питання

1.  Який спосіб з'єднання з базою даних є більш безпечним?
