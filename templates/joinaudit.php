<div class="top">
    <div class="container">
        <div class="top__title"><a href="/" class="back">Аудиты</a> ⇢ Присоединиться к&nbsp;аудиту</div>
    </div>
</div>

<div class="top-placeholder" style="height: 50px;"></div>

<div class="content">
    <div class="container" style="max-width: 500px;">
        <h1><a href="/" class="back">⇠</a> Присоединиться к аудиту</h1>
        <form action="/modules/joinaudit" method="POST">
            <span class="error">
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] === 'format') {
                        print('Код аудита должен состоять из 6 латинских букв');
                    } else if ($_GET['error'] === 'empty') {
                        print('Введите код аудита');
                    } else if ($_GET['error'] === 'notfound') {
                        print('Аудит не найден');
                    }
                }
                ?>
            </span>
            <label>
                <span>Код аудита:</span>
                <input type="text" name="code" placeholder="ABCDEF">
            </label>
            <button>Присоединиться</button>
        </form>
    </div>
</div>