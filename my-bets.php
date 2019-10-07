<?php
require_once 'init.php';
if (isset($_SESSION['user'])) {
    $name_user = $_SESSION['user']['name_user'];
    $user_id = $_SESSION['user']['user_id'];
}
   if (!$link) {
       $error = mysqli_connect_error();
       $page_content = include_template("error.php", ["error" => $error]);
   }
   else {
//       Получение всех категорий
       $sql_cat = 'SELECT * FROM category ORDER BY name_cat ASC';
       $cats = db_fetch_data($link, $sql_cat, $data = []);
   }
   $sql = "SELECT l.lot_id, l.name_lot, l.image, l.expiration_date, l.user_winner, "
       . "r.date_rate, r.rate, r.user_id, c.name_cat, u.contact_information "
    . "FROM lot l JOIN rate r ON l.lot_id = r.lot_id "
    . "JOIN category c ON l.category_id = c.category_id "
    . "JOIN user u ON u.user_id = l.user_id"
    . " WHERE r.user_id = $user_id and rate = (SELECT MAX(rate) FROM rate)";
   if (!$link) {
       $error = mysqli_connect_error();
       $page_content = include_template("error.php", ["error" => $error]);
   }
   else {
    $lot = db_fetch_data($link, $sql, $data = []);
    $page_content = include_template('main_my-bets.php', ["lot" => $lot]);
   }
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'cats' => $cats,
    'title' => 'Мои ставки',
    'name_user' => $name_user
]);
print($layout_content);
?>