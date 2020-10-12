<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Listado de cines</h2>
               <form action="<?php echo FRONT_ROOT."Cinema/removeCinema"?>">
                    <table class="table bg-light-alpha">
                         <thead>
                              <th>Nombre</th>
                              <th>Precio de Entrada</th>
                         </thead>
                         <tbody>
                              <?php
                                   foreach($cinemasList as $cinema)
                                   {
                                        ?>
                                             <tr>
                                                  <td><?php echo $cinema-> getName() ?></td>
                                                  <td><?php echo $cinema-> getTicketValue() ?></td>
                                                  <td>
                                                       <button type="submit" name="id" class="btn" value="<?php echo $cinema-> getID()?>"> Eliminar </button>
                                                  </td>
                                                  <td>
                                                       <a href= "<?php echo FRONT_ROOT ?>Cinema/showEditView/?id=<?php echo $cinema->getID();?>" > Editar </a>
                                                  </td>
                                             </tr>
                                        <?php
                                   }
                              ?>
                              </tr>
                         </tbody>
                    </table>
               </form>
          </div>
     </section>
</main>