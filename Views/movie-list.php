<?php
    require_once('nav.php');
?>
<main class="py-5">
    <h1 class="title">Películas Actuales</h1>
    <ul class="nav justify-content-center nav-filters">
        <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtros de búsqueda:</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Géneros</a>
            <div class="dropdown-menu">
                <?php
                foreach ($apiGenresList as $genre){
                ?>
                    <a class="dropdown-item" href="<?=FRONT_ROOT?>Movie/showNowPlaying?genreID=<?=$genre["id"]?>"><?=$genre["name"]?></a>
                <?php
                }
                ?>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Ordenar por fecha</a>
        </li>
        <?php
        if (isset($_GET['genreID'])){
        ?>
            <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Filtro actual (ID): <?=$genreID?></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?=FRONT_ROOT?>Movie/showNowPlaying">Limpiar filtros</a>
            </li>
        <?php
        }
        ?>
    </ul>
        <?php
            if (count($apiMoviesList)){
                ?>
                <div class="row row-cols-1 row-cols-md-3">
                <?php
                foreach ($apiMoviesList as $movie){
                    ?>
                    <div class="col mb-4 movie-div">
                        <div class="card card-movie">
                            <img src="https://image.tmdb.org/t/p/w500<?=$movie["poster_path"]?>" class="card-image">
                            <div class="card-body">
                                <h5 class="card-title"><?=$movie["title"]?></h5>
                                <p class="pelicula"><?=$movie["overview"]?></p>
                                <p class="card-text"><small class="text-muted">Idioma: <?=$movie["original_language"]?></small></p>
                                <p class="card-text"><small class="text-muted">Género: <?=$movie["genre_ids"][0]?></small></p>
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