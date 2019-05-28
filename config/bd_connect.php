<?php /* ПАРСИНГ КУРСА ВАЛЮТ НБРБ  * КРАВЕЦ АЛЕКСАНДР  * 21.05.2019 */

/* [ УСТАНАВЛИВАЕМ ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ ] */
$link = mysqli_connect("127.0.0.1", "root", "", "kursvalut");

/* [ ПРОВЕРЯЕМ ПОДКЛЮЧЕНИЕ ] */
if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
    //echo "Соединение с MySQL установлено!" . PHP_EOL;
}

