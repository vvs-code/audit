<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (!isset($_POST['code'])) {
        leave();
    }

    $code = trim($_POST['code']);
    $myid = +$_SESSION['user']['id'];

    if (empty($code)) {
        leave('/joinaudit?error=empty');
    }

    if (mb_strlen($code) !== 6) {
        leave('/joinaudit?error=format');
    }

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users FROM audits WHERE code = "'.safe_string($code).'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave('location: /joinaudit?error=notfound');
    }


    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $users = json_decode($audit['users']);

    $contains = in_array($myid, $users);

    if ($audit['admin'] === $myid) {
        $contains = true;
    }

    if (!$contains) {
        $users[] = $myid;
        mysqli_query($connection, 'UPDATE audits SET users = "'.safe_string(json_encode($users)).'" WHERE code = "'.safe_string($code).'"');
    }

    leave();
