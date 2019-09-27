<?php
require_once 'init.php';
   if (!$link) {
       $error = mysqli_connect_error();
       show_error($content, $error);
   }
   else {
       $sql = "SELECT * FROM category ORDER BY name_cat ASC";
       $result = mysqli_query($link, $sql);
       $cats_ids = [];

       if ($result) {
           $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);
           $cats_ids = array_column($cats, 'category_id');
       }

       if (isset($_SESSION['user'])) {
           $name_user = $_SESSION['user']['name_user'];
           $sql_user = 'SELECT * FROM user WHERE name_user = "$name_user"';
           $user = db_fetch_data($link, $sql, $data = []);
       }

       $lot = [];
       //Получим содержимое поискового запроса. Если поисковый запрос не задан, то присвоим пустую строку
       $search = $_GET['search'] ?? '';

       if ($search) {
           $sql_lot = 'SELECT lot_id, name_lot, description, initial_price, image, expiration_date, step_rate, name_cat FROM  category c '
               . 'INNER JOIN lot l ON c.category_id = l.category_id '
               . 'WHERE now() < expiration_date AND MATCH(name_lot, description) AGAINST(?)';

           $stmt = db_get_prepare_stmt($link, $sql_lot, [$search]);
           mysqli_stmt_execute($stmt);
           $result_lot = mysqli_stmt_get_result($stmt);

           $lot = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
           $count_lot = count($lot);
           $page_content = include_template('main_search.php', [
               'search' => $search,
               'lot' => $lot,
               'count_lot' => $count_lot,
               'cats' => $cats]
           );
       }
   }
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'cats' => $cats,
    'lot' => $lot,
    'title' => 'Результаты поиска',
    'name_user' => $name_user]);
print($layout_content);
?>