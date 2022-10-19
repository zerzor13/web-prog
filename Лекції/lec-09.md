Інструментальні засоби візуального програмування. Лекція №9  

Інструментальні засоби візуального програмування. Лекція №9

Об'єктно-орієнтоване програмування ч.2
======================================

Модифікатори доступу
--------------------

Модифікатори доступу - це, по суті, інтерпретація інкапсуляції в ООП. Нагадую, що інкапсуляція - це механізм приховування реалізації об'єкта. І для реалізації інкапсуляції існують модифікатори доступу в PHP.

У PHP є три модифікатори доступу:

1.  Public
2.  Protected
3.  Private

Почнемо з модифікаторів доступу **public.** Даний модифікатор означає, що властивість, метод або конструктор будуть доступні для всіх об'єктів, які їх використовують.

Модифікатор доступу **protected** означає, що даний елемент об'єкта може бути використаний в самому об'єкті, а також у його дочірніх.

І, нарешті, модифікатор доступу **private** означає, що даний елемент об'єкта може бути використаний тільки в самому об'єкті і ніде більше.

Область видимості властивостей
------------------------------

Властивості класу повинні бути визначені через модифікатори public, private, або protected.

**Приклад 1**. Оголошення властивості класу


```php
<?php
/* 
Визначення MyClass 
*/
class MyClass
{
    public $public = "Загальний";
    protected $protected = "Захищений";
    private $private = "Закритий";

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

$obj = new MyClass();
echo $obj->public; // Працює
echo $obj->protected; // Невиправна помилка
echo $obj->private; // Невиправна помилка
$obj->printHello(); // Виводить Загальний, Захищений і Закритий

/* 
Визначення MyClass2 
*/
class MyClass2 extends MyClass
{
    // Ми можемо перевизначити public і protected методи, але не private
    protected $protected = "Захищений2";

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

$obj2 = new MyClass2();
echo $obj2->public; // Працює
echo $obj2->private; // Невизначений
echo $obj2->protected; // Невиправна помилка
$obj2->printHello(); // Виводить Загальний, Захищений2 і Закритий
?>
```


**Зауваження**: Метод оголошення змінної через ключове слово var, прийнятий в PHP 4, досі підтримується з метою сумісності (як синонім ключового слова public). У версіях PHP 5 нижче 5.1.3 таке використання виводить попередження E_STRICT.

Область видимості методу
------------------------

Методи класу повинні бути визначені через модифікатори public, private, або protected. Методи, де визначення модифікатора відсутня, визначаються як public.

**Приклад 2** Оголошення методу


```php
<?php
/* 
Визначення MyClass 
*/
class MyClass
{
    // Оголошення загальнодоступного конструктора
    public function __construct()
    {
    }

    // Оголошення загальнодоступного методу
    public function MyPublic()
    {
    }

    // Оголошення захищеного методу
    protected function MyProtected()
    {
    }

    // Оголошення закритого методу
    private function MyPrivate()
    {
    }

    // Це загальнодоступний метод
    function Foo()
    {
        $this->MyPublic();
        $this->MyProtected();
        $this->MyPrivate();
    }
}

$myclass = new MyClass();
$myclass->MyPublic(); // Працює
$myclass->MyProtected(); // Помилка
$myclass->MyPrivate(); // Помилка
$myclass->Foo(); // Працює загальний, захищений і закритий

/* 
Визначення MyClass2 
*/
class MyClass2 extends MyClass
{
    // Це загальнодоступний метод
    function Foo2()
    {
        $this->MyPublic();
        $this->MyProtected();
        $this->MyPrivate(); // Невиправна помилка
    }
}

$myclass2 = new MyClass2();
$myclass2->MyPublic(); // Працює
$myclass2->Foo2(); // Працює загальний і захищений, закритий не працює

class Bar
{
    public function test()
    {
        $this->testPrivate();
        $this->testPublic();
    }

    public function testPublic()
    {
        echo "Bar::testPublic \n";
    }

    private function testPrivate()
    {
        echo "Bar::testPrivate \n";
    }
}

class Foo extends Bar
{
    public function testPublic()
    {
        echo "Foo::testPublic \n";
    }

    private function testPrivate()
    {
        echo "Foo::testPrivate \n";
    }
}

$myFoo = new foo();
$myFoo->test(); // Bar::testPrivate
?>
```


