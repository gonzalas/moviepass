<!-- Admin NavBar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo FRONT_ROOT ?>Cinema/ShowListView">
    <img src="../Views/img/icon.png" width="27" height="27" class="d-inline-block align-top" alt="" loading="lazy">
    MoviePass
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cines
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Cinema/showAddView">Agregar Cine</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Cinema/showListView">Listar Cines</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Películas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Movie/showNowPlaying">Películas API</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Movie/showSavedMovies">Películas Guardadas</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Funciones
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Show/showAddView">Agregar función</a>
          <div class="dropdown-divider"></div>
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Show/showUpcomingShows">Ver funciones</a>
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li>
      <a href="<?php echo FRONT_ROOT ?>Home/Index" class="btn btn-light">Logout</a>
      </li>
    </ul>
  </div>
</nav>