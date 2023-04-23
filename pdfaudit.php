<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/modules/checklistsdata.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

    http_response_code(200);
    $connection = get_connection();

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $fontDirectory = $_SERVER['DOCUMENT_ROOT'].'/styles/';

    $uri = explode('/', $_SERVER['REQUEST_URI'])[2];
    $auditcode = $uri;

    $audit = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM audits WHERE code = "'.mysqli_real_escape_string($connection, $auditcode).'"'), MYSQLI_ASSOC)[0];

    $audit['weights'] = json_decode($audit['weights']);
    $audit['users'] = json_decode($audit['users']);
    $audit['checklists'] = json_decode($audit['checklists']);
    $audit['comments'] = json_decode($audit['comments']);

    $options = new Options();
    $options->setChroot($fontDirectory);

    $dompdf = new Dompdf($options);
    $dompdf->getFontMetrics()->registerFont(
        ['family' => 'Times New Roman', 'style' => 'regular', 'weight' => 'normal'],
        $fontDirectory.'/TimesNewRomanRegular.ttf'
    );
    $dompdf->setPaper('A4', 'landscape');

    $tables = [];

    $html = <<<ENDHTML
    <html>
        <head>
            <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
            <style>
            
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box; 
                }
            
                @font-face {
                  font-family: 'Times New Roman';
                  font-weight: normal;
                  font-style: normal;
                  font-variant: normal;
                  src: url('/styles/TimesNewRomanRegular.ttf') format("truetype");
                }
    
                body {
                    font-family: "Times New Roman";
                    font-size: 12px;
                    padding: 1cm;
                    line-height: 1.1em;
                }
                
                td {
                    padding: 1mm 1mm;
                    border: 1px solid black;
                }
            </style>
        </head>
        <body>
