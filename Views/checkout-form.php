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
    <h2>Información de Pago</h2>
    <p class="lead">Para confirmar su compra en MoviePass, deberá ingresar información de una tarjeta de crédito Visa o Master válida.</p>
  </div>

  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Detalles de compra</span>
        <span class="badge badge-secondary badge-pill">3</span>
      </h4>
      <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0"><?=$show->getMovie()->getTitle()?></h6>
            <small class="text-muted"><?=$show->getMovie()->getLanguage()?> - <?=$show->getMovie()->getLength()?> min.</small>
          </div>
          <span class="text-muted">$12</span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Second product</h6>
            <small class="text-muted">Brief description</small>
          </div>
          <span class="text-muted">$8</span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Third item</h6>
            <small class="text-muted">Brief description</small>
          </div>
          <span class="text-muted">$5</span>
        </li>
        <li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-success">
            <h6 class="my-0">Promo code</h6>
            <small>EXAMPLECODE</small>
          </div>
          <span class="text-success">-$5</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span>Total (USD)</span>
          <strong>$20</strong>
        </li>
      </ul>
    </div>
    <div class="col-md-8 order-md-1">
      <form class="needs-validation">
        <h4 class="mb-3">Pago</h4>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="cc-name">Nombre en la tarjeta</label>
            <input type="text" class="form-control" id="cc-name" placeholder="" required>
            <small class="text-muted">Nombre completo, como aparece en la tarjeta</small>
            <div class="invalid-feedback">
              El nombre en la tarjeta es requerido
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cc-number">Número de tarjeta de crédito</label>
            <input type="text" class="form-control" id="cc-number" placeholder="" required>
            <small class="text-muted">Los 16 números al frente de la tarjeta</small>
            <div class="invalid-feedback">
              El número de la tarjeta es requerido
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-6">
            <label for="cc-expiration">Vencimiento</label>
            <input type="text" class="form-control" id="cc-expiration" placeholder="" style="width: 33%;" required>
            <div class="invalid-feedback">
              La fecha de vencimiento es requerida
            </div>
          </div>
          <div class="col-md-6 mb-6">
            <label for="cc-cvv">Código de seguridad</label>
            <input type="text" class="form-control" id="cc-cvv" placeholder="" style="width: 33%;" required>
            <div class="invalid-feedback">
              El código de seguridad es requerido
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Confirmar medio de pago</button>
      </form>
    </div>
  </div>
</div>

</main>
