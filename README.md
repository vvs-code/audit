# Автоматизация процесса проведения аудитов поставщика

Приложение позволяет в электронном виде проводить аудиты поставщика согласно корпоративному стандарту АО «ОСК», а также формировать чек-листы в формате PDF.

## Схема проведения аудитов

Аудит состоит из чек-листов (всего составлено 10 чек-листов, их набор зависит от профиля предприятия). Каждый чек-лист состоит из 10–50 критериев, по которым аудитор выставляет оценки `0`, `0,25`, `0,5`, `0,75`, `1` (также критерий может быть `Не применим`, тогда он исключается из расчета). Отношение оценок с учетом показателей значимости к максимально возможной оценке — `показатель соответствия`. Чтобы получить `итоговую оценку` по чек-листу, нужно `показатель соответствия` умножить на `весовой коэффициент` чек-листа (установленный стандартом) и `корректирующий коэффициент` (зависящий от наличия у организаций Группы ОСК претензий к качеству продукции или ведения договорной работы). `Результат аудита` — сумма `итоговых оценок` по чек-листам. 

Согласно результату аудита, предприятие получает класс соответствия, который помогает другим Обществам оценить надежность данного предприятия и сформировать АО «ОСК» мейкерс-лист поставщика. 

![Схема проведения аудитов](.README/audit-plan.jpg)

## Страница всех аудитов

Здесь отображаются все аудиты, которые вы создали или в которых принимали участие.

![Внешний вид страницы аудитов](.README/index.png)

Каждый аудит отображается, как отдельная строчка с градиентом, соответствующем статусу аудита.

Слева отображается название и профиль предприятия, даты проведения аудита. 

Справа — статус аудита (`Активен`/`Заблокирован`/`Завершен`). Далее отображается количество заполненных аудитов (для `Активных`), либо итоговый результат и класс соответствия (для `Завершенных`). Кнопка <img src=".README/file-pdf-solid.svg" width="15" align="center"> позволяет сформировать все чек-листы аудита в формате PDF. Кнопка <img src=".README/trash.svg" width="15" align="center"> (отображается только у создателя) удаляет созданный аудит. Кнопка <img src=".README/leave.svg" width="15" align="center"> (у остальных аудиторов) позволяет покинуть аудит.

Также у создателя отображается `ABCDEF` 6-буквенный код аудита, с помощью которого эксперты могут присоединяться к аудиту.
<hr>

Вверху страницы находятся кнопки, которые позволяют `Создать` новый аудит или `Присоединиться` к существующему.

<img src=".README/createaudit.png" width="48%" align="top"> <img src=".README/joinaudit.png" width="48%" align="top">


## Страница аудита

![Внешний вид страницы аудита](.README/audit-page-owner.png)

Сверху отображается название предприятия и корректирующий коэффициент (`1.00`)

<hr>

**Доступно всем аудиторам:**

<img src=".README/file-pdf-solid.svg" width="15" align="center">&nbsp;`Сформировать PDF` — формирует все чек-листы в PDF. Это выглядит примерно так:

![Внешний вид чек-листа в PDF](.README/example.png)

<hr>

**Доступно только создателю аудита:**

<img src=".README/auditors.svg" width="15" align="center">&nbsp;`Аудиторы` — открывает список всех, экспертов, участвующих в аудите. Здесь возможно распределить чек-листы между аудиторами или исключить эксперта из аудита. Также на этой странице можно <nobr><img src=".README/gear.svg" width="15" align="center">&nbsp;`Сменить код`</nobr> аудита из соображений безопасности (кроме того, он автоматически изменится при исключении кого-либо из аудита)

![Внешний вид страницы аудиторов](.README/auditors-page.png)

<img src=".README/edit.svg" width="15" align="center">&nbsp;`Редактировать` — позволяет изменить параметры, указанные при создании аудита, кроме профиля предприятия

<img src=".README/lock.svg" width="15" align="center">&nbsp;`Заблокировать` — позволяет запретить редактирование чек-листов всеми аудиторами (блокировку можно отменить)

<img src=".README/check.svg" width="15" align="center">&nbsp;`Завершить` — появляется вместо кнопки `Заблокировать`, когда заполнены все чек-листы. Блокирует редактирование всех чек-листов и выводит итоговый результат аудита (завершение можно отменить)

<hr>

![Цвета чек-листов](.README/checkcolors.png)

Каждый чек-лист имеет свой уникальный цвет. Градиент сильно упрощает ориентирование между чек-листами. Слева — цвет чек-листа, справа — цвет статуса чек-листа

