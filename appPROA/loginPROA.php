<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN PROA</title>
  <link rel="stylesheet" href="./cssPROA/estilos_combinados.css">
  
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <<!--
  <style> 
    .demo-footer {
      background-color: rgba(76, 95, 244, 0.5);
  text-align: center;
  font-size: 0.85em;
  color: rgba(0, 0, 0, 0.5);
  margin-top: 2rem;
  padding: 1rem 0;
}

.perfil-buttons {
  margin-top: 0.5rem;
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.perfil-buttons button {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.5rem;
  background-color: #e0e0e0;
  cursor: pointer;
  transition: background-color 0.3s ease;
  font-size: 0.9em;
}

.perfil-buttons button:hover {
  background-color: #ccc;
}
  </style>-->
</head>
<body>
<!--Esto es el panel de la izquierda-->
  <div class="panel-izquierdo">
    <!--aqui va el logo-->
    <a href="../index.php">
      <img src="../img/Logo-Proa.png" alt="Logo de PROA">
    </a>
    <!--aqui va el texto-->
    <p>Ayudamos a conectar docentes y alumnos con módulos educativos mediante una interfaz intuitiva, accesible y cómoda.</p>
  </div>
   <!--Esto es el panel de la derecha-->
   <div class="panel-derecho">
    <div class="cuadrado-login">
      <h2>Bienvenido a PROA</h2>
      <form method="post">
        <?php include('../bbdd/Proalogin.php') ; 
         include('../bbdd/conexionbasesPROA.php') ;
        ?>
        <label for="usuario">Email</label>
        <input type="email" id="usuario" name="usuario" placeholder="Ingresa Email">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Ingresa Contraseña">
        <input type="submit" value="Iniciar Sesión" class="boton-login" name="botonLogin">
      </form>
    </div>
  </div>
 <footer class="demo-footer">
  <p>Se encuentra en la demo de PROA</p>
  <div class="perfil-buttons">
    <button onclick="autocompletar('alumno')">alumno</button>
    <button onclick="autocompletar('profesor')">profesor</button>
    <button onclick="autocompletar('pas')">pas</button>
  </div>
</footer>
</body>
<script>
function autocompletar(perfil) {
  const datos = {
    alumno: { usuario: "l.simdre@epsg.upv.es", contrasena: "9218611" },
    profesor: { usuario: "k.poumai@upv.es", contrasena: "4525956" },
    pas: { usuario: "o.breshe@upv.es", contrasena: "1316390" }
  }[perfil];

  document.getElementById('usuario').value = datos.usuario;
  document.getElementById('contrasena').value = datos.contrasena;
}
</script>
</html>