<?php

// Setăm titlul bannerului și includem componenta banner
$bannerTitle = "Contactează-ne";
include 'banner.php';

?>

<div id="sectiune-contact">
	<div class="container">
		<div class="row">

			<!-- Formular de contact -->
			<div class="col-md-4">
				<h2>Formular de contact</h2>
				<p>Completează câmpurile<br>pentru a ne trimite un mesaj.</p>
			</div>

			<!-- Informații utile -->
			<div class="col-md-4">
				<h2>Informații utile</h2>
				<ul>
					<li><i class="fa fa-map-marker-alt fa-3x"></i>România, RO</li>
					<hr>
					<li><i class="fa fa-mobile-alt fa-3x"></i> <?php echo $_SESSION['config_nr_tel'] ?></li>
					<hr>
					<li><i class="fa fa-paper-plane fa-2x"></i> <?php echo $_SESSION['config_email'] ?></li>
				</ul>
			</div>

			<!-- Formular propriu-zis -->
			<div class="col-md-4">

				<div id="msgSuccess">Mesaj trimis cu succes</div>
				<div id="msgError"></div>

				<form action="send_mail.php" method="post" class="formular-contact">
					<div class="form-group">
						<input type="text" name="nume" data-rule="minlen:4"
							data-msg="Vă rugăm să introduceți minim 4 caractere" placeholder="Numele tău"
							class="form-control">
						<div class="feedback-validare"></div>
					</div>

					<div class="form-group">
						<input type="email" name="email" data-rule="email"
							data-msg="Vă rugăm să introduceți un email valid" placeholder="Adresa email"
							class="form-control">
						<div class="feedback-validare"></div>
					</div>

					<div class="form-group">
						<input type="text" name="subiect" data-rule="minlen:4"
							data-msg="Va rugăm să introduceți minim 4 caractere" placeholder="Titlul mesajului"
							class="form-control">
						<div class="feedback-validare"></div>
					</div>

					<div class="form-group">
						<textarea name="mesaj" data-rule="required" data-msg="Mesajul nu poate fi gol"
							placeholder="Scrie mesajul tău" class="form-control"></textarea>
						<div class="feedback-validare"></div>
					</div>

					<button type="submit" class="btn-custom">Trimite</button>
				</form>

			</div>
		</div>
	</div>
</div>
</div>

<script src="js/contact.js"></script>