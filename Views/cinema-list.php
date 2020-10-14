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
                                        <td>
                                             <input type="button" value="Ver salas" id="ac-btn" class="btn" onClick="toggleRoom(<?php echo $cinema-> getID()?>)"></input>
                                        </td>
                                   </tr>
                                   <?php
                                        $roomsList = $cinema-> getRooms();
                                   ?>
                                   <tr id="accordion" class="animate__animated animate__fadeIn accordion-child<?php echo $cinema-> getID()?>" style="display:none">
                                        <td>
                                             <table>
                                                  <thead>
                                                       <th>Nombre de sala</th>
                                                       <th>Capacidad</th>
                                                  </thead>
                                                  <tbody>
                                                       <?php
                                                            foreach ($roomsList as $room){
                                                       ?>
                                                       <tr>
                                                            <td><?php echo $room-> getName() ?></td>
                                                            <td><?php echo $room-> getCapacity() ?></td>
                                                            <td>
                                                                 <a href= "<?php echo FRONT_ROOT ?>Cinema/showEditRoomView/" > Editar </a>
                                                            </td>
                                                            <td>
                                                                 <a href= "<?php echo FRONT_ROOT ?>Cinema/showEditRoomView/" > Eliminar </a>
                                                            </td>
                                                       </tr>
                                                       <?php
                                                            }
                                                       ?>
                                                       <tr>
                                                       <td>
                                                            <a href= "<?php echo FRONT_ROOT ?>Cinema/showAddRoomView/"> Agregar sala </a>
                                                       </td>
                                                       </tr>
                                                  </tbody>
                                             </table>  
                                        </td>
                                   </tr>        
                              <?php
                                   }
                              ?>
                         </tbody>
                    </table>
               </form>
          </div>
     </section>
</main>