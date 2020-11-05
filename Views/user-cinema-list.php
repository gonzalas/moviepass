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

    <section class="container">
        <div class="pt-5 pb-5">
            <h1 style="color: #e88e9d; font-weight: 700;">Cines</h1>
        </div>
        <img id="back-img" src="<?php echo IMG_PATH."poster00.jpg" ?>" alt="Poster">
            <form action="<?php echo FRONT_ROOT ?>User/showMovieListing" method="post" id="cinema-list-form">
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
