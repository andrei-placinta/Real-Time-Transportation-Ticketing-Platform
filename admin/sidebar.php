<style>
body { margin-left: 250px; padding: 20px; background: #f8f9fa; padding-top: 80px; }
@media screen and (max-width: 768px) {
  body { margin-left: 0; }
}
</style>

<!-- Sidebar  -->
<nav id="sidebar">
  <div class="sidebar-list">
    <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-house-user"></i></span> Acasă</a>
    <a href="index.php?page=info_rezervari" class="nav-item nav-info_rezervari"><span class='icon-field'><i class="fa fa-calendar-check"></i></span> Rezervări</a>
    <a href="index.php?page=info_curse" class="nav-item nav-info_curse"><span class='icon-field'><i class="fa fa-taxi"></i></span> Curse</a>
    <a href="index.php?page=orase" class="nav-item nav-orase"><span class='icon-field'><i class="fa fa-map-marked-alt"></i></span> Orașe</a>
    <a href="index.php?page=conturi" class="nav-item nav-conturi"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Conturi</a>
    <a href="index.php?page=config" class="nav-item nav-config"><span class='icon-field'><i class="fa fa-tools"></i></span> Setări</a>
  </div>
</nav>

<!-- Buton toggle -->
<button class="sidebar-toggle" id="sidebarToggle"><i class="fa fa-bars"></i></button>

<script>

  // active nav item din PHP
  $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');

  // toggle sidebar pe mobil
  $('#sidebarToggle').on('click', function () {
    $('#sidebar').toggleClass('active');
  });

</script>