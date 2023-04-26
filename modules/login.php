<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (!isset($_POST['email']) or !isset($_POST['password'])) {
        leave();
    }

    $email = trim(mb_strtolower($_POST['email']));
    $password = $_POST['password'];

    $users = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE email = "'.safe_string($email).'"'), MYSQLI_ASSOC);

    if (empty($users)) {
        leave('/login?error');
    }

    $user = $users[0];

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        leave();
    } else {
        leave('/login?error');
    }
