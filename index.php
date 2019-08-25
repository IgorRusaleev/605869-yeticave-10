<?php
$is_auth = rand(0, 1);
$user_name = 'Игорь Русалеев'; // укажите здесь ваше имя
require_once('helpers.php');
/*подключение к MySQL*/
$link = mysqli_connect("localhost", "root", "","yeticave");
mysqli_set_charset($link, "utf8");
$ads = [];
$content = '';
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    /*Запрос на получение новых, открытых лотов*/
    $sql = 'SELECT name_lot, description, initial_price, image, name_cat FROM  category c '
        . 'INNER JOIN lot l ON c.category_id = l.category_id '
        . 'WHERE now() < completion_date '
        . 'ORDER BY creation_date DESC\'';
    $ads = db_fetch_data($link, $sql, $data = []);
}
$cats = ["Доски и лыжи","Крепления","Ботинки","Одежда","Инструменты","Разное"];

function adding_ruble($input) {
    $number = ceil($input);
    if ($number < 1000) {
        $output = $number;
    }
    elseif ($number >= 1000) {
        $output = number_format($number,0,' ',' ');
    }
    return $output . " ₽";
}

function get_dt_range($input) {
    $next_date = date_create($input);
    $today = date_create("now");
    $dif = date_diff($next_date, $today);
    $day_count = date_interval_format($dif, "%d");
    $hour_count = date_interval_format($dif, "%H") + ($day_count * 24);
    $min_count = date_interval_format($dif, "%I");
    $hour_and_min_count = str_pad($hour_count, 6, ", $min_count", STR_PAD_RIGHT);
    $hour_and_min = ['hour' => $hour_count, 'min' => $min_count];
    return $hour_and_min;
}

$page_content = include_template('main.php', ['ads' => $ads, 'cats' => $cats,]);
$layout_content = include_template('layout.php', [
'content' => $page_content,
'cats' => $cats,
'title' => 'Главная страница',
'user_name' => $user_name,
'is_auth' => $is_auth
]);
print($layout_content);
?>