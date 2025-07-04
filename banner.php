<?php

// Setăm un titlu implicit dacă nu există deja unul definit
if (!isset($bannerTitle)) {
    $bannerTitle = "Titlu implicit";
}
?>

<!-- Banner -->
<header class="banner">
    <div class="container h-100">
        <div class="row h-75 align-items-center justify-content-center text-center">
            <div class="col-lg-10 mb-4 align-self-end title-box">
                <h1 class="font-weight-bold text-uppercase text-white"><?php echo $bannerTitle; ?></h1>
            </div>
        </div>
    </div>
</header>