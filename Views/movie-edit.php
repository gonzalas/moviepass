<?php
    require_once('nav.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container white-font">
            <h2 class="mb-4">Editar Película</h2>
            <form action="<?php echo FRONT_ROOT ?>Movie/editMovie" method="post" class="bg-light-alpha p-5">
                <div class="row">                         
                        <div class="col-lg-8">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $movie-> getID()?>">
                                <label>Título (actual: <?php echo $movie-> getTitle()?>)</label>
                                <select name="title" class="form-control form-control-lg">
                                    <option><?=$movie-> getTitle()?></option>
                                    <?php foreach ($titlesResult as $title){?>
                                        <option><?=$title["title"]?></option>
                                    <?php }?>
                                </select>
                                <br>
                                <label>Descripción</label>
                                <br>
                                <textarea type="text" name="overview" rows="4" cols="50" required><?php echo $movie-> getOverview()?></textarea>
                            </div>
                        </div>
                </div>
                <div class="d-flex flex-row-reverse">
                        <a class="btn btn-danger p-2" href= "<?php echo FRONT_ROOT ?>Movie/showSavedMovies" > Cancelar </a>
                        <button type="submit" class="btn btn-success ml-auto p-2 mr-4">Confirmar</button>
                </div>
            </form>
        </div>
    </section>
</main>