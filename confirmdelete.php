<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

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

    print(include_template([
        'page' => 'confirmdelete.php',
        'title' => 'Подтвердить удаление',
        'scripts' => [],
        'data' => [
            'audit' => $audit,
            'auditid' => $auditid
        ]
    ]));
