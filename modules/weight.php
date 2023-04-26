<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if (!isset($_SESSION['user']) or $_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(403);
        exit();
    }

    if (!isset($_POST['weight']) or !isset($_POST['checklist']) or !isset($_POST['audit'])) {
        http_response_code(500);
        exit();
    }

    $myid = +$_SESSION['user']['id'];
    $weight = +$_POST['weight'];
    $checkid = +$_POST['checklist'];
    $auditid = +$_POST['audit'];

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_POST['audit'].'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        http_response_code(404);
        exit();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $weights = json_decode($audit['weights']);

    if ($audit['admin'] !== $myid) {
        http_response_code(403);
        exit();
    }

    if (!in_array($weight, [0.05, 0.1, 0.15, 0.2, 0.25, 0.3, 0.35, 0.4, 0.45, 0.5, 0.55, 0.6, 0.65, 0.7, 0.75, 0.8, 0.85, 0.9, 0.95, 1])) {
        http_response_code(500);
        exit();
    }

    $weights[$checkid] = $weight;
    mysqli_query($connection, 'UPDATE audits SET weights = "'.safe_string(json_encode($weights)).'" WHERE id = "'.$auditid.'"');
    print(json_encode($weights));
