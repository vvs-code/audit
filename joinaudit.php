<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    if (!isset($_SESSION['user'])) {
        header('location: /login');
    }

    $errormessage = '';

    if (isset($_GET['error'])) {
        $error = $_GET['error'];

        if ($error === 'format') {
            $errormessage = 'Код аудита должен состоять из 6 латинских букв';
        } elseif ($error === 'empty') {
            $errormessage = 'Введите код аудита';
        } elseif ($error === 'notfound') {
            $errormessage = 'Аудит не найден';
        }
    }

    print(include_template([
        'page' => 'joinaudit.php',
        'title' => 'Присоединиться к аудиту',
        'scripts' => [],
        'data' => [
            'errormessage' => $errormessage
        ]
    ]));
