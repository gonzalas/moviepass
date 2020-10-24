<style>
     .login-view {
        height: 100vh;
        background-image: linear-gradient(to right, #ba001f, red);
        }
        .login-img{
            position: absolute;
            margin-left: 650px;
        }
        .navbar {
            display: flex;
            justify-content: flex-end;
            border-bottom: 1px solid #ff3b55;
        }
        .nav-list {
            display: flex;
            margin: 10px;
        }
        .nav-list label {
            line-height: 100%;
            margin-top: 5px;
            margin-right: 3px;
            color: #fad4d9;
        }
        .nav-list input {
            border: 0;
            border-radius: 5px;
            width: 150px;
        }
        .btn-login {
            height: 40px;
            outline: none;
        }
        .btn-login:hover {
            cursor: pointer;
            background-color: #fad4d9;
            transition: 1s; 
        }
</style>

<main class="login-view">
    <form  action="<?php echo FRONT_ROOT ?>User/processLogin" method="post">
        <nav class="navbar">
            <div class="nav-list">
                <label for="userName">Usuario:</label>
                <input type="text" id="userName" name="userName">
            </div>
            
            <div class="nav-list">
                <label for="userPass">Contraseña:</label>
                <input type="password" id="userPass" name="userPassword">
            </div>
            <div class="nav-list">
                <input type="submit" value="Ingresar" class="btn-login">
            </div>
        </nav>
    </form>
  

    <section class="container">
        <div class="pt-5">
            <h1 style="color: #e88e9d; font-weight: 700;">Cinema</h1>
        </div>

        <div class="login-img">
            <svg id="Capa_1" enable-background="new 0 0 501 501" height="350" viewBox="0 0 501 501" width="350" xmlns="http://www.w3.org/2000/svg"><g><path d="m50.952 398.18c-29.197-40.905-46.131-91.166-45.431-145.413 1.757-136.243 113.284-244.199 249.515-241.726 133.217 2.419 240.464 111.164 240.464 244.959 0 52.796-16.7 101.691-45.105 141.691-1.914 2.695-5.73 3.16-8.241 1.009-49.644-42.535-117.207-68.7-191.654-68.7-74.671 0-142.416 26.322-192.101 69.084-2.263 1.948-5.712 1.526-7.447-.904z" fill="#533672"/><path d="m412.842 85.481-347.686 126.547c-7.785 2.833-16.392-1.18-19.226-8.965l-20.521-56.382c-2.833-7.785 1.18-16.392 8.965-19.226l347.686-126.546c7.785-2.833 16.392 1.18 19.226 8.965l20.521 56.382c2.833 7.784-1.18 16.392-8.965 19.225z" fill="#edd578"/><path d="m415.978 50.24-375.877 136.808-14.692-40.366c-2.833-7.785 1.18-16.392 8.965-19.226l347.686-126.547c7.785-2.833 16.392 1.18 19.226 8.965z" fill="#f1de96"/><path d="m146.197 86.756 1.668 61.069-73.295 26.678-1.669-61.069zm39.467-14.365 1.669 61.069 73.296-26.678-1.668-61.069zm186.059-67.72-73.296 26.677 1.668 61.07 73.296-26.678z" fill="#eac23f"/><path d="m260.629 106.783.922 33.764-73.296 26.678-.922-33.764zm-186.059 67.72.922 33.764 73.296-26.678-.922-33.763zm298.822-108.763-73.296 26.678.922 33.763 73.296-26.677z" fill="#c3a01a"/><path d="m450.5 257v140.543c-44.384 62.601-117.421 103.457-200 103.457s-155.616-40.856-200-103.457v-155.543l-17.332-74h1.332c44.461-4.446 84.324 27.454 89.733 71.808l.267 2.192h311c8.284 0 15 6.716 15 15z" fill="#edd578"/><path d="m94.5 250v194.924c-16.663-13.775-31.473-29.711-44-47.38v-147.019c0-5.667-.604-11.318-1.802-16.857l-9.303-39.222c21.032 0 37.061 11.427 48.355 28.554 6.426 9.745 6.75 27 6.75 27z" fill="#e9cc5a"/><path d="m370.5 440.588h-240c-5.523 0-10-4.477-10-10v-140.588c0-5.523 4.477-10 10-10h240c5.523 0 10 4.477 10 10v140.588c0 5.523-4.477 10-10 10z" fill="#f5e8b4"/><path d="m370.5 440.588h-217.5c-5.523 0-10-4.477-10-10v-140.588c0-5.523 4.477-10 10-10h217.5c5.523 0 10 4.477 10 10v140.588c0 5.523-4.477 10-10 10z" fill="#f9f1d2"/><path d="m347 325.294h-55c-4.142 0-7.5-3.358-7.5-7.5 0-4.142 3.358-7.5 7.5-7.5h55c4.142 0 7.5 3.358 7.5 7.5 0 4.142-3.358 7.5-7.5 7.5zm-22.5 17.5c0-4.142-3.358-7.5-7.5-7.5h-25c-4.142 0-7.5 3.358-7.5 7.5 0 4.142 3.358 7.5 7.5 7.5h25c4.142 0 7.5-3.358 7.5-7.5zm30 35c0-4.142-3.358-7.5-7.5-7.5h-55c-4.142 0-7.5 3.358-7.5 7.5 0 4.142 3.358 7.5 7.5 7.5h55c4.142 0 7.5-3.358 7.5-7.5zm-20 25c0-4.142-3.358-7.5-7.5-7.5h-35c-4.142 0-7.5 3.358-7.5 7.5 0 4.142 3.358 7.5 7.5 7.5h35c4.142 0 7.5-3.358 7.5-7.5z" fill="#edd578"/><path d="m201.826 302.764 15.546 31.499c.728 1.476 2.136 2.499 3.765 2.735l34.762 5.051c4.101.596 5.739 5.636 2.771 8.528l-25.154 24.519c-1.178 1.149-1.716 2.804-1.438 4.426l5.938 34.621c.701 4.085-3.587 7.199-7.255 5.271l-31.092-16.346c-1.457-.766-3.197-.766-4.653 0l-31.092 16.346c-3.668 1.928-7.955-1.186-7.255-5.271l5.938-34.621c.278-1.622-.26-3.277-1.438-4.426l-25.154-24.519c-2.968-2.893-1.33-7.933 2.771-8.528l34.762-5.051c1.629-.237 3.036-1.259 3.765-2.735l15.546-31.499c1.834-3.716 7.133-3.716 8.967 0z" fill="#e9cc5a"/><path d="m238.016 414.144c.701 4.084-3.587 7.199-7.255 5.271l-31.092-16.346c-1.457-.766-3.197-.766-4.653 0l-31.092 16.346c-3.668 1.928-7.955-1.186-7.255-5.271l5.938-34.621c.278-1.622-.26-3.277-1.438-4.426l-25.154-24.519c-2.968-2.893-1.33-7.933 2.771-8.529l27.702-4.025c12.037 25.285 36.952 43.256 66.264 45.432z" fill="#e1b91e"/><path d="m368.392 191.139 14.156-4.146c1.154-.338 2.226.734 1.888 1.888l-4.146 14.156c-.082.279-.082.576 0 .855l4.146 14.156c.338 1.154-.734 2.226-1.888 1.888l-14.156-4.146c-.279-.082-.576-.082-.855 0l-14.156 4.146c-1.154.338-2.226-.734-1.888-1.888l4.146-14.156c.082-.279.082-.576 0-.855l-4.146-14.156c-.338-1.154.734-2.226 1.888-1.888l14.156 4.146c.279.081.576.081.855 0z" fill="#c3a01a"/><path d="m276.795 175.533 18.606-5.45c1.517-.444 2.926.964 2.482 2.482l-5.45 18.606c-.108.367-.108.757 0 1.124l5.45 18.606c.444 1.517-.964 2.926-2.482 2.482l-18.606-5.45c-.367-.108-.757-.108-1.124 0l-18.606 5.45c-1.517.444-2.926-.964-2.482-2.482l5.45-18.606c.108-.367.108-.757 0-1.124l-5.45-18.606c-.444-1.517.964-2.926 2.482-2.482l18.606 5.45c.367.107.757.107 1.124 0z" fill="#e9cc5a"/><path d="m424.917 126.721-7.543 20.386c-.203.547-.634.979-1.182 1.182l-20.386 7.543c-1.741.644-1.741 3.107 0 3.751l20.386 7.543c.547.203.979.634 1.182 1.182l7.543 20.386c.644 1.741 3.107 1.741 3.751 0l7.543-20.386c.203-.547.634-.979 1.182-1.182l20.386-7.543c1.741-.644 1.741-3.107 0-3.751l-20.386-7.543c-.547-.203-.979-.634-1.182-1.182l-7.543-20.386c-.644-1.741-3.107-1.741-3.751 0z" fill="#fff5f5"/></g></svg>
        </div>

        <div>
            <form action="<?php echo FRONT_ROOT ?>User/registerUser" method="post" class="p-2 mt-5" style="width: 50%;">
                <div class="form-group">
                    <div class="col">
                        <input type="text" name="firstName" class="form-control" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <input type="text" name="lastName" class="form-control" placeholder="Apellido" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <input type="text" name="email" class="form-control" placeholder="Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <input type="text" name="username" class="form-control" placeholder="Usuario" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col">
                        <input type="password" name="password2" class="form-control" placeholder="Repita contraseña" required>
                    </div>
                </div>
                <div class="form-group mt-5 float-right">
                    <button type="submit" class="btn btn-primary mb-2">Registarme</button>
                </div>
            </form>
        </div>

    </section>
</main>

