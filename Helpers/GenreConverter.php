<?php
    namespace Helpers;

    class GenreConverter {

        public static function Convert($genre){
            switch($genre){
                case ("en"):
                    return "Inglés";
                case ("es"):
                    return "Español";
                case ("it"):
                    return "Italiano";
                case ("fr"):
                    return "Francés";
                default:
                    return $genre;
            }
        }
    }
?>