<?php
    require_once('nav-client.php');
?>

<style>
    body {
        background-image: linear-gradient(to right, #ba001f, red);
        }
    img#back-img-movie {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 0;
        max-height: 200vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
</style>

<main class="py-5">
     <section id="listado" class="mb-5">
        <img id="back-img-movie" src="<?php echo API_IMG.$show-> getMovie()->getImage(); ?>" alt="Poster">
          <div class="container">
               <h1 class="title">Datos de compra</h1>
               <form action="<?php echo FRONT_ROOT ?>Ticket/readCCInformation" method="post" class="bg-dark-alpha white-font p-5">                       
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Película</label>
                            <input class="form-control" type="text" value="<?=$show-> getMovie()-> getTitle();?>" readonly>
                            <input type="hidden" name="showID" value="<?=$show-> getID();?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Duración</label>
                            <input class="form-control" type="text" value="<?=$movie-> getLength() . ' minutos.';?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Cine</label>
                            <input class="form-control" type="text" value="<?=$show-> getRoom()-> getCinema()-> getName();?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Dirección del cine</label>
                            <input class="form-control" type="text" value="<?=$show-> getRoom()-> getCinema()-> getAddress();?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Sala</label>
                            <input class="form-control" type="text" value="<?=$show-> getRoom()-> getName();?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Fecha</label>
                            <input class="form-control" type="text" value="<?=$show-> getDate()?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Hora</label>
                            <input class="form-control" type="text" value="<?=$show-> getStartTime();?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="seatsQuantity">Cantidad de entradas</label><br>
                            <input type="number" id="seatsQuantity" value="" name="seatsQuantity" min="1" max="<?=$show-> getRoom()-> getCapacity();?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <a href="<?php echo FRONT_ROOT ?>User/showCinemaListMenu/" class="btn btn-danger ml-auto d-block">Cancelar</a>
                        <button type="submit" class="btn btn-primary ml-3">Confirmar compra</button>
                    </div>
               </form>
          </div>
     </section>
</main>