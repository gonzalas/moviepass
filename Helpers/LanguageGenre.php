<?php
    namespace Helpers;

    class LanguageGenre {

        public static function getLanguage($shortLenguage){
            switch($shortLenguage){
                case "en": $response = "Inglés";
                            break;
                case "de": $response = "Alemán";
                            break;
                case "fr": $response = "Francés";
                            break;
                case "gl": $response = "Gallego";
                            break; 
                case "it": $response = "Italiano";
                            break;     
                case "ja": $response = "Japonés";
                            break; 
                case "ko": $response = "Coreano";
                            break; 
                case "pt": $response = "Portugués";
                            break; 
                case "es": $response = "Español";
                            break; 
                case "zh": $response = "Chino";
                            break;
                default: $response = "Desconocido";
                                 
            }
            return $response;
        }
    }

?>