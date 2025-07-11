<?php include 'db_connect.php'; ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<strong>Curse</strong>
				</large>
				<button class="btn btn-primary btn-block col-md-2 float-right" type="button" id="cursa_noua"><i
						class="fa fa-plus"></i> Cursă nouă</button>
			</div>

			<div class="card-body">
				<table class="table table-bordered" id="tabel-curse">
					<colgroup>
						<col width="5%">
						<col width="20%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					</colgroup>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="js/info_curse.js"></script>