<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div>
          <?php 
               if ($messageCode == 3 || $messageCode == 4 || $messageCode == 5|| $messageCode == 7 || $messageCode == 8 ){
          ?>
                    <div  class="alert alert-success alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong>
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
               </div>
          <?php } else {
                    if ($messageCode == 1 || $messageCode == 2|| $messageCode == 6){
               ?>
                    <div  class="alert alert-danger alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong>
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
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
                              <a class="dropdown-item" href="<?=FRONT_ROOT?>Cinema/showListView/?messageCode=0&filter=all">Todos</a>
                              <a class="dropdown-item" href="<?=FRONT_ROOT?>Cinema/showListView/?messageCode=0&filter=removed">Eliminados</a>
                         </div>
                    </li>
                    <?php
                    if ($filter != ""){
                    ?>
                         <li class="nav-item">
                         <?php if ($filter == "all"){ ?> <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual: Todos</a>
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
                                   <th scope="col"></th>
                                   <th scope="col"></th>
                                   <th scope="col"></th>
                                   <th scope="col"></th>
                              </tr>
                         </thead>
                         <tbody>
                              <?php
                                   foreach($cinemasList as $cinema)
                                   {
                              ?>
                                   <tr>
                                        <td scope="row"><?php echo $cinema-> getName() ?></td>
                                        <td><?php echo $cinema-> getAddress() ?></td>
                                        <td><?php echo $cinema-> getTotalCapacity()?></td>
                                        <td>
                                             <input type="button" value="Ver salas" id="ac-btn" class="btn btn-info" onClick="toggleRoom(<?php echo $cinema-> getID()?>)"></input>
                                        </td>
                                        <td>
                                             <button type="button" class="btn btn-warning btn-center" data-toggle="modal" data-target="#statisticsModal<?=$cinema-> getID()?>">Estadísticas</button>
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
                                   <div class="modal fade show" id="statisticsModal<?=$cinema->getID()?>" tabindex="-1" aria-labelledby="statisticsModal<?=$cinema->getID()?>" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                             <div class="modal-content" style="width: 700px;">
                                                  <div class="modal-header">
                                                       <h5 class="modal-title" id="statisticsModal<?=$cinema->getID()?>">Estadísticas del cine</h5>
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                       <span aria-hidden="true">×</span>
                                                       </button>
                                                  </div>
                                                  <div class="modal-body">
                                                       <div class="col mb-3 movie-div">
                                                            <div class="card card-movie">
                                                            <div class="card-body">
                                                                 <?php if ($cinema-> getTotalPossibleMoney() != 0){ ?>
                                                                      <h5 class="card-title">Entradas vendidas: <?=$cinema->getSoldTickets()?>/<?=$cinema->getTotalShowsCapacity()?></h5>
                                                                      <div class="progress">
                                                                           <div class="progress-bar" role="progressbar" style="width: <?=$cinema->getSoldTickets() * 100/ $cinema->getTotalShowsCapacity()?>%;" aria-valuenow="<?=$cinema->getSoldTickets() * 100 / $cinema->getTotalShowsCapacity()?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                      <h5 class="card-title"><br>Entradas disponibles: <?=$cinema->getTotalShowsCapacity() - $cinema->getSoldTickets()?>/<?=$cinema->getTotalShowsCapacity()?></h5>
                                                                      <div class="progress">
                                                                           <div class="progress-bar bg-danger" role="progressbar" style="width: <?=($cinema->getTotalShowsCapacity() - $cinema->getSoldTickets()) * 100/ $cinema-> getTotalShowsCapacity()?>%;" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                      <?php if ($cinema->getGatheredMoney()>0){ ?>
                                                                           <h5 class="card-title"><br>Dinero recaudado*: $<?=$cinema->getGatheredMoney()?>/$<?=$cinema-> getTotalPossibleMoney()?></h5>
                                                                      <?php } else { ?>
                                                                           <h5 class="card-title"><br>Dinero recaudado*: $0/$<?=$cinema->getTotalPossibleMoney()?></h5>
                                                                      <?php } ?>
                                                                      <div class="progress">
                                                                           <div class="progress-bar bg-success" role="progressbar" style="width: <?=$cinema->getGatheredMoney() * 100/ $cinema-> getTotalPossibleMoney()?>%;" aria-valuenow="<?=$cinema->getGatheredMoney() * 100/ $cinema-> getTotalPossibleMoney()?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                      <div class="muted">* algunas entradas pueden contener descuentos</div>
                                                                 <?php } else { ?>
                                                                      <div class="jumbotron jumbotron-fluid custom-jumbotron">
                                                                           <div class="container">
                                                                                <h1 class="display-4">No hay funciones cargadas para este cine.</h1>
                                                                                <p class="lead">Lamentamos el inconveniente. Intenta agregando funciones al sistema.</p>
                                                                           </div>
                                                                      </div>
                                                                 <?php } ?>
                                                            </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
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