<?php
session_start();
require_once('helpers.php');
/*подключение к MySQL*/
$link = mysqli_connect("localhost", "root", "","yeticave");
mysqli_set_charset($link, "utf8");
$lot = [];
$cats = [];
$content = '';
$name_user = [];