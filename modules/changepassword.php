<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';

    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (!isset($_POST['passwordold']) or !isset($_POST['password1']) or !isset($_POST['password2'])) {
        leave('/account');
    }

    $passwordold = trim($_POST['passwordold']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);
    $myid = +$_SESSION['user']['id'];

    if (empty($passwordold) or empty($password1) or empty($password2)) {
        leave('/account?errorpassword=empty');
    }

    $user = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE id = "'.$myid.'"'), MYSQLI_ASSOC);

    if (empty($user)) {
        leave();
    }

    $user = $user[0];

    if (!password_verify($passwordold, $user['password'])) {
        leave('/account?errorpassword=wrong');
    }

    if (mb_strlen($password1) < 8) {
        leave('/account?errorpassword=passwordlength');
    }

    if ($password1 !== $password2) {
        leave('/account?errorpassword=diff');
    }

    mysqli_query($connection, 'UPDATE users SET password = "'.safe_string(password_hash($password1, PASSWORD_DEFAULT)).'" WHERE id = "'.$myid.'"');

    $_SESSION['user'] = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE id = "'.$myid.'"'), MYSQLI_ASSOC)[0];

    leave('/account?successpassword');