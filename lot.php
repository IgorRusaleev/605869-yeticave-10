<?php
require_once 'init.php';
require_once 'vendor/autoload.php';
   if (isset($_SESSION['user'])) {
       $name_user = $_SESSION['user']['name_user'];
       $user_id = $_SESSION['user']['user_id'];
   }
   if (isset($_GET["id"])) {
       $id = htmlspecialchars($_GET["id"]);
   }
   else {
       header('http_response_code(404)');
   }

   if (!$link) {
       $error = mysqli_connect_error();
       $page_content = include_template("error.php", ["error" => $error]);
   }
   else {
//       Запрос на получение новых, открытых лотов
       $sql_lot = "SELECT lot_id, name_lot, description, initial_price, image, expiration_date, step_rate, name_cat, user_id "
           . "FROM  category c "
           . "INNER JOIN lot l ON c.category_id = l.category_id "
           . "WHERE lot_id = $id";
       $lot = db_fetch_data($link, $sql_lot, $data = []);
//       Получение всех категорий
       $sql_cat = "SELECT * FROM category ORDER BY name_cat ASC";
       $cats = db_fetch_data($link, $sql_cat, $data = []);
   }
   $rate = ($lot[0]['initial_price'] + $lot[0]['step_rate']);
//   проверяем метод отправки формы
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $errors = [];
       $cost = $_POST["cost"];
       if (empty($_POST["cost"])) {
//     если поле не заполнено, то добавляем ошибку валидации в список ошибок
           $errors["cost"] = 'Это поле надо заполнить';
       }
       else {
           if (!is_numeric($cost)) {
               $errors['cost'] = "Ваша ставка должена быть числом ";
           }
           else {
               if ($cost < 0) {
                   $errors['cost'] = "Ваша ставка должена быть положительным числом ";
               }
               elseif ($cost < $rate) {
                   $errors['cost'] = "Значение должно быть больше или равно сумме текущей цены лота и шага ставки ";
               }
               else {
                   $errors['cost'] = null;
               }
           }
       }
//         массив отфильтровываем, чтобы удалить от туда пустые значения и оставить только сообщения об ошибках
       $errors = array_filter($errors);
       if (count($errors)) {
           $sql_history_rate = "SELECT u.name_user, r.rate, r.date_rate "
               . "FROM  user u "
               . "INNER JOIN rate r ON r.user_id = u.user_id "
               . "WHERE r.lot_id = $id";
           $history_rate = db_fetch_data($link, $sql_history_rate, $data = []);
           $number_rate = count($history_rate);
           $page_content = include_template('main_lot.php', ["id" => $id, 'lot' => $lot, 'errors' => $errors, 'cats' => $cats, "history_rate" => $history_rate, "number_rate" => $number_rate]);
       }
       else {
           $rate = $cost;
           $rate_lot = [
               'rate' => $rate,
               'user_id' => $user_id,
               'lot_id' => $id
           ];
           $sql_rate = 'INSERT INTO rate (date_rate, rate, user_id, lot_id) VALUES (NOW(), ?, ?, ?)';
           $stmt_rate = db_get_prepare_stmt($link, $sql_rate, $rate_lot);
           $res_rate = mysqli_stmt_execute($stmt_rate);
           $sql_history_rate = "SELECT u.name_user, r.rate, r.date_rate "
               . "FROM  user u "
               . "INNER JOIN rate r ON r.user_id = u.user_id "
               . "WHERE r.lot_id = $id";
           $history_rate = db_fetch_data($link, $sql_history_rate, $data = []);
           $number_rate = count($history_rate);
           if ($res_rate) {
               $page_content = include_template('main_lot.php', ["id" => $id, "lot" => $lot, "cats" => $cats, "history_rate" => $history_rate, "number_rate" => $number_rate]);
           }
           else {
               $error = mysqli_error($link);
               $page_content = include_template("error.php", ["error" => $error]);
           }
       }
   }
   else {
       $sql_history_rate = "SELECT u.name_user, r.rate, r.date_rate "
           . "FROM  user u "
           . "INNER JOIN rate r ON r.user_id = u.user_id "
           . "WHERE r.lot_id = $id";
       $history_rate = db_fetch_data($link, $sql_history_rate, $data = []);
       $number_rate = count($history_rate);
       $page_content = include_template('main_lot.php', ["id" => $id, "lot" => $lot, "cats" => $cats, "history_rate" => $history_rate, "number_rate" => $number_rate]);
   }


$title = $lot[0]["name_lot"];
$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "cats" => $cats,
    'title' => $title,
    "lot" => $lot,
    'name_user' => $name_user
]);
print($layout_content);
?>