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
                                <a href= "<?php echo FRONT_ROOT ?>Room/showEditView/?id=<?php echo $room->getID();?>" > Editar </a>
                        </td>
                        <td>
                                <a href= "<?php echo FRONT_ROOT ?>Room/removeRoom/?id=<?php echo $room->getID();?>" > Eliminar </a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                    <tr>
                    <td>
                        <a href= "<?php echo FRONT_ROOT ?>Room/showAddView/?cinemaId=<?php echo $cinema->getID();?>"> Agregar sala </a>
                    </td>
                    </tr>
                </tbody>
            </table>  
    </td>
</tr>