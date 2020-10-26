<style>
    .card-rooms:hover {
        cursor: pointer;
        opacity: 0.7;
    }
    .card-room-img {
        transform: translate(-21px, -21px);
        width: 114.4%;
        height: 100px;
        object-fit: cover;
    }
    .card a {
        text-decoration: none;
        color: #000000;
    }
</style>


<div style="display: grid; grid-template-columns: 30% 30% 30%; padding-top: 5rem; margin-left: 10%;">

    <?php
        if($roomList){
 
            foreach($roomList as $room){     
    ?>
            <div class="card animate__animated animate__headShake" style="margin: 1rem; background-image: linear-gradient(to left, #e0c1d7, #ffffff);">
                <a href="<?php echo FRONT_ROOT ?>User/showRoomMovieListing?cinema=<?php echo $cinemaSelected ?>&room=<?php echo $room->getID(); ?>">
                    <div class="card-body card-rooms">
                        <img src="<?php echo IMG_PATH."back.png"?>" class="card-room-img card-img-top" alt="Sala">
                        <h5 class="card-title"><?php echo $room->getName();?></h5>
                        <p class="card-text"><b>Capacidad: </b><?php echo $room->getCapacity();?></p>
                        <p class="card-text"><b>Valor: </b>$<?php echo $room->getTicketValue();?></p>
                    </div>
                </a>
            </div>
    <?php
        }
    } else {
    ?>

    <div class="alert alert-dark mt-5" role="alert" style="margin-left: 15%; text-align: center; width: 700px;">
        <h5>Lo sentimos, no hay salas disponibles de momento.</h5>
    </div>

    <?php
        }
    ?>
       
</div>



