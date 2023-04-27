<?php
    /** Импортируемые переменные */
    /** @var array $profile_to_full */
    /** @var array $profiles_list */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/" class="back">Аудиты</a> ⇢ Создать аудит</span></div>
    </div>
</div>

<div class="top-placeholder"></div>

<div class="content">
    <div class="container in-app-form">
        <h1><a href="/" class="back">⇠</a> Создать аудит</h1>
        <form action="/modules/createaudit" method="POST">
            <span class="error">
                <?=isset($_GET['error']) ? 'Не все поля заполнены' : ''?>
            </span>
            <label>
                <span>Предприятие:</span>
                <input type="text" name="title">
            </label>
            <div class="in-app-form__flex-dates">
                <label>
                    <span>Дата начала:</span>
                    <input type="date" name="datestart">
                </label>
                <label>
                    <span>Дата окончания:</span>
                    <input type="date" name="dateend">
                </label>
            </div>
            <label>
                <span>Профиль предприятия:</span>
                <select name="profile" onchange="(document.querySelector('.checklist-multiple-choose').hidden = document.querySelector('[name=profile]').value !== 'Др')">

                    <?php foreach ($profiles_list as $profile): ?>

                        <option value="<?=$profile?>"><?=$profile_to_full[$profile]?></option>

                    <?php endforeach; ?>

                </select>
            </label>
            <div class="checklist-multiple-choose" hidden>
                <span>Чек-листы:</span>
                <div class="checklist-multiple-choose__line">
                    <label>
                        <input type="checkbox" name="checklist0">
                        <span>0</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist1">
                        <span>1</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist2">
                        <span>2</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist3">
                        <span>3</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist4">
                        <span>4</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist5">
                        <span>5</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist6">
                        <span>6</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist7">
                        <span>7</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist8">
                        <span>8</span>
                    </label>
                    <label>
                        <input type="checkbox" name="checklist9">
                        <span>9</span>
                    </label>
                </div>
                <p class="anno red">Укажите веса чек-листов на странице созданного аудита!</p>
            </div>
            <label>
                <span>Корректирующий коэффициент:</span>
                <select name="coeff">
                    <option value="1.00">1.00</option>
                    <option value="(1)0.90">(1) 0.90</option>
                    <option value="(2)0.90">(2) 0.90</option>
                    <option value="0.80">0.80</option>
                </select>
                <p class="anno">1.00 — у обществ Группы ОСК отсутствуют претензии к поставщику по срокам и качеству</p>
                <p class="anno">(1) 0.90 — у обществ Группы ОСК имеются претензии к поставщику по срокам и качеству</p>
                <p class="anno">(2) 0.90 — до 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
                <p class="anno">0.80 — свыше 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
            </label>
            <button>Создать</button>
        </form>
    </div>
</div>