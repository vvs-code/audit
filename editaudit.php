<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    /** Импортируемые переменные */
    /** @var array $profile_to_full */
    /** @var array $profiles_list */

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    if (!isset($_GET['id'])) {
        leave();
    }

    $auditid = +$_GET['id'];
    $myid = +$_SESSION['user']['id'];

    $connection = get_connection();

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $users = json_decode($audit['users']);

    if ($myid !== $audit['admin']) {
        leave();
    }

    $errormessage = '';

    if (isset($_GET['error'])) {
        $error = $_GET['error'];

        if ($error === 'empty') {
            $errormessage = 'Не все поля заполнены';
        } elseif ($error === 'rights') {
            $errormessage = 'Нет прав на редактрование аудита';
        }
    }

    print(include_template([
        'page' => 'editaudit.php',
        'title' => 'Редактировать аудит',
        'scripts' => [],
        'data' => [
            'audit' => $audit,
            'auditid' => $auditid,
            'errormessage' => $errormessage,
            'profile_to_full' => $profile_to_full,
            'profiles_list' => $profiles_list
        ]
    ]));
