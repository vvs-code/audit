<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    $myid = +$_SESSION['user']['id'];

    $connection = get_connection();

    $audits = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE deleted = "0" ORDER BY id DESC'), MYSQLI_ASSOC);

    $myaudits = [];

    foreach ($audits as $audit) {
        $users = json_decode($audit['users']);
        $contains = false;
        $audit['admin'] = +$audit['admin'];

        foreach ($users as $user) {
            if ($user === $myid) {
                $contains = true;
            }
        }

        if ($audit['admin'] === $myid or $contains) {
            $marks = json_decode($audit['marks']);
            $audit['checklists'] = json_decode($audit['checklists']);
            $audit['marks'] = json_decode($audit['marks']);
            $audit['weights'] = json_decode($audit['weights']);
            $audit['finished'] = +$audit['finished'];

            $resulted = 0;

            foreach ($audit['checklists'] as $i => $checklist) {
                if ($audit['checklists'][$i]) {
                    $unedited = (count(array_filter($marks[$i], function($value) { return $value === -1;})));
                    if ($unedited === 0) {
                        $resulted++;
                    }
                }
            }

            if ($audit['finished']) {
                $finals = get_final_for_checklist($audit);
                $audit['finals'] = $finals;
            }

            $audit['resulted'] = $resulted;

            $myaudits[] = $audit;
        }
    }

    print(include_template([
        'page' => 'index.php',
        'title' => 'Аудиты',
        'scripts' => [],
        'data' => [
            'myaudits' => $myaudits,
            'myid' => $myid
        ]
    ]));
