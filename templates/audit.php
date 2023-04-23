<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();
    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC)[0];
    $audit['participants'] = json_decode($audit['participants']);
    $audit['marks'] = json_decode($audit['marks']);
    $audit['checklists'] = json_decode($audit['checklists']);
    $audit['weights'] = json_decode($audit['weights']);
    $audit['started'] = json_decode($audit['started']);
    $users = json_decode($audit['users']);

    if (!in_array(+$_SESSION['user']['id'], $users) and +$_SESSION['user']['id'] !== +$audit['admin']) {
        header('location: /');
    }

    $sumfinal = 0;
    $fullchecklists = 0;
?>



<div class="top">
    <div class="container">
        <div class="top__title"><span style="white-space: nowrap"><a href="/" class="back">Аудиты</a> ⇢ <?=$audit['title']?></span></div>
    </div>
</div>

<style>

    .top__title {
        height: 100%;
        display: flex;
        align-items: center;
        overflow-x: scroll;
        overflow-y: hidden;
    }

</style>

<div class="top-placeholder" style="height: 50px;"></div>

<script>
    let auditid = <?=$audit['id']?>;
</script>

<div class="content">
    <div class="container">
        <div class="auditpage">
            <h1>
                <span><a href="/" class="back">⇠</a> <?=$audit['title']?> <span class="auditpage__factorycoeff"><?=$audit['coeff']?></span></span>
                <div style="display: flex; flex-wrap: wrap; align-items: center; padding: 3px 0;">
                    <a href="/pdfaudit/<?=$audit['code']?>" class="auditpage__pdf">
                        <svg fill="#4747f1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg> Сформировать&nbsp;PDF</a>
                    <?php if (+$audit['admin'] === +$_SESSION['user']['id']): ?>
                        <a href="/auditors?id=<?=$audit['id']?>" class="auditpage__pdf"><svg fill="#ea0000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 1 224 0a128 128 0 1 1 0 256zM209.1 359.2l-18.6-31c-6.4-10.7 1.3-24.2 13.7-24.2H224h19.7c12.4 0 20.1 13.6 13.7 24.2l-18.6 31 33.4 123.9 36-146.9c2-8.1 9.8-13.4 17.9-11.3c70.1 17.6 121.9 81 121.9 156.4c0 17-13.8 30.7-30.7 30.7H285.5c-2.1 0-4-.4-5.8-1.1l.3 1.1H168l.3-1.1c-1.8 .7-3.8 1.1-5.8 1.1H30.7C13.8 512 0 498.2 0 481.3c0-75.5 51.9-138.9 121.9-156.4c8.1-2 15.9 3.3 17.9 11.3l36 146.9 33.4-123.9z"/></svg> Аудиторы</a>
                        <a href="/editaudit?id=<?=$audit['id']?>" class="auditpage__edit"><svg fill="#b15bfd" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg> Редактировать</a>
                        <?php if (!+$audit['finished']): ?>
                            <a href="/modules/releaseaudit?id=<?=$audit['id']?>" class="auditpage__release auditpage__release--not-released auditpage__release--finish"><svg fill="#209620" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> Завершить</a>
                            <a href="/modules/releaseaudit?id=<?=$audit['id']?>" class="auditpage__release auditpage__release--not-released auditpage__release--block"><svg fill="#ffad33" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"></path></svg> Заблокировать</a>
                        <?php else: ?>
                            <a href="/modules/releaseaudit?id=<?=$audit['id']?>" class="auditpage__release auditpage__release--released auditpage__release--finished"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> Завершен</a>
                            <a href="/modules/releaseaudit?id=<?=$audit['id']?>" class="auditpage__release auditpage__release--not-released auditpage__release--blocked"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"></path></svg> Заблокирован</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </h1>
            <div class="error-checklist-sum" <?=(round(array_sum($audit['weights']), 2) == 1) ? 'hidden' : ''?>>
                Сумма весовых коэффициентов чек-листов не равна 1.00!
            </div>
            <?php for ($i = 0; $i <= 9; $i++): ?>
                <?php if ($audit['checklists'][$i]):

                        $marks = $audit['marks'];

                        $unedited = (count(array_filter($marks[$i], function ($value) {
                            return $value === -1;
                        })));
                        $edited = (count(array_filter($marks[$i], function ($value) {
                            return $value !== -1;
                        })));

                        $fullchecklists += $unedited === 0 ? 1 : 0;

                        $finals = get_final_for_checklist($audit);
                    ?>
                    <div class="checklist" style="background: linear-gradient(160deg, <?=$checklist_color[$i][4]?>88 15%, #f1f1f1 50%, <?=($unedited === 0 ? '#09b534' : (!$audit['started'][$i] ? '#ff5858' : '#ab4eff'))?>22 85%);">
                        <div style="margin: 3px 0; display: flex;">
                            <div class="checklist__number monospace">(<?=$i?>)</div>
                            <a <?= +$audit['finished'] ? '' : ($unedited === 0 ? 'href="/confirmedit?audit='.$audit['id'].'&id='.$i.'"' : 'href="/checklist?audit='.$audit['id'].'&id='.$i.'"') ?> class="checklist__title <?= +$audit['finished'] ? 'checklist__title--finished' : '' ?>"><?=$criteria_titles[$i]?>
                                <?php if (+$audit['finished']): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div style="margin: 3px 0; display: flex; align-items: center; margin-left: auto;">
                            <?php if ($unedited === 0): ?>
                                <div class="checklist__status checklist__status--ready">Заполнен</div>
                                <div class="checklist__result--final"><?=$finals['checklists'][$i] < 10 ? '&nbsp;' : ''?>(<?=number_format((float)$finals['checklists'][$i], 2, ',', '')?>)</div>
                            <?php elseif (!$audit['started'][$i]): ?>
                                <div class="checklist__status checklist__status--created">Создан</div>
                                <div class="checklist__result"><?=$edited < 10 ? '&nbsp;' : ''?>(<?=$edited?>/<?=$criteria_numbers[$i]?>)</div>
                            <?php else: ?>
                                <div class="checklist__status checklist__status--in-progress">В работе</div>
                                <div class="checklist__result"><?=$edited < 10 ? '&nbsp;' : ''?>(<?=$edited?>/<?=$criteria_numbers[$i]?>)</div>
                            <?php endif; ?>

        <!--                <div class="checklist__weight" title="Вес чек-листа">0.05</div>-->

                            <!--<input class="checklist__weight" type="number" title="Вес чек-листа" value="<?=$audit['weights'][$i]?>" step="0.05" disabled>-->
                            <select class="checklist__weight" title="Вес чек-листа" name="checklistweight" data-checklist="<?=$i?>" <?=(+$audit['admin'] !== +$_SESSION['user']['id'] or $audit['profile'] !== 'Др') ? 'disabled' : ''?>>
                                <option value="0.05" <?=$audit['weights'][$i] === 0.05 ? 'selected' : ''?>>0,05</option>
                                <option value="0.1" <?=$audit['weights'][$i] === 0.1 ? 'selected' : ''?>>0,10</option>
                                <option value="0.15" <?=$audit['weights'][$i] === 0.15 ? 'selected' : ''?>>0,15</option>
                                <option value="0.2" <?=$audit['weights'][$i] === 0.2 ? 'selected' : ''?>>0,20</option>
                                <option value="0.25" <?=$audit['weights'][$i] === 0.25 ? 'selected' : ''?>>0,25</option>
                                <option value="0.3" <?=$audit['weights'][$i] === 0.3 ? 'selected' : ''?>>0,30</option>
                                <option value="0.35" <?=$audit['weights'][$i] === 0.35 ? 'selected' : ''?>>0,35</option>
                                <option value="0.4" <?=$audit['weights'][$i] === 0.4 ? 'selected' : ''?>>0,40</option>
                                <option value="0.45" <?=$audit['weights'][$i] === 0.45 ? 'selected' : ''?>>0,45</option>
                                <option value="0.5" <?=$audit['weights'][$i] === 0.5 ? 'selected' : ''?>>0,50</option>
                                <option value="0.55" <?=$audit['weights'][$i] === 0.55 ? 'selected' : ''?>>0,55</option>
                                <option value="0.6" <?=$audit['weights'][$i] === 0.6 ? 'selected' : ''?>>0,60</option>
                                <option value="0.65" <?=$audit['weights'][$i] === 0.65 ? 'selected' : ''?>>0,65</option>
                                <option value="0.7" <?=$audit['weights'][$i] === 0.7 ? 'selected' : ''?>>0,70</option>
                                <option value="0.75" <?=$audit['weights'][$i] === 0.75 ? 'selected' : ''?>>0,75</option>
                                <option value="0.8" <?=$audit['weights'][$i] === 0.8 ? 'selected' : ''?>>0,80</option>
                                <option value="0.85" <?=$audit['weights'][$i] === 0.85 ? 'selected' : ''?>>0,85</option>
                                <option value="0.9" <?=$audit['weights'][$i] === 0.9 ? 'selected' : ''?>>0,90</option>
                                <option value="0.95" <?=$audit['weights'][$i] === 0.95 ? 'selected' : ''?>>0,95</option>
                                <option value="1" <?=$audit['weights'][$i] === 1 ? 'selected' : ''?>>1,00</option>
                            </select>
                            <a href="/pdfchecklist/<?=$i.'-'.$audit['code']?>" class="checklist__pdf" title="Сформировать PDF">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg></a>
                            <?php if (!+$audit['finished']): ?>
                                <span class="checklist__add" title="Добавиться к чек-листу" data-join="<?=$i?>" <?=in_array(+$_SESSION['user']['id'], $audit['participants'][$i]) ? 'hidden' : ''?>>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></span>
                                <span class="checklist__added" title="Покинуть чек-лист" data-leave="<?=$i?>" <?=in_array(+$_SESSION['user']['id'], $audit['participants'][$i]) ? '' : 'hidden'?>>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM625 177L497 305c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L591 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php endif; endfor;

                if (+$audit['finished'] and $fullchecklists === array_sum($audit['checklists'])): ?>
                <div class="auditpage__result">
                    Итоговая оценка: <?=$finals['final']?>&thinsp;(<?=$finals['class']?>)
                </div>
            <?php endif; ?>
            <?php if ($fullchecklists === array_sum($audit['checklists'])): ?>
                <style>
                    .auditpage__release--block,
                    .auditpage__release--blocked {
                        display: none !important;
                    }
                </style>
            <?php else: ?>
                <style>
                    .auditpage__release--finish,
                    .auditpage__release--finished {
                        display: none !important;
                    }
                </style>
            <?php endif; ?>
            <?php if (false): ?>
            <div class="checklist">
                <div class="checklist__number monospace">(2)</div>
                <a href="/checklist" class="checklist__title">Производственная система</a>
                <div class="checklist__status checklist__status--created">Создан</div>
                <div class="checklist__result">(0/50)</div>
