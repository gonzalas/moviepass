<?php
    require_once('nav.php');
?>
<main class="py-5">
<div class="row row-cols-1 row-cols-md-2">
            <?php
                foreach ($apiMoviesList as $movie){
                    ?>
                    <div class="col mb-4">
                        <div class="card">
                            <img src="https://image.tmdb.org/t/p/w500<?=$movie["poster_path"]?>" class="card-image">
                            <div class="card-body">
                                <h5 class="card-title"><?=$movie["title"]?></h5>
                                <p class="pelicula"><?=$movie["overview"]?></p>
                                <p class="card-text"><small class="text-muted">Idioma: <?=$movie["original_language"]?></small></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
</main>