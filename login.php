<?php
  session_start();
  session_destroy();

  setcookie("email", null, -1);


if ($_POST) {
  $usuariosExistentes = file_get_contents("usuarios.json");
  $usuariosExistentes = json_decode($usuariosExistentes, true);

  foreach ($usuariosExistentes as $usuarioEnArray){
    if ($usuarioEnArray["correo"] == $_POST["email"]) {
      $user = $usuarioEnArray;
      if (password_verify($_POST["password"], $usuarioEnArray["clave"])) {
        session_start();
        if (isset($_POST["recordarme"])) {
          setcookie("correo", $usuarioEnArray["correo"], time()+3600*24*365*5);
        }
        $_SESSION["correo"] = $usuarioEnArray["correo"];
        header("Location:login.php");

        exit;
      }
        break;
    }
  }
  echo "Usuario y/o contraseña inválida.";
}

 ?>


<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
  </head>
  <body>
    <div class="contenedor-principal">
    <header class="cabecera-principal">
      <h1 class="logo"><a href="index.php">Logo</a></h1>
      <ul class="login-navbar">
        <li><a href="registro.php">Registro</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </header>
    </div>
    <div class="contenedor-login">
      <br>
      <section class="container-login">
       <h1>Logo</h1>
        <br>
        <form class="registro" action="" method="post">
          <div class ="contenedor-input">
            <label for="email"></label>
            <br>
            <input id=email type="email" name="email" value="" placeholder="Email">
          </div>

          <div class="contenedor-input">
            <label for="pass"></label>

            <input id=pass type="password" name="password" value="" placeholder="Contraseña">
          </div>
          <a class="pass-olvidada" href="#">¿Olvidaste tu contraseña?</a>
          <label id="recordarme">
          <input type="checkbox" name="recordarme" value="rec"> Recordarme
          </label>
            <br><br>
          <button type="submit" name="button">Iniciar Sesión</button>
        </form>
      </section>
    </div>
  </body>
</html>
