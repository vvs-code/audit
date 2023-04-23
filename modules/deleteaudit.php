<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if (isset($_GET['id'])) {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC);
        if (!empty($audit)) {
            $audit = $audit[0];
            if (+$_SESSION['user']['id'] === +$audit['admin']) {
                mysqli_query($connection, 'UPDATE audits SET deleted = "1" WHERE id = "'.+$_GET['id'].'"');
            }
        }
    }

    header('location: /');