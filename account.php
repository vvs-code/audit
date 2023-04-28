<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    $user = $_SESSION['user'];
    $myid = +$user['id'];
    $email = $user['email'];
    $surname = $user['surname'];
    $nameletter = preg_split('//u', $user['name'], -1, PREG_SPLIT_NO_EMPTY)[0];
    $fathernameletter = preg_split('//u', $user['fathername'], -1, PREG_SPLIT_NO_EMPTY)[0];

    $errormessage_data = '';

    if (isset($_GET['errordata'])) {
        $error = $_GET['errordata'];

        if ($error === 'empty') {
            $errormessage_data = 'Не все поля заполнены';
        } elseif ($error === 'exist') {
            $errormessage_data = 'Аккаунт с таким email уже существует';
        } elseif ($error === 'email') {
            $errormessage_data = 'Введите корректный email';
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
            'email' => $email,
            'surname' => $surname,
            'nameletter' => $nameletter,
            'fathernameletter' => $fathernameletter
        ]
    ]));
