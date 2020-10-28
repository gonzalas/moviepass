<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
          <?php 
               if ($messageCode > 0){
          ?>
                    <div  class="alert alert-success alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong></div>
          <?php } ?>
               <h1 class="title">Listado de cines</h1>
               <form action="<?php echo FRONT_ROOT."Cinema/removeCinema"?>">
                    <table class="table bg-light-alpha white-font">
                         <thead>
                              <th>Nombre</th>
                              <th>Dirección</th>
                              <th>Capacidad Total</th>
                         </thead>
                         <tbody>
                              <?php
                                   foreach($cinemasList as $cinema)
                                   {
                              ?>
                                   <tr>
                                        <td><?php echo $cinema-> getName() ?></td>
                                        <td><?php echo $cinema-> getAddress() ?></td>
                                        <td><?php echo $cinema-> getTotalCapacity()?></td>
                                        <td>
                                             <input type="button" value="Ver salas" id="ac-btn" class="btn btn-info" onClick="toggleRoom(<?php echo $cinema-> getID()?>)"></input>
                                        </td>
                                        <td>
                                             <a class="btn btn-success" href= "<?php echo FRONT_ROOT ?>Cinema/showEditView/?id=<?php echo $cinema->getID();?>" > Editar </a>
                                        </td>
                                        <td>
                                             <button type="submit" name="id" class="btn btn-danger" onClick="confirmDelete(<?php echo $cinema-> getID()?>)" id="btnDelete<?php echo $cinema-> getID()?>"> Eliminar </button>
                                        </td>
                                   </tr>
                                   <?php
                                        require('room-list.php');
                                   }
                              ?>
                         </tbody>
                    </table>
               </form>
          </div>
     </section>
</main>