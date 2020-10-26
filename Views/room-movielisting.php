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
        <div class="mt-5 mb-5">
            <h1 style="color: #e88e9d; font-weight: 700;">Cartelera</h1>
        </div>
        <div>

        <?php
            if($movieListing){

                foreach($movieListing as $movie){
        ?>

            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo $movie->getImage(); ?>" class="card-img" alt="<?php echo $movie->getTitle(); ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $movie->getTitle(); ?></h5>
                            <p class="card-text"><?php echo $movie->getOverview(); ?></p>
                            <p class="card-text"><small class="text-muted"><?php echo $movie->getDateRelease(); ?></small></p>
                        </div>
                    </div>
                </div>
            </div>

        <?php
                }
            } else {
        ?>

            <div class="alert alert-dark" role="alert">
                Aún no hay cartelera disponible.
            </div>

        <?php
            }
        ?>

        </div>
    </section>
</main>