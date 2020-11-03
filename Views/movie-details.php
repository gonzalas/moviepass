<?php
    require_once("nav-client.php"); 
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
    #img-detail-poster {
        max-height: 800px;
        width: 100%;
        object-fit: cover;
    } 
</style>

<section class="container">
    <img id="back-img-movie" src="<?php echo API_IMG.$movieSelected->getImage(); ?>" alt="Poster">
    <div>
        <h1 class="mt-3 p-4" style="color: #e88e9d; font-weight: 700;">Detalles de la película</h1>
    </div>
    <div class="card mb-3">
        <img id="img-detail-poster" class="card-img-top" src="<?php echo API_IMG.$movieSelected->getImage(); ?>" alt="Poster">
        <div class="card-body" style="margin-bottom: 20px;">
            <h5 class="card-title"><?php echo $movieSelected->getTitle(); ?></h5>
            <p class="card-text"><?php echo $movieSelected->getOverview(); ?></p>
            <p class="card-text"><small class="text-muted">Lanzamiento: <?php echo $movieSelected->getReleaseDate(); ?></small></p>
        </div>
        <div style="right: 0; position: absolute; bottom: 0;">
            <button type="button" class="btn btn-dark" style="width: 150px; padding: 10px;" onClick="showModalTrailer()">Trailer</button>
            <button type="button" class="btn btn-primary" style="width: 150px; padding: 10px;">Comprar</button>
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

<script>
    function showModalTrailer(){
        document.getElementById("trailer-modal").style.display = "block";
    }
    function closeModalTrailer(){
        document.getElementById("trailer-modal").style.display = "none";
    }
</script>
