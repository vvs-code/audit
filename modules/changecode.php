<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if (isset($_GET['id'])) {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC);
        if (!empty($audit)) {
            $audit = $audit[0];

            if (+$audit['admin'] === +$_SESSION['user']['id']) {
                mysqli_query($connection, 'UPDATE audits SET code = "'.generate_random_code().'" WHERE id = "'.+$_GET['id'].'"');
            }
        }
    }

    header('location: /auditors?id='.+$_GET['id']);