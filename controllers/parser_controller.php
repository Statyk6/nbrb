<?php /* ПАРСИНГ КУРСА ВАЛЮТ НБРБ  * КРАВЕЦ АЛЕКСАНДР  * 21.05.2019 */

date_default_timezone_get(); // вычисляем текущий часовой пояс
date_default_timezone_set('UTC'); // присваиваем новый часовой пояс
$date = date('d.m.Y'); // формирование даты в URL

/* [ ПАРСЕР ДАННЫХ С САЙТА НБРБ В МАССИВ ] */
$charset = 'UTF-8'; // кодировка получаемой страницы


$url="http://www.nbrb.by/statistics/rates/ratesDaily.asp?date_req=$date"; // URL страницы с курсами валют НБРБ
$html = file_get_contents($url); // Читаем содержимое HTML страницы

// находим в коде блок с классом таблицы и все что до него удаляем
$pos=mb_strpos($html,'<table class="currencyTable">', 0, $charset); // у нас это класс .currencyTable
$html=mb_substr($html,$pos,mb_strlen($html, $charset), $charset); // обрезаем до указанной позиции, удаляя все лишнее
$dom = new domDocument; // создаем объект дерева DOM
$dom->loadHTML($html); // загружаем в него спарсенную страницу

$dom->preserveWhiteSpace = false; // Указание не убирать лишние пробелы и отступы.
$tables = $dom->getElementsByTagName('table'); // ищем в дереве DOM таблицу с курсами валют
$rows = $tables->item(0)->getElementsByTagName('tr'); // получаем из таблицы все строки

$i=0; // присваиваем по умолчаниею 0
$parser = array(); // массив который будет хранить данные

foreach ($rows as $row) // перебираем полученные строки
{
    if($i==0) {$i++; continue;} // пропускаем строку с заголовками таблицы
    $cols = $row->getElementsByTagName('td'); // разбираем все строки по столбцам

    // записываем полученные данные в массив
    $code = $parser[$i][0] = $cols->item(1)->nodeValue; // находим код валюты
    $pieces = explode(" ", $code); // делим на единицы и код валюты $pieces[0] и $pieces[1]
    $value = $parser[$i][1] = str_replace(",",".", $cols->item(2)->nodeValue) / $pieces[0];  // находим курс валюты и заменяем запятую на точку

    // записываем полученные данные в базу данных
    $result = $link->query("SELECT 1 FROM `nbrb` WHERE `code` LIKE '%".$pieces[1]."%'");
    if ($result->num_rows == 0) { // Если база пуста - присваиваем новые значения в таблицы
        $result = $link->query ("INSERT INTO `nbrb` (`code`, `value`, `updat`) VALUES ('$pieces[1]', '$value', '$date')"); // Записываем в базу обновления
        echo "<span style='color:blue'>ID $i:</span> Валюта <span style='color:red'>$pieces[1]</span> добавлена в базу со значением <span style='color:green'>$value</span> <br>";
    }
    else { // Если в базе есть данные - обновляем таблицы.
        //$result = $link->query("ALTER TABLE `nbrb` DROP `id`"); // Удаляем уже используемые id
        //$result = $link->query("ALTER TABLE `nbrb` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST"); // Резервируем id по новой
        $result = $link->query("UPDATE `nbrb` SET `value`='$value', `updat`='$date' WHERE `code`='$pieces[1]'"); // Записываем в базу обновления
        echo "<span style='color:blue'>ID $i:</span> Валюта <span style='color:red'>$pieces[1]</span> успешно обновлена, новое значение <span style='color:green'>$value</span> <br>";
    }
    $i++;
}