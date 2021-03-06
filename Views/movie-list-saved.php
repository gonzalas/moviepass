<?php
    require_once('nav.php');
    use Helpers\LanguageConverter as LanguageConverter;
?>
<main class="py-5">
    <?php if (strcmp($message, "0") != 0){
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
    <h1 class="title">Películas guardadas en el Sistema</h1>
    <ul class="nav justify-content-center nav-filters">
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtros de búsqueda:</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="#">Ordenar por fecha</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Validez</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showSavedMovies/?message=0&messageCode=0&validity=all">Todas</a>
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showSavedMovies/?message=0&messageCode=0&validity=active">Activas</a>
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showSavedMovies/?message=0&messageCode=0&validity=deleted">Eliminadas</a>
            </div>
        </li>
        <?php
        if (isset($_GET['genreID'])){
        ?>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (ID): <?=$genreID?></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?=FRONT_ROOT?>Movie/showSavedMovies">Limpiar filtros</a>
            </li>
        <?php
        }
        ?>
    </ul>
        <?php
            if (!$emptyList){
                ?>
                <table class= "movie-table">
                <tbody>
                <?php
                foreach ($moviesList as $movie){
                    ?>
                    <tr class="tr-movie">
                        <td class="wi62">
                            <div stlye="height: 35px; border: 2px solid white(0, 0, 0, 0.125);">
                                <div class="img_top_div">
                                    <img src="https://image.tmdb.org/t/p/w500<?=$movie-> getImage()?>" class="img_top_img">
                                </div>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="table-movie-title">
                                <?=$movie-> getTitle()?>
                            </div>
                        </td>
                        <td class="tac dn600 wi74">
                            <div class="row" >
                                <div class="col-md-12 text-center" >
                                    <div class="btn-group btn-group-lg" style="width:80%;">
                                        <?php
                                        if (!$movie->getIsActive()){ ?>
                                            <a href="<?php echo FRONT_ROOT ?>Movie/retrieveMovie/?movieId=<?php echo $movie-> getID()?>" type="button" class="btn btn-success btn-center" style="left-border-radius:20px; width:25%;">Dar de alta</button></a>
                                        <?php } else { ?>
                                            <a href="<?php echo FRONT_ROOT ?>Movie/removeMovie/?movieId=<?php echo $movie-> getID()?>" type="button" class="btn btn-danger btn-center" style="left-border-radius:20px; width:25%;">Eliminar</button></a>
                                        <?php } ?>
                                        <button type="button" class="btn btn-secondary btn-center" data-toggle="modal" data-target="#detailsModal<?=$movie->getID()?>" style="right-border-radius:20px; width:25%;">Ver detalles</button>
                                        <button type="button" class="btn btn-warning btn-center" data-toggle="modal" data-target="#statisticsModal<?=$movie->getID()?>" style="right-border-radius:20px; width:25%;">Estadísticas</button>
                                        <a href="<?php echo FRONT_ROOT ?>Movie/showEditView/?movieId=<?php echo $movie-> getID()?>" type="button" class="btn btn-primary btn-center" style="right-border-radius:20px; width:25%;">Editar</button></a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade show" id="detailsModal<?=$movie->getID()?>" tabindex="-1" aria-labelledby="detailsModal" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content" style="width: 700px;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModal"><?=$movie->getTitle()?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col mb-3 movie-div">
                                    <div class="card card-movie">
                                    <img src="https://image.tmdb.org/t/p/w500<?=$movie-> getImage()?>" class="card-image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?=$movie-> getTitle()?></h5>
                                            <p><?=$movie-> getOverview()?></p>
                                            <p class="card-text"><small class="text-muted">Fecha de lanzamiento: <?=$movie-> getReleaseDate()?></small></p>
                                            <p class="card-text"><small class="text-muted">Idioma: <?=LanguageConverter::Convert($movie-> getLanguage())?></small></p>
                                            <p class="card-text"><small class="text-muted">Géneros: 
                                            <?php
                                                foreach($movie-> getGenres() as $genre){
                                                    echo $genre-> getName();
                                                    echo ". ";
                                                }
                                            ?>
                                            </small></p>
                                            <p class="card-text"><small class="text-muted">Duración: <?=$movie-> getLength()?> minutos</small></p>
                                            <p class="card-text"><small class="text-muted">Promedio de votos: <?=$movie-> getVoteAverage()?></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="<?php echo FRONT_ROOT ?>Movie/showEditView/?movieId=<?php echo $movie-> getID()?>" type="button" class="btn btn-primary">Editar</button></a>
                                <?php if ($movie-> getTrailer() != null){
                                    ?>
                                    <a href="<?=$movie->getTrailer()?>" target="_blank" type="button" class="btn btn-danger"> Ver trailer </a>
                                    <?php
                                }
                                ?>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade show" id="statisticsModal<?=$movie->getID()?>" tabindex="-1" aria-labelledby="statisticsModal<?=$movie->getID()?>" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content" style="width: 700px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statisticsModal<?=$movie->getID()?>">Estadísticas de la función</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col mb-3 movie-div">
                                        <div class="card card-movie">
                                            <div class="card-body">
                                                <?php if ($movie-> getTotalPossibleMoney() != 0){ ?>
                                                    <h5 class="card-title">Entradas vendidas: <?=$movie->getSoldTickets()?>/<?=$movie->getTotalCapacity()?></h5>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: <?=$movie->getSoldTickets() * 100/ $movie->getTotalCapacity()?>%;" aria-valuenow="<?=$movie->getSoldTickets() * 100 / $movie->getTotalCapacity()?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <h5 class="card-title"><br>Entradas disponibles: <?=$movie->getTotalCapacity() - $movie->getSoldTickets()?>/<?=$movie->getTotalCapacity()?></h5>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?=($movie->getTotalCapacity() - $movie->getSoldTickets()) * 100/ $movie-> getTotalCapacity()?>%;" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <?php if ($movie->getGatheredMoney()>0){ ?>
                                                        <h5 class="card-title"><br>Dinero recaudado*: $<?=$movie->getGatheredMoney()?>/$<?=$movie-> getTotalPossibleMoney()?></h5>
                                                    <?php } else { ?>
                                                        <h5 class="card-title"><br>Dinero recaudado*: $0/$<?=$movie->getTotalPossibleMoney()?></h5>
                                                    <?php } ?>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?=$movie->getGatheredMoney() * 100/ $movie-> getTotalPossibleMoney()?>%;" aria-valuenow="<?=$movie->getGatheredMoney() * 100/ $movie-> getTotalPossibleMoney()?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="muted">* algunas entradas pueden contener descuentos</div>
                                                <?php } else { ?>
                                                    <div class="jumbotron jumbotron-fluid custom-jumbotron">
                                                        <div class="container">
                                                            <h1 class="display-4">No hay funciones cargadas para esta película.</h1>
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
                }
            ?>
            </tbody>
            </table>
            <?php
            } else {
            ?>
            <div class="jumbotron jumbotron-fluid custom-jumbotron">
                <div class="container">
                    <h1 class="display-4">No hay películas cargadas en esta categoría.</h1>
                    <p class="lead">Lamentamos el inconveniente. Intenta cambiando el filtro de búsqueda o agregando películas al sistema.</p>
                </div>
            </div>
            <?php
            }
            ?>
            
    
</main>