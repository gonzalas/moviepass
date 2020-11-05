<?php
    namespace Helpers;

    class LanguageConverter {

        public static function Convert($language){
            switch($language){
                case "en": $language = "Inglés";
                            break;
                case "de": $language = "Alemán";
                            break;
                case "fr": $language = "Francés";
                            break;
                case "gl": $language = "Gallego";
                            break; 
                case "it": $language = "Italiano";
                            break;     
                case "ja": $language = "Japonés";
                            break; 
                case "ko": $language = "Coreano";
                            break; 
                case "pt": $language = "Portugués";
                            break; 
                case "es": $language = "Español";
                            break; 
                case "zh": $language = "Chino";
                            break;
                default:
                    return $language;
            }
            return $language;
        }
    }
?>