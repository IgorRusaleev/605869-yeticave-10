<?php
$is_auth = 0;
    /*rand(0, 1);*/
$user_name = 'Игорь Русалеев';
require_once 'init.php';
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    /*Запрос на получение новых, открытых лотов*/
    $sql = 'SELECT lot_id, name_lot, description, initial_price, image, expiration_date, step_rate, name_cat FROM  category c '
        . 'INNER JOIN lot l ON c.category_id = l.category_id '
        . 'WHERE now() < expiration_date '
        . 'ORDER BY creation_date DESC';
    $lot = db_fetch_data($link, $sql, $data = []);
}
/*Получение всех категорий*/
$sql = 'SELECT * FROM category ORDER BY name_cat ASC';
$cats = db_fetch_data($link, $sql, $data = []);

$page_content = include_template('main.php', ['lot' => $lot, 'cats' => $cats,]);
$layout_content = include_template('layout.php', [
'content' => $page_content,
'cats' => $cats,
'title' => 'Главная страница',
'user_name' => $user_name,
'is_auth' => $is_auth
]);
print($layout_content);
?>