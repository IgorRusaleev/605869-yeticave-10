<?php
$is_auth = rand(0, 1);
$user_name = 'Игорь Русалеев'; // укажите здесь ваше имя
require_once('helpers.php');
/*подключение к MySQL*/
$con = mysqli_connect("localhost", "root", "","yeticave");

$cats = ["Доски и лыжи","Крепления","Ботинки","Одежда","Инструменты","Разное"];
$ads = [
        [
            'name' => '2014 Rossignol District Snowboard',
            'cat' => $cats[0],
            'Price' => '10999',
            'Picture_URL' => 'img/lot-1.jpg',
            'expiration_date' => '2019-12-30'
        ],
        [
            'name' => 'DC Ply Mens 2016/2017 Snowboard',
            'cat' => $cats[0],
            'Price' => '159999',
            'Picture_URL' => 'img/lot-2.jpg',
            'expiration_date' => '2019-11-27'
        ],
        [
            'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'cat' => $cats[1],
            'Price' => '8000',
            'Picture_URL' => 'img/lot-3.jpg',
            'expiration_date' => '2019-11-16'
        ],
        [
            'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'cat' => $cats[2],
            'Price' => '10999',
            'Picture_URL' => 'img/lot-4.jpg',
            'expiration_date' => '2019-12-21'
        ],
        [
            'name' => 'Куртка для сноуборда DC Mutiny Charocal',
            'cat' => $cats[3],
            'Price' => '7500',
            'Picture_URL' => 'img/lot-5.jpg',
            'expiration_date' => '2019-11-13'
        ],
        [
            'name' => 'Маска Oakley Canopy',
            'cat' => $cats[5],
            'Price' => '5400',
            'Picture_URL' => 'img/lot-6.jpg',
            'expiration_date' => '2019-12-11'
        ]
];
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