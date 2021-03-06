<?php
    $roomsList = $cinema-> getRooms();
?>
<tr id="accordion" class="animate__animated animate__fadeIn accordion-child<?php echo $cinema-> getID()?>" style="display:none">
    <td>
            <table>
                <thead>
                    <th>Nombre de sala</th>
                    <th>Valor de Entrada</th>
                    <th>Capacidad</th>
                    <th><input type="button" value="Ver eliminadas" id="ac-btn" class="btn btn-info" onClick="toggleValidRooms(<?php echo $cinema-> getID()?>)"></input></th>
                </thead>
                <tbody>
                    <?php
                        //echo "ID de cine actual: ", $cinema->getID;
                        foreach ($roomsList as $room){
                            if ($room-> getIsActive()){
                    ?>
                    <tr>
                        <td><?php echo $room-> getName() ?></td>
                        <td>$<?php echo $room-> getTicketValue() ?></td>
                        <td><?php echo $room-> getCapacity() ?></td>
                        <td>
                            <a class="btn btn-success" href= "<?php echo FRONT_ROOT ?>Room/showEditView/?id=<?php echo $room->getID();?>" > Editar </a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href= "<?php echo FRONT_ROOT ?>Room/removeRoom/?id=<?php echo $room->getID();?>" > Eliminar </a>
                        </td>
                    </tr>
                    <?php
                        } else {
                    ?>
                        <tr class="animate__animated animate__fadeIn accordion-child-room<?php echo $cinema-> getID()?>" style="display:none">
                            <td><?php echo $room-> getName() ?></td>
                            <td>$<?php echo $room-> getTicketValue() ?></td>
                            <td><?php echo $room-> getCapacity() ?></td>
                            <td>
                                <a class="btn btn-success" href= "<?php echo FRONT_ROOT ?>Room/retrieveRoom/?id=<?php echo $room->getID();?>" > Dar de alta </a>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                    <td>
                        <a class="btn btn-info" href= "<?php echo FRONT_ROOT ?>Room/showAddView/?cinemaId=<?php echo $cinema->getID();?>"> Agregar sala </a>
                    </td>
                    </tr>
                </tbody>
            </table>  
    </td>
</tr>