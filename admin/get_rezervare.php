<style>
	#modal_window .modal-footer {
		display: none;
	}
</style>

<?php
include 'db_connect.php';

$qry = $conn->query("SELECT * FROM rezervare where id = " . $_GET['id']);
foreach ($qry->fetch_array() as $key => $value) {
	$$key = $value;
}

?>

<div class="container-fluid">
	<div class="col-lg-12">
		<form id="formular-rezervare">
			<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
			<div class="row">
				<div class="col-md-6">
					<label class="control-label">Nume</label>
					<input type="text" name="nume" class="form-control" value="<?php echo $nume; ?>">
					<div class="invalid-feedback">Numele este obligatoriu.</div>
				</div>
				<div class="col-md-6">
					<label class="control-label">Număr Telefon</label>
					<input type="text" name="telefon" class="form-control" value="<?php echo $telefon; ?>">
					<div class="invalid-feedback">Numărul de telefon trebuie să aibă exact 10 cifre.</div>
				</div>
			</div>

			<div class="row mt-2">
				<div class="col-md-6">
					<label class="control-label">Email</label>
					<input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
					<div class="invalid-feedback">Adresa de email nu este validă.</div>
				</div>
				<div class="col-md-6">
					<label class="control-label">Stare rezervare</label>
					<select name="stare" class="form-control">
						<option value="1" <?php echo (strcmp($stare, 'in progres') == 0) ? 'selected' : '' ?>>in progres
						</option>
						<option value="2" <?php echo (strcmp($stare, 'confirmata') == 0) ? 'selected' : '' ?>>confirmata
						</option>
						<option value="3" <?php echo (strcmp($stare, 'anulata') == 0) ? 'selected' : '' ?>>anulata
						</option>
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 text-center">
					<p>&nbsp;</p>
					<button class="btn btn-primary btn-sm">Salvare</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Anulare</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="js/get_rezervare.js"></script>