<?php

    namespace Helpers;

    use Helpers\QR\QR_BarCode;
    define('QR_SIZE', 300);

    abstract class QR{
        static function generateQR($data){

            $qr = new QR_BarCode();
    
            $qr->text($data['text']); //Almacena en el QR el texto asignado a la variable text del array data
    
            $qr->qrCode(QR_SIZE, ROOT."Helpers\QR\assets\\".$data['id'].".png");
        }
    }
    

?>