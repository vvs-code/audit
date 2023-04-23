<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if (isset($_SESSION['user']) and $_SERVER['REQUEST_METHOD'] === 'POST') {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_POST['audit'].'"'), MYSQLI_ASSOC)[0];
        $audit['admin'] = +$audit['admin'];
        $weights = json_decode($audit['weights']);
        if ($audit['admin'] === +$_SESSION['user']['id']) {
            if (in_array(+$_POST['weight'], [0.05, 0.1, 0.15, 0.2, 0.25, 0.3, 0.35, 0.4, 0.45, 0.5, 0.55, 0.6, 0.65, 0.7, 0.75, 0.8, 0.85, 0.9, 0.95, 1])) {
                $weights[+$_POST['checklist']] = +$_POST['weight'];
                mysqli_query($connection, 'UPDATE audits SET weights = "'.mysqli_real_escape_string($connection, json_encode($weights)).'" WHERE id = "'.+$_POST['audit'].'"');
                print(json_encode($weights));
            } else {
                http_response_code(500);
            }
        } else {
            http_response_code(403);
        }
    } else {
        http_response_code(403);
    }