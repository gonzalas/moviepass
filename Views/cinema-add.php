<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <?php if ($message != ""){ ?>
               <div class="alert alert-danger" role="alert"> <?php echo $message?> </div>
          <?php } ?>
          <div class="container">
               <h1 class="title">Agregar nuevo Cine</h1>
               <form action="<?php echo FRONT_ROOT ?>Cinema/addCinema" method="post" class="bg-light-alpha white-font p-5">
                    <div class="row">                         
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Nombre</label>
                                   <input type="text" name="name" class="form-control" required autofocus>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Dirección del Cine</label>
                                   <input type="text" name="address" class="form-control" required>
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