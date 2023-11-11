<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp 2</title>
    <link rel="shortcut icon" href="./src/LOGO/logopro-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="">
    <header class="flex">
        <div class="nav">
            <img class="logoarriba" src="./src/LOGO/_55770202-d102-434c-ab15-1b4f4bb9e1a3.png">
        </div>
    </header>
    <form action="./inc/validaciones_prueba.php" method="post" id="loginForm">
        <div class="flex" id="oscuro">
            <div class="container row">
                <div class="column-2-izq flex">
                    <img class="logo" src="./src/LOGO/logopro-removebg-preview.png" alt="">
                </div>
                <div class="column-2-der">
                    <h2 id="titulo">WhatsApp 2 | Login</h2>
                    <form>
                        <div class="inputs">
                            <label for="form2Example17">Nombre de usuario:</label>
                            <input type="input" id="user" name="user" class="form-control" />
                        </div>
                        <div class="inputs">
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" id="password" name="password" id="form2Example27" class="form-control" />
                            <?php if (isset($_GET['error'])) {echo " <br> <br> <p style='text-align: center;'>Usuario o contraseña incorrecto.</p>"; } ?>
                            <?php if (isset($_GET['emptyUsr'])) {echo " <br> <br> <p style='text-align: center;'>No has ingresado el usuario.</p>"; } ?>
                            <?php if (isset($_GET['emptyPwd'])) {echo " <br> <br> <p style='text-align: center;'>No has ingresado la contrasña.</p>"; } ?>
                        </div>
                       
                        <div class="flex">
                            <input type="submit" class="boton" name="inicio" value="Iniciar sesión">
                        </div>
                        <div class="abajo">
                            <a class="link" href="./indexRegister.php">
                                <p class="pp">¡Registrate Gratis!</p>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</section>
</body>


</html>