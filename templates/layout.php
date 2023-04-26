<!-- © vvs_code | vvscode.ru | vlad@veselov.spb.ru -->
<!doctype html>
<html lang="ru" dir="ltr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">

    <title><?=/** @var string $title */$title?></title>

    <meta name="theme-color" content="<?=isset($theme) ? $theme : '#f1f1f1'?>" />

    <link rel="shortcut icon" href="/favicon/audit.ico" type="image/x-icon">
<!--    <link rel="mask-icon" href="/audit.ico" color="#121212">-->

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100;0,400;0,700;1,100;1,400;1,700&family=Montserrat:ital,wght@0,500;0,700;1,700&family=Nunito+Sans:ital,wght@0,400;0,600;0,800;1,400;1,700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
<!--    <link rel="stylesheet" href="/styles/main.min.css?1">-->
        <link rel="stylesheet/less" href="/styles/main.less?2">
        <script src="/scripts/less.min.js"></script>

</head>
<body>

<style>
    .no-js,
    .ie {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        text-align: center;
        justify-content: center;
        align-items: center;
        background-color: #2a3f84;
        color: #fff;
        font-family: 'Open Sans', sans-serif;
        z-index: 999999999;
        line-height: 27px;
        font-size: 18px;
        font-weight: 400;
    }
    .no-js span,
    .ie span {
        width: 600px;
        max-width: 80%;
    }
</style>

<noscript>
    <style>
        body {
            overflow: hidden;
        }
    </style>
    <div class="no-js">
        <span>Пожалуйста, включите JavaScript в браузере.</span>
    </div>
</noscript>

<main class="main">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    ?>

    <?php
    if (isset($page) and isset($data)) {
        /** @var int $path_type */
        print(include_template($data, $page, $path_type));
    } elseif (isset($page)) {
        /** @var int $path_type */
        print(include_template([], $page, $path_type));
    }
    ?>
</main>

<div class="ie-message" hidden>
    <p>Вы используете устаревший браузер. Некоторые элементы сайта могут отображаться некорректно.</p>
    <button class="close" onclick="document.querySelector('.ie-message').hidden = true; localStorage['ie'] = 1">Закрыть</button>
</div>

<style>
    .ie-message {
        width: 400px;
        position: fixed;
        z-index: 2;
        bottom: 20px;
        right: 20px;
        font-size: 16px;
        background-color: #e8e8e8;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .4);
    }
    .ie-message button {
        background-color: #ccc;
        border: none;
        padding: 5px 15px;
        margin-top: 10px;
        cursor: pointer;
    }
    .ie-message button:hover {
        background-color: #bbb;
    }
    .ie-message button:active {
        background-color: #aaa;
    }
</style>

<script>
    if (document.documentMode && !+localStorage['ie']) {
        document.querySelector('.ie-message').hidden = false;
        localStorage['ie'] = 0;
    }
</script>

<!--<script src="/scripts/vue.min.js"></script>-->
<script src="/scripts/main.js"></script>

<?php /** @var array $scripts */
foreach ($scripts as $script): ?>
    <script src="<?=$script?>"></script>
<?php endforeach; ?>

</body>
</html>
