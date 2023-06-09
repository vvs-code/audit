<?php
    /** Импортируемые переменные */
    /** @var array $audit */
    /** @var int $auditid */
    /** @var string $errormessage */
    /** @var array $profile_to_full */
    /** @var array $profiles_list */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/audit?id=<?=$auditid?>" class="back"><?=$audit['title']?></a> ⇢ Редактировать аудит</span></div>
    </div>
</div>

<div class="top-placeholder"></div>

<div class="content">
    <div class="container in-app-form">
        <h1><a href="/audit?id=<?=$auditid?>" class="back">⇠</a> Редактировать аудит</h1>
        <form action="/modules/editaudit" method="POST">
            <span class="error">
                <?=$errormessage?>
            </span>
            <input type="hidden" name="id" value="<?=$auditid?>">
            <label>
                <span>Предприятие:</span>
                <input type="text" name="title" value="<?=safe_attribute($audit['title'])?>">
            </label>
            <div class="in-app-form__flex-dates">
                <label>
                    <span>Дата начала:</span>
                    <input type="date" name="datestart" value="<?=$audit['datestart']?>">
                </label>
                <label>
                    <span>Дата окончания:</span>
                    <input type="date" name="dateend" value="<?=$audit['dateend']?>">
                </label>
            </div>
            <label>
                <span>Профиль предприятия:</span>
                <select name="profile" class="inactive">

                    <?php foreach ($profiles_list as $profile): ?>

                        <option value="<?=$profile?>" <?= ($audit['profile'] === $profile ? 'selected' : '') ?>><?=$profile_to_full[$profile]?></option>

                    <?php endforeach; ?>

                </select>
                <p class="anno">Поменять профиль после создания аудита невозможно</p>
            </label>
            <label>
                <span>Корректирующий коэффициент:</span>
                <select name="coeff">
                    <option value="1.00" <?= ($audit['coeff'] === '1.00' ? 'selected' : '') ?>>1.00</option>
                    <option value="(1)0.90" <?= ($audit['coeff'] === '(1)0.90' ? 'selected' : '') ?>>(1) 0.90</option>
                    <option value="(2)0.90" <?= ($audit['coeff'] === '(2)0.90' ? 'selected' : '') ?>>(2) 0.90</option>
                    <option value="0.80" <?= ($audit['coeff'] === '0.80' ? 'selected' : '') ?>>0.80</option>
                </select>
                <p class="anno">1.00 — у обществ Группы ОСК отсутствуют претензии к поставщику по срокам и качеству</p>
                <p class="anno">(1) 0.90 — у обществ Группы ОСК имеются претензии к поставщику по срокам и качеству</p>
                <p class="anno">(2) 0.90 — до 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
                <p class="anno">0.80 — свыше 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
            </label>
            <button>Сохранить</button>
        </form>
    </div>
</div>