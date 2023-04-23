<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

    if (!isset($_SESSION['user'])) {
        header('location: /login');
    }

    print(include_template([
        'page' => 'auditors.php',
        'title' => 'Аудиторы',
        'scripts' => [],
        'data' => []
    ]));
