<?php
$bannerTitle = "Personal";
include 'banner.php';

// Obține toți administratorii
$admini = $conn->query("SELECT * FROM admin");

if ($admini && $admini->num_rows > 0):
?>

	<!-- Secțiune echipă admin -->
	<div class="container mt-5">
		<h4 class="mb-4 text-center">Echipa de administrare:</h4>
		<div class="row">
			<?php while ($row = $admini->fetch_assoc()): ?>
				<div class="col-md-4 mb-4">
					<div class="card text-center shadow h-100">
						<img src="img/default.jpg" alt="Poza Admin" class="card-img-top d-block mx-auto profile-img">
						<div class="card-body">
							<h5 class="card-title"><?php echo $row['nume_user']; ?></h5>
							<p class="card-text">
								<strong>Email:</strong> <?php echo $row['email']; ?><br>
								<strong>Telefon:</strong> <?php echo $row['nr_tel']; ?>
							</p>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>

<?php else: ?>

	<!-- Mesaj fallback dacă nu sunt admini -->
	<div class="container mt-5 text-center">
		<p class="text-muted">Nu există administratori înregistrați.</p>
	</div>

<?php endif; ?>