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
</style>

<section class="navbar navbar-dark bg-dark" style="display: flex; justify-content: center;">
    <div style="display flex; padding-top: 15px; margin-right: 50px;">
        <img id="back-img" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">
        <form action="<?php echo FRONT_ROOT ?>User/showMovieListing" method="get" id="cinema-list-form">
            <div class="input-group mb-3" style="" id="options">
                <div class="input-group-prepend">
                    <label title="Filtrar películas por cine" class="input-group-text" for="inputGroupSelect01">Cines</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" style="width: 200px;" name="cinemaSelected">
                    <option selected id="cine-selected" value="-1">Elija...</option>
                    <?php 
                        foreach($cinemasList as $cinema){
                    ?>
                    <option value="<?php echo $cinema->getID();?>"><?php echo $cinema->getName();?></option>
                    <?php
                        }
                    ?>
                </select>
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>                
        </form>
    </div>

    <div style="display: flex; align-items: center;">
        <div id="movie-search-filters" style="display: block;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <nav class="navbar navbar-light bg-light" style="border-radius: 5px;">
                    <form class="form-inline" action="<?php echo FRONT_ROOT?>User/showMovieTitle" method="get">
                        <input title="Ingrese el nombre de la película que quiera buscar" class="form-control mr-sm-2" style="width: 400px;" name="movieTitle" type="search" placeholder="Nombre de película" aria-label="Search" required>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </nav>

                <div class="input-group mb-3" style="width: 400px; top: 10px; margin-left: 50px;">
                    <form action="<?php echo FRONT_ROOT?>User/showMovieGenre" method="get" style="display: flex; width: 100%;">
                        <div class="input-group-prepend">
                            <label title="Filtrar películas por género" class="input-group-text" for="inputGroupSelect01">Género</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01" name="genreID" required>
                            <?php
                                foreach($genresList as $genre){
                            ?>
                            <option value="<?php echo $genre->getID();?>"><?php echo $genre->getName();?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
