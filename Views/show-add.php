<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <?php if ($message != ""){ ?>
               <div class="alert alert-danger" role="alert"> <?php echo $message?> </div>
          <?php } ?>
          <div class="container">
               <h1 class="title">Agregar nueva Función</h1>
               <form action="<?php echo FRONT_ROOT ?>Show/addShow" method="post" class="bg-light-alpha white-font p-5">                       
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cinemaSelection">Cine (si un cine no aparece, probá agregándole salas)</label>
                            <select class="form-control" id="cinemaSelection" name="cinemaID">
                            <?php foreach($cinemasList as $cinema){
                                ?>
                                <option value="<?=$cinema->getID()?>"><?=$cinema->getName()?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="movieSelection">Película (si una película no aparece, probá dándola de alta)</label>
                            <select class="form-control" id="movieSelection" name="movieID">
                            <?php foreach($moviesList as $movie){
                                ?>
                                <option value="<?=$movie->getID()?>"><?=$movie->getTitle()?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark ml-auto d-block">Continuar</button>
               </form>
          </div>
     </section>
</main>