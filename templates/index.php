<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();
    $audits = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE deleted = "0" ORDER BY id DESC'), MYSQLI_ASSOC);
    $myaudits = [];
    foreach ($audits as $audit) {
        $users = json_decode($audit['users']);
        $contains = false;
        foreach ($users as $user) {
            if ($user === +$_SESSION['user']['id']) {
                $contains = true;
            }
        }
        if (+$audit['admin'] === +$_SESSION['user']['id'] or $contains) {
            $myaudits[] = $audit;
        }
    }
?>
<div class="top">
    <div class="container">
        <div class="top__title">Аудиты</div>
        <div class="top__logout"><a href="/modules/logout">Выйти</a></div>
    </div>
</div>

<div class="top-placeholder" style="height: 50px;"></div>

<div class="content">
    <div class="container">
        <div class="audits">
            <h1>
                <span>Аудиты</span>
                <div style="display: flex; flex-wrap: wrap; align-items: center; padding: 3px 0;">
                    <a href="/createaudit" class="audits__create">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/></svg> Создать</a>
                    <a href="/joinaudit" class="audits__join">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/></svg> Присоединиться</a>
                </div>
            </h1>
            <?php if (!count($myaudits)): ?>
                <p style="width: 400px; max-width: 100%; text-align: center; margin: 0 auto; padding: 10px; font-style: italic; opacity: 0.7;">Аудитов пока нет, создайте новый или присоединитесь к существующему аудиту</p>
            <?php endif; ?>
            <?php foreach ($myaudits as $audit):

                $marks = json_decode($audit['marks']);
                $audit['checklists'] = json_decode($audit['checklists']);
                $audit['marks'] = json_decode($audit['marks']);
                $audit['weights'] = json_decode($audit['weights']);

                $resulted = 0;

                foreach ($audit['checklists'] as $i => $checklist) {
                    if ($audit['checklists']) {
                        $unedited = (count(array_filter($marks[$i], function($value) { return $value === -1;})));
                        if ($unedited === 0) {
                            $resulted++;
                        }
                    }
                }

                if (+$audit['finished']) {
                    $finals = get_final_for_checklist($audit);
                }

                ?>
                <div class="audit" style="background: linear-gradient(90deg, #f1f1f1, #f1f1f1, <?=(+$audit['finished'] ? ($finals['full'] ?'#09b534' : '#ffb500') : '#ab4eff')?>22);">
                    <div style="margin: 3px 0; display: flex; flex-direction: column;">
                        <span>
                            <a href="/audit?id=<?=$audit['id']?>" class="audit__title"><?=$audit['title']?></a>
                            <span class="audit__class">(<?=$audit['profile']?>)</span>
                        </span>
                        <span style="opacity: 0.5; white-space: nowrap; padding: 3px 0;"> <?=format_date_range($audit['datestart'], $audit['dateend'])?></span>
                    </div>
                    <div style="margin: 3px 0; display: flex; align-items: center; margin-left: auto;">
                        <div class="audit__status audit__status--<?=$audit['finished'] ? ($finals['full'] ? 'ready' : 'blocked') : 'in-progress'?>"><?=+$audit['finished'] ? ($finals['full'] ? 'Завершен' : 'Заблокирован') : 'Активен'?></div>
                        <?php if (+$audit['finished'] and !$finals['full']): ?>
                        <?php elseif (+$audit['finished']): ?>
                            <div class="audit__result"><b><?=$finals['final']?>&thinsp;(<?=$finals['class']?>)</b></div>
                        <?php else: ?>
                            <div class="audit__result">(<?=$resulted?>/<?=array_sum($audit['checklists'])?>)</div>
                        <?php endif; ?>
                        <?php if (+$audit['admin'] === +$_SESSION['user']['id']): ?>
                            <div class="audit__code" title="Код аудита"><?=$audit['code']?></div>
                        <?php endif; ?>
                        <a href="/pdfaudit/<?=$audit['code']?>" class="audit__pdf" title="Сформировать PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg></a>
                        <?php if (+$audit['admin'] === +$_SESSION['user']['id']): ?>
                            <a href="/confirmdelete?id=<?=$audit['id']?>" class="audit__delete" title="Удалить аудит">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg></a>
                        <?php else: ?>
                            <a href="/modules/leaveaudit?id=<?=$audit['id']?>" class="audit__leave" title="Покинуть аудит">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>