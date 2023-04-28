<?php

    ini_set('session.cookie_httponly', 1);
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $config = [
        'name' => 'audit',
        'password' => 'root',
        'user' => 'root',
        'host' => 'localhost'
    ];

    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['name']);
    mysqli_set_charset($connection, 'utf8');


    /* Оставлено для совместимости */
    /**
     * @return false|mysqli
     */
    function get_connection () {
        global $connection;
        return $connection;
    }

    /**
     * @param $string
     * @return string
     */
    function safe_string ($string) {
        global $connection;
        return mysqli_real_escape_string($connection, $string);
    }

    /**
     * @param $string
     * @return string
     */
    function safe_attribute ($string) {
        return implode('&quot;', explode('"', $string));
    }

    /**
     * @param $data
     * @param $name
     * @param $path_type
     * @return false|string
     */
    function include_template ($data = [], $name = 'layout.php', $path_type = 0) {
        if (!isset($data['is_include'])) {
            $data['is_include'] = true;
        }
        $data['logged_user'] = isset($_SESSION['user']) ? $_SESSION['user'] : false;
        if (!isset($data['scripts'])) {
            $data['scripts'] = [];
        }
        if (!isset($data['file_path'])) {
            $data['file_path'] = 0;
        }
        $name = $path_type ? ($path_type === 1 ? $name : $_SERVER['DOCUMENT_ROOT'].'/'.$name) : $_SERVER['DOCUMENT_ROOT'].'/templates/'.$name;
        $result = '';

        if (!file_exists($name)) {
            return $result;
        }

        ob_start();
        extract($data);
        require_once $name;

        return ob_get_clean();
    }

    /**
     * @param $date
     * @return string
     */
    function format_date ($date) {
        $date = explode('-', $date);
        return +$date[2].' '.['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'][$date[1] - 1].' '.$date[0];
    }

    /**
     * @param $datestart
     * @param $dateend
     * @return string
     */
    function format_date_range ($datestart, $dateend) {
        $datestart = explode('-', $datestart);
        $dateend = explode('-', $dateend);
        $mn = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

        if ($datestart[0] === $dateend[0]) {
            if ($datestart[1] === $dateend[1]) {
                if ($datestart[2] === $dateend[2]) {
                    return +$dateend[2].' '.$mn[$dateend[1] - 1].' '.$dateend[0];
                } else {
                    return +$datestart[2].'–'.+$dateend[2].' '.$mn[$dateend[1] - 1].' '.$dateend[0];
                }
            } else {
                return +$datestart[2].' '.$mn[$datestart[1] - 1].' — '.+$dateend[2].' '.$mn[$dateend[1] - 1].' '.$dateend[0];
            }
        } else {
            return +$datestart[2].' '.$mn[$datestart[1] - 1].' '.$datestart[0].' — '.+$dateend[2].' '.$mn[$dateend[1] - 1].' '.$dateend[0];
        }

    }

    /**
     * @param $length
     * @return string
     */
    function generate_random_code ($length = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    function transliterate ($str) {
        $from = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'];
        $to = ['a','b','v','g','d','e','yo','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','kh','c','ch','sh','sch','','y','','e','yu','ya','A','B','V','G','D','E','Yo','Zh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','Kh','C','Ch','Sh','Sch','','Y','','E','YU','YA'];
        return str_replace($from, $to, $str);
    }

    /**
     * @param $url
     * @return void
     */
    function leave ($url = '/') {
        header('location: '.$url);
        exit();
    }