![Чек-лист на странице аудите](.README/checkrow.png)

Слева отображается номер и название чек-листа. Справа — статус чек-листа (`Создан`/`В работе`/`Заполнен`), количество заполненных критериев (для тех, которые `В работе`), итоговая оценка (для `Заполненных`). Далее — весовой коэффициент чек-листа (создатель может корректировать его только если профиль предприятия `Другое`, в остальных случаях значение установлено автоматически в соответствии со стандартом<sup>1</sup>). Кнопка <img src=".README/file-pdf-solid.svg" width="15" align="center"> позволяет сформировать один чек-листу. Кнопки <img src=".README/user-check.svg" width="15" align="center"> и <img src=".README/user-plus.svg" width="15" align="center"> показывают, в каких чек-листах вы участвуете. Если вы присоединяетесь к чек-листу, ваша фамилия отобразится в PDF-файле чек-листа.

<hr>

*<sup>1</sup> Весовые коэффициенты чек-листов по профилям поставщика в соответствии со стандартом:*
<table>
    <tr>
        <td>№</td>
        <td><nobr>Чек-лист</nobr></td>
        <td>Разработчик-изготовитель&nbsp;(РИ)</td>
        <td>Разработчик (Р)</td>
        <td>Изготовитель (И)</td>
        <td>Оказание услуг&nbsp;(У)</td>
        <td>Дилер&nbsp;(Д)</td>
    </tr>
    <tr>
        <td>0</td>
        <td>Планирование</td>
        <td>0,05</td><td>0,05</td><td>0,05</td><td>0,05</td><td>0,1</td>
    </tr>
    <tr>
        <td>1</td>
        <td>Производство</td>
        <td>0,15</td><td>—</td><td>0,2</td><td>0,15</td><td>—</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Бережливость</td>
        <td>0,1</td><td>0,1</td><td>0,1</td><td>0,1</td><td>0,1</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Разработка</td>
        <td>0,15</td><td>0,55</td><td>—</td><td>—</td><td>—</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Технология</td>
        <td>0,1</td><td>—</td><td>0,15</td><td>0,15</td><td>—</td>
    </tr>
    <tr>
        <td>5</td>
        <td>СМК</td>
        <td>0,1</td><td>0,2</td><td>0,15</td><td>0,15</td><td>0,2</td>
    </tr>
    <tr>
        <td>6</td>
        <td>Контроль&nbsp;качества</td>
        <td>0,15</td><td>—</td><td>0,15</td><td>0,15</td><td>0,15</td>
    </tr>
    <tr>
        <td>7</td>
        <td>Персонал</td>
        <td>0,05</td><td>0,1</td><td>0,05</td><td>0,1</td><td>0,05</td>
    </tr>
    <tr>
        <td>8</td>
        <td>Закупки</td>
        <td>0,1</td><td>—</td><td>0,1</td><td>0,1</td><td>0,3</td>
    </tr>
    <tr>
        <td>9</td>
        <td>Склад</td>
        <td>0,05</td><td>—</td><td>0,05</td><td>0,05</td><td>0,1</td>
    </tr>
</table>

## Страница чек-листа

На этой странице отображаются критерии и возможные оценки по ним. Также все элементы дизайна страницы имеют цвет уникальный для каждого чек-листа

![Страница чек-листа](.README/checkpage.png)

**Справа отображаются функциональные кнопки:**

<img src=".README/circle-xmark.svg" width="15" align="center"> — отменяет выставленную оценку
<br>
<img src=".README/question.svg" width="15" align="center"> — открывает справочную информацию об оценках

![Описание оценок критерия](.README/checkquestion.png)

<img src=".README/book.svg" width="15" align="center"> — открывает справочную информацию о пунктах стандарта

![Описание пунктов стандарта критерия](.README/checkbook.png)

<img src=".README/pen.svg" width="15" align="center">&nbsp;— отображает поле для введения обоснования оценки или комментария (это поле обязательно для заполнения при выборе пункта `Не применим`, поэтому открывается автоматически). 
<br>
<img src=".README/pen-checked.svg" width="15" align="center"> — показывает, что к данному критерию написан комментарий

![Комментарий к критерию](.README/checkcomment.png)

## Адаптивность

Приложение корректно отображается как на больших экранах, так и на телефонах и планшетах, что делает работу в полевых условиях значительно более удобной.

![Адаптивность](.README/adapt.jpg)
