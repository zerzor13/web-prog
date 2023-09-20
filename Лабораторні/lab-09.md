[Перелік усіх робіт](README.md)

# Лабораторна робота №9. Обробка графіки. Бібліотека GD

## Мета роботи

Навчитися створювати, змінювати та зберігати зображення за допомогою бібліотеки GD2 на мові PHP

## Обладнання

Персональний комп'ютер. Пакет програм XAMPP. Текстовий редактор Sublime Text 3 або IDE NetBeans. Web-браузер Chrome, Firefox, Opera

## Теоретичні відомості

GD Graphics Library — це бібліотека графічного програмного забезпечення для динамічного керування зображеннями . Він може створювати файли GIF , JPEG , PNG і WBMP . Зображення можуть складатися з ліній, дуг, тексту (з використанням вибраних програмою шрифтів), інших зображень і кількох кольорів, підтримуючи зображення у справжніх кольорах , альфа-канали , повторну дискретизацію та багато інших функцій.

GD широко використовується з PHP, де модифікована версія з підтримкою додаткових функцій включена за замовчуванням, починаючи з PHP 4.3, і була опцією до цього. Починаючи з PHP 5.3, також можна використовувати системну версію GD, щоб отримати додаткові функції, які раніше були доступні лише для пакетної версії GD.

### Функции GD и функции для работы с изображениями

    
* [gd_info](function.gd-info.php) — Вывод информации о текущей установленной GD библиотеке
* [getimagesize](function.getimagesize.php) — Получение размера изображения
* [getimagesizefromstring](function.getimagesizefromstring.php) — Получение размера изображения из строки данных
* [image\_type\_to_extension](function.image-type-to-extension.php) — Получение расширения файла для типа изображения
* [image\_type\_to\_mime\_type](function.image-type-to-mime-type.php) — Получение Mime-типа для типа изображения, возвращаемого функциями getimagesize, exif\_read\_data, exif\_thumbnail, exif\_imagetype
* [image2wbmp](function.image2wbmp.php) — Выводит изображение в браузер или пишет в файл
* [imageaffine](function.imageaffine.php) — Вернуть изображение, содержащее аффинно-преобразованное изображение src, используя дополнительную область ограничения
* [imageaffinematrixconcat](function.imageaffinematrixconcat.php) — Конкатенирует две аффинные матрицы преобразования
* [imageaffinematrixget](function.imageaffinematrixget.php) — Получает матрицу аффинного преобразования
* [imagealphablending](function.imagealphablending.php) — Задание режима сопряжения цветов для изображения
* [imageantialias](function.imageantialias.php) — Требуется ли применять функции сглаживания или нет
* [imagearc](function.imagearc.php) — Рисование дуги
* [imagebmp](function.imagebmp.php) — Вывести BMP-изображение в браузер или файл
* [imagechar](function.imagechar.php) — Рисование символа по горизонтали
* [imagecharup](function.imagecharup.php) — Рисование символа вертикально
* [imagecolorallocate](function.imagecolorallocate.php) — Создание цвета для изображения
* [imagecolorallocatealpha](function.imagecolorallocatealpha.php) — Создание цвета для изображения
* [imagecolorat](function.imagecolorat.php) — Получение индекса цвета пиксела
* [imagecolorclosest](function.imagecolorclosest.php) — Получение индекса цвета ближайшего к заданному
* [imagecolorclosestalpha](function.imagecolorclosestalpha.php) — Получение индекса цвета ближайшего к заданному с учетом прозрачности
* [imagecolorclosesthwb](function.imagecolorclosesthwb.php) — Получение индекса цвета, имеющего заданный тон, белизну и затемнение
* [imagecolordeallocate](function.imagecolordeallocate.php) — Разрыв ассоциации переменной с цветом для заданного изображения
* [imagecolorexact](function.imagecolorexact.php) — Получение индекса заданного цвета
* [imagecolorexactalpha](function.imagecolorexactalpha.php) — Получение индекса заданного цвета и альфа компонента
* [imagecolormatch](function.imagecolormatch.php) — Делает цвета палитровой версии изображения более соответствующими truecolor версии
* [Больше функций вы можете найти на book.image](https://www.php.net/manual/ru/book.image.php)
    
## Хід роботи

1. Впевніться, що пакет XAMPP встановлено та web-сервер Apache запущений
2. Перейдіть до каталогу `C:\xampp\htdocs\` та очистіть його
3. В каталогу `C:\xampp\htdocs\` створіть файли з іменем index.php
4. Відкрийте index.php та збережіть у ньому наступний код:

```php
<?php
    // Create an image
    $image = imagecreatetruecolor(100, 100);

    // Allocate some colors
    $white    = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
    $gray     = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);
    $darkgray = imagecolorallocate($image, 0x90, 0x90, 0x90);
    $navy     = imagecolorallocate($image, 0x00, 0x00, 0x80);
    $darknavy = imagecolorallocate($image, 0x00, 0x00, 0x50);
    $red      = imagecolorallocate($image, 0xFF, 0x00, 0x00);
    $darkred  = imagecolorallocate($image, 0x90, 0x00, 0x00);

    // Make the 3D effect
    for ($i = 60; $i > 50; $i--) {
        imagefilledarc($image, 50, $i, 100, 50, 0,   45, $darknavy, IMG_ARC_PIE);
        imagefilledarc($image, 50, $i, 100, 50, 45,  75, $darkgray, IMG_ARC_PIE);
        imagefilledarc($image, 50, $i, 100, 50, 75, 360, $darkred,  IMG_ARC_PIE);
    }

    imagefilledarc($image, 50, 50, 100, 50,  0,  45, $navy, IMG_ARC_PIE);
    imagefilledarc($image, 50, 50, 100, 50, 45,  75, $gray, IMG_ARC_PIE);
    imagefilledarc($image, 50, 50, 100, 50, 75, 360, $red,  IMG_ARC_PIE);

    // Flush the image
    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
