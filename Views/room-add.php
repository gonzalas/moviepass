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
               <h2 class="mb-4">Agregar nueva Sala</h2>
               <form action="<?php echo FRONT_ROOT ?>Room/addRoom" method="post" class="bg-light-alpha p-5">
                    <div class="row">                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                    <input type="hidden" name="cinemaID" value="<?php echo $cinemaId?>">
                                    <label for="">Nombre</label>
                                    <input type="text" name="name" class="form-control" required autofocus>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                    <label for="">Capacidad de sala</label>
                                    <input type="number" name="capacity" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                    <label for="">Precio único de entrada</label>
                                    <input type="text" name="ticketValue" class="form-control" required autofocus>
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         <a href="<?php echo FRONT_ROOT ?>Cinema/showListView/" class="btn btn-danger ml-auto d-block">Cancelar</a>
                         <button type="submit" class="btn btn-primary ml-3">Agregar</button>
                    </div>
               </form>
          </div>
     </section>
</main>