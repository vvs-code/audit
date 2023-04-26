<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    print(include_template([
        'page' => 'createaudit.php',
        'title' => 'Создать аудит',
        'scripts' => []
    ]));
