<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <?php if ($message != ""){ ?>
               <div class="alert alert-danger" role="alert"> <?php echo $message?> </div>
          <?php } ?>
          <div class="container">
               <h2 class="mb-4">Editar Sala</h2>
               <form action="<?php echo FRONT_ROOT ?>Room/editRoom" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <input type="hidden" name="id" value="<?php echo $room-> getID()?>">
                                   <label for="">Nombre (actual: <?php echo $room-> getName()?>)</label>
                                   <input type="text" name="name" value="<?php echo $room-> getName()?>" class="form-control" required autofocus>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Capacidad (actual: <?php echo $room-> getCapacity()?>)</label>
                                   <input type="text" name="capacity" value="<?php echo $room-> getCapacity()?>" class="form-control" required>
                              </div>
                         </div>
                    </div>
                    <button type="submit" class="btn btn-dark ml-auto d-block">Editar</button>
               </form>
          </div>
     </section>
</main>