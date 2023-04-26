<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    /** Импортируемые переменные */
    /** @var array $criteria_numbers */
    /** @var array $profile_to_checklists */
    /** @var array $profile_to_checklists_weights */

    $connection = get_connection();

    $myid = +$_SESSION['user']['id'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (empty(trim($_POST['title'])) or empty($_POST['datestart']) or empty($_POST['dateend']) or empty($_POST['profile']) or empty($_POST['coeff'])) {
        leave('/createaudit?error');
    }

    $marks = [];
    $comments = [];

    for ($i = 0; $i <= 9; $i++) {
        $marks[] = get_array_of_ns($criteria_numbers[$i], -1);
        $comments[] = get_array_of_ns($criteria_numbers[$i], '');
    }

    if (in_array($_POST['profile'], ['РИ', 'Р', 'И', 'У', 'Д'])) {
        $checklists = $profile_to_checklists[$_POST['profile']];
        $weights = $profile_to_checklists_weights[$_POST['profile']];
    } elseif ($_POST['profile'] === 'Др') {
        $checklists = [
            +isset($_POST['checklist0']),
            +isset($_POST['checklist1']),
            +isset($_POST['checklist2']),
            +isset($_POST['checklist3']),
            +isset($_POST['checklist4']),
            +isset($_POST['checklist5']),
            +isset($_POST['checklist6']),
            +isset($_POST['checklist7']),
            +isset($_POST['checklist8']),
            +isset($_POST['checklist9'])
        ];

        $weights = [
            $checklists[0] * 0.05,
            $checklists[1] * 0.05,
            $checklists[2] * 0.05,
            $checklists[3] * 0.05,
            $checklists[4] * 0.05,
            $checklists[5] * 0.05,
            $checklists[6] * 0.05,
            $checklists[7] * 0.05,
            $checklists[8] * 0.05,
            $checklists[9] * 0.05
        ];
    } else {
        leave('/createaudit?error');
    }

    mysqli_query($connection, 'INSERT INTO audits SET title = "'.safe_string(trim($_POST['title'])).'", `admin` = '.$myid.', `users` = "[]", participants = "[[],[],[],[],[],[],[],[],[],[]]", `started` = "[0,0,0,0,0,0,0,0,0,0]", `code` = "'.generate_random_code().'", `profile` = "'.safe_string($_POST['profile']).'", `datestart` = "'.safe_string($_POST['datestart']).'", `dateend` = "'.safe_string($_POST['dateend']).'", `marks` = "'.safe_string(json_encode($marks)).'", `comments` = "'.safe_string(json_encode($comments)).'", `coeff` = "'.safe_string($_POST['coeff']).'", `checklists` = "'.safe_string(json_encode($checklists)).'", `weights` = "'.safe_string(json_encode($weights)).'"');

    leave();
