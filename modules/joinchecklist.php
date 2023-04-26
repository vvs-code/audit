<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(403);
        exit();
    }

    if (!isset($_POST['id']) or !isset($_POST['checklist'])) {
        http_response_code(500);
        exit();
    }

    $checkid = +$_POST['checklist'];
    $auditid = +$_POST['id'];
    $myid = +$_SESSION['user']['id'];

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users, participants FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        http_response_code(404);
        exit();
    }

    $audit = $audit[0];
    $audit['finished'] = +$audit['finished'];
    $participants = json_decode($audit['participants']);

    $checklist = $participants[$checkid];

    if ($audit['finished']) {
        http_response_code(403);
        exit();
    }

    if (!in_array($myid, $checklist)) {
        $checklist[] = $myid;
        $participants[$checkid] = $checklist;

        mysqli_query($connection, 'UPDATE audits SET participants = "'.safe_string(json_encode($participants)).'" WHERE id = "'.$auditid.'"');
    }