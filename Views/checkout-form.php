<?php
    require_once('nav-client.php');
?>

<style>
    .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    }

    @media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
    }
</style>

<main>
<div class="container" style="background-color: #f8f9fa !important;">
  <div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="https://image.flaticon.com/icons/png/512/126/126083.png" alt="" width="72" height="72">
    <?php if ($show-> getSoldTickets() < $show-> getRoom()-> getCapacity()){ ?>
    <h2>Información de Pago</h2>
    <p class="lead">Para confirmar su compra en MoviePass, deberá ingresar información de una tarjeta de crédito Visa o Master válida.</p>
    <?php if ($message != ""){ ?>
        <div  class="alert alert-danger alert-dismissible fade show" role="alert"> <strong> <?php echo $message?> </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
  </div>

  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-success">Detalles de compra</span>
      </h4>
      <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0"><?=$show->getMovie()->getTitle()?> | <?php echo $seatsQuantity; if ($seatsQuantity > 1) echo " entradas."; else echo " entrada."; ?> </h6>
            <small class="text-muted"><?=$show->getMovie()->getLanguage()?> | <?=$show->getMovie()->getLength()?> min.</small>
          </div>
          <span class="text-muted">$<?=$subtotal?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0"><?=$show-> getRoom()-> getName()?></h6>
            <small class="text-muted"><?=$show-> getRoom()-> getCinema()-> getName()?> | <?=$show-> getRoom()-> getCinema()-> getAddress()?></small>
          </div>
          <span class="text-muted"><?=date("d M Y", strtotime($show->getDate()));?> | <?=$show->getStartTime()?></span>
        </li>
        <?php
          if ($subtotal != $total){
        ?>
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Descuentos (25%)</h6>
              <small>DÍA FUNCIÓN + CANT. ENTRADAS</small>
            </div>
            <span class="text-success">-$<?=$subtotal - $total?></span>
          </li>
        <?php
          } else {
        ?>
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-danger">
              <h6 class="my-0">Sin descuentos en su compra</h6>
              <small type="button" data-toggle="modal" data-target="#discountsModal"><strong><u>VER PROMOCIONES</u></strong></small>
            </div>
            <span class="text-danger">-$0</span>
          </li>
        <?php
          }
        ?>
        
        <li class="list-group-item d-flex justify-content-between">
          <span>Total (ARS)</span>
          <strong>$<?=$total?></strong>
        </li>
      </ul>
    </div>
    <div class="col-md-8 order-md-1">
      <form action="<?php echo FRONT_ROOT ?>Ticket/validateCCInformation" method="post">
        <h4 class="mb-3">Pago</h4>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="cc-name">Nombre en la tarjeta</label>
            <input type="text" class="form-control" name="ccName" id="cc-name" placeholder="" required>
            <small class="text-muted">Nombre completo, como aparece en la tarjeta</small>
            <div class="invalid-feedback">
              El nombre en la tarjeta es requerido
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cc-number">Número de tarjeta de crédito</label>
            <input type="text" class="form-control" name="ccNumber" id="cc-number" placeholder="" required>
            <small class="text-muted">Los 16 números al frente de la tarjeta</small>
            <div class="invalid-feedback">
              El número de la tarjeta es requerido
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-6">
            <label>Vencimiento</label>
            <div class="row pl-3">
              <select class="form-control" name='expireMM' id='expireMM' style="width: 33%;" required>
                <option value=''>Mes</option>
                <option value='01'>Enero</option>
                <option value='02'>Febrero</option>
                <option value='03'>Marzo</option>
                <option value='04'>Abril</option>
                <option value='05'>Mayo</option>
                <option value='06'>Junio</option>
                <option value='07'>Julio</option>
                <option value='08'>Agosto</option>
                <option value='09'>Septiembre</option>
                <option value='10'>Octubre</option>
                <option value='11'>Noviembre</option>
                <option value='12'>Diciembre</option>
              </select> 
              <select class="form-control ml-3" name='expireYY' id='expireYY' style="width: 33%;" required>
                  <option value=''>Año</option>
                  <?php $year = date('Y')-1;
                  $i=0;
                  for ($i; $i<6; $i++){
                    $year++;
                  ?>
                    <option value='<?=$year?>'><?=substr($year, -2);?></option>
                  <?php
                  }
                  ?>
              </select> 
            </div>
            <div class="invalid-feedback">
              La fecha de vencimiento es requerida
            </div>
          </div>
          <div class="col-md-6 mb-6">
            <label for="cc-cvv">Código de seguridad</label>
            <input type="text" class="form-control" name="ccCVV" id="cc-cvv" placeholder="" style="width: 33%;" required>
            <div class="invalid-feedback">
              El código de seguridad es requerido
            </div>
          </div>
        </div>
        <input type="hidden" name="showID" value="<?=$show-> getID()?>">
        <input type="hidden" name="seatsQuantity" value="<?=$seatsQuantity?>">
        <hr class="mb-4">
        <div class="row pl-3">
          <a href="<?php echo FRONT_ROOT ?>Ticket/showBuyTicketView/?movieID=<?=$show->getID()?>" class="btn btn-danger btn-lg btn-block mr-3" type="button" style="width: 48%; margin-top: .5rem;">Editar compra</a>
          <button class="btn btn-success btn-lg btn-block" type="submit" style="width: 48%;">Confirmar medio de pago</button>
        </div>
      </form>
    </div>
  </div>
  <?php } else { ?>
    <div class="jumbotron jumbotron-fluid custom-jumbotron" style="background-color: #f8f9fa !important;">
      <div class="container">
          <h1 class="display-4">En este momento, todas las entradas para la función elegida están agotadas.</h1>
          <p class="lead">Lamentamos el inconveniente y agradecemos su paciencia. Agregaremos más funciones a la brevedad.</p>
          <a href="<?php echo FRONT_ROOT ?>User/showMovieDetails?movieID=<?=$show->getMovie()->getID()?>&cinemaID=<?=$show->getRoom()->getCinema()->getID()?>" class="btn btn-danger ml-auto d-block">Regresar</a>
      </div>
    </div>
  <?php } ?>
</div>

<!-- Discounts Policies Modal -->
<div class="modal fade" id="discountsModal" tabindex="-1" role="dialog" aria-labelledby="discountsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="discountsModalLabel">Políticas de descuento en MoviePass</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Como siempre pensamos en vos, te ofrecemos un descuento del 25%. Para disfrutar de esta promoción, debés comprar dos o más entradas para una función que se proyecte un día martes o miércoles. <br> ¿Qué esperás para cortar la semana compartiendo una peli?
      </div>
      <div class="modal-footer">
      <a href="<?php echo FRONT_ROOT ?>Ticket/showBuyTicketView/?movieID=<?=$show->getID()?>" class="btn btn-danger" type="button">Editar compra</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

</main>
