<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h1 class="title">Selección de horario</h1>
               <form action="<?php echo FRONT_ROOT ?>Show/validateAddShow" method="post" class="bg-light-alpha white-font p-5">                       
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Película</label>
                            <input class="form-control" type="text" value="<?=$movie->getTitle();?>" readonly>
                            <input type="hidden" name="movieID" value="<?php echo $movie-> getID()?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Cine</label>
                            <input class="form-control" type="text" value="<?=$cinema->getName();?>" readonly>
                            <input type="hidden" name="cinemaID" value="<?php echo $cinema-> getID()?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Sala</label>
                            <input class="form-control" type="text" value="<?=$room->getName();?>" readonly>
                            <input type="hidden" name="roomID" value="<?php echo $room-> getID()?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Fecha</label>
                            <input class="form-control" name="showDate" type="text" value="<?=$showDate?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="timeSelection">Horario (recordá que debe haber 15 minutos entre funciones)</label><br>
                            <input type="time" id="timeSelection" name="showTime" min="11:00" max="23:30" required>
                        </div>
                    </div>
                    <div class="row">
                        <button type="" class="btn btn-danger ml-auto d-block">Cancelar</button>
                        <button type="submit" class="btn btn-primary ml-3">Comprobar horario</button>
                    </div>
               </form>
          </div>
     </section>
</main>