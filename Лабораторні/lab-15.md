[Перелік усіх робіт](README.md)

## Работа с изображениями на PHP с использованием GD(лаб 13)

## Что такое GD?

PHP может сделать гораздо больше, чем просто отправлять HTML-сообщения посетителям. Например, он имеет возможность манипулировать изображениями. Не только это, но вы также можете создавать свои собственные изображения с нуля, а затем либо сохранять их, либо подавать их пользователям.

PHP может удовлетворить практически все ваши основные потребности в управлении изображениями, используя [библиотеку GD](https://php.net/manual/en/book.image.php) \- сокращение для Graphic Draw.

### Установка

Если вы работаете в Windows, вы можете включить файл **php_gd2.dll** в качестве расширения в **php.ini**. Если вы используете что-то вроде XAMPP, вы найдете файл **php_gd2.dll** в каталоге **xampp\\php\\ext**. Вы также можете проверить, установлена ли GD в вашей системе, с помощью функции `phpinfo();`. Если вы просмотрите полученный результат, вы найдете что-то похожее на следующее.

![](https://cms-assets.tutsplus.com/uploads/users/1251/posts/31701/image/php_gd_xampp.png)

Вы также можете посетить страницу [требований](http://php.net/manual/en/image.requirements.php) и [установки](http://php.net/manual/en/image.installation.php), чтобы узнать больше об установке.

#### * Функции GD и функции для работы с изображениями
    
    #### 
    
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
    * Больше функций вы можете найти на [book.image](https://www.php.net/manual/ru/book.image.php)
    

### Создание нового изображения

Функция imagecreatetruecolor() окажется полезной, если у вас нет исходного источника изображения, которое вы хотите изменять. Она принимает два целочисленных параметра: ширину и высоту. Она вернет ресурс изображения, если все пойдет по плану. Возвращаемый ресурс изображения в основном представляет собой черное изображение с заданной шириной и высотой.

### Загрузка файла изображения

Если вы планируете работать с изображениями, которые уже хранятся где-то, вам пригодится использование таких функций, как imagecreatefromjpeg(), imagecreatefrompng() и imagecreatefromgif(). Они создадут ресурс изображения со всеми данными из загруженного файла изображения. Эти функции принимают единственный параметр, который указывает местоположение загружаемого изображения, как URL-адрес или путь к файлу.

### Создание изображения из строки

Библиотека GD также позволяет создавать изображения из строки, используя функцию imagecreatefromstring() в PHP. Помните, что вам нужно будет использовать base64_decode() для данной строки перед imagecreatefromstring(). Функция может автоматически определять, является ли тип изображения JPG, PNG, GIF или другим поддерживаемым форматом.

#### Обработка изображений в PHP

#### Открытие изображения

Итак, есть исходное изображение PNG 400x400px:

![](https://snipp.ru/uploads/images/donut.png)

С помощью функции `getimagesize()` получим ширину, высоту и тип, далее откроем его функциями в зависимости от типа:
```sql
    $filename = __DIR__ . '/donut.png';
    $info   = getimagesize($filename);
    $width  = $info[0];
    $height = $info[1];
    $type   = $info[2];
    
    switch ($type) { 
    	case 1: 
    		$img = imageCreateFromGif($filename);
    		imageSaveAlpha($img, true);
    		break;					
    	case 2: 
    		$img = imageCreateFromJpeg($filename);
    		break;
    	case 3: 
    		$img = imageCreateFromPng($filename); 
    		imageSaveAlpha($img, true);
    		break;
    }
```
PHP[](https://snipp.ru/download/code/6366 "Сохранить")[](# "Скопировать")

_2_

# Изменение размера изображения (resize)


Приведенный код уменьшает или увеличивает изображение не искажая его пропорции.
```sql
    // Размеры новой фотки.
    $w = 200;
    $h = 0;
    
    if (empty($w)) {
    	$w = ceil($h / ($height / $width));
    }
    if (empty($h)) {
    	$h = ceil($w / ($width / $height));
    }
    
    $tmp = imageCreateTrueColor($w, $h);
    if ($type == 1 || $type == 3) {
    	imagealphablending($tmp, true); 
    	imageSaveAlpha($tmp, true);
    	$transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127); 
    	imagefill($tmp, 0, 0, $transparent); 
    	imagecolortransparent($tmp, $transparent);    
    }   
    
    $tw = ceil($h / ($height / $width));
    $th = ceil($w / ($width / $height));
    if ($tw < $w) {
    	imageCopyResampled($tmp, $img, ceil(($w - $tw) / 2), 0, 0, 0, $tw, $h, $width, $height);        
    } else {
    	imageCopyResampled($tmp, $img, 0, ceil(($h - $th) / 2), 0, 0, $w, $th, $width, $height);    
    }            
    
    $img = $tmp;
```
PHP[](https://snipp.ru/download/code/6658 "Сохранить")[](# "Скопировать")

#### Результат

|     |     |     |
| --- | --- | --- |
| `$w = 200;  <br>$h = 0;`  <br>![](https://snipp.ru/uploads/images/donut-resize-200x0.png) | `$w = 200;  <br>$h = 100;`  <br>![](https://snipp.ru/uploads/images/donut-resize-200x100.png) | `$w = 100;  <br>$h = 200;`  <br>![](https://snipp.ru/uploads/images/donut-resize-100x200.png) |

_3_

# Обрезать изображение (crop)


Пример вырезает из исходного изображения часть размером `$w` на `$h`.  
`$x` и `$y` задают начальные координаты в пикселях или процентах.
```sql
    $w = 200;
    $h = 200;
    
    $x = '100%';
    $y = '100%';
    
    if (strpos($x, '%') !== false) {
    	$x = intval($x);
    	$x = ceil(($width * $x / 100) - ($w / 100 * $x));
    }
    if (strpos($y, '%') !== false) {
    	$y = intval($y);
    	$y = ceil(($height * $y / 100) - ($h / 100 * $y));
    }
    
    $tmp = imageCreateTrueColor($w, $h);
    if ($type == 1 || $type == 3) {
    	imagealphablending($tmp, true); 
    	imageSaveAlpha($tmp, true);
    	$transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127); 
    	imagefill($tmp, 0, 0, $transparent); 
    	imagecolortransparent($tmp, $transparent);    
    }
    
    imageCopyResampled($tmp, $img, 0, 0, $x, $y, $width, $height, $width, $height);
    $img = $tmp;
```
PHP[](https://snipp.ru/download/code/6661 "Сохранить")[](# "Скопировать")

#### Результат

|     |     |     |
| --- | --- | --- |
| `$x = 0;  <br>$y = 0;`  <br>![](https://snipp.ru/uploads/images/donut-crop-0-0.png) | `$x = '50%';  <br>$y = '0%';`  <br>![](https://snipp.ru/uploads/images/donut-crop-50-0.png) | `$x = '100%';  <br>$y = '0%';`  <br>![](https://snipp.ru/uploads/images/donut-crop-100-0.png) |

_4_

# Поворот изображения

Функция `imagerotate()` поворачивает изображение на заданный угол против часовой стрелки, отрицательный угол меняет направление поворота.
```sql
    // Поворот против часовой стрелки на 45°.
    $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127); 
    $img = imagerotate($img, 45, $transparent);
    
    // Поворот по часовой стрелки на 90°
    $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127); 
    $img = imagerotate($img, -90, $transparent);
```
PHP[](https://snipp.ru/download/code/6670 "Сохранить")[](# "Скопировать")

Поворот на не ровный угол увеличит ширину и высоту фото:

![](https://snipp.ru/uploads/images/donut-rotate.png)

_5_

# Зеркальное отражение

    imageflip($img, IMG_FLIP_HORIZONTAL);

PHP[](https://snipp.ru/download/code/6673 "Сохранить")[](# "Скопировать")

`Imageflip()` зеркалит изображение, могут быть следующие параметры:

|     |     |
| --- | --- |  
| `IMG_FLIP_HORIZONTAL` | По горизонтали |
| `IMG_FLIP_VERTICAL` | По вертикали |
| `IMG_FLIP_BOTH` | По горизонтали и вертикали |

(function(w, d, n, s, t) { w\[n\] = w\[n\] || \[\]; w\[n\].push(function() { Ya.Context.AdvManager.render({ blockId: "R-A-278660-17", renderTo: "yandex\_rtb\_R-A-278660-17", async: true }); }); t = d.getElementsByTagName("script")\[0\]; s = d.createElement("script"); s.type = "text/javascript"; s.src = "//an.yandex.ru/system/context.js"; s.async = true; t.parentNode.insertBefore(s, t); })(this, this.document, "yandexContextAsyncCallbacks");

_6_

# Наложение водяного знака (watermark)

Для защиты на картинки наносят копирайт, например, данный скрип накладывает картинку watermark.png на основное изображение:

![](https://snipp.ru/uploads/images/watermark.png)
```sql
    $watermark = __DIR__ . '/watermark.png';
    
    $x = '50%';
    $y = '50%';
    
    $info = getimagesize($watermark);
    switch ($info[2]) { 
    	case 1: 
    		$tmp = imageCreateFromGif($watermark);
    		break;					
    	case 2: 
    		$tmp = imageCreateFromJpeg($watermark);
    		break;
    	case 3: 
    		$tmp = imageCreateFromPng($watermark); 
    		break;
    }
    
    if (strpos($x, '%') !== false) {
    	$x = intval($x);
    	$x = ceil(($width * $x / 100) - ($info[0] / 100 * $x));
    }
    if (strpos($y, '%') !== false) {
    	$y = intval($y);
    	$y = ceil(($height * $y / 100) - ($info[1] / 100 * $y));
    }
    
    imagecopy($img, $tmp, $x, $y, 0, 0, $info[0], $info[1]); 
    imagedestroy($tmp);
```
PHP[](https://snipp.ru/download/code/6677 "Сохранить")[](# "Скопировать")

#### Результат

|     |     |     |
| --- | --- | --- |
| `$x = '50%';  <br>$y = '50%';`  <br>![](https://snipp.ru/uploads/images/donut-watermark-50-50.png) | `$x = '100%';  <br>$y = '0%';`  <br>![](https://snipp.ru/uploads/images/donut-watermark-100-0.png) | `$x = '100%';  <br>$y = '100%';`  <br>![](https://snipp.ru/uploads/images/donut-watermark-100-100.png) |

_7_

# Добавление фона

Актуально для PNG с прозрачностью. Скрипт вставит на задний фон картинку с положением `$x` и `$y`. Размер основного изображения не изменится.
```sql
    $file = __DIR__ . '/donut_bg.jpg';
    
    // Положение фона.
    $x = '50%';
    $y = '50%';
    
    $info = getimagesize($file);
    switch ($info[2]) { 
    	case 1: 
    		$bg = imageCreateFromGif($file);
    		break;					
    	case 2: 
    		$bg = imageCreateFromJpeg($file);
    		break;
    	case 3: 
    		$bg = imageCreateFromPng($file); 
    		break;
    }
    
    if (strpos($x, '%') !== false) {
    	$x = intval($x);
    	$x = ceil(($info[0] * $x / 100) - ($width / 100 * $x));
    }
    if (strpos($y, '%') !== false) {
    	$y = intval($y);
    	$y = ceil(($info[1] * $y / 100) - ($height / 100 * $y));
    }
    
    $tmp = imageCreateTrueColor($width, $height);
    imagecopy($tmp, $bg, 0, 0, $x, $y, $width, $height); 
    imagedestroy($bg);
    
    imagecopy($tmp, $img, 0, 0, 0, 0, $width, $height); 
    $img = $tmp;
```
PHP[](https://snipp.ru/download/code/6690 "Сохранить")[](# "Скопировать")

|     |     |
| --- | --- |
| Фон  <br>![](https://snipp.ru/uploads/images/donut-bg.jpg) | Результат  <br>![](https://snipp.ru/uploads/images/donut-bg-result.png) |

_8_

# Фильтры
```sql
    imagefilter($img, $filtertype, $arg1, $arg2);
```
PHP[](https://snipp.ru/download/code/6731 "Сохранить")[](# "Скопировать")

Функция `imagefilter()` применяет фильтр к изображению.  
В параметре `$filtertype` указывается константа применяемого фильтра, а в следующих его настройки.

### IMG\_FILTER\_NEGATE

Инвертирует цвета изображения.
```sql
    imagefilter($img, IMG_FILTER_NEGATE);
```
PHP[](https://snipp.ru/download/code/6695 "Сохранить")[](# "Скопировать")

![](https://snipp.ru/uploads/images/donut-img_filter_negate.png)

### IMG\_FILTER\_GRAYSCALE

Преобразует цвета изображения в градации серого.  
```sql
    imagefilter($img, IMG_FILTER_GRAYSCALE);
```
PHP[](https://snipp.ru/download/code/6698 "Сохранить")[](# "Скопировать")

![](https://snipp.ru/uploads/images/donut-img_filter_grayscale.png)

### IMG\_FILTER\_COLORIZE

Преобразует цвета изображения в градации заданного цвета в формате RGB.
```sql
    // Красный
    imagefilter($img, IMG_FILTER_COLORIZE, 0, 240, 120);
    
    // Синий
    imagefilter($img, IMG_FILTER_COLORIZE, 150, 240, 120);
    
    // Зеленый
    imagefilter($img, IMG_FILTER_COLORIZE, 90, 240, 90);
```
PHP[](https://snipp.ru/download/code/6701 "Сохранить")[](# "Скопировать")

|     |     |     |
| --- | --- | --- |
| `0, 240, 120`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_colorize-1.png) | `150, 240, 120`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_colorize-2.png) | `90, 240, 90`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_colorize-3.png) |

### IMG\_FILTER\_BRIGHTNESS

Изменяет яркость изображения, диапазон от -255 до 255.
```sql
    imagefilter($img, IMG_FILTER_BRIGHTNESS, 127);
```
PHP[](https://snipp.ru/download/code/6704 "Сохранить")[](# "Скопировать")

|     |     |     |     |
| --- | --- | --- | --- |
| `-200`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_brightness-200.png) | `-100`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_brightness-100.png) | `100`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_brightness%2B100.png) | `200`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_brightness%2B200.png) |

### IMG\_FILTER\_CONTRAST

Изменяет контрастность изображения. Уровень может быть от -100 до 100.
```sql
    imagefilter($img, IMG_FILTER_CONTRAST, 100);
```
PHP[](https://snipp.ru/download/code/6730 "Сохранить")[](# "Скопировать")

|     |     |     |     |
| --- | --- | --- | --- |
| `-100`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_contrast-100.png) | `-50`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_contrast-50.png) | `50`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_contrast%2B50.png) | `100`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_contrast%2B100.png) |

### IMG\_FILTER\_EDGEDETECT

Использует определение границ для их подсветки.
```sql
    imagefilter($img, IMG_FILTER_EDGEDETECT);
```
PHP[](https://snipp.ru/download/code/6709 "Сохранить")[](# "Скопировать")

![](https://snipp.ru/uploads/images/donut-img_filter_edgedetect.png)

### IMG\_FILTER\_EMBOSS

Добавляет рельеф.
```sql
    imagefilter($img, IMG_FILTER_EMBOSS);
```
PHP[](https://snipp.ru/download/code/6712 "Сохранить")[](# "Скопировать")

![](https://snipp.ru/uploads/images/donut-img_filter_emboss.png)

### IMG\_FILTER\_GAUSSIAN_BLUR

Размывает изображение по методу Гаусса.
```sql
    imagefilter($img, IMG_FILTER_GAUSSIAN_BLUR);
```
PHP[](https://snipp.ru/download/code/6715 "Сохранить")[](# "Скопировать")

![](https://snipp.ru/uploads/images/donut-img_filter_gaussian_blur.png)

### IMG\_FILTER\_SELECTIVE_BLUR

Как и `IMG_FILTER_GAUSSIAN_BLUR` размывает изображение.
```sql
    imagefilter($img, IMG_FILTER_SELECTIVE_BLUR);
```
PHP[](https://snipp.ru/download/code/6718 "Сохранить")[](# "Скопировать")

### IMG\_FILTER\_MEAN_REMOVAL

Делает эффект «эскиза».
```sql
    imagefilter($img, IMG_FILTER_MEAN_REMOVAL);
```
PHP[](https://snipp.ru/download/code/6720 "Сохранить")[](# "Скопировать")

![](https://snipp.ru/uploads/images/donut-img_filter_mean_removal.png)

### IMG\_FILTER\_SMOOTH

Делает границы более плавными, а изображение менее четким. Диапазон значений не ограничен, но наиболее заметные изменения происходят от 0 до -8.
```sql
    imagefilter($img, IMG_FILTER_SMOOTH, -2);
```
PHP[](https://snipp.ru/download/code/6723 "Сохранить")[](# "Скопировать")

|     |     |     |     |
| --- | --- | --- | --- |
| `0`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_smooth-0.png) | `-2`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_smooth-2.png) | `-4`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_smooth-4.png) | `-6`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_smooth-6.png) |

### IMG\_FILTER\_PIXELATE

Применяет эффект пикселирования.

`arg1` – задает размера блока в пикселях.  
`arg2` – включает усовершенствованный эффект пикселирования.
```sql
    imagefilter($img, IMG_FILTER_PIXELATE, 2, true);
```
PHP[](https://snipp.ru/download/code/6726 "Сохранить")[](# "Скопировать")

|     |     |     |     |
| --- | --- | --- | --- |
| `2`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_pixelate-2.png) | `3`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_pixelate-3.png) | `4`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_pixelate-4.png) | `5`  <br>![](https://snipp.ru/uploads/images/donut-img_filter_pixelate-5.png) |

_9_

# Сохранение

### Вывод изображения в браузер

До вызова функции `header()` скрипт ничего не должен выводить (`echo`, `?>...<?php`), иначе картинка будет битой.
```sql
    switch ($type) {
    	case 1: 
    		header('Content-Type: image/gif'); 
    		imageGif($img);
    		break;			
    	case 2: 
    		header('Content-Type: image/jpeg');
    		imageJpeg($img, null, 100);
    		break;			
    	case 3: 
    		header('Content-Type: image/x-png');
    		imagePng($img);
    		break;
    }
    
    imagedestroy($img);
    exit();
```
PHP[](https://snipp.ru/download/code/6684 "Сохранить")[](# "Скопировать")

Чтобы браузер отдал фото на скачивание, в начало кода нужно добавить заголовок:
```sql
    header('Content-Disposition: Attachment;filename=' . basename($src)); 
```
PHP[](https://snipp.ru/download/code/6729 "Сохранить")[](# "Скопировать")

### Сохранение изображения в файл на сервере
```sql
    switch ($type) {
    	case 1:
    		imageGif($img, $src);
    		break;			
    	case 2:
    		imageJpeg($img, $src, 100);
    		break;			
    	case 3:
    		imagePng($img, $src);
    		break;
    }
    
    imagedestroy($img);
```
PHP[](https://snipp.ru/download/code/6686 "Сохранить")[](# "Скопировать")

### Вывод в браузер и сохранение в файл
```sql
    switch ($type) {
    	case 1:
    		header('Content-Type: image/gif'); 
    		imageGif($img, $src);
    		break;			
    	case 2:
    		header('Content-Type: image/jpeg');
    		imageJpeg($img, $src, 100);
    		break;			
    	case 3:
    		header('Content-Type: image/x-png');
    		imagePng($img, $src);
    		break;
    }
    
    imagedestroy($img);
    readfile($src);
    exit();
```
[](https://snipp.ru/download/code/6688 "Сохранить")[](# "Скопировать")

## Задание

Создать изображение и отредактировать его применив: изменение размера изображения, обрезка изображения, наложение водного знака и добавление фона.