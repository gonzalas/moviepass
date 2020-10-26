<?php
    require_once('nav.php');
?>
<main class="py-5">
    <section id="detalle" class="mb-5">
        <div class="container">
        <h1 class="title">Información de la película elegida</h1>
            <table class="table table-bordered table-striped table-light">
                <thead class="text-center align-middle">
                    <tr>
                        <th style="width: 100px;" class="align-middle">Título</th>
                        <th style="width: 50px;" class="align-middle">Fecha de Lanzamiento</th>
                        <th style="width: 50px;" class="align-middle">Duración</th>
                        <th style="width: 50px;" class="align-middle">Idioma original</th>
                        <th style="width: 50px;" class="align-middle">Géneros</th>
                        <th style="width: 50px;" class="align-middle">Promedio de Votos</th>
                        <th class="align-middle">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$movie->getTitle()?></td>
                        <td><?=$movie->getReleaseDate()?></td>
                        <td><?=$movie->getLength()." min."?></td>
                        <td><?=$movie->getLanguage()?></td>
                        <td><?php 
                            foreach ($movie->getGenres() as $genre){
                                echo $genre["name"]."<br>";
                            }
                        ?></td>
                        <td><?=$movie->getVoteAverage()?></td>
                        <td><?=$movie->getOverview()?></td>    
                    </tr>
                </tbody>
            </table>
            <div class="btn-group" role="group" aria-label="Basic example" style="width:100%;">
                <a href="<?php echo FRONT_ROOT ?>Movie/showNowPlaying" type="button" class="btn btn-danger" style="border-radius:0px;">Cancelar</button></a>
                <a href="<?php echo FRONT_ROOT ?>Movie/addMovie/?movieId=<?php echo $movie->getID();?>" type="button" class="btn btn-success" style="border-radius:0px;">Confirmar</button></a>
            </div>
        </div>
    </section>
</main>