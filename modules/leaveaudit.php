<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if (!isset($_GET['id'])) {
        leave();
    }

    $auditid = +$_GET['id'];
    $myid = +$_SESSION['user']['id'];

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $users = json_decode($audit['users']);

    $res = [];
    $edited = false;

    foreach ($users as $user) {
        if ($user !== +$_SESSION['user']['id']) {
            $res[] = $user;
        } else {
            $edited = true;
        }
    }

    if ($edited) {
        mysqli_query($connection, 'UPDATE audits SET users = "'.safe_string(json_encode($res)).'" WHERE id = "'.$auditid.'"');
    }

    leave();
