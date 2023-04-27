<?php
    /** Импортируемые переменные */
    /** @var array $audit */
    /** @var int $auditid */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/" class="back">Аудиты</a> ⇢ Удалить аудит</span></div>
    </div>
</div>

<div class="top-placeholder"></div>

<div class="content">
    <div class="container in-app-form">
        <h1 class="flexed"><svg fill="#dc4a4a" class="title-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg><span>Удалить аудит</span></h1>
        <p class="bottom-margin">Вы точно хотите удалить аудит предприятия <b><?=$audit['title']?> (<?=format_date_range($audit['datestart'], $audit['dateend'])?>)?</b></p>
        <div class="in-app-form__flex-buttons">
            <a href="/" class="cancel-delete">Отменить</a>
            <a href="/modules/deleteaudit?id=<?=$auditid?>" class="confirm-delete">Удалить</a>
        </div>
    </div>
</div>