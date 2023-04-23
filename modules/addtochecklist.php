<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if (isset($_GET['id']) and isset($_GET['checklist']) and isset($_GET['user'])) {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users, participants FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC);
        if (!empty($audit) and +$audit[0]['admin'] === +$_SESSION['user']['id']) {
            $audit = $audit[0];
            $participants = json_decode($audit['participants']);
            $checklist = $participants[+$_GET['checklist']];
            if (!in_array($checklist, +$_GET['user'])) {
                $participants[+$_GET['checklist']][] = +$_GET['user'];
                mysqli_query($connection, 'UPDATE audits SET participants = "'.mysqli_real_escape_string($connection, json_encode($participants)).'" WHERE id = "'.+$_GET['id'].'"');
            }
        }
    }

    header('location: /auditors?id='.+$_GET['id']);