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
                            <input class="form-control" type="text" value="<?=$movie-> getTitle();?>" readonly>
                            <input type="hidden" name="movieID" value="<?=$movie-> getID();?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Duración (al horario de finalización se le agregan 15 minutos)</label>
                            <input class="form-control" type="text" value="<?=$movie-> getLength() . ' minutos.';?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Cine</label>
                            <input class="form-control" type="text" value="<?=$room-> getCinema()-> getName();?>" readonly>
                            <input type="hidden" name="cinemaID" value="<?=$room-> getCinema()-> getID();?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Sala</label>
                            <input class="form-control" type="text" value="<?=$room-> getName();?>" readonly>
                            <input type="hidden" name="roomID" value="<?=$room-> getID();?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Fecha</label>
                            <input class="form-control" name="showDate" type="text" value="<?=$showDate?>" readonly>
                        </div>
                    </div>
                    <?php 
                        if(!empty($showsList)){
                    ?>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="cinemaSelection">Horarios ocupados</label>
                                <?php foreach ($showsList as $show){ ?>
                                    <input class="form-control" name="" type="text" value="<?= $show->getStartTime() . ' - ' . $show->getEndTime(); ?>" readonly>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="timeSelection">Horario (tener en cuenta que al horario de finalización se le agregan 15 minutos)</label><br>
                            <input type="time" id="timeSelection" name="showTime" min="11:00" max="23:30" required>
                        </div>
                    </div>
                    <div class="row">
                        <a href="<?php echo FRONT_ROOT ?>Show/showAddView/" class="btn btn-danger ml-auto d-block">Cancelar</a>
                        <button type="submit" class="btn btn-primary ml-3">Comprobar horario</button>
                    </div>
               </form>
          </div>
     </section>
</main>