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
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Show/showUpcomingShows?time=previous">Anteriores</a>
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Show/showUpcomingShows?time=upcoming">Próximas</a>
            </div>
        </li>
        <?php
        if (isset($_GET['time'])){
        ?>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (período): <?=$filter?></a>
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
                <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Película</th>
                        <th scope="col">Sala</th>
                        <th scope="col">Cine</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($showsList as $show){
                    ?>
                    <tr>
                        <th scope="row"><?=$show->getDate()?></th>
                        <td ><?=$show->getStartTime()?><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<br><?=$show->getEndTime()?></td>
                        <td><?=$show-> getMovie()-> getTitle()?></td>
                        <td><?=$show-> getRoom()-> getName()?></td>
                        <td><?=$show-> getRoom()-> getCinema()-> getName()?></td>
                        <td><button type="button" class="btn btn-primary btn-center" data-toggle="modal" data-target="#exampleModal" style="right-border-radius:20px;">Estadísticas</button></td>
                        <?php
                        if($show->getDate() < $today && $show-> getIsActive()){
                        ?>
                            <td><a href="<?php echo FRONT_ROOT ?>Show/removeShow/?showId=<?php echo $show->getID();?>" class="btn btn-danger btn-center" style="right-border-radius:20px;">Eliminar</a></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                    $i++;
                    }
                ?>
                </tbody>
            </table>
            
            <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="width: 700px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModal">Estadísticas de función</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col mb-3 movie-div">
                                <div class="card card-movie">
                                    <div class="card-body">
                                        <h5 class="card-title">Entradas vendidas</h5>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 54%;" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100">162/300</div>
                                        </div>
                                        <h5 class="card-title"><br>Entradas disponibles</h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 46%;" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100">128/300</div>
                                        </div>
                                        <h5 class="card-title"><br>Dinero recaudado</h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 54%;" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100">$72.900,00/$135.000,00</div>
                                        </div>
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