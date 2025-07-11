<?php include 'db_connect.php'; ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">

			<!-- Formular -->
			<div class="col-md-4">
				<form id="modif_orase">
					<div class="card">
						<div class="card-header">
							Orașe
						</div>
						<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Denumire</label>
								<input name="denumire" class="form-control"></i>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-primary col-sm-3 offset-md-3">Adaugă</button>
									<button class="btn btn-sm btn-secondary col-sm-3" type="button"
										onclick="_reset()">Anulează</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<!-- Tabel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover" id="tabel-orase">
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<script src="js/orase.js"></script>