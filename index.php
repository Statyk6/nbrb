<?php /* ПАРСИНГ КУРСА ВАЛЮТ НБРБ  * КРАВЕЦ АЛЕКСАНДР  * 21.05.2019 */

/* [ УСТАНАВЛИВАЕМ ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ ] */
require_once "config/bd_connect.php";

/* [ НЕБОЛЬШОЙ КОСТЫЛЬ ЧТОБЫ ИЗБАВИТЬСЯ ОТ НАДОЕДЛИВЫХ ВАРНИНГОВ DOM ] */
include "controllers/errview_controller.php";

/* [ ПАРСЕР ДАННЫХ С САЙТА НБРБ В МАССИВ ] */
include "controllers/parser_controller.php";

