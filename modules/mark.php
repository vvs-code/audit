<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if (!isset($_SESSION['user']) or $_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(403);
        exit();
    }

    if (!isset($_POST['audit']) or !isset($_POST['mark']) or !isset($_POST['checklist']) or !isset($_POST['criteria'])) {
        http_response_code(500);
        exit();
    }

    $myid = +$_SESSION['user']['id'];
    $auditid = +$_POST['audit'];
    $mark = +$_POST['mark'];
    $checkid = +$_POST['checklist'];
    $critid = +$_POST['criteria'];

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        http_response_code(404);
        exit();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $audit['users'] = json_decode($audit['users']);
    $marks = json_decode($audit['marks']);

    if ($audit['admin'] !== $myid and !in_array($myid, $audit['users'])) {
        http_response_code(403);
        exit();
    }

    if (!in_array($mark, [-2, -1, 0, 0.25, 0.5, 0.75, 1])) {
        http_response_code(500);
        exit();
    }

    $marks[$checkid][$critid] = $mark;
    mysqli_query($connection, 'UPDATE audits SET marks = "'.safe_string(json_encode($marks)).'" WHERE id = "'.$auditid.'"');
