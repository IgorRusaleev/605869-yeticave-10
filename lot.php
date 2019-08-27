<?php
require_once('helpers.php');
/*подключение к MySQL*/
$link = mysqli_connect("localhost", "root", "","yeticave");
mysqli_set_charset($link, "utf8");
$id = $_GET['id'];
$id = $_GET['id'] ?? 'http_response_code(404)';
$lot = [];
$cats = [];
$content = '';
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    /*Запрос на получение новых, открытых лотов*/
    $sql = 'SELECT lot_id, name_lot, description, initial_price, image, expiration_date, step_rate, name_cat FROM  category c '
        . 'INNER JOIN lot l ON c.category_id = l.category_id '
        . 'WHERE lot_id = $id';
    $lot = db_fetch_data($link, $sql, $data = []);
}
/*Получение всех категорий*/
$sql = 'SELECT * FROM category ORDER BY name_cat ASC';
$cats = db_fetch_data($link, $sql, $data = []);
$page_content = include_template('main_lot.php', ['lot' => $lot, 'cats' => $cats]);
$layout_content = include_template('layout_lot.php', [
    'content' => $page_content,
    'cats' => $cats,
    'lot' => $lot
]);
print($layout_content);
?>