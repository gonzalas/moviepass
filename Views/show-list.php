<?php
    require_once('nav.php');
?>
<main class="py-5">
    <?php 
        if ($success == 1){
    ?>
            <div  class="alert alert-success alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong></div>
    <?php } ?>
    <h1 class="title">Funciones - MoviePass</h1>
    <ul class="nav justify-content-center nav-filters">
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtros de búsqueda:</a>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Período</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Show/showUpcomingShows?success=0&time=previous&genreID=-1">Anteriores</a>
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Show/showUpcomingShows?success=0&time=upcoming&genreID=-1">Próximas</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Género</a>
            <div class="dropdown-menu">
            <?php
                foreach ($genresList as $genre){ ?>
                    <a class="dropdown-item" href="<?=FRONT_ROOT?>Show/showUpcomingShows?success=0&time=0&genreID=<?=$genre->getID()?>"><?=$genre->getName()?></a>
            <?php
                }
            ?>
            </div>
        </li>

        <?php
        if (strcmp($time, "0") != 0){
        ?>
            <li class="nav-item">
            <?php if (strcmp($time, "previous") == 0){ ?> <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (período): Anteriores</a>
            <?php } ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=FRONT_ROOT?>Show/showUpcomingShows">Limpiar filtros</a>
            </li>
        <?php
        } elseif ($genreID != -1) {
        ?>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (género): <?=$filterGenre->getName()?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=FRONT_ROOT?>Show/showUpcomingShows">Limpiar filtros</a>
            </li>
        <?php
        }
        ?>
    </ul>
        <?php
            if (!$emptyList){
                ?>
                <table class="table table-hover table-dark" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Película</th>
                        <th scope="col">Sala</th>
                        <th scope="col">Cine</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($showsList as $show){
                    ?>
                    <tr>
                        <th scope="row"><?=date("d M Y", strtotime($show->getDate()));?></th>
                        <td ><?=$show->getStartTime()?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<br><?=$show->getEndTime()?></td>
                        <td><?=$show-> getMovie()-> getTitle()?></td>
                        <td><?=$show-> getRoom()-> getName()?></td>
                        <td><?=$show-> getRoom()-> getCinema()-> getName()?></td>
                        <td><button type="button" class="btn btn-warning btn-center" data-toggle="modal" data-target="#statisticsModal<?=$show->getID()?>" style="right-border-radius:20px;">Estadísticas</button></td>
                        <!-- <?php
                        /* if($show->getDate() < $today && $show-> getIsActive()){ */
                        ?>
                            <td><a href="<?php /* echo FRONT_ROOT */ ?>Show/removeShow/?showId=<?php /* echo $show->getID(); */?>" class="btn btn-danger btn-center" style="right-border-radius:20px;">Eliminar</a></td>
                        <?php
                        /* } */
                        ?> -->
                    </tr>
                    <div class="modal fade show" id="statisticsModal<?=$show->getID()?>" tabindex="-1" aria-labelledby="statisticsModal<?=$show->getID()?>" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content" style="width: 700px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statisticsModal<?=$show->getID()?>">Estadísticas de la función</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col mb-3 movie-div">
                                        <div class="card card-movie">
                                            <div class="card-body">
                                                <h5 class="card-title">Entradas vendidas: <?=$show->getSoldTickets()?>/<?=$show->getRoom()->getCapacity()?></h5>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: <?=$show->getSoldTickets() * 100/ $show-> getRoom()-> getCapacity()?>%;" aria-valuenow="<?=$show->getSoldTickets() * 100 / $show-> getRoom()-> getCapacity()?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <h5 class="card-title"><br>Entradas disponibles: <?=$show->getRoom()->getCapacity() - $show->getSoldTickets()?>/<?=$show->getRoom()->getCapacity()?></h5>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=($show->getRoom()->getCapacity() - $show->getSoldTickets()) * 100/ $show-> getRoom()-> getCapacity()?>%;" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <?php if ($show->getGatheredMoney()>0){ ?>
                                                    <h5 class="card-title"><br>Dinero recaudado*: $<?=$show->getGatheredMoney()?>/$<?=($show-> getRoom()-> getCapacity() * $show-> getRoom()-> getTicketValue())?></h5>
                                                <?php } else { ?>
                                                    <h5 class="card-title"><br>Dinero recaudado*: $0/$<?=($show-> getRoom()-> getCapacity() * $show-> getRoom()-> getTicketValue())?></h5>
                                                <?php } ?>
                                                
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?=$show->getGatheredMoney() * 100/ ($show-> getRoom()-> getCapacity() * $show-> getRoom()-> getTicketValue())?>%;" aria-valuenow="<?=$show->getGatheredMoney() * 100/ ($show-> getRoom()-> getCapacity() * $show-> getRoom()-> getTicketValue())?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="muted">* algunas entradas pueden contener descuentos</div>
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
                    }
                ?>
                </tbody>
            </table>
            
            
            <?php
            } else {
            ?>
            <div class="jumbotron jumbotron-fluid custom-jumbotron">
                <div class="container">
                    <h1 class="display-4">No hay funciones cargadas en este criterio.</h1>
                    <p class="lead">Lamentamos el inconveniente. Intenta cambiando el filtro de búsqueda o agregando funciones al sistema.</p>
                </div>
            </div>
            <?php
            }
            ?>
            
    
</main>