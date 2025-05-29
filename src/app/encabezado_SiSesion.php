<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
?>

<header>
    <div class="logo">
      <a href="HomepageGTI.php"><img src="../img/logoGTI.png" alt="Logo de GTI"></a>
    </div>

    <button class="hamburger" aria-label="Abrir menú" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>

    <div class="div-header">
      <nav class="botones-sub">
        <a href="sobrenosotros_SiSesion.php">Sobre Nosotros</a>
        <a href="formulario_contacto_SiSesion.php">Contacto</a>
      </nav>

      <div class="user-info">
        <a class="username">
          <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Usuario'; ?>
        </a>
        <img src="../img/user.png" alt="Usuario" class="avatar">
        <a href="../logout.php"><img class="cerrarsesionGTI" src="../img/cerrarsesionGTI.png" alt="Cerrar Sesión"></a>
      </div>
    </div>
</header>

