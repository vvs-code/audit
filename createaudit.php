<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    /** Импортируемые переменные */
    /** @var array $profile_to_full */
    /** @var array $profiles_list */

    if (!isset($_SESSION['user'])) {
        leave('/login');
    }

    print(include_template([
        'page' => 'createaudit.php',
        'title' => 'Создать аудит',
        'scripts' => [],
        'data' => [
            'profile_to_full' => $profile_to_full,
            'profiles_list' => $profiles_list
        ]
    ]));
