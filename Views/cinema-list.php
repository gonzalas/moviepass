<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div>
          <?php 
               if ($messageCode == 1 || $messageCode == 3){
          ?>
                    <div  class="alert alert-success alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong></div>
          <?php } else {
                    if ($messageCode == 2 || $messageCode == 4){
               ?>
                    <div  class="alert alert-danger alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong></div>
          <?php
               }
          } ?>
               <h1 class="title">Listado de cines</h1>
               <ul class="nav justify-content-center nav-filters">
                    <li class="nav-item">
                         <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Opciones de listado:</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cines</a>
                         <div class="dropdown-menu">
                              <a class="dropdown-item" href="<?=FRONT_ROOT?>Cinema/showListView?filter=all">Todos</a>
                              <a class="dropdown-item" href="<?=FRONT_ROOT?>Cinema/showListView?filter=removed">Eliminados</a>
                         </div>
                    </li>
                    <?php
                    if (isset($_GET['filter'])){
                    ?>
                         <li class="nav-item">
                         <?php if (strcmp($_GET['filter'], "all") == 0){ ?> <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual: Todos</a>
                         <?php } else { ?> <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual: Eliminados</a>
                         <?php } ?>
                         </li>
                         <li class="nav-item">
                         <a class="nav-link" href="<?=FRONT_ROOT?>Cinema/showListView">Limpiar filtros</a>
                         </li>
                    <?php
                    }
                    ?>
               </ul>
               <?php if (!empty($cinemasList)){ ?>
               <form action="<?php echo FRONT_ROOT."Cinema/removeCinema"?>">
                    <table class="table table-hover table-dark">
                         <thead>
                              <tr>
                                   <th scope="col">Nombre</th>
                                   <th scope="col">Dirección</th>
                                   <th scope="col">Capacidad Total</th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php
                                   foreach($cinemasList as $cinema)
                                   {
                              ?>
                                   <tr>
                                        <th scope="row"><?php echo $cinema-> getName() ?></td>
                                        <td><?php echo $cinema-> getAddress() ?></td>
                                        <td><?php echo $cinema-> getTotalCapacity()?></td>
                                        <td>
                                             <input type="button" value="Ver salas" id="ac-btn" class="btn btn-info" onClick="toggleRoom(<?php echo $cinema-> getID()?>)"></input>
                                        </td>
                                        <td>
                                             <a class="btn btn-success" href= "<?php echo FRONT_ROOT ?>Cinema/showEditView/?id=<?php echo $cinema->getID();?>" > Editar </a>
                                        </td>
                                        <?php
                                        if ($cinema-> getIsActive()){
                                        ?>
                                             <td>
                                                  <button type="submit" name="id" class="btn btn-danger" onClick="confirmDelete(<?php echo $cinema-> getID()?>)" id="btnDelete<?php echo $cinema-> getID()?>"> Eliminar </button>
                                             </td>
                                        <?php
                                        } else {
                                        ?>
                                             <td>
                                                  <a class="btn btn-success" href= "<?php echo FRONT_ROOT ?>Cinema/retrieveCinema/?id=<?php echo $cinema->getID();?>" > Dar de alta </a>
                                             </td>
                                        <?php
                                        }
                                        ?>
                                   </tr>
                                   <?php
                                        require('room-list.php');
                                   }
                              ?>
                         </tbody>
                    </table>
               </form>
               <?php } else { ?>
                    <div class="jumbotron jumbotron-fluid custom-jumbotron">
                         <div class="container">
                         <h1 class="display-4">No hay cines cargados en este criterio.</h1>
                         <p class="lead">Lamentamos el inconveniente. Intenta cambiando el filtro de búsqueda o agregando cines al sistema.</p>
                         </div>
                    </div>
                <?php
                    }
                ?>
          </div>
     </section>
</main>