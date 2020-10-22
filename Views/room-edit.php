<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <?php if ($message != ""){
               if ($messageCode == 1){
                    $text = "success";
               } else{
                    $text = "danger";
               }
          ?>
               <div  class="alert alert-<?php echo $text?> alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
               </div>
          <?php } ?>
          <div class="container white-font">
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
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Precio de entrada (actual: <?php echo $room-> getTicketValue()?>)</label>
                                   <input type="text" name="ticketValue" value="<?php echo $room-> getTicketValue()?>" class="form-control" required>
                              </div>
                         </div>
                    </div>
                    
                    <div class="d-flex flex-row-reverse">
                         <a class="btn btn-danger p-2" href= "<?php echo FRONT_ROOT ?>Cinema/showListView" > Cancelar </a>
                         <button type="submit" class="btn btn-success ml-auto p-2 mr-4">Confirmar</button>
                    </div>
                    
               </form>
          </div>
     </section>
</main>