<script>
    document.getElementById("back-img").style.display = "none";
</script>

<style>
     img#back-img-2 {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 0;
        max-height: 200vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
    img#back-img-3 {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 199vh;
        height: 100vh;
        max-height: 200vh;
        left: 0;
        filter: opacity(0.1) grayscale(1) contrast(120%) blur(4px);
        object-fit: cover;
    }
    .movie img {
        height: 560px;
        object-fit: cover;
        object-position: top;
        z-index: -1;
    }
    #myCarousel:hover{
        cursor: pointer;
        opacity: 0.9;
        transition: 0.2s;
    }
    .img-btn-submit{
        position: absolute;
        top: 85%;
        left: 38.5%;
        width: 200px;
        outline: none;
        border-style: none;
        padding: 5px;
        border-radius: 15px;
    }
    .img-btn-submit:hover{
        background-color: red;
        color: #ffffff;
        transition: 1s;
    }
</style>

<?php if($cinemaSelected){ 
    //This function it's not appropiate but $cinema change its value between controller and view and IDK why!
    $cinema = $this->cinemaDAO->ReadByID($cinemaSelected);
?>
    <div class="container card" style="width: 50%; text-align: center; margin-top: 3%; background-color: rgba(255, 255, 255, 0.85)">
        <div class="card-body">
            <h1>Cine <?php echo $cinema->getName()?></h1>
            <h4>Dirección: <?php echo $cinema->getAddress()?></h4>
        </div>
    </div>
<?php } ?>

<section class="container">
    <img id="back-img-2" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">

    <!-- CAROUSEL FOR MAIN 3 MOVIES -->
    <?php 
        if(!empty($carousel)){ 
    ?>

    <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel" style="margin-top: 5%; margin-bottom: 10%; margin-left: 10%; width: 80%;">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner img-hover" style="border-radius: 5px;">

            <?php
                foreach($carousel as $movieCarousel){
                    if($movieCarousel == $carousel[0]){
            ?>
            
            <div class="carousel-item active movie">
                <h1 style="position: absolute; top: 15%; color: #ffffff; background-color: rgba(0,0,0,0.7); padding: 20px 100px;"><?php echo $movieCarousel->getTitle(); ?></h1>
                <img src="<?php echo API_IMG.$movieCarousel->getImage(); ?>" class="d-block w-100" alt="Poster">
                <form action="<?php echo FRONT_ROOT ?>User/showMovieDetails" method="get">
                   <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                    <input type="hidden" name="movieID" value="<?php echo $movieCarousel->getID(); ?>">
                    <input type="hidden" name="cinemaID" value="<?php echo $cinemaSelected; ?>">
                    <!-- --- -->
                    <button class="img-btn-submit" type="submit">Ver detalles</button>
                </form>
            </div>

            <?php
                } else {
            ?>

            <div class="carousel-item movie">
                <h1 style="position: absolute; top: 15%; color: #ffffff; background-color: rgba(0,0,0,0.7); padding: 20px 100px;"><?php echo $movieCarousel->getTitle(); ?></h1>
                <img src="<?php echo API_IMG.$movieCarousel->getImage(); ?>" class="d-block w-100" alt="Poster">
                <form action="<?php echo FRONT_ROOT ?>User/showMovieDetails" method="get">
                    <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                    <input type="hidden" name="movieID" value="<?php echo $movieCarousel->getID(); ?>">
                    <input type="hidden" name="cinemaID" value="<?php echo $cinemaSelected; ?>">
                    <!-- --- -->
                    <button class="img-btn-submit" type="submit">Ver detalles</button>
                </form>
            </div>

            <?php
                    }
                }
            ?>

        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <?php
        } ?>

  
    <!-- ALL MOVIES ON LISTING AS CARDS -->
    <?php
        if(!empty($movieListing)){
    ?>
    
    <div class="row" style="justify-content: center;">

        <?php
    
            foreach($movieListing as $movie){
        ?>
    
        <div class="card mb-3 col-5" style="max-width: 540px; background-color: rgba(10, 0, 0, 0.8); color: #ffffff;">
            <form action="<?php echo FRONT_ROOT ?>User/showMovieDetails" method="get">

                <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                <input type="hidden" name="movieID" value="<?php echo $movie->getID(); ?>">
                <input type="hidden" name="cinemaID" value="<?php echo $cinemaSelected; ?>">
                <!-- --- -->

                <div class="row no-gutters movieListing">
                    <div class="col-md-4" style="top: 12%;">
                        <img src="<?php echo API_IMG.$movie->getImage(); ?>" class="card-img" alt="Poster" style="margin-top: 20px;">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                        <p class="card-text"><?php echo $movie->getOverview();?></p>
                        <p class="card-text"><small>Duración: <?=$movie-> getLength()?> min.</small></p>
                    </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" style="width: 120px; left: 5%; bottom: 5%; position: absolute;">Ver detalle</button>
            </form>
        </div>

        <div class="p-4"></div> 

        <?php
            }
        ?>

    </div>

    <?php
        } else {
            ?>
               
                   <div class="alert alert-dark mt-5 p-4" role="alert" style="top: 10rem;">
                       <h4>La cartelera no está disponible de momento. Vuelva en un rato.</h4>
                   </div>
                   <style>
                       #back-img-2{
                           height: 100vh;
                       }
                       #back-img-3{
                           display: none;
                       }
                   </style>
           <?php } ?>
    
    <img id="back-img-3" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">
</section>