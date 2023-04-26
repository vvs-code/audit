<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    if (!isset($_GET['id'])) {
        leave();
    }

    $auditid = +$_GET['id'];

    $myid = +$_SESSION['user']['id'];
    $mysurname = $_SESSION['user']['surname'];
    $myname = $_SESSION['user']['name'];
    $myfathername = $_SESSION['user']['fathername'];

    $connection = get_connection();
    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];

    $audit['participants'] = json_decode($audit['participants']);
    $audit['marks'] = json_decode($audit['marks']);
    $audit['checklists'] = json_decode($audit['checklists']);
    $audit['weights'] = json_decode($audit['weights']);
    $audit['started'] = json_decode($audit['started']);
    $audit['admin'] = +$audit['admin'];

    if ($myid !== $audit['admin']) {
        leave();
    }

    $sumfinal = 0;
    $fullchecklists = 0;

    $userids = json_decode($audit['users']);
    $users = [];

    foreach ($userids as $userid) {
        $users[] = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE id = "'.$userid.'"'), MYSQLI_ASSOC)[0];
    }

    print(include_template([
        'page' => 'auditors.php',
        'title' => 'Аудиторы',
        'scripts' => [],
        'data' => [
            'audit' => $audit,
            'auditid' => $auditid,
            'users' => $users,
            'myid' => $myid,
            'mysurname' => $mysurname,
            'myname' => $myname,
            'myfathername' => $myfathername
        ]
    ]));
