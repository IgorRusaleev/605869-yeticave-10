<?php
require_once 'init.php';
if (!$link) {
    $error = mysqli_connect_error();
    show_error($content, $error);
}
else {
    /*Получение всех категорий*/
    $sql_cat = 'SELECT * FROM category ORDER BY name_cat ASC';
    $cats = db_fetch_data($link, $sql_cat, $data = []);

    if (isset($_SESSION['user'])) {
        $name_user = $_SESSION['user']['name_user'];
        $sql_user = 'SELECT * FROM user WHERE name_user = "$name_user"';
        $user = db_fetch_data($link, $sql, $data = []);
    }

    //Получаем текущую страницу. Определяем число лотов на странице
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 6;

    //Узнаем общее число лотов. Считаем кол-во страниц и смещение
    $result_count_lot = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lot");
    $items_count = mysqli_fetch_assoc($result_count_lot)['cnt'];

    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

//Заполняем массив номерами всех страниц
    $pages = range(1, $pages_count);

//Формируем запрос на показ списка лотов, учитывая смещение и число лотов на странице
    $sql = 'SELECT lot_id, name_lot, description, initial_price, image, expiration_date, step_rate, name_cat FROM  category c '
        . 'INNER JOIN lot l ON c.category_id = l.category_id '
        . 'WHERE now() < expiration_date '
        . 'ORDER BY creation_date DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
    $lot = db_fetch_data($link, $sql, $data = []);

    if ($lot = mysqli_query($link, $sql)) {
        $tpl_data = [
            'lot' => $lot,
            'cats' => $cats,
            'pages' => $pages,
            'pages_count' => $pages_count,
            'cur_page' => $cur_page
        ];
        $page_content = include_template('main.php', $tpl_data);
    }
    else {
        show_error($content, mysqli_error($link));
    }
}

$layout_content = include_template('layout.php', [
'content' => $page_content,
'cats' => $cats,
'title' => 'Главная страница',
'name_user' => $name_user
]);
print($layout_content);
?>