<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();

    if (isset($_GET['id'])) {
        $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC);
        if (!empty($audit)) {
            $audit = $audit[0];
            if (+$_SESSION['user']['id'] === +$audit['admin']) {
                mysqli_query($connection, 'UPDATE audits SET finished = "'.(1 - $audit['finished']).'" WHERE id = "'.+$_GET['id'].'"');
            }
        }
    }

    header('location: /audit?id='.+$_GET['id']);