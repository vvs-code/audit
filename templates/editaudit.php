<?php
    if (!isset($_GET['id'])) {
        header('location: /');
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    $connection = get_connection();
    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE id = "'.+$_GET['id'].'"'), MYSQLI_ASSOC)[0];
    $users = json_decode($audit['users']);
    if (!in_array(+$_SESSION['user']['id'], $users) and +$_SESSION['user']['id'] !== +$audit['admin']) {
        header('location: /');
    }
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/audit?id=<?=+$_GET['id']?>" class="back"><?=$audit['title']?></a> ⇢ Редактировать аудит</span></div>
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
        <h1><a href="/audit?id=<?=+$_GET['id']?>" class="back">⇠</a> Редактировать аудит</h1>
        <form action="/modules/editaudit" method="POST">
            <span class="error">
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] === 'empty') {
                        print('Не все поля заполнены');
                    } else if ($_GET['error'] === 'rights') {
                        print('Нет прав на редактрование аудита');
                    }
                }
                ?>
            </span>
            <input type="hidden" name="id" value="<?=+$_GET['id']?>">
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
                <span>Весовой коэффициент:</span>
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