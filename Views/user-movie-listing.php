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
    .movie img {
        height: 560px;
        object-fit: cover;
    }
    .movieListing:hover{
        cursor: pointer;
        opacity: 0.7;
        transition: 0.5s;
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
        <div class="carousel-inner" style="border-radius: 5px;">

            <?php
                foreach($carrousel as $movieCarrousel){
                    if($movieCarrousel == $carrousel[0]){
            ?>
            
            <div class="carousel-item active movie">
                <h1 style="position: absolute; top: 25%; left: 20%; color: #ffffff;"><?php echo $movieCarrousel->getTitle(); ?></h1>
                <img src="<?php echo $movieCarrousel->getImage(); ?>" class="d-block w-100" alt="Poster">
            </div>

            <?php
                } else {
            ?>

            <div class="carousel-item movie">
                <h1 style="position: absolute; top: 25%; left: 20%; color: #ffffff;"><?php echo $movieCarrousel->getTitle(); ?></h1>
                <img src="<?php echo $movieCarrousel->getImage(); ?>" class="d-block w-100" alt="Poster">
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
        if(!empty($moviesOnListing)){
    ?>
    
    <div class="row" style="justify-content: center;">

        <?php
    
            foreach($moviesOnListing as $movie){
        ?>
    
        <div class="card mb-3 col-5" style="max-width: 540px; background-color: rgba(10, 0, 0, 0.8); color: #ffffff;">
            <div class="row no-gutters movieListing">
                <div class="col-md-4" style="top: 12%;">
                    <img src="<?php echo $movie->getImage(); ?>" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
                </div>
            </div>
        </div>

        <div class="p-4"></div> 

        <?php
            }
        ?>

    </div>

    <?php
        }
    ?>
    
</section>