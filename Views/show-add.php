<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
            <?php 
                if ($messageCode == 1){
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong></div>
            <?php } else {
                        if ($messageCode == 2){
            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong></div>
            <?php
                        }
            } ?>
          <div class="container">
          <?php if($cinemaList != null){
                    if ($moviesList != null){
          ?>
               <h1 class="title">Agregar nueva Función</h1>
               <form action="<?php echo FRONT_ROOT ?>Show/addShowSecondForm" method="post" class="bg-light-alpha white-font p-5">                       
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="movieSelection">Película (si una película no aparece, probá dándola de alta)</label>
                            <select class="form-control" id="movieSelection" name="movieID" required>
                            <?php foreach($moviesList as $movie){
                                ?>
                                <option value="<?=$movie->getID()?>"><?=$movie->getTitle()?></option>
                            <?php
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="dateSelection">Día (recordá que una película se proyecta en una sala al día)</label><br>
                            <input type="date" id="dateSelection" name="showDate" value="<?=date("Y-m-d");?>" min="<?=date("Y-m-d");?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark ml-auto d-block">Continuar</button>
               </form>
          </div>
          <?php } else { ?>
                    <div class="jumbotron jumbotron-fluid custom-jumbotron">
                         <div class="container">
                         <h1 class="display-4">No hay películas activas cargadas en el sistema.</h1>
                         <p class="lead">Lamentamos el inconveniente. Intenta agregando películas al sistema.</p>
                         </div>
                    </div>
                <?php
                    }
                ?>
          <?php } else { ?>
                    <div class="jumbotron jumbotron-fluid custom-jumbotron">
                         <div class="container">
                         <h1 class="display-4">No hay salas activas cargadas en el sistema.</h1>
                         <p class="lead">Lamentamos el inconveniente. Intenta agregando salas al sistema.</p>
                         </div>
                    </div>
                <?php
                    }
                ?>
     </section>
</main>