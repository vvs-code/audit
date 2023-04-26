<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    if (isset($_SESSION['user'])) {
        leave();
    }

    print(include_template([
        'page' => 'login.php',
        'title' => 'Аудиты',
        'scripts' => ['/scripts/login.js'],
        'data' => []
    ]));
