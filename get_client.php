<?php

// Preia numărul de rezervări din parametrul GET 'count', implicit 0
$nrRezervari = isset($_GET['count']) ? (int) $_GET['count'] : 0;

// Generează câte un set de câmpuri pentru fiecare rezervare
for ($index = 0; $index < $nrRezervari; $index++): ?>
	<div class="row mb-3">
		<div class="col-md-6">
			<label class="control-label">Nume</label>
			<input type="text" name="nume[]" class="form-control">
			<div class="invalid-feedback">Numele este obligatoriu.</div>
		</div>
		<div class="col-md-6">
			<label class="control-label">Număr telefon</label>
			<input type="text" name="telefon[]" class="form-control">
			<div class="invalid-feedback">Numărul de telefon trebuie să aibă exact 10 cifre.</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="form-group col-md-12">
			<label class="control-label">Email</label>
			<input type="text" name="email[]" class="form-control">
			<div class="invalid-feedback">Adresa de email nu este validă.</div>
		</div>
	</div>
<?php endfor; ?>