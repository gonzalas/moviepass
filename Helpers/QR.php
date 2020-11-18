<?php
    namespace Helpers;

    // require_once("C:\wamp64\www\UTN\Moviepass\QRCode\phpqrcode\qrlib.php");
    require_once("C:\wamp64\www\UTN\Moviepass\QRCode\phpqrcode\phpqrcode.php");

            $path = FRONT_ROOT.VIEWS_PATH."qrcodes/";
            $file = $path.$email."-show".$show->getID().".png";

            $data = "Ticket comprado.";

            QRcode::png($data, $file);

?>