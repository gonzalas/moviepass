<?php
    namespace Helpers;

    class EncodePassword {

        public static function Encode($password){
            $length = strlen($password);
            $encode = '*';

            for($i = 1; $i < $length; $i++){
                $encode = $encode.'*';
            }
            return $encode;
        }
    }
?>