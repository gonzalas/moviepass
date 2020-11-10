<?php
    use Helpers\LanguageConverter as LanguageConverter;
    Helpers\SessionValidatorHelper::ValidateUserNav();
?>

<style>
    body {
        background-image: linear-gradient(to right, #ba001f, red);
        }
    img#back-img-movie {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 0;
        max-height: 200vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
    img#back-img-movie-2 {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 200vh;
        max-height: 150vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
    #img-detail-poster {
        max-height: 800px;
        width: 100%;
        object-fit: cover;
        object-position: top;
    } 
    #available-shows img{
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 200vh;
        max-height: 100vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
</style>

<section class="container" style="width: 40%; max-width:90%;">
    <img id="back-img-movie" src="<?php echo API_IMG.$movieSelected->getImage(); ?>" alt="Poster">
    <div>
        <h1 class="mt-3 p-4" style="color: white; font-weight: 700; text-align: center;">Detalles de la película</h1>
    </div>
    <div class="card mb-3">
        <img class="card-img-top" src="<?php echo API_IMG.$movieSelected->getImage(); ?>" alt="Poster">
        <div class="card-body" style="margin-bottom: 20px;">
            <h4 class="card-title"><?php echo $movieSelected->getTitle(); ?></h4>
            <p class="card-text"><small class="text-muted"><?php foreach ($movieSelected-> getGenres() as $genre){ echo $genre->getName() . " | "; } ?></small></p>
            <p class="card-text"><small class="text-muted">Idioma: <?php echo LanguageConverter::Convert($movieSelected->getLanguage()); ?></small></p>
            <p class="card-text"><b><?php echo $movieSelected->getOverview(); ?></b></p>
            <p class="card-text">Estreno: <?php echo date("d M Y", strtotime($movieSelected->getReleaseDate())); ?></p>
            <p class="card-text">Duración: <?php echo $movieSelected->getLength(); ?> minutos.</p>
            <p class="card-text">Rating: <?php echo $movieSelected->getVoteAverage(); ?> / 10</p>
        </div>
        <div style="right: 0; position: absolute; bottom: 0; display: flex;">
            <button type="button" class="btn btn-dark" style="width: 150px; padding: 10px;" onClick="showModalTrailer()">Trailer</button>
        </div>
    </div>
</section>


<div id="trailer-modal" class="modal modal-trailer animate__animated animate__fadeInDown" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Trailer</h5>
      </div>
      <?php if($movieSelected->getTrailer()){ 
            
        ?>
            <div class="modal-body">
                <?php echo preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width=\"470\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",$movieSelected->getTrailer());  ?>
            </div>
        <?php } else {?>
            <div class="modal-body">
                <h4>Trailer no disponible.</h4>
            </div>
        <?php } ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="closeModalTrailer()">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<section class="container" style="width: 80%; max-width: 90%; margin-top: 8%;">
    <img id="back-img-movie-2" src="<?php echo API_IMG.$movieSelected->getImage(); ?>" alt="Poster">
    <div>
        <h1 class="mt-3 p-4" style="color: white; font-weight: 700; text-align: center;">Funciones disponibles para <?php echo $movieSelected->getTitle();?></h1>
    </div>
    <table class="table table-hover table-dark" style="text-align: center;">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Cine</th>
                <th scope="col">Sala</th>
                <th scope="col">Precio por entrada</th>
                <th scope="col"></th>
            </tr>
        </thead>
        
        <?php
        if(is_array($showsList)){
            for($i = 0; $i < count($showsList); $i++){  
                ?>
        <tbody>
                <tr>
                    <th scope="row"><?=date("d M Y", strtotime($showsList[$i]->getDate()));?></th>
                    <td><?=$showsList[$i]->getStartTime()?><br>-<br><?=$showsList[$i]->getEndTime()?></td>
                    <td><?=$cinemaList[$i]->getName()?></td>
                    <td><?=$roomList[$i]-> getName()?></td>
                    <td>$<?=$roomList[$i]-> getTicketValue()?></td>
                    <td><a href="<?php echo FRONT_ROOT ?>Ticket/showBuyTicketView/?showId=<?php echo $showsList[$i]->getID();?>" class="btn btn-primary btn-center" style="right-border-radius:20px;">Comprar Entradas</button></td>
                </tr>
        </tbody>
        <?php
            }
         } else { 
             
        ?>
        <tbody>
                <tr>
                    <th scope="row"><?=date("d M Y", strtotime($showsList->getDate()));?></th>
                    <td><?=$showsList->getStartTime()?><br>-<br><?=$showsList->getEndTime()?></td>
                    <td><?=$cinema-> getName()?></td>
                    <td><?=$room-> getName()?></td>
                    <td>$<?=$room-> getTicketValue()?></td>
                    <td><a href="<?php echo FRONT_ROOT ?>Ticket/showBuyTicketView/?showId=<?php echo $showsList->getID();?>" class="btn btn-primary btn-center" style="right-border-radius:20px;">Comprar Entradas</button></td>
                </tr>
        </tbody>
        <?php
            } 
        ?>
    </table>

</section>

<script>
    function showModalTrailer(){
        document.getElementById("trailer-modal").style.display = "block";
    }
    function closeModalTrailer(){
        document.getElementById("trailer-modal").style.display = "none";
    }
</script>