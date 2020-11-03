<script>
    document.getElementById("back-img").style.display = "none";

    window.onload = function(){
        window.scroll({
            top: 250,
            left: 0,
            behavior: 'smooth'
        });
    }
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

<section class="container">
    <img id="back-img-2" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">

    <!-- CARROUSEL FOR MAIN 3 MOVIES -->
    <?php 
        if(!empty($carrousel)){ 
    ?>

    <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel" style="margin-top: 5%; margin-bottom: 10%; margin-left: 10%; width: 80%;">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner img-hover" style="border-radius: 5px;">

            <?php
                foreach($carrousel as $movieCarrousel){
                    if($movieCarrousel == $carrousel[0]){
            ?>
            
            <div class="carousel-item active movie">
                <h1 style="position: absolute; top: 15%; color: #ffffff; background-color: rgba(0,0,0,0.7); padding: 20px 100px;"><?php echo $movieCarrousel->getTitle(); ?></h1>
                <img src="<?php echo API_IMG.$movieCarrousel->getImage(); ?>" class="d-block w-100" alt="Poster">
                <form action="<?php echo FRONT_ROOT ?>User/showMovieDetails" method="post">
                    <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                    <input type="hidden" name="movieID" value="<?php echo $movieCarrousel->getID(); ?>">
                    <input type="hidden" name="movieTitle" value="<?php echo $movieCarrousel->getTitle(); ?>">
                    <input type="hidden" name="movieOverview" value="<?php echo $movieCarrousel->getOverview(); ?>">
                    <input type="hidden" name="movieReleaseDate" value="<?php echo $movieCarrousel->getReleaseDate(); ?>">
                    <input type="hidden" name="movieLength" value="<?php echo $movieCarrousel->getLength(); ?>">
                    <input type="hidden" name="movieImage" value="<?php echo $movieCarrousel->getImage(); ?>">
                    <input type="hidden" name="movieTrailer" value="<?php echo $movieCarrousel->getTrailer(); ?>">
                    <input type="hidden" name="movieLanguage" value="<?php echo $movieCarrousel->getLanguage(); ?>">
                    <input type="hidden" name="movieGenres" value="<?php echo $movieCarrousel->getGenres(); ?>">
                    <input type="hidden" name="movieVoteAverage" value="<?php echo $movieCarrousel->getVoteAverage(); ?>">
                    <!-- --- -->
                    <button class="img-btn-submit" type="submit">Ver detalles</button>
                </form>
            </div>

            <?php
                } else {
            ?>

            <div class="carousel-item movie">
                <h1 style="position: absolute; top: 15%; color: #ffffff; background-color: rgba(0,0,0,0.7); padding: 20px 100px;"><?php echo $movieCarrousel->getTitle(); ?></h1>
                <img src="<?php echo API_IMG.$movieCarrousel->getImage(); ?>" class="d-block w-100" alt="Poster">
                <form action="<?php echo FRONT_ROOT ?>User/showMovieDetails" method="post">
                    <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                    <input type="hidden" name="movieID" value="<?php echo $movieCarrousel->getID(); ?>">
                    <input type="hidden" name="movieTitle" value="<?php echo $movieCarrousel->getTitle(); ?>">
                    <input type="hidden" name="movieOverview" value="<?php echo $movieCarrousel->getOverview(); ?>">
                    <input type="hidden" name="movieReleaseDate" value="<?php echo $movieCarrousel->getReleaseDate(); ?>">
                    <input type="hidden" name="movieLength" value="<?php echo $movieCarrousel->getLength(); ?>">
                    <input type="hidden" name="movieImage" value="<?php echo $movieCarrousel->getImage(); ?>">
                    <input type="hidden" name="movieTrailer" value="<?php echo $movieCarrousel->getTrailer(); ?>">
                    <input type="hidden" name="movieLanguage" value="<?php echo $movieCarrousel->getLanguage(); ?>">
                    <input type="hidden" name="movieGenres" value="<?php echo $movieCarrousel->getGenres(); ?>">
                    <input type="hidden" name="movieVoteAverage" value="<?php echo $movieCarrousel->getVoteAverage(); ?>">
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
        }
    ?>

    <!-- ALL MOVIES ON LISTING AS CARDS -->
    <?php
        if(!empty($movieListing)){
    ?>
    
    <div class="row" style="justify-content: center;">

        <?php
    
            foreach($movieListing as $movie){
        ?>
    
        <div class="card mb-3 col-5" style="max-width: 540px; background-color: rgba(10, 0, 0, 0.8); color: #ffffff;">
            <form action="<?php echo FRONT_ROOT ?>User/showMovieDetails" method="post">

                <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                <input type="hidden" name="movieID" value="<?php echo $movie->getID(); ?>">
                <input type="hidden" name="movieTitle" value="<?php echo $movie->getTitle(); ?>">
                <input type="hidden" name="movieOverview" value="<?php echo $movie->getOverview(); ?>">
                <input type="hidden" name="movieReleaseDate" value="<?php echo $movie->getReleaseDate(); ?>">
                <input type="hidden" name="movieLength" value="<?php echo $movie->getLength(); ?>">
                <input type="hidden" name="movieImage" value="<?php echo $movie->getImage(); ?>">
                <input type="hidden" name="movieTrailer" value="<?php echo $movie->getTrailer(); ?>">
                <input type="hidden" name="movieLanguage" value="<?php echo $movie->getLanguage(); ?>">
                <input type="hidden" name="movieGenres" value="<?php echo $movie->getGenres(); ?>">
                <input type="hidden" name="movieVoteAverage" value="<?php echo $movie->getVoteAverage(); ?>">
                <!-- --- -->

                <div class="row no-gutters movieListing">
                    <div class="col-md-4" style="top: 12%;">
                        <img src="<?php echo API_IMG.$movie->getImage(); ?>" class="card-img" alt="Poster" style="margin-top: 20px;">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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
        }
    ?>
    
    <img id="back-img-3" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">
</section>