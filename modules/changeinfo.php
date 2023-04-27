<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (!isset($_POST['surname']) or !isset($_POST['name']) or !isset($_POST['fathername']) or !isset($_POST['position'])) {
        leave('/account');
    }

    $surname = trim($_POST['surname']);
    $name = trim($_POST['name']);
    $fathername = trim($_POST['fathername']);
    $position = trim($_POST['position']);
    $myid = +$_SESSION['user']['id'];

    if (empty($surname) or empty($name) or empty($fathername) or empty($position)) {
        leave('/account?errordata=empty');
    }

    mysqli_query($connection, 'UPDATE users SET name = "'.safe_string($name).'", surname = "'.safe_string($surname).'", fathername = "'.safe_string($fathername).'", position = "'.safe_string($position).'" WHERE id = "'.$myid.'"');

    $_SESSION['user'] = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE id = "'.$myid.'"'), MYSQLI_ASSOC)[0];

    leave('/account?successdata');