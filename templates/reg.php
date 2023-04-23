<div class="content">
    <div class="container" style="max-width: 500px;">
        <!--<img src="/styles/logo.png" alt="Логотип" style="height: 50px; margin: 35px auto 0; display: block;">-->
        <h1 style="padding-top: 0; text-align: center;font-weight: 500;">Создать аккаунт аудитора</h1>
        <form action="/modules/reg" method="POST">
            <span class="error">
                <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] === 'email') {
                            print('Введите действительный email, пожалуйста');
                        } else if ($_GET['error'] === 'empty') {
                            print('Не все поля заполнены');
                        } else if ($_GET['error'] === 'passwordlength') {
                            print('Пароль должен быть не менее 8 символов');
                        } else if ($_GET['error'] === 'password2') {
                            print('Пароли не совпадают');
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
                <span>Пароль:</span>
                <input type="password" name="password">
            </label>
            <label>
                <span>Повторите пароль:</span>
                <input type="password" name="password2">
            </label>
            <button style="margin-bottom: 10px;">Зарегистрироваться</button>
            <a href="/login">Войти в существующий аккаунт</a>

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