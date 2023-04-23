<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['email']) and !empty(trim($_POST['name'])) and !empty(trim($_POST['surname'])) and !empty(trim($_POST['fathername'])) and !empty($_POST['password']) and !empty($_POST['password2'])) {
            if (filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
                if (mb_strlen($_POST['password']) >= 8) {
                    if ($_POST['password'] === $_POST['password2']) {
                        mysqli_query($connection, 'INSERT INTO users SET email = "'.mysqli_real_escape_string($connection, trim($_POST['email'])).'", `name` = "'.mysqli_real_escape_string($connection, trim($_POST['name'])).'", surname = "'.mysqli_real_escape_string($connection, trim($_POST['surname'])).'", fathername = "'.mysqli_real_escape_string($connection, trim($_POST['fathername'])).'", password = "'.mysqli_real_escape_string($connection, password_hash($_POST['password'], PASSWORD_DEFAULT)).'", secret = "'.generate_random_string().'"');
                        header('location: /login');
                    } else {
                        header('location: /reg?error=password2');
                    }
                } else {
                    header('location: /reg?error=passwordlength');
                }
            } else {
                header('location: /reg?error=email');
            }
        } else {
            header('location: /reg?error=empty');
        }
    } else {
        header('location: /');
    }