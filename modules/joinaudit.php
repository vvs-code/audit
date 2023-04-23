<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty(trim($_POST['code']))) {
            if (mb_strlen(trim($_POST['code'])) === 6) {
                $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT id, admin, users FROM audits WHERE code = "'.mysqli_real_escape_string($connection, trim($_POST['code'])).'"'), MYSQLI_ASSOC);
                if (!empty($audit)) {
                    $audit = $audit[0];
                    $users = json_decode($audit['users']);
                    $contains = in_array(+$_SESSION['user']['id'], $users);
                    if (+$audit['admin'] === +$_SESSION['user']['id']) {
                        $contains = true;
                    }
                    if (!$contains) {
                        $users[] = +$_SESSION['user']['id'];
                        mysqli_query($connection, 'UPDATE audits SET users = "'.mysqli_real_escape_string($connection, json_encode($users)).'" WHERE code = "'.mysqli_real_escape_string($connection, trim($_POST['code'])).'"');
                    }
                    header('location: /');
                } else {
                    header('location: /joinaudit?error=notfound');
                }
            } else {
                header('location: /joinaudit?error=format');
            }
        } else {
            header('location: /joinaudit?error=empty');
        }
    } else {
        header('location: /');
    }