<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if (isset($_SESSION['user']) and $_SERVER['REQUEST_METHOD'] === 'POST') {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_POST['audit'].'"'), MYSQLI_ASSOC)[0];
        $audit['admin'] = +$audit['admin'];
        $audit['users'] = json_decode($audit['users']);
        $marks = json_decode($audit['marks']);
        if ($audit['admin'] === +$_SESSION['user']['id'] or in_array(+$_SESSION['user']['id'], $audit['users'])) {
            if (in_array($_POST['mark'], [-2, -1, 0, 0.25, 0.5, 0.75, 1])) {
                $marks[+$_POST['checklist']][+$_POST['criteria']] = +$_POST['mark'];
                mysqli_query($connection, 'UPDATE audits SET marks = "'.mysqli_real_escape_string($connection, json_encode($marks)).'" WHERE id = "'.+$_POST['audit'].'"');
            } else {
                http_response_code(500);
            }
        } else {
            http_response_code(403);
        }
    } else {
        http_response_code(403);
    }