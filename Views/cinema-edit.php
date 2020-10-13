<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <?php if ($message != ""){ ?>
               <div class="alert alert-danger" role="alert"> <?php echo $message?> </div>
          <?php } ?>
          <div class="container">
               <h2 class="mb-4">Editar Cine</h2>
               <form action="<?php echo FRONT_ROOT ?>Cinema/editCinema" method="post" class="bg-light-alpha p-5">
                    <div class="row">                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <input type="hidden" name="id" value="<?php echo $cinema-> getID()?>">
                                   <label for="">Nombre (actual: <?php echo $cinema-> getName()?>)</label>
                                   <input type="text" name="name" value="<?php echo $cinema-> getName()?>" class="form-control" required autofocus>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Precio de entrada (actual: <?php echo $cinema-> getTicketValue()?>)</label>
                                   <input type="text" name="ticketValue" value="<?php echo $cinema-> getTicketValue()?>" class="form-control" required>
                              </div>
                         </div>
                    </div>
                    <button type="submit" class="btn btn-dark ml-auto d-block">Editar</button>
               </form>
          </div>
     </section>
</main>