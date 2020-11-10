<?php
    Helpers\SessionValidatorHelper::ValidateUserNav();
?>
<style>
    body {
        background-image: linear-gradient(to right, #ba001f, red);
        }
    img#back-img {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 0;
        max-height: 100vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
    #clicker:hover, #clicker2:hover{
        cursor: pointer;
        opacity: 0.6;
        transition: 1s;
    }
</style>

<section class="container">
    <div class="pt-5 pb-5">
        <h1 style="color: #e88e9d; font-weight: 700;">Cines</h1>
    </div>
    <img id="back-img" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">
        <form action="<?php echo FRONT_ROOT ?>User/showMovieListing" method="get" id="cinema-list-form">
            <div class="input-group mb-3" style="width: 50%; margin-left: 23%;" id="options">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Cines</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="cinemaSelected">
                    <option selected id="cine-selected" value="-1">Elija...</option>
                    <?php 
                        foreach($cinemasList as $cinema){
                    ?>
                    <option value="<?php echo $cinema->getID();?>"><?php echo $cinema->getName();?></option>
                    <?php
                        }
                    ?>
                </select>
                <button type="submit" class="btn btn-dark">Buscar</button>
            </div>                
        </form>
</section>

<section class="container" style="margin-top: 50px; margin-bottom: 5%; display: flex; align-items: center;">
    <div id="clicker" title="Buscar por título o género" onClick="showBars()"><i class="fas fa-arrow-circle-right" style="font-size: 3em; padding: 20px;"></i></div>
    <div id="clicker2" title="Cerrar menú" style="display: none;" onClick="showBars()"><i class="fas fa-arrow-circle-left" style="font-size: 3em; padding: 20px;"></i></div>
    
    <div id="movie-search-filters" class="animate__animated animate__fadeInLeft" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <nav class="navbar navbar-light bg-light" style="border-radius: 5px;">
                <form class="form-inline" action="<?php echo FRONT_ROOT?>User/showMovieTitle" method="post">
                    <input class="form-control mr-sm-2" style="width: 400px;" name="movieTitle" type="search" placeholder="Nombre de película" aria-label="Search" required>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </nav>

            <div class="input-group mb-3" style="width: 400px; top: 10px; margin-left: 50px;">
                <form action="<?php echo FRONT_ROOT?>User/showMovieGenre" method="post" style="display: flex; width: 100%;">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Género</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" name="genreID">
                        <?php
                            foreach($genresList as $genre){
                        ?>
                        <option value="<?php echo $genre->getID();?>"><?php echo $genre->getName();?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-dark">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function showBars(){
        let bars = document.getElementById("movie-search-filters");
        let clicker = document.getElementById("clicker");
        let clicker2 = document.getElementById("clicker2");

        if(bars.style.display == "none"){
            bars.style.display = "block";
            clicker.style.display = "none";
            clicker2.style.display = "block";
            return;
        }
        if(bars.style.display == "block"){
            bars.style.display = "none";
            clicker.style.display = "block";
            clicker2.style.display = "none";
        }
    }
</script>