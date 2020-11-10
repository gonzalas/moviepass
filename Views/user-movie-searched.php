<?php
    Helpers\SessionValidatorHelper::ValidateUserNav();
?>

<section class="container">

    <!-- MOVIES SEARCHED -->
    <?php
        if(!empty($movieSearched)){
    ?>
    
    <div class="row" style="justify-content: center;">

        <?php
    
            foreach($movieSearched as $movie){
        ?>
    
        <div class="card mb-3 col-5" style="max-width: 540px; background-color: rgba(10, 0, 0, 0.8); color: #ffffff;">
            <form action="<?php echo FRONT_ROOT ?>User/showMovieSearchedDetails" method="get">

                <!-- GET MOVIE ATTRIBUTES TO SEND BY FORM -->
                <input type="hidden" name="movieID" value="<?php echo $movie->getID(); ?>">
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
        <img id="back-img-movie" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">
    </div>

    <?php
        } else {
    ?>
               
        <div class="alert alert-dark mt-5 p-4" role="alert" style="top: 10rem;">
            <h4>No hay funciones para películas con ese título.</h4>
        </div>
    <?php } ?>

</section>

<style>
    img#back-img-movie {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 100vh;
        max-height: 150vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
</style>