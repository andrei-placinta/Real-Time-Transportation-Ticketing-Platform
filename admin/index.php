<!DOCTYPE html>
<html lang="ro">

<?php

session_start();

include 'header.php';
include 'topbar.php';
include 'sidebar.php';

if (!isset($_SESSION['login_id']))
  header("Location: login.php");
?>

<body>
  <!-- Notificare verde (succes) sau roșie (eroare)  -->
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white"></div>
  </div>

  <main>
    <?php

    // Include pagina activă (default home)
    $page = isset($_GET['page']) ? $_GET['page'] : "home";
    include $page . '.php';
    ?>
  </main>

  <!-- Fereastră modală confirmare  -->
  <div class="modal fade" id="modal_confirm" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm_btn'>Da</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Fereastră modală editare -->
  <div class="modal fade" id="modal_window" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="$('#modal_window form').submit()">Salvare</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulare</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Loader -->
  <!-- <div id="loader-screen"></div> -->

</body>
<!-- JS personalizat -->
<script src="js/scripts.js"></script>

</html>