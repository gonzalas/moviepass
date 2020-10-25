<style>
    .card-rooms:hover {
        cursor: pointer;
        opacity: 0.7;
    }
</style>


<div style="display: grid; grid-template-columns: 30% 30% 30%; padding-top: 5rem; margin-left: 10%;">

    <?php
        if($roomList){

            foreach($roomList as $room){     
    ?>
            <div class="card animate__animated animate__headShake" style="margin: 1rem; background-image: linear-gradient(to left, #e0c1d7, #ffffff);">
                <div class="card-body card-rooms">
                    <h5 class="card-title"><?php echo $room->getName();?></h5>
                    <p class="card-text"><b>Capacidad: </b><?php echo $room->getCapacity();?></p>
                    <p class="card-text"><b>Valor: </b>$<?php echo $room->getTicketValue();?></p>
                </div>
            </div>
    <?php
        }
    } else {
    ?>

    <div class="alert alert-dark mt-5" role="alert" style="margin-left: 15%; text-align: center;">
        <h5>Lo sentimos, no hay salas disponibles de momento.</h5>
    </div>

    <?php
        }
    ?>
       
</div>



