<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();
    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_POST['id'].'"'), MYSQLI_ASSOC)[0];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty(trim($_POST['title'])) and !empty($_POST['datestart']) and !empty($_POST['dateend']) and !empty($_POST['coeff'])) {
            if (+$audit['admin'] === +$_SESSION['user']['id']) {
                mysqli_query($connection, 'UPDATE audits SET title = "'.mysqli_real_escape_string($connection, trim($_POST['title'])).'", datestart = "'.mysqli_real_escape_string($connection, $_POST['datestart']).'", dateend = "'.mysqli_real_escape_string($connection, $_POST['dateend']).'", coeff = "'.mysqli_real_escape_string($connection, $_POST['coeff']).'" WHERE id = '.+$_POST['id']);
                header('location: /audit?id='.+$_POST['id']);
            } else {
                header('location: /editaudit?id='.+$_POST['id'].'&error=rights');
            }
        } else {
            header('location: /editaudit?id='.+$_POST['id'].'&error=empty');
        }
    } else {
        header('location: /');
    }