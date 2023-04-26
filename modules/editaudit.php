<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    $auditid = +$_POST['id'];
    $myid = +$_SESSION['user']['id'];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (empty(trim($_POST['title'])) or empty($_POST['datestart']) or empty($_POST['dateend']) or empty($_POST['coeff'])) {
        leave('/editaudit?id='.$auditid.'&error=empty');
    }

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];

    if ($audit['admin'] !== $myid) {
        leave();
    }

    mysqli_query($connection, 'UPDATE audits SET title = "'.safe_string(trim($_POST['title'])).'", datestart = "'.safe_string($_POST['datestart']).'", dateend = "'.safe_string($_POST['dateend']).'", coeff = "'.safe_string($_POST['coeff']).'" WHERE id = '.$auditid);

    leave('/audit?id='.$auditid);
