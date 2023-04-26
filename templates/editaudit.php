<?php
    /** Импортируемые переменные */
    /** @var array $audit */
    /** @var int $auditid */
    /** @var string $errormessage */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/audit?id=<?=$auditid?>" class="back"><?=$audit['title']?></a> ⇢ Редактировать аудит</span></div>
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
        <h1><a href="/audit?id=<?=$auditid?>" class="back">⇠</a> Редактировать аудит</h1>
        <form action="/modules/editaudit" method="POST">
            <span class="error">
                <?=$errormessage?>
            </span>
            <input type="hidden" name="id" value="<?=$auditid?>">
            <label>
                <span>Предприятие:</span>
                <input type="text" name="title" value="<?=implode('&quot;', explode('"', $audit['title']))?>">
            </label>
            <div style="display: flex; width: 100%;">
                <label style="width: 100%; margin-right: 5px;">
                    <span>Дата начала:</span>
                    <input type="date" name="datestart" value="<?=$audit['datestart']?>">
                </label>
                <label style="width: 100%; margin-left: 5px;">
                    <span>Дата окончания:</span>
                    <input type="date" name="dateend" value="<?=$audit['dateend']?>">
                </label>
            </div>
            <label>
                <span>Профиль предприятия:</span>
                <select name="profile" disabled style="opacity: 0.4; pointer-events: none">
                    <option value="РИ" <?= ($audit['profile'] === 'РИ' ? 'selected' : '') ?>>Разработчик-изготовитель</option>
                    <option value="Р" <?= ($audit['profile'] === 'Р' ? 'selected' : '') ?>>Разработчик</option>
                    <option value="И" <?= ($audit['profile'] === 'И' ? 'selected' : '') ?>>Изготовитель</option>
                    <option value="У" <?= ($audit['profile'] === 'У' ? 'selected' : '') ?>>Услуги</option>
                    <option value="Д" <?= ($audit['profile'] === 'Д' ? 'selected' : '') ?>>Дилер</option>
                    <option value="Др" <?= ($audit['profile'] === 'Др' ? 'selected' : '') ?>>Другое</option>
                </select>
                <p style="font-size: 11px;">Поменять профиль после создания аудита невозможно</p>
            </label>
            <label>
                <span>Корректирующий коэффициент:</span>
                <select name="coeff">
                    <option value="1.00" <?= ($audit['coeff'] === '1.00' ? 'selected' : '') ?>>1.00</option>
                    <option value="(1)0.90" <?= ($audit['coeff'] === '(1)0.90' ? 'selected' : '') ?>>(1) 0.90</option>
                    <option value="(2)0.90" <?= ($audit['coeff'] === '(2)0.90' ? 'selected' : '') ?>>(2) 0.90</option>
                    <option value="0.80" <?= ($audit['coeff'] === '0.80' ? 'selected' : '') ?>>0.80</option>
                </select>
                <p style="font-size: 11px;">1.00 — у обществ Группы ОСК отсутствуют претензии к поставщику по срокам и качеству</p>
                <p style="font-size: 11px;">(1) 0.90 — у обществ Группы ОСК имеются претензии к поставщику по срокам и качеству</p>
                <p style="font-size: 11px;">(2) 0.90 — до 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
                <p style="font-size: 11px;">0.80 — свыше 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
            </label>
            <button>Сохранить</button>
        </form>
    </div>
</div>