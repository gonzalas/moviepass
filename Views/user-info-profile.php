<?php
    require_once("nav-client.php"); 
?>
<style>
    body {
        background-image: linear-gradient(to right, #ba001f, red);
        }
        img#img-back-prof {
        position: absolute;
        width: 100%;
        z-index: -1;
        top: 0;
        max-height: 100vh;
        left: 0;
        filter: opacity(0.2) grayscale(1) contrast(200%) blur(3.5px);
        object-fit: cover;
    }
</style>

<main class="container">
    <section>
        <div class="mt-5 mb-5">
            <h1 style="color: #e88e9d; font-weight: 700;">Perfil</h1>
        </div>
        <img id="img-back-prof" src="<?php echo IMG_PATH."poster01.jpg"; ?>" alt="Poster">
        <div>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Contraseña</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $user->getFirstName(); ?></th>
                    <td><?php echo $user->getLastName(); ?></td>
                    <td><?php echo $user->getEmail(); ?></td>
                    <td><?php echo $user->getUserName(); ?></td>
                    <td><?php echo $user->getPassword(); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>