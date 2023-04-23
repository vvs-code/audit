<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['id']) and isset($_POST['checklist'])) {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users, participants FROM audits WHERE id = "'.+$_POST['id'].'"'), MYSQLI_ASSOC);
        if (!empty($audit) and !+$audit['finished']) {
            $audit = $audit[0];
            $participants = json_decode($audit['participants']);
            $checklist = $participants[+$_POST['checklist']];
            $res = [];
            $edited = false;
            foreach ($checklist as $user) {
                if ($user !== +$_SESSION['user']['id']) {
                    $res[] = $user;
                } else {
                    $edited = true;
                }
            }
            $participants[+$_POST['checklist']] = $res;
            if ($edited) {
                mysqli_query($connection, 'UPDATE audits SET participants = "'.mysqli_real_escape_string($connection, json_encode($participants)).'" WHERE id = "'.+$_POST['id'].'"');
            }
        }
    }
