<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    /** Импортируемые переменные */
    /** @var array $criteria_titles */
    /** @var array $criteria_numbers */
    /** @var array $checklist_color */
    /** @var array $possible_weights */

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    $myid = +$_SESSION['user']['id'];
    $auditid = +$_GET['id'];

    $connection = get_connection();

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE `id` = '.$auditid), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['participants'] = json_decode($audit['participants']);
    $audit['marks'] = json_decode($audit['marks']);
    $audit['checklists'] = json_decode($audit['checklists']);
    $audit['weights'] = json_decode($audit['weights']);
    $audit['started'] = json_decode($audit['started']);
    $users = json_decode($audit['users']);
    $audit['admin'] = +$audit['admin'];
    $audit['finished'] = +$audit['finished'];

    if (!in_array($myid, $users) and $myid !== $audit['admin']) {
        leave();
    }

    $audit['finaldata'] = get_array_of_ns(10, []);

    $fullchecklists = 0;

    for ($i = 0; $i <= 9; $i++) {
        if ($audit['checklists'][$i]) {
            $marks = $audit['marks'];

            $unedited = (count(array_filter($marks[$i], function ($value) {
                return $value === -1;
            })));
            $edited = (count(array_filter($marks[$i], function ($value) {
                return $value !== -1;
            })));

            $fullchecklists += $unedited === 0 ? 1 : 0;

            $audit['usage'][$i] = [
                'edited' => $edited,
                'unedited' => $unedited
            ];
        }
    }

    $finals = get_final_for_checklist($audit);
    $audit['finals'] = $finals;

    print(include_template([
        'page' => 'audit.php',
        'title' => 'Аудит',
        'scripts' => ['/scripts/audit.js'],
        'data' => [
            'audit' => $audit,
            'myid' => $myid,
            'auditid' => $auditid,
            'possible_weights' => $possible_weights,
            'criteria_titles' => $criteria_titles,
            'criteria_numbers' => $criteria_numbers,
            'checklist_color' => $checklist_color,
            'fullchecklists' => $fullchecklists
        ]
    ]));
