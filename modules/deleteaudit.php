<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    $auditid = +$_GET['id'];
    $myid = +$_SESSION['user']['id'];

    if (!isset($_GET['id'])) {
        leave();
    }

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];

    if ($myid !== $audit['admin']) {
        leave();
    }

    mysqli_query($connection, 'UPDATE audits SET deleted = "1" WHERE id = "'.$auditid.'"');

    leave();
