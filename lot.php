<?php
require_once('helpers.php');
/*подключение к MySQL*/
$link = mysqli_connect("localhost", "root", "","yeticave");
mysqli_set_charset($link, "utf8");
if (isset($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);
}
else {
    header('http_response_code(404)');
}
$id = htmlspecialchars($_GET["id"]) ?? header('http_response_code(404)');
$lot = [];
$cats = [];
$content = "";
$sql = "SELECT lot_id, name_lot, description, initial_price, image, expiration_date, step_rate, name_cat FROM  category c "
    . "INNER JOIN lot l ON c.category_id = l.category_id "
    . "WHERE $id = lot_id";
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template("error.php", ["error" => $error]);
}
else {
    /*Запрос на получение новых, открытых лотов*/
    $lot = db_fetch_data($link, $sql, $data = []) ?? header('http_response_code(404)');


}
/*Получение всех категорий*/
$sql = "SELECT * FROM category ORDER BY name_cat ASC";
$cats = db_fetch_data($link, $sql, $data = []);
$is_auth = rand(0, 1);
$page_content = include_template("main_lot.php", ["is auth" => $is_auth, "lot" => $lot, "cats" => $cats]);
$layout_content = include_template("layout_lot.php", [
    "content" => $page_content,
    "cats" => $cats,
    "lot" => $lot
]);
print($layout_content);
?>