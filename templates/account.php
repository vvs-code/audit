<?php
    /** Импортируемые переменные */
    /** @var string $errormessage_data */
    /** @var string $errormessage_password */
    /** @var array $user */
    /** @var int $myid */
    /** @var string $email */
    /** @var string $surname */
    /** @var string $nameletter */
    /** @var string $fathernameletter */
?>

<div class="top">
    <div class="container">
        <div class="top__title"><span><a href="/" class="back">Аудиты</a> ⇢ Аккаунт аудитора</span></div>
    </div>
</div>

<div class="top-placeholder"></div>

<div class="content">
    <div class="container in-app-form">
        <h1 class="flexed"><a href="/" class="back">⇠</a> Аккаунт аудитора <span class="title-name"><svg class="title-svg" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 1 224 0a128 128 0 1 1 0 256zM209.1 359.2l-18.6-31c-6.4-10.7 1.3-24.2 13.7-24.2H224h19.7c12.4 0 20.1 13.6 13.7 24.2l-18.6 31 33.4 123.9 36-146.9c2-8.1 9.8-13.4 17.9-11.3c70.1 17.6 121.9 81 121.9 156.4c0 17-13.8 30.7-30.7 30.7H285.5c-2.1 0-4-.4-5.8-1.1l.3 1.1H168l.3-1.1c-1.8 .7-3.8 1.1-5.8 1.1H30.7C13.8 512 0 498.2 0 481.3c0-75.5 51.9-138.9 121.9-156.4c8.1-2 15.9 3.3 17.9 11.3l36 146.9 33.4-123.9z"/></svg> <?=$surname?>&nbsp;<?=$nameletter?>.&thinsp;<?=$fathernameletter?>.</span></h1>
        <form action="/modules/changeinfo" method="POST" class="account-form">
            <h2>Личные данные</h2>
            <span class="error">
                <?=$errormessage_data?>
            </span>
            <span class="success">
                <?=isset($_GET['successdata']) ? 'Сохранено' : ''?>
            </span>
            <label>
                <span>Фамилия:</span>
                <input type="text" name="surname" value="<?=safe_attribute($user['surname'])?>">
            </label>
            <label>
                <span>Имя:</span>
                <input type="text" name="name" value="<?=safe_attribute($user['name'])?>">
            </label>
            <label>
                <span>Отчество:</span>
                <input type="text" name="fathername" value="<?=safe_attribute($user['fathername'])?>">
            </label>
            <label>
                <span>Должность:</span>
                <input type="text" name="position" value="<?=safe_attribute($user['position'])?>">
            </label>
            <label>
                <span>Email:</span>
                <input type="text" name="email" value="<?=safe_attribute($user['email'])?>">
            </label>
            <button>Сохранить</button>
        </form>

        <form action="/modules/changepassword" method="POST" class="account-form">
            <h2>Пароль</h2>
            <span class="error">
                <?=$errormessage_password?>
            </span>
            <span class="success">
                <?=isset($_GET['successpassword']) ? 'Пароль изменен' : ''?>
            </span>
            <label>
                <span>Текущий пароль:</span>
                <input type="password" name="passwordold">
            </label>
            <label>
                <span>Новый пароль:</span>
                <input type="password" name="password1">
            </label>
            <label>
                <span>Повторите пароль:</span>
                <input type="password" name="password2">
            </label>
            <button>Сменить пароль</button>
        </form>
    </div>
</div>