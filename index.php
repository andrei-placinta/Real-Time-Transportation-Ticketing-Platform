<!DOCTYPE html>
<html lang="ro">

<?php

session_start();
ob_start();

include 'header.php';
include 'admin/db_connect.php';

// Preluare setări din baza de date și salvare în sesiune
$config = $conn->query("SELECT * FROM optiune limit 1")->fetch_array();
foreach ($config as $key => $value) {
  if (!is_numeric($key))
    $_SESSION['config_' . $key] = $value;
}
ob_end_flush();
?>

<body>
  <!-- Notificare verde (succes) colț dreapta sus la finalizare rezervare -->
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white"></div>
  </div>

  <!-- Navbar fix sus -->
  <nav class="navbar navbar-expand-lg fixed-top py-3 bg-info" id="navCore">
    <div class="container">
      <i class="fa fa-shuttle-van fa-3x"></i>
      <a class="navbar-brand js-scroll-trigger" href="./"><?php echo "&nbsp;" . $_SESSION['config_titlu'] ?></a>

      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home">Acasă</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=curse">Curse</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=info">Informații</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=personal">Personal</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=contact">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <?php

  // Include pagina activă (default home)
  $page = isset($_GET['page']) ? $_GET['page'] : "home";
  include $page . '.php';
  ?>

  <!-- Fereastră modală pentru rezervări -->
  <div class="modal fade" id="modal_window" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <!-- Loader -->
  <div id="loader-screen"></div>

  <!-- Footer -->
  <footer class="bg-light py-3">
    <div class="container">
      <div class="small text-center text-muted">
        <?php echo "&#169; 2025 " . $_SESSION['config_titlu'] . ". Toate drepturile rezervate."; ?>
      </div>
    </div>
  </footer>

  <?php include 'footer.php'; ?>
</body>

</html>