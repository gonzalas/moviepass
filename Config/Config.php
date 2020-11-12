<?php namespace Config;

    define("ROOT", dirname(__DIR__) . "/");
    //Path to your project's root folder
    define("FRONT_ROOT", "/UTN/Moviepass/");
    define("VIEWS_PATH", "Views/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
    define("IMG_PATH", "http://localhost" . FRONT_ROOT.VIEWS_PATH . "img/");

    //API
    define("API_KEY", "1fda2c2ca096a563fb941fcfd34c718a");
    define("API_IMG", "https://image.tmdb.org/t/p/w500");

    //ADMIN HARCODE
    define("ADMIN_USERNAME", "admin");
    define("ADMIN_PASSWORD", "1234");

    //TIME BETWEEN SHOWS CONSTANTS IN SECONDS
    define("TIME_AFTER_SHOW", 900);

    //DATABASE
    define("DB_HOST", "localhost");
    define("DB_NAME", "moviepass");
    define("DB_USER", "root");
    define("DB_PASS", "");

    //PHPMailer
    define("MAILER_EMAIL", "cinemamoviepass@gmail.com");
    define("MAILER_PASSWORD", "fercas2020");
    define("MAILER_NAME", "Cinema Moviepass");
?>




