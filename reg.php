<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

if (isset($_SESSION['user'])) {
    header('location: /');
}

print(include_template([
    'page' => 'reg.php',
    'title' => 'Регистрация',
    'scripts' => [],
    'data' => []
]));
