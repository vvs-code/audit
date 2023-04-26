<?php
    /** Импортируемые переменные */
    /** @var array $audit */
    /** @var array $checklist_color */
    /** @var array $criteria_titles */
    /** @var int $auditid */
    /** @var int $checkid */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/audit?id=<?=$auditid?>" class="back"><?=$audit['title']?></a> ⇢ Редактировать чек-лист</span></div>
    </div>
</div>

<style>

    .top {
        background-color: <?=$checklist_color[$checkid][0]?> !important;
    }

    .top__title {
        height: 100%;
        display: flex;
        align-items: center;
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
    }

    .confirm-edit {
        color: #fff;
        background-color: <?=$checklist_color[$checkid][2]?>;
    }

    .confirm-edit:hover {
        background-color: <?=$checklist_color[$checkid][3]?>;
    }


</style>

<div class="top-placeholder" style="height: 50px;"></div>

<div class="content">
    <div class="container" style="max-width: 500px;">
        <h1 style="display: flex; align-items: center;"><svg style="height: 1em" fill="<?=$checklist_color[$checkid][2]?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg><span style="margin-left: 10px;">Редактировать <span style="white-space: nowrap">чек-лист</span></span></h1>
        <p style="margin-bottom: 15px;">Вы точно хотите изменить заполненный чек-лист <b>(<?=$checkid?>)&nbsp;<?=$criteria_titles[$checkid]?>?</b></p>
        <div style="display: flex; align-items: center;">
            <a href="/audit?id=<?=$auditid?>" class="cancel-edit">Отменить</a>
            <a href="/checklist?audit=<?=$auditid?>&id=<?=$checkid?>" class="confirm-edit">Редактировать</a>
        </div>
    </div>
</div>