Статичні методи і властивості
-----------------------------

Статичні методи класу можуть бути викликані безпосередньо у класі, а не через один із його об'єктів. Відповідно, покажчик $this в статичних методах недоступний.

Фактично, оголошення класу зі статичними методами є, більшою мірою, методом угруповання функцій і загальних для них констант і змінних.

Застосування такого підходу гарантує, що всі класи доступу до бази даних будуть реалізовувати один інтерфейс, зменшується вірогідність конфліктності імен, спрощується існування декількох версій класу доступу до бази і т.д.


```php
<?php
class MyClass
{
    static function helloWorld()
    {
        print "Hello, world";
    }
}
MyClass::helloWorld();
?>
```


Загальне використання статичних методів показано на прикладі:


```php
<?php
class Singleton
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }
}
?>
```


Подвійна двокрапка
------------------

Використовуючи цю лексему, програміст може звертатися до констант, статичних або перевантажених властивостей або методів класу.

При зверненні до цих елементів ззовні класу, програміст повинен використовувати ім'я цього класу.

**Приклад 1** Використання ::поза оголошення класу


```php
<?php
class MyClass
{
    const CONST_VALUE = "Значення константи";
}
echo MyClass::CONST_VALUE;
?>

```


Для звернення до властивостей і методів в оголошенні класу використовуються ключові слова self і parent.

**Приклад 2** Використання ::в оголошенні класу


```php
<?php
class OtherClass extends MyClass
{
    public static $my_static = "статична змінна";

    public static function doubleColon()
    {
        echo parent::CONST_VALUE . "\n";
        echo self::$my_static . "\n";
    }
}

OtherClass::doubleColon();
?>

```


Коли дочірній клас перевантажує методи, оголошені в класі-батьку, PHP не буде здійснювати автоматичний виклик методів, що належать класу-батькові. Цей функціонал покладається на метод, перевантаження в дочірньому класі. Це правило поширюється на конструктори і деструктори, перевантажені та методи.

**Приклад 3** Звернення до методу в батьківському класі


```php
<?php
class MyClass
{
    protected function myFunc()
    {
        echo "MyClass::myFunc () \n";
    }
}

class OtherClass extends MyClass
{
    /* Перезапис батьківського визначення */
    public function myFunc()
    {
        /* Але виклик батьківської функції все-рівно відбувається */
        parent::myFunc();
        echo "OtherClass::myFunc () \n";
    }
}

$Class = new OtherClass();
$Class->myFunc();
?>
```


Оператор instanceof
-------------------

Підтримка перевірки залежності від інших об'єктів. Функцією is_a (), яка міститься в PHP 4, користуватися тепер не рекомендується.


```php
<?php 
if ($obj instance of Circle) { 
print '$obj is a Circle'; 
}
?>
```


Фінальні методи і класи
-----------------------

### Метод final

Ключове слово final дозволяє вам позначати методи, щоб наслідуючий клас не міг перевантажити їх. Розмістивши перед оголошенням методів або властивостей класу ключове слово final, ви можете запобігти їх перевизначення в дочірніх класах, наприклад:


```php
<?php
class BaseClass
{
    public function test()
    {
        echo "Викликаний метод BaseClass::test () \n";
    }

    final public function moreTesting()
    {
        echo "Викликаний метод BaseClass::moreTesting () \n";
    }
}

class ChildClass extends BaseClass
{
    public function moreTesting()
    {
        echo "Викликаний метод ChildClass::moreTesting () \n";
    }
}
// Виконання закінчується фатальною помилкою:
// Неможливо перезаписати фінальний метод BaseClass::moreTesting ()
// (Метод BaseClass::moretesting () не може бути перевизначений)
?>

```


