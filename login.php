<?php
$is_auth = 0;
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

    //  Проверяем, что форма была отправлена
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //  Определяем обязательные для заполнения поля, а также массив, где будут храниться ошибки
        $form = $_POST;

        $required = ['email', 'password'];
        $errors = [];
        // Проверяем все поля на заполненность
        foreach ($required as $field) {
            if (empty($form[$field])) {
                $errors[$field] = 'Это поле надо заполнить';
            }
        }

        //  Найдем в таблице users пользователя с переданным email.
        $email = mysqli_real_escape_string($link, $form['email']);
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $res = mysqli_query($link, $sql);

        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

        if (!count($errors) and $user) {
            //  Проверяем, что сохраненный хеш пароля и введенный пароль из формы совпадают
            if (password_verify($form['password'], $user['password'])) {
                //  Если пароль совпадает, то для пользователя открываем сессию
                $_SESSION['user'] = $user;
            }
            // иначе, если пароль неверный, и мы добавляем сообщение об этом в список ошибок
            else {
                $errors['password'] = 'Неверный пароль';
            }
        }
        // Если пользователь не найден, то записываем это как ошибку валидации
        else {
            $errors['email'] = 'Такой пользователь не найден';
        }

        // Если были ошибки, значит мы снова должны показать форму входа, передав в шаблон список полученных ошибок
        if (count($errors)) {
            $page_content = include_template('main_login.php', ['form' => $form, 'errors' => $errors]);
        }
        //Если ошибок нет, значит аутентификация прошла успешно и пользователя можно перенаправить на главную страницу
        else {
            header("Location: /index.php");
            exit();
        }

        //  Если форма не была отправлена, то проверяем существование сессии с пользователем.
        else {
            $page_content = include_template('enter.php', []);

            //  Сессия есть - значит пользователь залогинен и ему можно показать главную страницу.
            if (isset($_SESSION['user'])) {
                header("Location: /index.php");
                exit();
            }
        }
$page_content = include_template('main_login.php']);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'cats' => $cats,
    'title' => 'Вход',
    'name_user' => $name_user,
    'is_auth' => $is_auth
]);
print($layout_content);
?>