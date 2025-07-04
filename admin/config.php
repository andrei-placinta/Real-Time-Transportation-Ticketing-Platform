<?php
include 'db_connect.php';

$qry = $conn->query("SELECT * from optiune limit 1");
if ($qry->num_rows > 0) {
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
}
?>

<div class="container-fluid">

	<div class="card col-lg-12">
		<div class="card-body">
			<form id="editare_setari">

				<div class="form-group">
					<label for="titlu" class="control-label">Titlu Site</label>
					<input type="text" class="form-control" id="titlu" name="titlu"
						value="<?php echo isset($meta['titlu']) ? $meta['titlu'] : '' ?>">
					<div class="invalid-feedback">Titlul este obligatoriu.</div>
				</div>

				<div class="form-group">
					<label for="email" class="control-label">Email</label>
					<input type="email" class="form-control" id="email" name="email"
						value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>">
					<div class="invalid-feedback">Adresa de email nu este validă.</div>
				</div>

				<div class="form-group">
					<label for="nr_tel" class="control-label">Telefon</label>
					<input type="text" class="form-control" id="nr_tel" name="nr_tel"
						value="<?php echo isset($meta['nr_tel']) ? $meta['nr_tel'] : '' ?>">
					<div class="invalid-feedback">Numărul de telefon trebuie să aibă exact 10 cifre.</div>
				</div>

				<div class="form-group">
					<label for="despre" class="control-label">Descriere</label>
					<textarea name="despre"
						class="text-jqte"><?php echo isset($meta['despre']) ? $meta['despre'] : '' ?></textarea>
					<div class="invalid-feedback">Descrierea este obligatorie.</div>
				</div>

				<div class="form-group">
					<label for="" class="control-label">Poza</label>
					<input type="file" class="form-control" name="img" onchange="afisare_imagine(this,$(this))">
					<div class="invalid-feedback">Selectați o imagine validă (jpg, png, gif).</div>
				</div>

				<div class="form-group">
					<img src="<?php echo isset($meta['poza']) ? '../img/upload/' . $meta['poza'] : '' ?>" id="pozaId"
						alt="">
				</div>
				<div class="d-flex justify-content-center">
					<button class="btn btn-info btn-primary btn-block col-md-2">Salvează</button>
				</div>

			</form>
		</div>
	</div>

</div>

<script src="js/config.js"></script>