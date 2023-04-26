<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if (!isset($_GET['id']) or !isset($_GET['user'])) {
        leave();
    }

    $auditid = +$_GET['id'];
    $userid = +$_GET['user'];
    $myid = +$_SESSION['user']['id'];

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users, participants FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $users = json_decode($audit['users']);

    if ($audit['admin'] !== $myid) {
        leave();
    }

    $res = [];
    $edited = false;

    foreach ($users as $user) {
        if ($user !== $userid) {
            $res[] = $user;
        } else {
            $edited = true;
        }
    }

    if ($edited) {
        mysqli_query($connection, 'UPDATE audits SET users = "'.safe_string(json_encode($res)).'" WHERE id = "'.$auditid.'"');
    }

    leave('/modules/changecode?id='.$auditid);