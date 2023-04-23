<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

//    var_dump($_POST);
//    die();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty(trim($_POST['title'])) and !empty($_POST['datestart']) and !empty($_POST['dateend']) and !empty($_POST['profile']) and !empty($_POST['coeff'])) {
            $marks = [];
            $comments = [];
            for ($i = 0; $i <= 9; $i++) {
                $marks[] = get_array_of_ns($criteria_numbers[$i], -1);
                $comments[] = get_array_of_ns($criteria_numbers[$i], "");
            }

            if (in_array($_POST['profile'], ['РИ', 'Р', 'И', 'У', 'Д'])) {
                $checklists = $profile_to_checklists[$_POST['profile']];
                $weights = $profile_to_checklists_weights[$_POST['profile']];
            } else if ($_POST['profile'] === 'Др') {
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
                header('location: /');
            }
            mysqli_query($connection, 'INSERT INTO audits SET title = "'.mysqli_real_escape_string($connection, trim($_POST['title'])).'", `admin` = '.+$_SESSION['user']['id'].', users = "[]", participants = "[[],[],[],[],[],[],[],[],[],[]]", started = "[0,0,0,0,0,0,0,0,0,0]", code = "'.generate_random_code().'", profile = "'.mysqli_real_escape_string($connection, $_POST['profile']).'", datestart = "'.mysqli_real_escape_string($connection, $_POST['datestart']).'", dateend = "'.mysqli_real_escape_string($connection, $_POST['dateend']).'", marks = "'.mysqli_real_escape_string($connection, json_encode($marks)).'", `comments` = "'.mysqli_real_escape_string($connection, json_encode($comments)).'", coeff = "'.mysqli_real_escape_string($connection, $_POST['coeff']).'", checklists = "'.mysqli_real_escape_string($connection, json_encode($checklists)).'", weights = "'.mysqli_real_escape_string($connection, json_encode($weights)).'"');
            header('location: /');
        } else {
            header('location: /createaudit?error');
        }
    } else {
        header('location: /');
    }