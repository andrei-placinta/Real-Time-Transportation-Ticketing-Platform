<!DOCTYPE html>
<html lang="ro">

<?php
include 'header.php';
include 'db_connect.php';
session_start();
if (isset($_SESSION['login_id']))
  header("Location: index.php?page=home");
?>

<body>
  <div class="login-page">
    <main id="main-container">
      <div id="login-center">
        <div class="card">
          <div class="card-body">
            <form id="formular-login">
              <div class="form-group">
                <label class="control-label">Nume / Email</label>
                <input type="text" name="nume_login" class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label">Parola</label>
                <input type="password" name="parola_login" class="form-control">
              </div>
              <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary mt-3">Conectare</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="js/login.js"></script>
</body>

</html>