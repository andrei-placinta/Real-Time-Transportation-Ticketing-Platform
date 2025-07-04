<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM admin where id =" . $_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
}
?>

<div class="container-fluid">
	<form id="formular-cont">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">

		<div class="form-group">
			<label for="nume_user">Nume</label>
			<input type="text" name="nume_user" id="nume_user" class="form-control"
				value="<?php echo isset($meta['nume_user']) ? $meta['nume_user'] : '' ?>" required>
			<div class="invalid-feedback">Numele este obligatoriu.</div>
		</div>

		<div class="form-group">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" class="form-control"
				value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required>
			<div class="invalid-feedback">Adresa de email nu este validă.</div>
		</div>

		<div class="form-group">
			<label for="hash_parola">Parola</label>
			<input type="password" name="hash_parola" id="hash_parola" class="form-control" required>
			<div class="invalid-feedback">Parola este obligatorie.</div>
		</div>

		<div class="form-group">
			<label for="nr_tel">Telefon</label>
			<input type="text" name="nr_tel" id="nr_tel" class="form-control"
				value="<?php echo isset($meta['nr_tel']) ? $meta['nr_tel'] : '' ?>" required>
			<div class="invalid-feedback">Numărul de telefon trebuie să aibă exact 10 cifre.</div>
		</div>

	</form>
</div>

<script>
	$('#formular-cont').submit(function (e) {
		e.preventDefault();

		const existingUsers = <?php
		$result = $conn->query("SELECT nume_user FROM admin");
		$names = [];
		while ($row = $result->fetch_assoc()) {
			$names[] = $row['nume_user'];
		}
		echo json_encode($names);
		?>;

		const existingEmails = <?php
		$result = $conn->query("SELECT email FROM admin");
		$emails = [];
		while ($row = $result->fetch_assoc()) {
			$emails[] = $row['email'];
		}
		echo json_encode($emails);
		?>;

		const existingPhones = <?php
		$result = $conn->query("SELECT nr_tel FROM admin");
		$phones = [];
		while ($row = $result->fetch_assoc()) {
			$phones[] = $row['nr_tel'];
		}
		echo json_encode($phones);
		?>;

		let valid = true;
		let isEdit = $('input[name="id"]').val() !== "";

		$('input[name="nume_user"]').each(function (index) {
			let value = $(this).val().trim();
			let feedback = $(this).closest('.form-group').find('.invalid-feedback');

			if (value === "") {
				valid = false;
				$(this).addClass('is-invalid');
				feedback.text('Numele este obligatoriu.').show();
			} else if (!isEdit && existingUsers.includes(value)) {
				valid = false;
				$(this).addClass('is-invalid');
				feedback.text('Acest nume de utilizator există deja.').show();
			} else {
				$(this).removeClass('is-invalid');
				feedback.hide();
			}
		});

		$('input[name="email"]').each(function () {
			let email = $(this).val().trim();
			let feedback = $(this).closest('.form-group').find('.invalid-feedback');
			const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

			if (!pattern.test(email)) {
				$(this).addClass('is-invalid');
				valid = false;
				feedback.text('Adresa de email nu este validă.').show();
			} else if (!isEdit && existingEmails.includes(email)) {
				valid = false;
				$(this).addClass('is-invalid');
				feedback.text('Acest email există deja.').show();
			} else {
				$(this).removeClass('is-invalid');
				feedback.hide();
			}
		});

		$('input[name="hash_parola"]').each(function (index) {
			if ($('input[name="id"]').val() === "" && $(this).val().trim() === "") {
				valid = false;
				$(this).addClass('is-invalid');
			} else {
				$(this).removeClass('is-invalid');
			}
		});

		$('input[name="nr_tel"]').each(function () {
			let phone = $(this).val().trim();
			let feedback = $(this).closest('.form-group').find('.invalid-feedback');

			if (!/^\d{10}$/.test(phone)) {
				$(this).addClass('is-invalid');
				valid = false;
				feedback.text('Numărul de telefon trebuie să aibă exact 10 cifre.').show();
			} else if (!isEdit && existingPhones.includes(phone)) {
				valid = false;
				$(this).addClass('is-invalid');
				feedback.text('Acest număr de telefon există deja.').show();
			} else {
				$(this).removeClass('is-invalid');
				feedback.hide();
			}
		});

		if (!valid) {
			return false;
		}

		let numeInitial = "<?php echo isset($meta['nume_user']) ? addslashes($meta['nume_user']) : '' ?>";
		let emailInitial = "<?php echo isset($meta['email']) ? addslashes($meta['email']) : '' ?>";
		let telInitial = "<?php echo isset($meta['nr_tel']) ? addslashes($meta['nr_tel']) : '' ?>";

		if (isEdit) {
			let numeNou = $('input[name="nume_user"]').val().trim();
			let emailNou = $('input[name="email"]').val().trim();
			let telNou = $('input[name="nr_tel"]').val().trim();
			let parolaNoua = $('input[name="hash_parola"]').val().trim();

			if (numeNou === numeInitial && emailNou === emailInitial && telNou === telInitial && parolaNoua === "") {
				$('.modal').modal('hide');
				alert_toast("Nu ai modificat nimic.", 'danger');
				exit();
			}
		}


		load_begin();
		$.ajax({
			url: 'ajax.php?action=salvare_admin',
			method: 'POST',
			data: $(this).serialize(),
			success: function (resp) {
				if (resp == 1) {
					$('.modal').modal('hide');
					alert_toast("Cererea de salvare a datelor a fost trimisă", 'success');
				}
			}
		});
	});

</script>