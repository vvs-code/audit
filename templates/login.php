<div class="content">
    <div class="container" style="max-width: 500px;">
        <img src="/styles/logo.png" alt="Логотип" style="height: 50px; margin: 35px auto 0; display: block;">
        <h1 style="padding-top: 0; text-align: center;font-weight: 500;">Войти в аккаунт аудитора</h1>
        <form action="/modules/login" method="POST">
            <span class="error">
                <?= isset($_GET['error']) ? print('Ошибка в email или пароле') : '' ?>
            </span>
            <label>
                <span>Электронная почта:</span>
                <input type="text" name="email">
            </label>
            <label>
                <span>Пароль:</span>
                <input type="password" name="password">
            </label>
            <button style="margin-bottom: 10px;">Войти</button>

            <a href="/reg">Создать аккаунт</a>

            <style>
                a {
                    text-decoration: none;
                    color: #398aff;
                    border-bottom: 1px solid #398aff;
                }

                a:hover {
                    color: #2166c9;
                    border-bottom: 1px solid #2166c9;
                }
            </style>
        </form>
    </div>
</div>