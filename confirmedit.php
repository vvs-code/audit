<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

    if (!isset($_SESSION['user'])) {
        header('location: /');
    }

    $checklist_color = [
        0 => ['#bffbff', '#ace3e7', '#68d2da', '#62c6ce', '#c4e2e5'],
        1 => ['#e4e4e4', '#d3d3d3', '#555555', '#333333', '#cccccc'],
        2 => ['#ffb257', '#ffa030', '#ff9e2c', '#f88c0c', '#ffdaae'],
        3 => ['#d6e9f9', '#bcd7ee', '#65a9e4', '#5091ca', '#c4e0f8'],
        4 => ['#efe0ba', '#dfc995', '#b6a477', '#988963', '#e5d09d'],
        5 => ['#d3ffb3', '#b7e296', '#90cf61', '#84bf57', '#ccf1b0'],
        6 => ['#ff9770', '#ff8051', '#ff723d', '#e15d2b', '#ffb79c'],
        7 => ['#efc4ef', '#eb94eb', '#dc71dc', '#c558c5', '#f9c8f9'],
        8 => ['#fff68e', '#ffe667', '#f4cd00', '#e2c00b', '#ffee97'],
        9 => ['#b5b4e5', '#979cd7', '#6e6cd7', '#5d5bce', '#c8c7f2']
    ];

    print(include_template([
        'page' => 'confirmedit.php',
        'title' => 'Подтвердить редактирование',
        'scripts' => [],
        'data' => [],
        'theme' => $checklist_color[+$_GET['id']][0]
    ]));
