<div class="content">
    <div class="container login-form">
        <img src="/styles/logo.png" class="login-form__logo" alt="Логотип">
        <h1>Создать аккаунт аудитора</h1>
        <form action="/modules/reg" method="POST">
            <span class="error">
                <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] === 'email') {
                            print('Введите действительный email, пожалуйста');
                        } elseif ($_GET['error'] === 'empty') {
                            print('Не все поля заполнены');
                        } elseif ($_GET['error'] === 'passwordlength') {
                            print('Пароль должен быть не менее 8 символов');
                        } elseif ($_GET['error'] === 'password2') {
                            print('Пароли не совпадают');
                        } elseif ($_GET['error'] === 'exist') {
                            print('Аккаунт уже существует');
                        }
                    }
                ?>
            </span>
            <label>
                <span>Электронная почта:</span>
                <input type="email" name="email">
            </label>
            <label>
                <span>Фамилия:</span>
                <input type="text" name="surname">
            </label>
            <label>
                <span>Имя:</span>
                <input type="text" name="name">
            </label>
            <label>
                <span>Отчество:</span>
                <input type="text" name="fathername">
            </label>
            <label>
                <span>Должность:</span>
                <input type="text" name="position">
            </label>
            <label>
                <span>Пароль:</span>
                <input type="password" name="password">
            </label>
            <label>
                <span>Повторите пароль:</span>
                <input type="password" name="password2">
            </label>
            <button>Зарегистрироваться</button>
            <a href="/login">Войти в существующий аккаунт</a>
        </form>
    </div>
</div>