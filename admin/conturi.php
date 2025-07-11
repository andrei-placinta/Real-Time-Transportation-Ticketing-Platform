<div class="container-fluid mt-4">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<button class="btn btn-sm btn-info" id="adauga_cont">
			<i class="fa fa-plus mr-1"></i> Adaugă Cont Nou
		</button>
	</div>

	<div class="card shadow-sm">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-bordered text-center mb-0">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Nume</th>
							<th>Email</th>
							<th>Telefon</th>
							<th>Comenzi</th>
						</tr>
					</thead>
					<tbody id="conturi-body">
						<?php include 'tabel_conturi.php'; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="js/conturi.js"></script>