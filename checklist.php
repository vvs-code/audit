<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    /** Импортируемые переменные */
    /** @var array $checklist_color */
    /** @var array $criteria_titles */
    /** @var array $checklists */

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    if (!isset($_GET['id']) or !isset($_GET['audit'])) {
        leave();
    }

    $myid = +$_SESSION['user']['id'];
    $auditid = +$_GET['audit'];
    $checkid = +$_GET['id'];

    $connection = get_connection();

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $marks = json_decode($audit['marks']);
    $audit['started'] = (array)json_decode($audit['started']);
    $audit['comments'] = (array)json_decode($audit['comments']);

    if (!$audit['started'][$checkid]) {
        $audit['started'][$checkid] = 1;
        mysqli_query($connection, 'UPDATE audits SET started = "'.safe_string(json_encode($audit['started'])).'" WHERE id = '.$auditid);
    }

    print(include_template([
        'page' => 'checklist.php',
        'title' => 'Чек-лист',
        'scripts' => ['/scripts/checklist.js'],
        'data' => [
            'audit' => $audit,
            'auditid' => $auditid,
            'checkid' => $checkid,
            'checklist_color' => $checklist_color,
            'criteria_titles' => $criteria_titles,
            'checklists' => $checklists,
            'marks' => $marks
        ],
        'theme' => $checklist_color[$checkid][0]
    ]));
