<?php
    if (!isset($_GET['id'])) {
        header('location: /');
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();
    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC)[0];
    $users = json_decode($audit['users']);

    if (+$_SESSION['user']['id'] !== +$audit['admin']) {
        header('location: /');
    }
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/" class="back">Аудиты</a> ⇢ Удалить аудит</span></div>
    </div>
</div>

<style>

    .top__title {
        height: 100%;
        display: flex;
        align-items: center;
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
    }

</style>

<div class="top-placeholder" style="height: 50px;"></div>

<div class="content">
    <div class="container" style="max-width: 500px;">
        <h1 style="display: flex; align-items: center;"><svg style="height: 1em; fill: #dc4a4a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg><span style="margin-left: 10px;">Удалить аудит</span></h1>
        <p style="margin-bottom: 15px;">Вы точно хотите удалить аудит предприятия <b><?=$audit['title']?> (<?=format_date_range($audit['datestart'], $audit['dateend'])?>)?</b></p>
        <div style="display: flex; align-items: center;">
            <a href="/" class="cancel-delete">Отменить</a>
            <a href="/modules/deleteaudit?id=<?=+$_GET['id']?>" class="confirm-delete">Удалить</a>
        </div>
    </div>
</div>