Класи, помічені як final
------------------------

Після оголошення класу final він не може бути успадкований. Наступний приклад викличе помилку:


```php
<?php
final class FinalClass
{
}

class BogusClass extends FinalClass
{
}
?>

```


Абстрактні класи та методи
--------------------------

### Абстрактні класи

PHP 5 підтримує визначення абстрактних класів і методів. Створювати екземпляр класу, який був оголошений абстрактним, не можна. Клас, в якому оголошено хоча б один абстрактний метод, повинен також бути оголошений абстрактним. Методи, оголошені як абстрактні, несуть, по суті, лише описовий зміст і не можуть включати будь-який функціонал. Клас може бути оголошений як абстрактний за допомогою використання ключового слова abstract, для виключення з обробки. Однак, ви можете наслідувати абстрактні класи. Практичний приклад:


```php
<?php
abstract class AbstractClass
{
    /* Даний метод повинен бути визначений в дочірньому класі */
    abstract protected function getValue();
    /* Загальний метод */
    public function print()
    {
        print $this->getValue();
    }
}
class ConcreteClass1 extends AbstractClass
{
    protected function getValue()
    {
        return "ConcreteClass1";
    }
}
class ConcreteClass2 extends AbstractClass
{
    protected function getValue()
    {
        return "ConcreteClass2";
    }
}
$Class1 = new ConcreteClass1();
$Class1->print();
$Class2 = new ConcreteClass2();
$Class2->print();
?>
```


### Абстрактні методи

Метод може бути оголошений як abstract, таким чином відклавши його визначення спадкоємним класом. Клас, який включає абстрактні методи, повинен бути оголошений як abstract.


```php
<?php 
abstract class MyBaseClass { 
    abstract function display (); 
}
?>
```


Абстрактні методи
-----------------

У PHP 5 з'явилася така чудова можливість ООП, як інтерфейс класів. Інтерфейс визначає методи, які повинен містити клас. Всі методи, визначені у інтерфейсі повинні бути реалізовані. Інтерфейс створюється за допомогою ключового слова interface. Всі методи в інтерфейсі повинні бути публічними.
```php
interface CanWalk { 
    public function walk (); 
}
```

Клас може реалізовувати декілька інтерфейсів. Перерахування інтерфейсів виконується після ключового слова implements:
```php
class Bird implements walk, run, fly
{
    public function walk()
    {
        echo "Walk!";
    }
    public function run()
    {
        echo "Run!";
    }
    public function fly()
    {
        echo "Fly!";
    }
}
```
**Інтерфейс** - це семантична і синтаксична конструкція в коді програми, яка використовується для послуг, що надаються класом чи компонентом. Інтерфейс визначає межу взаємодії між класами або компонентами, специфікуючи певну абстракцію, яку здійснює сторона. На відміну від багатьох інших видів інтерфейсів, інтерфейс в ООП є строго формалізованим елементом об'єктно-орієнтованої мови і широко використовується кодом програми.

Таким чином, з одного боку, **інтерфейс** \- це контракт, який зобов'язується виконати клас, який реалізує його, з іншого боку, **інтерфейс** - це тип даних, тому що його опис досить чітко визначає властивості об'єктів, щоб нарівні з класом типізувати змінні. Слід, однак, підкреслити, що інтерфейс не є повноцінним типом даних, так як він задає тільки зовнішню поведінку об'єктів. Внутрішню структуру і реалізацію заданого інтерфейсом поведінку забезпечує клас, який реалізує інтерфейс; саме тому «прикладів інтерфейсу» в чистому вигляді не буває, і будь-яка змінна типу «інтерфейс» містить екземпляри конкретних класів.

Інтерфейси та абстрактні класи
------------------------------

Можна помітити, що інтерфейс, з точки зору реалізації - це просто чистий абстрактний клас, тобто клас, в якому не визначено нічого, крім абстрактних методів. Якщо мова програмування підтримує множинне успадкування і абстрактні методи (як, наприклад, C + +), то необхідність у введенні в синтаксис мови, окремого поняття «інтерфейс» не виникає. Дані сутності описуються за допомогою абстрактних класів і успадковуються класами для реалізації абстрактних методів.

