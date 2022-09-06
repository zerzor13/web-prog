[Перелік усіх робіт](README.md)

# Перевірка роботи CGI-застосувань

## Мета роботи

Перевірити можливість використання bat-файлів, як CGI-застосувань

## Обладнання

Персональний комп'ютер. Текстовий редактор Sublime Text 3 або Notepad++. Пакет програм XAMPP. Web-браузер Chrome, Firefox, Opera, MS Edge

## Теоретичні відомості



## Хід роботи

1. Впевнитись, що пакет XAMPP встановлено та web-сервер Apache запущений
2. Перейти до каталогу `C:\xampp\htdocs\` та очистити його
3. В каталогу `C:\xampp\htdocs\` створити файли з іменем `.htaccess` та `index.bat`
4. Відкрити `.htaccess` та записати туди наступні налаштування серверу та зберегти файл
```htaccess
ScriptInterpreterSource Registry-Strict 
AddHandler cgi-script .bat 
Options +ExecCGI +FollowSymlinks 
```
5. Відкрити `index.bat` та записати туди наступний код інтерпритатору командного рядка та зберегти файл
```bat
@echo off 

echo Content-Type: text/plain 

echo. 

dir
```
6. Перейти за адресою `http://127.0.0.1/index.bat` або `http://localhost/index.bat` та впевнитись, що завантажився результат роботи консольної команди `dir`
7. Profit! Ви щойно налаштували виконання Batch-сценаріїв, як веб-застосування
8. Відкрити `.htaccess` та додати туди наступні налаштування серверу:
```htaccess
AddHandler cgi-script .exe
```
9. Створити консольний проект на Delphi. Написати наступну програму \*
```delphi
program Project1; 

{$APPTYPE CONSOLE} 

{$R *.res} 

uses 
System.SysUtils; 

begin 
try 
    { TODO -oUser -cConsole Main : Insert code here } 
    Write('Content-Type: text/plain'); 
    Writeln(''); 
    Writeln(''); 
    Write('hello world!'); 
except 
    on E: Exception do 
    Writeln(E.ClassName, ': ', E.Message); 
end; 
end. 
```
10. Зберегти проект та зкомпілювати виконуваний файл `project1.exe`
11. Помістити файл `project1.exe` до каталогу `C:\xampp\htdocs\`
12. Перейти за адресою `http://127.0.0.1/project1.exe` або `http://localhost/project1.exe` та впевнитись, що завантажився результат роботи консольної програми `project1.exe`
13. Перевірити чи встановлено на комп'ютер інтерпритатор мови Python. У разі необхідності встановити його самостійно
14. Створити самостійно CGI-сценарій на Python, який виводить числа від 1 до 10 \*\*
15. Перевірити роботу сценарію через HTTP-запит
16. Для кожного етапу роботи зробити знімки екрану та додати їх у звіт з описом кожного скіншота
17. Додати програмний код завдання для самомтійного виконання
18. Дати відповіді на контрольні запитання
19. Зберегти звіт у форматі PDF

## Контрольні питання

1.  Що таке CGI?
2.  Як додати до веб-серверу можливість виконувати застосування на мові perl?
3.  В яких випадках застосовують CGI



## Довідники та додаткові матеріали

1.  [Комплексний довідник web-розробника](https://www.w3schools.com/)
2.  [Довідник HTML та CSS](https://css.in.ua/)
3.  [Справочник по HTML](http://htmlbook.ru/)
4.  [Елемент section](https://developer.mozilla.org/ru/docs/Web/HTML/Element/section)
5.  [Елемент header](https://developer.mozilla.org/ru/docs/Web/HTML/Element/header)
6.  [Елемент footer](https://developer.mozilla.org/ru/docs/Web/HTML/Element/footer)
7.  [Елемент article](https://developer.mozilla.org/ru/docs/Web/HTML/Element/article)
8.  [Елемент nav](https://developer.mozilla.org/ru/docs/Web/HTML/Element/nav)
9.  [Елемент aside](https://developer.mozilla.org/ru/docs/Web/HTML/Element/aside)
10.  [Елемент img](https://developer.mozilla.org/ru/docs/Web/HTML/Element/img)
11.  [Елемент figure](https://developer.mozilla.org/ru/docs/Web/HTML/Element/figure)
12.  [Елемент audio](https://developer.mozilla.org/ru/docs/Web/HTML/Element/audio)
13.  [Елемент video](https://developer.mozilla.org/ru/docs/Web/HTML/Element/video)
14.  [Елемент a](https://developer.mozilla.org/ru/docs/Web/HTML/Element/a)

## Примітки
* \* - код надано на мові Delphi 2010
* \*\* - дозволяється використання коду інших розробників