ENDHTML;

    for ($checklistnum = 0; $checklistnum <= 9; $checklistnum++): if ($audit['checklists'][$checklistnum]):
    $osklogo = $_SERVER['DOCUMENT_ROOT'].'/styles/osk.png';
    $lightcolor = $checklist_color[$checklistnum][0];
    $darkcolor = $checklist_color[$checklistnum][1];

    if ($audit['datestart'] === $audit['dateend']) {
        $date = 'Дата аудита: '.format_date($audit['datestart']);
    } else {
        $date = 'Даты аудита: '.format_date($audit['datestart']).' — '.format_date($audit['dateend']);
    }

    $categories = '';
    $marks = json_decode($audit['marks']);
    $resmark = 0;

    foreach ($checklists[$checklistnum]['categories'][0] as $i => $category) {
        $categories .= <<<HTML
            <tr style="background-color: {$lightcolor};">
                <td></td>
                <td colspan="6">{$category}</td>
            </tr>
HTML;

        foreach ($checklists[$checklistnum]['categories'][1][$i] as $criteria) {
            $thismark = $marks[$checklistnum][$criteria];
            $num = $criteria + 1;
            $title = $checklists[$checklistnum]['criteria'][$criteria];
            $standard = $checklists[$checklistnum]['standard'][$criteria];
            $w = $checklists[$checklistnum]['weights'][$criteria];
            $weight = $thismark === -2 ? '—' : $w;
            $mark = str_replace('.', ',', (string)($thismark === -2 ? '—' : ($thismark === -1 ? '' : $thismark)));
            $res = str_replace('.', ',', (string)($thismark === -2 ? '—' : ($thismark === -1 ? '' : $thismark * $w)));
            $resmark += $thismark === -2 ? 0 : ($thismark === -1 ? 0 : $thismark * $w);
            $standardstyle = $checklistnum === 2 ? 'style="font-size: 10px"' : '';
            $comment = htmlspecialchars($audit['comments'][$checklistnum][$criteria]);
            $categories .= <<<HTML
            <tr style="line-height: 1em;">
                <td style="text-align: center;">{$num}</td>
                <td>{$title}</td>
                <td {$standardstyle}>{$standard}</td>
                <td style="text-align: center">{$mark}</td>
                <td style="text-align: center">{$weight}</td>
                <td style="text-align: center">{$res}</td>
                <td>{$comment}</td>
            </tr>
HTML;
        }
    }


    $maxmarksum = 0;
    foreach ($checklists[$checklistnum]['weights'] as $i => $weight) {
        if ($marks[$checklistnum][$i] !== -2) {
            $maxmarksum += $weight;
        }
    }
    $Qi = in_array(-1, $marks[$checklistnum]) ? '' : number_format((float)$resmark / $maxmarksum * 100, 2, ',', ' ').'%';
    $resmark = in_array(-1, $marks[$checklistnum]) ? '' : $resmark;
    $checklistweight = $audit['weights'][$checklistnum];
    $coeff = $coeff_to_num[$audit['coeff']];
    $wmark = in_array(-1, $marks[$checklistnum]) ? '' : round($checklistweight * ($resmark / $maxmarksum * 100), 3);
    $final = in_array(-1, $marks[$checklistnum]) ? '' : round($wmark * $coeff, 2);

    if ($checklistnum === 2) {
        $anno = '<p style="text-align: right; padding-bottom: 2mm; margin-top: -3mm;"><sup style="font-size: 10px">1</sup> Итоговая оценка по критерию (оценка аудитора &times; коэффициент значимости критерия)</p>';
        $header = <<<HTML
            <tr style="text-align: center; background-color: {$lightcolor};">
                <td style="width: 3%">№ п/п</td>
                <td style="width: 23%">Критерий</td>
                <td style="width: 41%">Характеристика оценки (0; 0,25; 0,5; 0,75; 1)</td>
                <td style="width: 6%">Оценка аудитора</td>
                <td style="width: 6%">Коэфф. значим. критерия</td>
                <td style="width: 6%">Итоговая оценка по критер.<sup style="font-size: 10px;">1</sup></td>
                <td style="width: 15%">Обоснование оценки</td>
            </tr>
HTML;
    } else {
        $anno = '';
        $header = <<<HTML
            <tr style="text-align: center; background-color: {$lightcolor};">
                <td style="width: 3%">№ п/п</td>
                <td style="width: 35%">Критерий</td>
                <td style="width: 10%">Стандарт ГОСТ Р ИСО 9001-2015 (ГОСТ РВ 0015-002-2020*) </td>
                <td style="width: 8%">Оценка аудитора (0; 0,25; 0,5; 0,75; 1)</td>
                <td style="width: 10%">Коэффициент значимости критерия</td>
                <td style="width: 11%">Итоговая оценка по критерию (оценка аудитора &times; коэфф. знач. критерия)</td>
                <td style="width: 23%">Обоснование оценки</td>
            </tr>
HTML;
    }

    $participants = json_decode($audit['participants']);

    $auditors = '';

    $auditorscount = 0;

    foreach ($participants[$checklistnum] as $participant) {
        $user = mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE id = '.+$participant), MYSQLI_ASSOC);
        if (isset($user[0]) and (in_array($participant, $audit['users']) or $participant === +$audit['admin'])) {
            $user = $user[0];
            $name = $user['surname'] . ' ' . $user['name'] . ' ' . $user['fathername'];
            $auditors .= <<<ENDHTML
             <tr>
                <td>{$name}</td>
                <td></td>
                <td></td>
                <td style="border: none;"></td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
ENDHTML;
            $auditorscount++;
        }
    }

    if ($auditorscount < 2) {
        for ($i = 0; $i < 2 - $auditorscount; $i++) {
            $auditors .= <<<ENDHTML
             <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="border: none;"></td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
ENDHTML;
        }
    }

    $resmark_text = $resmark === '' ? '' : number_format((float)$resmark, 2, ',', ' ');
    $checklistweight_text = $checklistweight === '' ? '' : number_format((float)$checklistweight, 2, ',', ' ');
    $wmark_text = $wmark === '' ? '' : number_format((float)$wmark, 2, ',', ' ');
    $coeff_text = $coeff === '' ? '' : number_format((float)$coeff, 2, ',', ' ');
    $final_text = $final === '' ? '' : number_format((float)$final, 2, ',', ' ');

    $goz = ($checklistnum !== 2 ? "* для организаций, выполняющих работы в обеспечение ГОЗ" : '');
    $tables[] = <<<ENDHTML

        <div style="padding-bottom: 5mm">
            <span style="font-size: 4.5mm; padding-top: 5mm; padding-bottom: 4.5mm; display: inline-block; padding-right: 3mm;">АО «ОСК»</span>
            <img src="{$osklogo}" alt="Логотип ОСК" style="width: 17mm; height: 17mm;">
            <span style="margin-left: auto; display: inline-block; padding-left: 180mm; font-size: 4mm; padding-top: 5mm; padding-bottom: 5mm;">СТО ОСК.КСМК 00.099-2022</span>
        </div>
        <div>
            <div style="display: inline-block; width: 35%;">
                <p>{$date}</p>
                <p>Наименование предприятия: {$audit['title']}</p>
                <p style="margin-bottom: 5px;">Профиль предприятия: {$profile_to_full[$audit['profile']]}</p>
            </div>
            <div style="display: inline-block; text-align: right; font-size: 16px; width: 64%; padding-bottom: 5mm">
                <p>Чек-лист оценки поставщика</p>
                <p>Часть {$checklistnum}. {$criteria_full_titles[$checklistnum]}</p>
            </div>
            {$anno}
        </div>
        <table style="width: 100%; white-space: break-spaces; border-collapse: collapse; page-break-inside: auto;">
            {$header}
            {$categories}
        </table>
        <table style="width: 100%; white-space: break-spaces; border-collapse: collapse; text-align: right;">
            <tr>
                <td style="width: 46%; border: none; text-align: left;">{$goz}</td>
                <td style="width: 20%; background-color: {$lightcolor}; border-top: none;">Максимально возможная оценка</td>
                <td style="width: 7%; background-color: {$lightcolor}; text-align: center; border-top: none;">{$maxmarksum}</td>
                <td style="width: 20%; background-color: {$lightcolor}; border-top: none;">Показатель соответствия</td>
                <td style="width: 7%; background-color: {$lightcolor}; text-align: center; border-top: none;">{$Qi}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="background-color: {$lightcolor};">Набранная оценка</td>
                <td style="background-color: {$lightcolor}; text-align: center;">{$resmark_text}</td>
                <td style="background-color: {$lightcolor};">Весовой коэффициент</td>
                <td style="background-color: {$lightcolor}; text-align: center;">{$checklistweight_text}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="background-color: {$lightcolor};">Итоговая оценка</td>
                <td style="background-color: {$lightcolor}; text-align: center;">{$wmark_text}</td>
                <td style="background-color: {$lightcolor};">Корректирующий коэффициент</td>
                <td style="background-color: {$lightcolor}; text-align: center;">{$coeff_text}</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
                <td style="background-color: {$darkcolor};">Скорректированная итоговая оценка</td>
                <td style="background-color: {$darkcolor}; text-align: center;">{$final_text}</td>
                <td style="border: none;"></td>
                <td style="border: none;"></td>
            </tr>
        </table>
        <table style="width: 100%; white-space: break-spaces; border-collapse: collapse">
            <tr>
                <td style="border: none; width: 31%;">Аудиторы:</td>
                <td style="border: none; width: 9%;"></td>
                <td style="border: none; width: 9%;"></td>
                <td style="border: none; width: 2%;"></td>
                <td style="border: none; width: 31%;">Представители предпрятия:</td>
                <td style="border: none; width: 9%;"></td>
                <td style="border: none; width: 9%;"></td>
            </tr>
            <tr>
                <td>ФИО</td>
                <td>Подпись</td>
                <td>Дата</td>
                <td style="border: none;"></td>
                <td>ФИО</td>
                <td>Подпись</td>
                <td>Дата</td>
            </tr>
            {$auditors}
        </table>
        

ENDHTML;


    endif; endfor;

    $html .= implode('<div style="page-break-after: always;"></div>', $tables);
    $html .= <<<ENDHTML
    </body>
</html>
ENDHTML;

//    print $html;
//    die();
    $dompdf->loadHtml($html);

    $dompdf->render();

    $name = '';

    foreach (preg_split('//u', $audit['title'], -1, PREG_SPLIT_NO_EMPTY) as $symbol) {
        if (in_array($symbol, preg_split('//u', 'йцукенгшщзхъфывапролджэёячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЁЯЧСМИТЬБЮ', -1, PREG_SPLIT_NO_EMPTY))) {
            $name .= $symbol;
        } else {
            $name .= ' ';
        }
    }

    while (count(explode('  ', $name)) > 1) {
        $name = implode(' ', explode('  ', $name));
    }

    $name = implode('_', explode(' ', trim($name)));

    $output = $dompdf->output();
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/pdf/'.$auditcode.'.pdf', $output);
    header('location: '.'/pdf/'.$auditcode.'.pdf');


