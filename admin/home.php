<div id="dashboard-page">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-12 text-center mt-4">
        <h2 class="text-primary">Panou de Control</h2>
        <p class="text-muted">Administrează-ți rapid cursele și rezervările</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card welcome-card">
          <div class="card-body text-center">
            <div class="welcome-message mb-3">
              <?php echo "Bine ai venit, <strong>" . $_SESSION['login_nume_user'] . "</strong>!" ?>
            </div>
            <hr>
            <p class="text-muted">Folosește meniul din stânga pentru a naviga între opțiuni.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>