?>
```

Збережіть файл, та подивіться результати роботи у браузері.
5. Виконайте індивідуальне завдання 1:
   - Враховуючи попередні лабораторні роботи, створіть файл XML або JSON із довільними даними для стовпчатої діаграми. Внесіть у нього дані.
   - Зчитайте дані з файлу, на основі цих даних побудуйте діаграму
   - Додайте на діаграму підпис - Група, ПІП, дата
   - Змініть сценарій таким чином, щоб у якості додаткових параметрів він приймав вихідні розміри зображення.
6. Виконайте індивідуальне завдання 2:
   - Створіть сценарій який у якості параметру приймає адресу зображення на диску.
   - Завантажте файл зображення з диску. Змініть його додавши підпис - Група, ПІП, дата
   - Збережіть зображення
   - Відвантажте змінене зображення користувачеві.
7. Для кожного етапу роботи зробити знімки екрану та додати їх у звіт з описом кожного скіншота
8. Додати програмний код завдання для самомтійного виконання
9.  Дати відповіді на контрольні запитання
10. Зберегти звіт у форматі PDF

## Контрольні питання
1. Для чого використовується бібліотека GD?
2. Які відмінності між бібліотеками GD та GD2?
3. Яким чином можна зберегти зображення на диск?
4. Яким чином зчитати зображення з диску для редагування?
5. Яким чином повернути зображення у HTTP-відповідь?

## Довідники та додаткові матеріали
1. [Офіційний сайт розробників PHP (англійська)](https://www.php.net/)
2. [Офіційна документація від розробників PHP (англійська, російська)](https://www.php.net/docs.php)
3. [Портал по PHP, MySQL и другим веб-технологиям](http://www.php.su/)
4. [Date/Time Functions](https://www.php.net/manual/en/ref.datetime.php)
5. [phpinfo() Function](https://www.php.net/manual/en/function.phpinfo.php)
