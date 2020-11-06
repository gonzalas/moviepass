<?php
    require_once('nav.php');
?>
<main class="py-5">
    <?php 
    if ($messageCode != -1){
        if ($message != ""){
            if ($messageCode > 0){
                $text = "danger";
            } else{
                $text = "success";
            } 
    }
    ?>
    
        <div  class="alert alert-<?php echo $text?> alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong>
            <?php if ($messageCode == 2){
                ?>
                <a href="<?php echo FRONT_ROOT ?>Movie/retrieveMovie/?movieId=<?php echo $_GET['movieId']?>" type="button" class="btn btn-success btn-center" style="left-border-radius:20px;">Dar de alta</button></a>
            <?php }?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <h1 class="title">Películas Actuales (API)</h1>
    <ul class="nav justify-content-center nav-filters">
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtros de búsqueda:</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Géneros</a>
            <div class="dropdown-menu">
                <?php
                foreach ($genresList as $genre){
                ?>
                    <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showNowPlaying?genreID=<?=$genre->getID()?>"><?=$genre->getName()?></a>
                <?php
                }
                ?>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Ordenar por fecha</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showNowPlaying?orderByDate=0">Más recientes primero</a>
                <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showNowPlaying?orderByDate=1">Más viejas primero</a>
            </div>
        </li>
        <?php
        if (isset($_GET['genreID'])){
        ?>
            <li class="nav-item">
            <a class="nav-link disabled" href="<?=FRONT_ROOT?>Movie/showNowPlaying?genreID=<?php echo $_GET['genreID'] ?>" tabindex="-1" aria-disabled="true">Filtro actual (género): <?=$genreFilterName?></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?=FRONT_ROOT?>Movie/showNowPlaying">Limpiar filtros</a>
            </li>
        <?php
        }
        ?>
        <?php
        if (isset($_GET['orderByDate'])){
            if ($_GET['orderByDate'] == 1){
                $moviesList = $this-> orderMoviesByDate($moviesList);
                ?>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (fecha): más viejas primero.</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=FRONT_ROOT?>Movie/showNowPlaying">Limpiar filtros</a>
                </li>
            <?php
            } else if ($_GET['orderByDate'] == 0){
                ?>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (fecha): más recientes primero.</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=FRONT_ROOT?>Movie/showNowPlaying">Limpiar filtros</a>
                </li>
            <?php
            }
        ?>
            
        <?php
        }
        ?>
    </ul>
        <?php
            if (count($moviesList)){
                ?>
                <div class="row row-cols row-cols-md-2">
                <?php
                foreach ($moviesList as $movie){
                    ?>
                    <div class="col mb-3 movie-div">
                        <div class="card card-movie">
                        <a href="" class="image-movie">
                        <img src="https://image.tmdb.org/t/p/w500<?=$movie-> getImage()?>" class="card-image">
                        </a>
                            <div class="card-body">
                                <h5 class="card-title"><?=$movie-> getTitle()?></h5>
                                <p class="pelicula"><?=$movie-> getOverview()?></p>
                                <p class="card-text"><small class="text-muted">Idioma: <?=$movie-> getLanguage()?></small></p>
                                <p class="card-text"><small class="text-muted">Fecha de lanzamiento: <?=$movie-> getReleaseDate()?></small></p>
                                <p class="card-text"><small class="text-muted">Géneros: 
                                <?php
                                    foreach($movie-> getGenres() as $genre){
                                        echo $genre-> getName();
                                        echo ". ";
                                    }
                                    ?>
                                </small></p>
                            </div>
                            <div class="row" >
                                <div class="col-md-12 text-center" >
                                    <div class="btn-group btn-group-lg" style="width:95%;">
                                        <a class="btn btn-block btn-dark" href= "<?php echo FRONT_ROOT ?>Movie/showAddView/?movieId=<?php echo $movie-> getID()?>">Añadir al sistema </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                <?php
                }
            ?>
            </div>
            <?php
            } else {
            ?>
            <div class="jumbotron jumbotron-fluid custom-jumbotron">
                <div class="container">
                    <h1 class="display-4">No hay películas en esta categoría.</h1>
                    <p class="lead">Lamentamos el inconveniente. Intenta cambiando el filtro de búsqueda.</p>
                </div>
            </div>
            <?php
            }
            ?>
            
    
</main>