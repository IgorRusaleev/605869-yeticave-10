<?php
require_once 'init.php';
$name_user = [];
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
}

if (isset($_SESSION['user'])) {
    $name_user = $_SESSION['user']['name_user'];
    $sql_user = 'SELECT * FROM user WHERE name_user = "$name_user"';
    $user = db_fetch_data($link, $sql, $data = []);
}

     /*проверяем метод отправки формы*/
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         /*Скопируем POST массив в переменную $lot*/
         $lot = $_POST;

         $name_lot = $_POST["name_lot"];
         $description = $_POST["description"];
         $initial_price = $_POST["initial_price"];
         $expiration_date = $_POST["expiration_date"];
         $step_rate = $_POST["step_rate"];
         $category_id = $_POST["category_id"];

         /*определяем список полей, которые собираемся валидировать*/
         $required = ['name_lot', 'description', 'initial_price', 'step_rate', 'expiration_date', 'category_id'];

         /*определяем пустой массив $errors, который будем заполнять ошибками валидации*/
         $errors = [];

         /*Определим функции-помощники для валидации и поля, которые они должны обработать*/
         $rules = [
             'category_id' => function () use ($cats_ids) {
                 return validateCategory('category_id', $cats_ids);
             },
             'name_lot' => function () {
                 return validateLength('name_lot', 10, 128);
             },
             'description' => function () {
                 return validateLength('description', 10, 2000);
             },
             'initial_price' => function () use ($initial_price) {
                 if ((!is_numeric($initial_price)) and ($initial_price > 0)) {
                     return "Начальная цена должна быть числом";
                 }
                 return null;
             },
             'step_rate' => function () use ($step_rate) {
                 if ((!is_numeric($step_rate)) and ($step_rate > 0)) {
                     return "Шаг ставки должен быть числом ";
                 }
                 return null;
             },
             'expiration_date' => function () use ($expiration_date) {
                 return is_date_valid('expiration_date');
             }
         ];

         /*Применяем функции ко всем полям формы*/
         foreach ($_POST as $key => $value) {
             if (isset($rules[$key])) {
                 $rule = $rules[$key];

                 /*Результат работы функций записывается в массив ошибок*/
                 $errors[$key] = $rule();
             }
         }

         /*массив отфильтровываем, чтобы удалить от туда пустые значения и оставить только сообщения об ошибках*/
         $errors = array_filter($errors);

         /*проверяем существование каждого поля в списке обязательных к заполнению*/
         foreach ($required as $key) {
             if (empty($_POST[$key])) {

                 /*если поле не заполнено, то добавляем ошибку валидации в список ошибок*/
                 $errors[$key] = 'Это поле надо заполнить';
             }
         }

         /*Проверим, был ли загружен файл*/
         if (isset($_FILES['image']['name'])) {
             $tmp_name = $_FILES['image']['tmp_name'];
             $image = $_FILES['image']['name'];

             /*получим информацию о типе файла*/
             $finfo = finfo_open(FILEINFO_MIME_TYPE);
             $file_type = finfo_file($finfo, $tmp_name);

             /*Если тип загруженного файла не является jpeg, то добавляем новую ошибку в список ошибок валидации*/
             if ($file_type !== "image/jpeg" or $file_type !== "image/png") {
                 $errors['file'] = 'Загрузите картинку в формате jpeg или png';
             }

             /*создание нового имени файла*/
             if ($file_type == "image/jpeg") {
                 $filename = uniqid() . '.jpeg';
             }
             elseif ($file_type == "image/png") {
                 $filename = uniqid() . '.png';
             }

//        Если файл jpeg, то мы копируем его в директорию где лежат все изображения и добавляем путь
//        к загруженному изображению в массив $lot
             else {
                 move_uploaded_file($tmp_name, 'uploads/' . $filename);
                 $lot['image'] = $filename;
                 $image = $lot['image'];
             }
         }

         /*если файл не был загружен, добавляем ошибку*/
         else {
             $errors['file'] = 'Вы не загрузили файл';
         }

         /*проверяем длину массива с ошибками*/
         if (count($errors)) {
             /*если были ошибки, то показываем их пользователю вместе с формой*/
             $page_content = include_template('main_add-lot.php', [
                 'lot' => $lot,
                 'errors' => $errors,
                 'cats' => $cats]);
         }
         else {
             /*до выполнения задания #15 user_id любое число*/
             $lot = [
                 'name_lot' => $name_lot,
                 'description' => $description,
                 'image' => 'uploads/' . $image,
                 'initial_price' => $initial_price,
                 'expiration_date' => $expiration_date,
                 'step_rate' => $step_rate,
                 'category_id' => $category_id
                 ];
             $sql = 'INSERT INTO lot (creation_date, name_lot, description, image, initial_price, expiration_date,
                 step_rate, user_id, category_id) VALUES (NOW(), ?, ?, ?, ?,  ?, ?, ?, ?)';

             /*Подготавливаем выражение*/
             $stmt = db_get_prepare_stmt($link, $sql, [$lot['name_lot'], $lot['description'], $lot['image'], $lot['initial_price'],
                 $lot['expiration_date'], $lot['step_rate'], $user['user_id'], $lot['category_id']]);
             $res = mysqli_stmt_execute($stmt);

             if ($res) {
                 $lot_id = mysqli_insert_id($link);
                 header("Location: lot.php?id=" . $lot_id);
             }
         }
     }
     else {
         $page_content = include_template('main_add-lot.php', [
             'cats' => $cats,
             'lot' => $lot,
             'name_user' => $name_user]);
     }
     //Если метод не POST, значит форма не была отправлена и валидировать ничего не надо, поэтому просто подключаем шаблон показа формы
  
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'cats' => $cats,
    'lot' => $lot,
    'title' => 'Добавление лота',
    'name_user' => $name_user]);

print($layout_content);
?>