<!--                <div class="checklist__weight" title="Вес чек-листа">0.10</div>-->
                <input class="checklist__weight" type="number" title="Вес чек-листа" value="0.10" step="0.05" disabled>

                <a class="checklist__pdf" title="Сформировать PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg></a>
                <a class="checklist__add" title="Добавиться к чек-листу">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></a>
            </div>
            <div class="checklist">
                <div class="checklist__number monospace">(3)</div>
                <a href="/checklist" class="checklist__title">Разработка и постановка на производство</a>
                <div class="checklist__status checklist__status--in-progress">В работе</div>
                <div class="checklist__result">(9/16)</div>
<!--                <div class="checklist__weight" title="Вес чек-листа">0.55</div>-->
                <input class="checklist__weight" type="number" title="Вес чек-листа" value="0.55" step="0.05">
                <a class="checklist__pdf" title="Сформировать PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg></a>
                <a class="checklist__add" title="Добавиться к чек-листу">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></a>
            </div>
            <div class="checklist">
                <div class="checklist__number monospace">(5)</div>
                <a href="/checklist" class="checklist__title">СМК</a>
                <div class="checklist__status checklist__status--ready">Завершен</div>
                <div class="checklist__result">(30/30) => <b>0.16/0.20</b></div>
<!--                <div class="checklist__weight" title="Вес чек-листа">0.20</div>-->
                <input class="checklist__weight" type="number" title="Вес чек-листа" value="0.20" step="0.05">
                <a class="checklist__pdf" title="Сформировать PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg></a>
                <a class="checklist__added" title="Покинуть чек-лист">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM625 177L497 305c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L591 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></a>
            </div>
            <div class="checklist">
                <div class="checklist__number monospace">(7)</div>
                <a href="/checklist" class="checklist__title">Управление персоналом</a>
                <div class="checklist__status checklist__status--ready">Завершен</div>
                <div class="checklist__result">(15/15) => <b>0.07/0.10</b></div>
<!--                <div class="checklist__weight" title="Вес чек-листа">0.10</div>-->
                <input class="checklist__weight" type="number" title="Вес чек-листа" value="0.10" step="0.05">
                <a class="checklist__pdf" title="Сформировать PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H296 272 184 160c-35.3 0-64 28.7-64 64v80 48 16H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM160 352h24c30.9 0 56 25.1 56 56s-25.1 56-56 56h-8v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm24 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8v48h8zm88-80h24c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H272c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm24 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16h-8v96h8zm72-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H400v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg></a>
                <a class="checklist__add" title="Добавиться к чек-листу">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>