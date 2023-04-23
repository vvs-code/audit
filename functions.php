<?php

    ini_set('session.cookie_httponly', 1);
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $config = [
        'name' => 'audit',
        'password' => '',
        'user' => '',
        'host' => 'localhost',

        'email_login' => '',
        'email_full' => '',
        'email_password' => ''
    ];

    $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['name']);
    mysqli_set_charset($connection, 'utf8');

    function get_connection () {
        global $config;
        $connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['name']);
        mysqli_set_charset($connection, 'utf8');
        return $connection;
    };

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

        $result = ob_get_clean();

        return $result;
    }

    function format_date ($date) {
        $date = explode('-', $date);
        return +$date[2].' '.['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'][$date[1] - 1].' '.$date[0];
    }

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

    function get_size_string ($size) {
        if ($size < 1024) {
            $size = $size.' б';
        } else if ($size >= 1024 && $size < 1048576) {
            $size = implode(',', explode('.', (round($size / 1024 * 10) / 10).' Кб'));
        } else {
            $size = implode(',', explode('.', (round($size / 1048576 * 10) / 10).' Мб'));
        }
        return $size;
    }

    function generate_random_string ($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    function generate_random_word ($length = 6) {
        $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    function generate_random_code ($length = 6) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    function get_user () {
        global $connection;
        return mysqli_fetch_all(mysqli_query($connection, 'SELECT * FROM users WHERE id = "'.(int)$_SESSION['admin']['id'].'"'), MYSQLI_ASSOC)[0];
    };