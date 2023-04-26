<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if (!isset($_GET['id']) or !isset($_GET['checklist']) or !isset($_GET['user'])) {
        leave();
    }

    $auditid = +$_GET['id'];
    $checkid = +$_GET['checklist'];
    $userid = +$_GET['user'];
    $myid = +$_SESSION['user']['id'];

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users, participants FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $participants = json_decode($audit['participants']);

    $checklist = $participants[$checkid];

    if ($audit['admin'] !== $myid) {
        leave();
    }

    $res = [];
    $edited = false;

    foreach ($checklist as $user) {
        if ($user !== $userid) {
            $res[] = $user;
        } else {
            $edited = true;
        }
    }

    $participants[$checkid] = $res;

    if ($edited) {
        mysqli_query($connection, 'UPDATE audits SET participants = "'.mysqli_real_escape_string($connection, json_encode($participants)).'" WHERE id = "'.$auditid.'"');
    }

    leave('/auditors?id='.$auditid);
