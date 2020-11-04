<section class="container" style="width: 80%; max-width:90%;" id="available-shows">
    <div>
        <h1 class="mt-3 p-4" style="color: white; font-weight: 700; text-align: center;">Funciones disponibles</h1>
    </div>
    <table class="table table-hover table-dark" style="text-align: center;">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Sala</th>
                <th scope="col">Precio por entrada</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($showsList as $show){
            ?>
            <tr>
                <th scope="row"><?=$show->getDate()?></th>
                <td><?=$show->getStartTime()?><br>-<br><?=$show->getEndTime()?></td>
                <td><?=$show-> getRoom()-> getName()?></td>
                <td>$<?=$show-> getRoom()-> getTicketValue()?></td>
                <td><a href="<?php echo FRONT_ROOT ?>Ticket/showBuyTicketView/?showId=<?php echo $show->getID();?>" class="btn btn-primary btn-center" style="right-border-radius:20px;">Comprar Entradas</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</section>