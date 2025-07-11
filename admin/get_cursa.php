<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM cursa where id =" . $_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$$key = $value;
	}
}

$ocupate = isset($_GET['ocupate']) ? $_GET['ocupate'] : 0;
?>

<div class="container-fluid">
	<div class="col-lg-12">
		<form id="formular-cursa">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="row form-group">
				<div class="col-md-3">
					<label>Plecare din</label>
					<select name="origine_id" id="origine_id" class="custom-select select2">
						<option value="select_from">-- Selectează --</option>
						<?php
						$lista_orase = $conn->query("SELECT * FROM oras order by denumire");
						while ($row = $lista_orase->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($origine_id) && $origine_id == $row['id'] ? "selected" : '' ?>><?php echo $row['denumire'] ?>
							</option>
						<?php endwhile; ?>
					</select>
					<div class="invalid-feedback">Selectați o opțiune.</div>
				</div>
				<div class="col-md-3">
					<label>Sosire la</label>
					<select name="destinatie_id" id="destinatie_id" class="custom-select select2">
						<option value="select_to">-- Selectează --</option>
						<?php
						$lista_orase = $conn->query("SELECT * FROM oras order by denumire");
						while ($row = $lista_orase->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($destinatie_id) && $destinatie_id == $row['id'] ? "selected" : '' ?>><?php echo $row['denumire'] ?>
							</option>
						<?php endwhile; ?>
					</select>
					<div class="invalid-feedback">Selectați o opțiune.</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-3">
					<label>Dată plecare</label>
					<input type="text" name="program" id="program" class="form-control datetimepicker"
						value="<?php echo isset($program) ? date("Y-m-d H:i", strtotime($program)) : '' ?>">
					<div class="invalid-feedback">Introduceți data.</div>
					<div class="input-group-append">
						<button type="button" id="setNowBtn" class="btn btn-outline-secondary">Acum</button>
					</div>
				</div>
				<div class="col-md-3">
					<label for="">Locuri (<?php echo $ocupate > 0 ? $ocupate : 1; ?>-100)</label>
					<input min="<?php echo $ocupate > 0 ? $ocupate : 1; ?>" max='100' name="locuri_disp"
						id="locuri_disp" type="number" data-ocupate="<?php echo $ocupate ?>"
						class="form-control text-right" value="<?php echo isset($locuri_disp) ? $locuri_disp : '1' ?>">
					<div class="invalid-feedback">Introduceți un număr valid.</div>
				</div>
				<div class="col-md-3">
					<label for="">Preț (1-9999)</label>
					<input min='1' max='9999' name="pret" id="pret" type="number" class="form-control text-right"
						value="<?php echo isset($pret) ? $pret : '1' ?>">
					<div class="invalid-feedback">Introduceți un număr valid.</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script src="js/get_cursa.js"></script>