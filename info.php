<?php

// Valori implicite
$descriereSite = 'Informațiile nu sunt disponibile.';
$pozaIncarcata = 'img/bg1.jpg';

// Suprascrie descrierea dacă există în sesiune
if (!empty($_SESSION['config_despre'])) {
	$descriereSite = html_entity_decode($_SESSION['config_despre']);
}

// Suprascrie imaginea dacă există în sesiune
if (!empty($_SESSION['config_poza'])) {
	$pozaIncarcata = sprintf("img/upload/%s", $_SESSION['config_poza']);
}

$bannerTitle = "Despre noi";
include 'banner.php';
?>

<section class="section-block">

	<!-- Descriere text -->
	<div class="container mb-5">
		<?php echo $descriereSite; ?>
	</div>

	<!-- Imagine principală  -->
	<div class="image-wrapper mb-5">
		<img src="<?php echo $pozaIncarcata; ?>" alt="Imagine Incarcata" class="image-responsive">
	</div>

	<!-- Secțiunea Avantaje -->
	<div id="features">
		<div class="container">
			<div class="text-center mb-4">
				<h3>De ce noi?</h3>
				<p>Oferim cele mai bune servicii<br>clienților noștri</p>
			</div>

			<div class="row">
				<?php

				// Listă avantaje
				$avantaje = [
					[
						"titlu" => "Prețuri accesibile",
						"descriere" => "Garanția<br>celui mai bun<br>preț",
						"imagine" => "img/img1.jpg",
						"animatie" => "fadeInRight"
					],
					[
						"titlu" => "Opțiuni variate",
						"descriere" => "Diversitate pentru fiecare destinație",
						"imagine" => "img/img2.jpg",
						"animatie" => "fadeInRight"
					],
					[
						"titlu" => "Disponibilitate",
						"descriere" => "Puteți cumpăra în orice moment",
						"imagine" => "img/img3.jpg",
						"animatie" => "fadeInLeft"
					],
					[
						"titlu" => "Asistență clienți",
						"descriere" => "Program cu clienții non-stop",
						"imagine" => "img/img4.jpg",
						"animatie" => "fadeInLeft"
					]
				];

				foreach ($avantaje as $index => $item): ?>
					<div class="col-md-3 <?php echo $item['animatie']; ?>">
						<div class="text-center">
							<div class="hi-icon-wrap hi-icon-effect">
								<img src="<?php echo $item['imagine']; ?>" alt="<?php echo $item['titlu']; ?>">
							</div>
							<h2><?php echo $item['titlu']; ?></h2>
							<p><?php echo $item['descriere']; ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>