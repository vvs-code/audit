<div class="top">
    <div class="container">
        <div class="top__title"><a href="/" class="back">Аудиты</a> ⇢ Создать аудит</div>
    </div>
</div>

<div class="top-placeholder" style="height: 50px;"></div>

<div class="content">
    <div class="container" style="max-width: 500px;">
        <h1><a href="/" class="back">⇠</a> Создать аудит</h1>
        <form action="/modules/createaudit" method="POST">
            <span class="error">
                <?php
                if (isset($_GET['error'])) {
                    print('Не все поля заполнены');
                }
                ?>
            </span>
            <label>
                <span>Предприятие:</span>
                <input type="text" name="title">
            </label>
            <div style="display: flex; width: 100%;">
                <label style="width: 100%; margin-right: 5px;">
                    <span>Дата начала:</span>
                    <input type="date" name="datestart">
                </label>
                <label style="width: 100%; margin-left: 5px;">
                    <span>Дата окончания:</span>
                    <input type="date" name="dateend">
                </label>
            </div>
            <label>
                <span>Профиль предприятия:</span>
                <select name="profile" onchange="(document.querySelector('.checklist-multiple-choose').hidden = document.querySelector('[name=profile]').value !== 'Др')">
                    <option value="РИ">Разработчик-изготовитель</option>
                    <option value="Р">Разработчик</option>
                    <option value="И">Изготовитель</option>
                    <option value="У">Услуги</option>
                    <option value="Д">Дилер</option>
                    <option value="Др">Другое</option>
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
                <p style="font-size: 12px; color: red;">Укажите веса чек-листов на странице созданного аудита!</p>
            </div>
            <label>
                <span>Весовой коэффициент:</span>
                <select name="coeff">
                    <option value="1.00">1.00</option>
                    <option value="(1)0.90">(1) 0.90</option>
                    <option value="(2)0.90">(2) 0.90</option>
                    <option value="0.80">0.80</option>
                </select>
                <p style="font-size: 11px;">1.00 — у обществ Группы ОСК отсутствуют претензии к поставщику по срокам и качеству</p>
                <p style="font-size: 11px;">(1) 0.90 — у обществ Группы ОСК имеются претензии к поставщику по срокам и качеству</p>
                <p style="font-size: 11px;">(2) 0.90 — до 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
                <p style="font-size: 11px;">0.80 — свыше 3 рекламаций от обществ Группы ОСК в течение предыдущих 12 месяцев</p>
            </label>
            <button>Создать</button>
        </form>
    </div>
</div>