Однак підтримка множинного спадкоємства в повному обсязі досить складна і викликає безліч проблем, як на рівні реалізації мови, так і на рівні архітектури додатків. Введення поняття інтерфейсів є компромісом, що дозволяє отримати багато переваг множинного спадкування (зокрема, можливість зручно визначати логічно пов'язані набори методів у вигляді сутностей, подібних класам, допускати спадкування і реалізацію), не реалізовуючи його в повному обсязі і не стикаючись, таким чином, з більшістю викликаних ним труднощів.

Магічні методи
--------------

Методи `__construct`, `__destruct` (див. Конструктори і деструктори), `__call`, `__callStatic`, `__get`, `__set`, `__isset`, `__unset`, `__sleep`, `__wakeup`, `__toString`, `__set_state` і `__clone` зарезервовані для "магічних" методів в PHP. Не варто називати свої методи цими іменами, якщо ви не хочете використовувати їх "магічну" функціональність.

**Застереження**

PHP залишає за собою право на всі методи, що починаються з `__`, вважати "магічними". Не рекомендується використовувати імена методів з `__` у PHP, якщо ви не бажаєте використовувати відповідний "магічний" функціонал.

__call
--------

З PHP5 ви можете реалізувати в класі спеціальний метод `__call()`, як метод для "вилову" всіх нереалізованих у даному класі методів. Метод `__call` (якщо він визначений) викликається при спробі викликати недоступний або неіснуючий метод.


```php
<?php
class foo
{
    function __call($name, $arguments)
    {
        print "Викликали? Я - $ name!";
    }
}

$X = new foo();
$X->doStuff();
$X->fancy_stuff();
?>
```


Цей спеціальний метод може бути використаний для реалізації перевантаження методів: ви можете досліджувати отримані аргументи і залежно від результату викликати підходящий для даного випадку закритий метод, наприклад:


```php
<?php
class Magic
{
    function __call($name, $arguments)
    {
        if ($name == "foo") {
            if (is_int($arguments[0])) {
                $this->foo_for_int($arguments[0]);
            }
            if (is_string($arguments[0])) {
                $this->foo_for_string($arguments[0]);
            }
        }
    }

    private function foo_for_int($x)
    {
        print "о, дивіться, ціле число!";
    }

    private function foo_for_string($x)
    {
        print "о, дивіться, рядок!";
    }
}

$X = new Magic();
$X->foo(3);
$X->foo("3");
?>
```


`__set` і `__get`
-----------------

Але це ще не все, тепер ви можете визначити методи `__set` і `__get` для пошуку всіх спроб зміни або доступу до невизначених (або недоступних) змінних.


```php
<?php
class foo
{
    function __set($name, $val)
    {
        print "Привіт, ви спробували привласнити значення $val змінній $name";
    }

    function __get($name)
    {
        print "Привіт, ви намагалися звернутися до $name";
    }
}

$X = new foo();
$X->bar = 3;
print $x->winky_winky;
?>
```


`__sleep` і `__wakeup`
----------------------

Функція **serialize ()** перевіряє, чи присутній у вашому класі метод з "магічним" іменем `__sleep`. Він може очистити об'єкт, буде повернутий масив з іменами всіх змінних об'єкта, який повинен бути серіалізований. Якщо метод нічого не повертає крім NULL, то це означає, що об'єкт серіалізований і видається попередження E_NOTICE.

Зазвичай **__sleep** використовується для передачі очікуваних даних або для виконання звичайних завдань їх очищення. Також, цей метод можна виконувати в тих випадках, коли ви не хочете зберігати дуже великі об'єкти повністю.

З іншого боку, функція **unserialize ()** перевіряє наявність методу з "магічним" іменем **__wakeup**. Якщо такий є, то він може відтворити всі ресурси об'єкта, які той має.

Зазвичай **__wakeup** використовується для відновлення будь-яких з'єднань з базою даних, які могли бути втрачені під час операції серіалізації та виконання інших операцій повторної ініціалізації.

**Приклад № 1** Sleep і wakeup


```php
<?php
class Connection
{
    protected $link;
    private $server, $username, $password, $db;

    public function __construct($server, $username, $password, $db)
    {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->connect();
    }

    private function connect()
    {
        $this->link = mysql_connect(
            $this->server,
            $this->username,
            $this->password
        );
        mysql_select_db($this->db, $this->link);
    }

    public function __sleep()
    {
        return ["server", "username", "password", "db"];
    }

    public function __wakeup()
    {
        $this->connect();
    }
}
?>
```


__toString
------------

Метод `__toString` дозволяє класу вирішувати самостійно, як він повинен реагувати при перетворенні в рядок.

**Приклад № 2** Простий приклад


```php
<?php
// Декларування простого класу
class TestClass
{
    public $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    public function __toString()
    {
        return $this->foo;
    }
}

$class = new TestClass("Привіт");
echo $class;
?>
```


Результат виконання цього прикладу:

Привіт

Раніше, до PHP 5.2.0, метод `__toString` викликався тільки безпосередньо в поєднанні з функціями echo () або print (). Починаючи з PHP 5.2.0, він викликається в будь-якому рядковому контексті (наприклад, у printf () з модифікатором %s), але не в контекстах інших типів (наприклад, з %d модифікатором). Починаючи з PHP 5.2.0, перетворення об'єкта в рядок за відсутності методу `__toString` викликає помилку E_RECOVERABLE_ERROR.

__invoke
----------

Метод `__invoke` викликається при спробі використовувати змінну-об'єкт як функцію.

Зауваження: Доступно тільки з версії PHP 5.3.0.

**Приклад № 3** Using `__invoke`


```php
<?php
class CallableClass
{
    function __invoke($x)
    {
        var_dump($x);
    }
}
$obj = new CallableClass();
$obj(5);
var_dump(is_callable($obj));
?>
```


Результат виконання цього прикладу:

```
int (5)
bool (true)
__set_state
```
--------------

Цей статичний метод викликається для тих класів, які експортуються функцією **var_export ()** починаючи з PHP 5.1.0.

Параметр цього методу повинен містити масив, що складається з експортованих властивостей у вигляді array ('property' => value, ...).

**Приклад № 4** Використання `__set_state` (починаючи з PHP 5.1.0)


```php
<?php
class A
{
    public $var1;
    public $var2;

    public static function __set_state($an_array)
    {
        // З PHP 5.1.0
        $obj = new A();
        $obj->var1 = $an_array["var1"];
        $obj->var2 = $an_array["var2"];
        return $obj;
    }
}

$a = new A();
$a->var1 = 5;
$a->var2 = "foo";

eval('$b =' . var_export($a, true) . ";");
// $ b = A::__set_state (array)
// 'var1' => 5,
// 'var2' => 'foo',
//));
var_dump($b);
?>
```


Результат виконання цього прикладу:
```
object (A) # 2 (2) { 
["Var1"] => 
int (5) 
["Var2"] => 
string (3) "foo" 
}
```
Функції для роботи з класами та об'єктами
-----------------------------------------

У РНР існує кілька стандартних функцій для роботи з класами та об'єктами. Розглянемо деякі функції для роботи з класами та об'єктами в контексті PHP5.

**get_class_methods ()**

Функція get_class_methods () повертає масив імен методів класу із заданим ім'ям. Синтаксис функції get_class_methods ():

array get_class_methods (string імя_класса)

Простий приклад використання get_class_methods () - Отримання списку методів класу:


```php
<?php

class Airplane extends Vehicle
{
    public $wingspan;
    function setWingSpan($wingspan)
    {
        $this->wingspan = $wingspan;
    }

    function getWingSpan()
    {
        return $this->wingspan;
    }
}

$cls_methods = get_class_methods(Airplane);
// Масив $ cls_methods містить імена всіх методів,
// Оголошених в класах "Airplane" і "Vehicle"
?>
```


Як видно з лістингу, функція get_class_methods () дозволяє легко отримати інформацію про всі методи, підтримуваних класом.

**get_class_vars ()**

Функція get_class_vars () повертає масив імен атрибутів класу із заданим ім'ям. Синтаксис функції get_class_vars ():

array get_class_vars (string імя_класса)

Приклад використання функції get_class_vars () - отримання списку атрибутів (властивостей) класу:


```php
<?php
class Vehicle
{
    public $model;
    public $urrent_speed;
}

class Airplane extends Vehicle
{
    public $Swingspan;
}

$a_class = "Airplane";
$attribs = get_class_vars($a_class);
// $Attribs = array ("wingspan", "model", "current_speed")
?>
```


У розглянутому прикладі масив $attribs заповнюється іменами всіх атрибутів класу Airplane.

**get_object_vars ()**

Функція **get_object_vars ()** повертає асоціативний масив з інформацією про всі атрибути об'єкту із заданим ім'ям. Синтаксис функції get_object_vars ():

array get_object_vars (object ім’я_об’єкта)

Приклад використання функції get_object_vars () - отримання інформації про змінні об'єкта:


```php
<?php
class Vehicle
{
    public $wheels;
}

class Land extends Vehicle
{
    public $engine;
}

class car extends Land
{
    var $doors;
    function car($doors, $eng, $wheels)
    {
        $this->doors = $doors;
        $this->engine = $eng;
        $this->wheels = $wheels;
    }

    function get_wheels()
    {
        return $this->wheels;
    }
}

$toyota = new car(2, 400, 4);
$vars = get_object_vars($toyota);
while (list($key, $value) = each($vars)):
    print "$key ==> $value";
endwhile;
// Вихідні дані:
// Wheels ==> 4
// Engine ==> 400
// Doors ==> 2
?>
```


Функція **get_object_vars ()** дозволяє швидко отримати всю інформацію про атрибути конкретного об'єкта та їх значеннях у вигляді асоціативного масиву.

**method_exists ()**

Функція **method_exists ()** перевіряє, чи підтримується об'єктом метод із заданим ім'ям. Якщо метод підтримується, функція повертає TRUE, в іншому випадку повертається FALSE. Синтаксис функції method_exists ():

bool method_exists (object ім’я_об’єкта. string імя_метода)

Приклад використання методу method_exists () - перевірка підтримки методу об'єктом:


```php
<?php
class Vehicle
{
    // ...
}

class Land extends Vehicle
{
    public $fourWheel;
    function setFourWheelDrive()
    {
        $this->fourWeel = 1;
    }
}
// Створити об'єкт з ім'ям $ саr
$car = new Land();
// Якщо метод "fourWheelDrive" підтримується класом "Land"
// Або "Vehicle", виклик method_exists повертає TRUE;
// У протилежному випадку повертається FALSE.
// У даному прикладі method_exists () повертає TRUE.
if (method_exists($car, "setfourWheelDrive")):
    print "Автомобіль з 4-ма ведучими колесами";
else:
    print "Автомобіль з 2-ма ведучими колесами";
endif;
?>
```


У розглянутому прикладі функція method_exists () перевіряє, чи підтримується об'єктом $car метод з ім'ям setFourWheelDrive (). Якщо метод підтримується, функція повертає логічну істину і фрагмент виводить відповідне повідомлення. В іншому випадку повертається FALSE і виводиться інше повідомлення.

**get_class ()**

Функція get_class () повертає ім'я класу, до якого належить об'єкт із заданим ім'ям. Синтаксис функції get_class ():

string get_class (object ім’я_об’єкта);

Приклад використання get_class () - отримання імені класу:


```php
<?php
class Vehicle
{
}

class Land extends Vehicle
{
}

// Створюємо об'єкт з ім'ям $саr:
$car = new Land();
// Змінній $ class_a присвоюється рядок "Land":
$class_a = get_class($car);
echo $class_a;
?>
```


У розглянутому прикладі змінної $class_a присвоюється ім'я класу, на основі якого був створений об'єкт $саr.

**get_parent_class ()**

Функція get_parent_class () повертає ім'я батьківського класу (якщо він є) для об'єкту із заданим ім'ям. Синтаксис функції get_parent_dass ():

string get_parent_class (object ім’я_об’єкта);

Приклад отримання імені батьківського класу функцією get_parent_class ():


```php
<?php
class Vehicle
{
    //...
}

class Land extends Vehicle
{
    //...
}

// Створюємо об'єкт з ім'ям $ саr:
$саr = new Land();
// Змінній $parent присвоюється рядок "Vehicle":
$parent = get_parent_class($car);
?>
```


При виклику get_parent_class () змінній $parent буде присвоєний рядок "Vehicle".

**is_subclass_of ()**

Функція **is_subclass_of ()** перевіряє, чи був об'єкт створений на базі класу, що має батьківський клас із заданим ім'ям. Функція повертає TRUE, якщо перевірка дає позитивний результат, і FALSE в іншому випадку. Синтаксис функції is_subclass_of ():

**bool is_subclass_of (object об'єкт, string імя_класса)**

Приклад використання функції is_subdass_of ():


```php
<?php
class Vehicle
{
    //...
}

class Land extends Vehicle
{
    //...
}
$auto = new Land();
// Змінній $is_subclass присвоюється TRUE
$is_subclass = is_subclass_of($auto, "Vehicle");
?>
```


У розглянутому прикладі змінншй $is_subclass () присвоюється ознака того, чи належить об'єкт $auto до підкласу батьківського класу Vehicle. У наведеному фрагменті $auto відноситься до класу Vehicle; отже $is_subclass () буде присвоєно значення TRUE.

**get_declared_classes ()**

Функція get_declared_classes () повертає масив з іменами всіх визначених класів. Синтаксис функції get_declared_classes ():

array get_declared_classes ()

Приклад отримання списку класів функцією get_declared_classes ():


```php
<?php
class Vehicle
{
    //...
}

class Land extends Vehicle
{
    //...
}
$declared_classes = get_declared_classes();
// $declared_classes = array ("Vehicle", "Land")
?>
```


Ми розглянули лише деякі основні функції, призначені для роботи з класами та об'єктами PHP. Для ознайомлення з повним переліком таких функцій зверніться до довідника функцій PHP.

Обробка винятків
----------------

Модель винятків **(exceptions)** в PHP 5 простіша, ніж в інших мовах програмування. Виняток можна згенерувати (як кажуть, "викинути") за допомогою оператора throw, і можна перехопити (або, як кажуть, "піймати") оператором catch. Код, що викидає виключення, повинен бути оточений блоком try, для того щоб можна було перехопити виняток. Кожен блок try повинен мати як мінімум один відповідний блок catch. Так само можна використовувати кілька блоків catch, що перехоплюють різні класи винятків. Нормальне виконання буде продовжено за останнім блоком catch. Винятки так само можуть бути згенерованими (або перегереровані - тобто викинуті знову) оператором throw всередині блоку catch.

При генерації виключення, код який слідує нижче оператора throw виконаний не буде, а PHP зробить спробу знайти перший блок catch, що перехоплює виключення даного класу. Якщо виключення не буде перехоплено, PHP видасть повідомлення про помилку: "Uncaught Exception ..." (неперехоплений виняток), якщо звичайно не був визначений обробник помилок за допомогою функції set_exception_handler ().

**Приклад № 1** Викид винятків


```php
<?php
function inverse($x)
{
    if (!$x) {
        throw new Exception("Поділ на нуль.");
    } else {
        return 1 / $x;
    }
}

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo "Викинуто виняток:", $e->getMessage(), "\n";
}

// Продовження виконання
echo "Hello World";
?>
```


Результат виконання цього прикладу:

0.2

Викинуто виняток: Поділ на нуль.

Hello World

Спадкування винятків
--------------------

Обробник винятків користувача повинен бути визначений, як клас, що розширює вбудований клас Exception. Нижче наведено методи і властивості класу Exception, доступні дочірнім класам.

**Приклад № 1** Вбудований клас Exception


```php
<?php 
class Exception 
{ 
protected $message = 'Unknown exception'; // повідомлення 
protected $code = 0; // Код винятку, визначається користувачем 
protected $file; // файл у якому було викинуто виключення 
protected $line; // рядок у якому було викинуто виключення 

function __construct ($message = null, $code = 0); 

final function getMessage (); // Повертає повідомлення виключення 
final function getCode (); // Код винятку 
final function getFile (); // Файл, де викинуто виняток 
final function getLine (); // Рядок, що викинув виключення 
final function getTrace (); // Масив backtrace () 
final function getTraceAsString (); // Зворотнє трасування, як рядок

function __toString (); /* повинен повернути форматований рядок,для відображення */
}
?>
```


Якщо клас, успадкований від Exception перевизначає конструктор, необхідно викликати в конструкторі `parent::__construct ()`, щоб бути впевненим, що всі дані будуть доступні. Метод `__toString ()` може бути перевизначений, що б забезпечити потрібний вивід, коли об'єкт перетворюється в рядок.

**Приклад № 2** Успадкування класу Exception


```php
<?php
/* Визначимо свій клас винятку*/
class MyException extends Exception
{
    // Перевизначивши виняток так, що параметр message стане обов'язковим
    public function __construct($message, $code = 0)
    {
        // Якийсь код

        parent::__construct($message, $code);
    }

    // Перевизначаємо рядкове подання об'єкта.
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message} \n";
    }

    public function customFunction()
    {
        echo "Ми можемо визначати нові методи в успадкованому класі \n";
    }
}

/* Створимо клас для тестування винятку */
class TestException
{
    public $var;

    const THROW_NONE = 0;
    const THROW_CUSTOM = 1;
    const THROW_DEFAULT = 2;

    function __construct($avalue = self::THROW_NONE)
    {
        switch ($avalue) {
            case self::THROW_CUSTOM:
                // Генеруємо власне виключення
                throw new MyException("1 - неправильний параметр ", 5);
                break;

            case self::THROW_DEFAULT:
                // Генеруємо вбудований виняток
                throw new Exception("2 - неприпустимий параметр ", 6);
                break;

            default:
                // Ніяких винятків, об'єкт буде створений.
                $tHIS->var = $avalue;
                break;
        }
    }
}

// Приклад 1
try {
    $o = new TestException(TestException::THROW_CUSTOM);
} catch (MyException $e) {
    // Буде перехоплено
    echo "Злови власне, перевизначене виключення \n", $e;
    $e->customFunction();
} catch (Exception $e) {
    // Буде пропущено.
    echo "Злови вбудоване виключення \n", $e;
}

// Звідси буде продовжено виконання програми
var_dump($o);
echo "\n\n";

// Приклад 2
try {
    $o = new TestException(TestException::THROW_DEFAULT);
} catch (MyException $e) {
    // Тип винятку не співпаде
    echo "Злови перевизначене виключення \n", $e;
    $e->customFunction();
} catch (Exception $e) {
    // Буде перехоплено
    echo "перехоплено вбудоване виключення \n", $e;
}

// Звідси буде продовжено виконання програми
var_dump($o);
echo "\n\n";

// Приклад 3
try {
    $o = new TestException(TestException::THROW_CUSTOM);
} catch (Exception $e) {
    // Буде перехоплено.
    echo "Злови вбудоване виключення \n", $e;
}

// Продовження виконання програми
var_dump($o);
echo "\n\n";

// Приклад 4
try {
    $o = new TestException();
} catch (Exception $e) {
    // Буде пропущено, тому що виняток не викинеться
    echo "Злови вбудоване виключення \n", $e;
}

// Продовження виконання програми
var_dump($o);
echo "\n\n";
?>
```
