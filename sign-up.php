<?php
require_once 'init.php';

    if (!$link) {
        $error = mysqli_connect_error();
        show_error($content, $error);
    }
    else {
        $sql = "SELECT * FROM category ORDER BY name_cat ASC";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $cats = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }

     $tpl_data = [];

     /*проверяем метод отправки формы*/
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $form = $_POST;
         $errors = [];

         $email = $_POST["email"];
         $password = $_POST["password"];
         $name_user = $_POST["name_user"];
         $contact_information = $_POST["contact_information"];

         $req_fields = ['email', 'password', 'name_user', 'contact_information'];

         foreach ($req_fields as $field) {
             if (empty($form[$field])) {
                 $errors[] = "Не заполнено поле " . $field;
             }
         }

         /*Определим функции-помощники для валидации и поля, которые они должны обработать*/
         $rules = [
             'email' => function () use ($email) {
                 if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                     return null;
                 } else {
                     return "E-mail адрес '$email' указан неверно";
                 }
             },
             'password' => function () {
             return validateLength('password', 6, 20);
             },
             'name_user' => function () {
             return validateLength('name_user', 2, 20);
             },
             'contact_information' => function () {
             return validateLength('contact_information', 6, 100);
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

/*        Проверка существования пользователя с email*/
         if (empty($errors)) {
             $email = mysqli_real_escape_string($link, $form['email']);
             $sql = "SELECT user_id FROM user WHERE email = '$email'";
             $res = mysqli_query($link, $sql);

//           Если запрос вернул больше нуля записей, значит такой поьзователь уже существует
             if (mysqli_num_rows($res) > 0) {
                 $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
             }

//           Добавим нового пользователя в БД. Чтобы не хранить пароль в открытом виде преобразуем его в хеш.
             else {
                 $password = password_hash($form['password'], PASSWORD_DEFAULT);

                 $sql = 'INSERT INTO user (registration_date, email, name_user, password, contact_information) VALUES (NOW(), ?, ?, ?, ?)';
                 $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name_user'], $password, $form['contact_information']]);
                 $res = mysqli_stmt_execute($stmt);
             }

//           Редирект на страницу входа, если пользователь был успешно добавлен в БД.
             if ($res && empty($errors)) {
                 header("Location: /login.php");
                 exit();
             }
         }

//       Передадим в шаблон список ошибок и данные из формы
         $tpl_data['errors'] = $errors;
         $tpl_data['values'] = $form;

     }

     $page_content = include_template('main_sign-up.php', $tpl_data);

     $layout_content = include_template('layout_sign-up.php', [
    'content' => $page_content,
    'cats' => $cats,
    'title' => 'Регистрация'
     ]);

     print($layout_content);
?>