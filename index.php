<?php
$is_auth = 0;
rand(0, 1);
$name_user = 'Игорь Русалеев';
require_once 'init.php';
if (!$link) {
    $error = mysqli_connect_error();
    show_error($content, $error);
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
'name_user' => $name_user,
'is_auth' => $is_auth
]);
print($layout_content);
?>