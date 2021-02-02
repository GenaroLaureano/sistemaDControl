<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="index.php">
                        <div class="form-group">
                            <label for="usuario_nick">Usuario</label>
                            <input type="text" class="form-control" placeholder="Introduzca su usuario o correo"
                            id="usuario_nick" name="usuario_nick">
                        </div>
                        <div class="form-group">
                            <label for="usuario_password">Contraseña</label>
                            <input type="password" class="form-control" placeholder="Introduzca su contraseña" id="usuario_password" name="usuario_password" required>
                        </div>
                        <div class="text-right">
                            <input class="btn btn-info" type="submit" value="Acceder" name="btnLogin">
                        </div>
                    </form>
                    <?php
                        if(isset($errmensaje)){
                            echo"<div class='alert alert-danger'>$errmensaje</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>