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
    .container {
        font-size: 1.3rem;
    }
    #edit-section input {
        width: 198px;
    }
    #edit-btn{
        float: right;
    }
</style>

<main class="container">
    <section>
        <div class="mt-5 mb-5">
            <h1 style="color: #e88e9d; font-weight: 700;">Perfil</h1>
        </div>
        <img id="img-back-prof" src="<?php echo IMG_PATH."poster01.jpg"; ?>" alt="Poster">
        <div>
        <?php if($message){ ?>
            <div class="alert alert-secondary" role="alert">
                    <h5><?php echo $message ?></h5>
            </div>
        <?php } else {?>
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
            <button id="edit-btn" type="button" class="btn btn-info" onClick="showEditProfile()">Editar</button>
        </div>
        <?php } ?>
    </section>
</main>

<section id="edit-section" class="container animate__animated animate__fadeInDown 1s" style="display: none; margin-top: 5%; opacity: 0.9;">
     <form action="<?php echo FRONT_ROOT?>User/changeInfoUser" method="post">
        <table class="table table-striped table-light">
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
                    <th scope="row"><input type="text" value="<?php echo $user->getFirstName(); ?>" style="background-color: grey;" readonly></th>
                    <td><input type="text" value="<?php echo $user->getLastName();?>"  style="background-color: grey;" readonly></td>
                    <td><input type="text" value="<?php echo $user->getEmail(); ?>" style="background-color: grey;" readonly></td>
                    <td><input type="text" name="userName" placeholder="Usuario" required></td>
                    <td><input type="text" name="password" placeholder="Contraseña" required></td>
                    </tr>
                </tbody>
        </table>
        <button type="submit" class="btn btn-success">Confirmar</button>
    </form>
</section>

<script>
    function showEditProfile(){
        document.getElementById("edit-section").style.display = "block";
    }
</script>