<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    $connection = get_connection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        leave();
    }

    if (empty(trim($_POST['email'])) or empty(trim($_POST['name'])) or empty(trim($_POST['surname'])) or empty(trim($_POST['fathername'])) or empty($_POST['password']) or empty($_POST['password2'])) {
        leave('/reg?error=empty');
    }

    $email = mb_strtolower(trim($_POST['email']));
    $surname = trim($_POST['surname']);
    $name = trim($_POST['name']);
    $fathername = trim($_POST['fathername']);
    $position = trim($_POST['position']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        leave('/reg?error=email');
    }

    if (mb_strlen($password) < 8) {
        leave('/reg?error=passwordlength');
    }

    if ($password !== $password2) {
        leave('/reg?error=password2');
    }

    $account = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE email = "'.safe_string($email).'"'), MYSQLI_ASSOC);

    if (!empty($account)) {
        leave('/reg?error=exist');
    }

    mysqli_query($connection, 'INSERT INTO users SET email = "'.safe_string($email).'", `name` = "'.safe_string($name).'", `surname` = "'.safe_string($surname).'", `fathername` = "'.safe_string($fathername).'", `position` = "'.safe_string($position).'", `password` = "'.safe_string(password_hash($password, PASSWORD_DEFAULT)).'"');

    leave('/login');
