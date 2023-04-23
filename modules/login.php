<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $users = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE email = "'.mysqli_real_escape_string($connection, $_POST['email']).'"'), MYSQLI_ASSOC);
        if (!empty($users)) {
            $user = $users[0];
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                header('location: /');
            } else {
                header('location: /login?error');
            }
        } else {
            header('location: /login?error');
        }
    } else {
        header('location: /');
    }