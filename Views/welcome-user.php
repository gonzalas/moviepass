<script>
    /*****FOR LOGIN *******/
    function closeWelcomeModal() {
        document.getElementById("welcome-modal").style.display = "none";
    }
</script>
<div id="welcome-modal" class="modal" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0,0,0,0.9); padding-top: 150px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content animate__animated animate__fadeInDown">
      <div class="modal-header">
        <h5 class="modal-title">¡Gracias por registrarse!</h5>
      </div>
      <div class="modal-body">
        <p>Bienvenido <b><?php echo $user->getFirstName()?> <?php echo $user->getLastName()?></b>.</p>
        <p>Esperamos que disfrute su experiencia con nosotros.</p>
        <p>Su usuario será <b><?php echo $user->getUserName()?></b>.</p>
        <p>Se ha registrado con el email <b><?php echo $user->getEmail()?></b>.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onClick="closeWelcomeModal()">Cerrar</button>
      </div>
    </div>
  </div>
</div>

