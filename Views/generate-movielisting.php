<?php
    require_once('nav.php');
?>

<section class="container mt-5 p-5">
<?php
    if($cinemasList!= null && $showsList != null){
?>
        <div class="alert alert-dark" role="alert">
            <h1>¡Cartelera generada!</h1>
        </div>
<?php
    }else if($cinemasList == null) {      
?>
    <div class="alert alert-dark" role="alert">
            <h1>No hay  cines generados</h1>
        </div>
<?php
    }else {
?>         
   <div class="alert alert-dark" role="alert">
            <h1>No hay funciones generadas</h1>
        </div>
<?php
    }
?>
</section>