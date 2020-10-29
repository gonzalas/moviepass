<!-- Client NavBar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">

      <a class="navbar-brand" href="<?php echo FRONT_ROOT ?>Home/Index">
        <img src="../Views/img/icon.png" width="27" height="27" class="d-inline-block align-top" alt="" loading="lazy">
        MoviePass
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 69%;">

      <ul class="navbar-nav mr-auto">

        <li>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/showCinemaListMenu" role="button" aria-haspopup="true" aria-expanded="false" style="margin-right: 50px;">
            Cines
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Mi perfil
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/showUserProfile">Ver perfil</a>
            <a class="nav-link" href="<?php echo FRONT_ROOT ?>User/userLogOut">Cerrar Sesión</a>
          </div>
        </li>

      </ul>

    </div>
</nav>