<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    /** Импортируемые переменные */
    /** @var array $checklist_color */
    /** @var array $criteria_titles */

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    if (!isset($_GET['id']) or !isset($_GET['audit'])) {
        leave();
    }

    $auditid = +$_GET['audit'];
    $checkid = +$_GET['id'];
    $myid = +$_SESSION['user']['id'];

    $connection = get_connection();

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $users = json_decode($audit['users']);

    if (!in_array($myid, $users) and $myid !== $audit['admin']) {
        leave();
    }

    print(include_template([
        'page' => 'confirmedit.php',
        'title' => 'Подтвердить редактирование',
        'scripts' => [],
        'data' => [
            'criteria_titles' => $criteria_titles,
            'checklist_color' => $checklist_color,
            'audit' => $audit,
            'auditid' => $auditid,
            'checkid' => $checkid
        ],
        'theme' => $checklist_color[$checkid][0]
    ]));
