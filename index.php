<?php
$is_auth = rand(0, 1);
$user_name = 'Игорь Русалеев'; // укажите здесь ваше имя
$cats = ["Доски и лыжи","Крепления","Ботинки","Одежда","Инструменты","Разное"];
$ads = [
        [
            'name' => '2014 Rossignol District Snowboard',
            'cat' => $cats[0],
            'Price' => '10999',
            'Picture_URL' => 'img/lot-1.jpg'
        ],
        [
            'name' => 'DC Ply Mens 2016/2017 Snowboard',
            'cat' => $cats[0],
            'Price' => '159999',
            'Picture_URL' => 'img/lot-2.jpg'
        ],
        [
            'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'cat' => $cats[1],
            'Price' => '8000',
            'Picture_URL' => 'img/lot-3.jpg'
        ],
        [
            'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'cat' => $cats[2],
            'Price' => '10999',
            'Picture_URL' => 'img/lot-4.jpg'
        ],
        [
            'name' => 'Куртка для сноуборда DC Mutiny Charocal',
            'cat' => $cats[3],
            'Price' => '7500',
            'Picture_URL' => 'img/lot-5.jpg'
        ],
        [
            'name' => 'Маска Oakley Canopy',
            'cat' => $cats[5],
            'Price' => '5400',
            'Picture_URL' => 'img/lot-6.jpg'
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
?>

$page_content = include_template('templates/main.php', ['ads' => $ads]);
$layout_content = include_template('templates/layout.php', [
'content' => $page_content,
'cat' => $cats,
'title' => 'Главная страница'
]);
print($layout_content);