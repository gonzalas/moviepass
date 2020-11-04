<?php
    require_once("nav-client.php"); 
?>
<style>
    body {
        background-image: linear-gradient(to right, #ba001f, red);
        }
        img#img-back-prof {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 0;
        max-height: 100vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
</style>

<section class="container">
    <div class="mt-5 mb-5">
        <h1 style="color: #e88e9d; font-weight: 700;">Ticket</h1>
    </div>
    <img id="img-back-prof" src="<?php echo IMG_PATH."poster01.jpg"; ?>" alt="Poster">
    <div style="background-color: rgba(256,256,256,0.75); padding: 50px; border-radius: 5px;">
        <h2 style="margin-bottom: 5%;">¡Gracias por elegirnos!</h2>
        <p><b>Comprobante</b></p>
        <hr>
        <p>Cliente: <?php echo $userLogged->getFirstName()." ".$userLogged->getLastName()?></p>
        <p>Película: <?php echo $movieToBuy->getTitle()?></p>
        <p>Horario: <?php echo date('H:i', strtotime($showToBuy->getStartTime()))?></p>
        <p>Entradas: <?php echo $seatsQuantity?></p>
        <p><b>Total: $<?php echo $purchase->getSubTotal()?></b></p>        
    </div>
</section>
