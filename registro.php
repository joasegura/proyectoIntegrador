<?php

$errorNombreCompleto = "";
$errorUsuario = "";
$errorEmail = "";
$errorContrasenia = "";
$errorConfirmarContrasenia = "";
$errorFoto = "";
$hayErrores = false;

if($_POST){

  $nombreCompleto = trim($_POST["nombreCompleto"]);
  $usuario = trim($_POST["usuario"]);
  $email = trim($_POST["correo"]);
  $contrasenia = trim($_POST["clave"]);
  $confirmarContrasenia = trim($_POST["claveConfirmar"]);
  $foto = $_FILES["imagen"];

  if ($nombreCompleto == ""){
    $errorNombreCompleto = "El nombre esta incompleto";
    $hayErrores = true;
  }
  if ($usuario == "") {
    $errorUsuario = "Completa el campo";
    $hayErrores = true;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errorEmail = "Email no válido";
    $hayErrores = true;
  }
  if ($contrasenia == "") {
    $errorContrasenia = "Completa la contraseña";
    $hayErrores = true;
  }else if (strlen($contrasenia) < 5) {
    $errorContrasenia = "Las contraseñas debe tener al menos 5 caracteres";
    $hayErrores = true;
  }else if ($contrasenia != $confirmarContrasenia) {
    $errorConfirmarContrasenia = "Las contraseñas no coinciden";
    $hayErrores = true;
  }



  if (isset($_FILES["imagen"])) {
    if ($_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
      $nombreFoto = $_FILES["imagen"]["name"];
      $origen = $_FILES["imagen"]["tmp_name"];
      $ext = pathinfo($nombreFoto, PATHINFO_EXTENSION);

      $destino = "";
      $destino = $destino."archivos/";
      $destino = $destino.$nombreCompleto."fotodeperfil.".$ext;


      move_uploaded_file($origen, $destino);
      $errorFoto = "Archivo subido con exito";
    }
  }else {
    $errorFoto = "Error con la foto";
    $hayErrores = true;
  }
  if (!$hayErrores) {
    $usuarioEnArray = [
      "nombreCompleto" => $nombreCompleto,
      "usuario" => $usuario,
      "correo" => $email,
      "clave" => password_hash($contrasenia, PASSWORD_DEFAULT),
      "imagen" => $nombreCompleto."fotodeperfil.".$ext
    ];
    $usuariosExistentes = file_get_contents('usuarios.json');
    $usuariosExistentes = json_decode($usuariosExistentes, true);
    $usuariosExistentes[] = $usuarioEnArray;
    $usuariosEnJson = json_encode($usuariosExistentes, JSON_PRETTY_PRINT);
    file_put_contents('usuarios.json', $usuariosEnJson);
    echo "<h2>Gracias por su registro!<h2>";
    $usuariosExistentes = file_get_contents('usuarios.json');
    $usuariosExistentes = json_decode($usuariosExistentes, true);
    exit;
  }
}



 ?>


<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registro.css">
    <title>Registro</title>
  </head>
  <body>
    <div class="contenedor-principal">
    <header class="cabecera-principal">
      <h1 class="logo"><a href="index.html">Logo</a></h1>
      <ul class="registro-navbar">
        <li><a href="registro.html">Registro</a></li>
        <li><a href="login.html">Login</a></li>
      </ul>
    </header>
    </div>
    <div class="contenedor-registro">
      <br>
      <section class="container-registro">
       <h1>Logo</h1>
        <br>

        <!-- formulario -->
        <form class="registro" action="registro.php" method="post" enctype="multipart/form-data">

          <div class ="contenedor-input">
            <label for="nombre"></label>
            <br>
            <input type="text" name="nombreCompleto" value="" placeholder="Nombre completo*">
            <?= $errorNombreCompleto ?>
          </div>

          <div class="contenedor-input">
            <label for="apellido"></label>
            <input type="text" name="usuario" value="" placeholder="Nombre de usuario*">
            <?= $errorUsuario ?>
          </div>

          <div class="contenedor-input">
            <label for="email"></label>
            <input type="email" name="correo" value="" placeholder="Email*">
            <?= $errorEmail ?>
          </div>

          <div class="contenedor-input">
            <label for="contraseña"></label>
            <input type="password" name="clave" value="" placeholder="Contraseña*">
            <?= $errorContrasenia ?>
          </div>

          <div class="contenedor-input">
            <label for="contraseña"></label>
            <input type="password" name="claveConfirmar" value="" placeholder="Repetir contraseña*">
            <?= $errorConfirmarContrasenia ?>
          </div>

          <div class="contenedor-input">
            <label for="telefono"></label>
            <input type="text" name="telefono" value="" placeholder="Telefono/Celular">
          </div>

          <div class="input-container">
            <label class="pais">País de nacimiento:</label>
            <select name="pais">
                <option value="arg">Seleccione su País</option>
                <option value="arg">Argentina</option>
                <option value="bra">Brasil</option>
                <option value="chi">Chile</option>
                <option value="col">Colombia</option>
                <option value="ven">Venezuela</option>
                <option value="col">Paraguay</option>
                <option value="ven">Uruguay</option>
                <option value="col">Ecuador</option>
                <option value="ven">Bolivia</option>
            </select>
          </div>

             <br> <br>

          <div class="input-container">
            <label class="special-label">Género*:</label> <br><br>
            <label class="short-label"> <input type="radio" name="genero" value="M" class="short-input"> Masculino </label>
            <label class="short-label"> <input type="radio" name="genero" value="F" class="short-input"> Femenino </label>
            <label class="short-label"> <input type="radio" name="genero" value="N/A" class="short-input"> Otro </label>
          </div>

             <br> <br>

             <div class="contenedor-input">
               <label for="file"></label>
               <input type="file" name="imagen">
               <?= $errorFoto ?>
             </div>

          <div class="input-container">
            <label class="special-label">Dejanos tus comentarios:</label>
            <textarea name="comentarios"></textarea>
          </div>

            <br><br>
          <button type="submit" name="button">Registrarme</button>
          <button type="reset" name="button">Cancelar</button>
        </form>
      </section>
    </div>
  </body>
</html>
