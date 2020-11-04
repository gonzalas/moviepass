<?php
    require_once('nav-client.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h1 class="title">Datos de compra</h1>
               <form action="<?php echo FRONT_ROOT ?>Ticket/validateTicketPurchase" method="post" class="bg-light-alpha white-font p-5">                       
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
                            <input class="form-control" name="showDate" type="text" value="<?=$show-> getDate()?>" readonly>
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