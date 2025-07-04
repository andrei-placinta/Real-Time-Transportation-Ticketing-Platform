<nav class="navbar navbar-dark fixed-top">
  <div class="container-fluid d-flex align-items-center justify-content-end">
    <div>
      <span class="text-white"><?php echo $_SESSION['login_nume_user']; ?></span><a href="ajax.php?action=logout"
        class="btn-logout ml-3"><i class="fa fa-power-off"></i></a>
    </div>
  </div>
</nav>