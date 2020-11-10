<?php
    require_once('nav-client.php');
?>
<main class="py-5">
    <h1 class="title">Mis compras - <?=$user->getUserName()?></h1>
        <?php
            if (!empty($purchasesList)){
                ?>
                <table class="table table-hover table-dark" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">Fecha de Compra</th>
                        <th scope="col">Cant. de Tickets</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Descuentos</th>
                        <th scope="col">Total</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($purchasesList as $purchase){
                    ?>
                    <tr>
                        <td scope="row"><?=date("d M Y", strtotime($purchase->getPurchaseDate()));?></td>
                        <td><?=count($purchase->getTicketsList())?></td>
                        <td>$<?=$purchase-> getSubtotal()?></td>
                        <?php if ($purchase-> getHasDiscount()){ ?>
                            <td class="text-success"><b>25%</b></td>
                        <?php } else { ?>
                            <td>0%</td>
                        <?php } ?>
                        <td>$<?=$purchase-> getPurchaseTotal()?></td>
                        <td><button type="button" class="btn btn-warning btn-center" data-toggle="modal" data-target="#purchaseModal<?=$purchase->getPurchaseID()?>" style="right-border-radius:20px;">Detalles de Compra</button></td>
                        
                    </tr>
                    <div class="modal fade show" id="purchaseModal<?=$purchase->getPurchaseID()?>" tabindex="-1" aria-labelledby="purchaseModal<?=$purchase->getPurchaseID()?>" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content" style="width: 700px;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="purchaseModal<?=$purchase->getPurchaseID()?>">Detalles de la compra</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col mb-3 movie-div">
                                        <div class="card card-movie">
                                            <div class="card-body">
                                                <h5 class="card-title">Película: <br><?=$purchase-> getShow()-> getMovie()-> getTitle()?></h5>
                                                <h5 class="card-title"><br>Fecha y hora de función: <br><?=date("d M Y", strtotime($purchase-> getShow()->getDate()));?> | <?=$purchase-> getShow()->getStartTime()?></h5>
                                                <h5 class="card-title"><br>Cine y sala de función: <br><?=$purchase-> getShow()->getRoom()->getCinema()->getName()?> | <?=$purchase-> getShow()->getRoom()->getName()?></h5>
                                                <h5 class="card-title"><br>Ubicación/es: <br><?php foreach($purchase->getTicketsList() as $ticket){echo " | " . $ticket-> getSeatLocation();}?></h5>
                                                <h5 class="card-title"><br>Número de Compra (comprobante): <br><?=$purchase-> getPurchaseID()?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
                </tbody>
            </table>
            
            
            <?php
            } else {
            ?>
            <div class="jumbotron jumbotron-fluid custom-jumbotron">
                <div class="container">
                    <h1 class="display-4">Todavía no has realizado ninguna compra.</h1>
                    <p class="lead">¡No está mal! Podés ver las próximas funciones desde la pestaña "Cines".</p>
                </div>
            </div>
            <?php
            }
            ?>
            
    
</main>