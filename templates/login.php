<div class="content">
    <div class="container login-form">
        <img src="/styles/logo.png" class="login-form__logo" alt="Логотип">
        <h1>Войти в аккаунт аудитора</h1>
        <form action="/modules/login" method="POST">
            <span class="error">
                <?= isset($_GET['error']) ? 'Ошибка в email или пароле' : '' ?>
            </span>
            <label>
                <span>Электронная почта:</span>
                <input type="text" name="email">
            </label>
            <label>
                <span>Пароль:</span>
                <input type="password" name="password">
            </label>
            <button>Войти</button>

            <a href="/reg">Создать аккаунт</a>
        </form>
    </div>
</div>