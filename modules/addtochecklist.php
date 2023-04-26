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

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users, participants FROM audits WHERE id = "'.$auditid.'"'), MYSQLI_ASSOC);

    if (empty($audit)) {
        leave();
    }

    $audit = $audit[0];
    $audit['admin'] = +$audit['admin'];
    $participants = json_decode($audit['participants']);


    if ($audit['admin'] !== $myid) {
        leave();
    }

    $checklist = $participants[$checkid];

    if (in_array($userid, $checklist)) {
        leave('/auditors?id='.$auditid);
    }

    $participants[$checkid][] = $userid;

    mysqli_query($connection, 'UPDATE audits SET participants = "'.safe_string(json_encode($participants)).'" WHERE id = "'.$auditid.'"');

    leave('/auditors?id='.+$_GET['id']);
