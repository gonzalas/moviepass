<?php
    require_once("nav-client.php"); 
?>
<style>
    body {
        background-image: linear-gradient(to right, #ba001f, red);
        }
</style>

<main class="container">
    <section>
        <div class="pt-5 pb-5">
            <h1 style="color: #e88e9d; font-weight: 700;">Cines</h1>
        </div>
            <form action="<?php echo FRONT_ROOT ?>User/showRoomsToUser" method="post" id="cinema-list-form">
                <div class="input-group mb-3" style="width: 50%;" id="options">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Cines</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" name="cinemaSelected">
                        <option selected id="cine-selected">Elija...</option>

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
</main>