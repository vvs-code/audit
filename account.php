<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    $user = $_SESSION['user'];
    $myid = +$_SESSION['user']['id'];
    $surname = $_SESSION['user']['surname'];
    $nameletter = preg_split('//u', $_SESSION['user']['name'], -1, PREG_SPLIT_NO_EMPTY)[0];
    $fathernameletter = preg_split('//u', $_SESSION['user']['fathername'], -1, PREG_SPLIT_NO_EMPTY)[0];

    $errormessage_data = '';

    if (isset($_GET['errordata'])) {
        $error = $_GET['errordata'];

        if ($error === 'empty') {
            $errormessage_data = 'Не все поля заполнены';
        }
    }

    $errormessage_password = '';

    if (isset($_GET['errorpassword'])) {
        $error = $_GET['errorpassword'];

        if ($error === 'empty') {
            $errormessage_password = 'Не все поля заполнены';
        } elseif ($error === 'wrong') {
            $errormessage_password = 'Текущий пароль неправильный';
        } elseif ($error === 'diff') {
            $errormessage_password = 'Пароли не совпадают';
        } elseif ($error === 'passwordlength') {
            $errormessage_password = 'Пароль должен быть не короче 8 символов';
        }
    }

    print(include_template([
        'page' => 'account.php',
        'title' => 'Данные аккаунта',
        'scripts' => [],
        'data' => [
            'errormessage_data' => $errormessage_data,
            'errormessage_password' => $errormessage_password,
            'user' => $user,
            'myid' => $myid,
            'surname' => $surname,
            'nameletter' => $nameletter,
            'fathernameletter' => $fathernameletter
        ]
    ]));
