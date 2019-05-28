<?php /* ПАРСИНГ КУРСА ВАЛЮТ НБРБ  * КРАВЕЦ АЛЕКСАНДР  * 21.05.2019 */

/* [ ОБРАБОТЧИК ОШИБОК DOM ] */
ob_start();
var_dump(libxml_use_internal_errors(true)); // включение обработчика ошибок для пользователя
ob_get_clean();
$doc = new DOMDocument; // загрузка документа
if (!$doc->load('file.xml')) {
foreach (libxml_get_errors() as $error) {
// обработка ошибок здесь
}
libxml_clear_errors();
}

//var_dump(ob_start());