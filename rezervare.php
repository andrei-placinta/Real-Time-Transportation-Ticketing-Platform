<div class="container-fluid">
	<div class="col-lg-12">
		<form id="form-rezervare">

			<!-- ID-ul cursei -->
			<input type="hidden" name="trip_id" value="<?php echo $_GET['id'] ?>">

			<!-- Selectare număr persoane -->
			<div class="form-group row" id="nr_locuri">
				<div class="col-md-3">
					<label for="nr_pers" class="control-label">Persoane</label>
					<input type="number" id="nr_pers" value="1" min='1' max="<?php echo $_GET['max'] ?>"
						class="form-control text-right" onkeydown="return false;">
				</div>

				<!-- Buton confirmare -->
				<div class="col-md-2">
					<label for="button-confirm" class="control-label">&nbsp;</label>
					<button type="button" id="button-confirm" class="btn btn-primary btn-block">Confirmă</button>
				</div>

				<!-- Buton anulare -->
				<div class="col-md-2">
					<label class="control-label">&nbsp;</label>
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Anulează</button>
				</div>
			</div>

			<!-- Detalii rezervare -->
			<div id="detalii-rezervare">
				<div class="row">
					<div class="col-md-12 text-center">
						<button id="button-confirm2" class="btn btn-primary btn-sm">Salvează</button>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Anulează</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Script rezervare -->
<script src="js/rezervare.js"></script>