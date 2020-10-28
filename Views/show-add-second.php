<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h1 class="title">Selección de sala para la Función</h1>
               <form action="<?php echo FRONT_ROOT ?>Show/addShowThirdForm" method="post" class="bg-light-alpha white-font p-5">                       
                    <div id="accordion">
                        <?php
                            foreach($cinemasList as $cinema){
                        ?>
                            <div class="card bg-light-alpha">
                                <div class="card-header cinema-card-title" id="heading<?=$cinema->getID()?>">
                                    <?=$cinema->getName()?>
                                    <input type="button" value="Ver salas" id="ac-btn" class="btn btn-info float-right" onClick="toggleRoom(<?php echo $cinema-> getID()?>)"></input>
                                </div>
                                <div id="collapse<?=$cinema->getID()?>" class="animate__animated animate__fadeIn accordion-child<?php echo $cinema-> getID()?>" aria-labelledby="heading<?=$cinema->getID()?>" data-parent="#accordion" style="display:none;">
                                    <div class="card-body">
                                        <?php
                                            foreach($cinema-> getRooms() as $room){
                                        ?>
                                            <input type="radio" id="room<?=$room->getID()?>" name="roomID" value="<?=$room->getID()?>" required>
                                            <label for="room<?=$room->getID()?>"><?=$room->getName()?></label><br>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        ?> 
                    </div>
                    <input type="hidden" name="showDate" value="<?php echo $showDate?>">
                    <input type="hidden" name="movieID" value="<?php echo $movieID?>">
                    <div class="row">
                        <a type="" class="btn btn-danger ml-auto d-block">Cancelar</a>
                        <button type="submit" class="btn btn-primary ml-3 mr-4">Continuar</button>
                    </div>
               </form>
          </div>
     </section>
</main>