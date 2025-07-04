<?php
ob_start();
session_start();
ini_set('display_errors', 1);

class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function login()
	{
		extract($_POST);
		$nume_user = mysqli_real_escape_string($this->db, $nume_login);
		$hash_parola = $_POST['parola_login'];
		$qry = $this->db->query("SELECT * FROM admin WHERE nume_user = '$nume_user' LIMIT 1");
		if ($qry->num_rows == 0) {
			$qry = $this->db->query("SELECT * FROM admin WHERE email = '$nume_user' LIMIT 1");
		}
		if ($qry->num_rows > 0) {
			$user = $qry->fetch_assoc();
			if (password_verify($hash_parola, $user['hash_parola'])) {
				foreach ($user as $key => $value) {
					if ($key != 'hash_parola' && !is_numeric($key)) {
						$_SESSION['login_' . $key] = $value;
					}
				}
				return 1;
			} else {
				return 2;
			}
		} else {
			return 3;
		}
	}

	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("Location: login.php");
	}

	function salvare_admin()
	{
		extract($_POST);
		$email_to = 'admin@mail.com'; // adresa unde se trimite email-ul de confirmare

		$data_array = [
			"nume_user" => $nume_user,
			"email" => $email,
			"nr_tel" => $nr_tel
		];

		if (!empty($hash_parola)) {
			$hashp = password_hash($hash_parola, PASSWORD_DEFAULT);
			$data_array['hash_parola'] = $hashp;
		}

		if (!empty($id)) {
			$data_array['id'] = $id;
		}

		// Generează token
		$token = bin2hex(random_bytes(32));
		$created_at = date('Y-m-d H:i:s');
		$data_json = json_encode($data_array);

		// Salvează token și datele
		$this->db->query("INSERT INTO save_tokens (user_id, token, data, created_at) VALUES (" . (!empty($id) ? $id : "NULL") . ", '$token', '$data_json', '$created_at')");

		// Trimite email
		require '../PHPMailer/src/Exception.php';
		require '../PHPMailer/src/PHPMailer.php';
		require '../PHPMailer/src/SMTP.php';

		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'sandbox.smtp.mailtrap.io';
			$mail->SMTPAuth = true;
			$mail->Username = '98734f8d467e6d';
			$mail->Password = '196c1042864b0f';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			$mail->setFrom('no-reply@app.com', 'Aplicație Rezervări');
			$mail->addAddress($email_to, 'Admin Aplicatie');
			$mail->isHTML(true);
			$mail->Subject = 'Confirmare salvare utilizator';
			$base_url = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			$mail->Body = "Salut, ai o solicitare de salvare a utilizatorului cu numele: $nume_user.<br><br>
		Apasa pe link-ul de mai jos pentru a confirma modificarea:<br><br>
		<a href='$base_url/salveaza_cont.php?token=$token'>Confirma salvarea utilizatorului</a><br><br>
		Daca nu ai cerut aceasta actiune, ignora acest mesaj.";

			$mail->send();
			return 1;
		} catch (Exception $e) {
			return 0;
		}
	}

	public function stergere_admin()
	{
		extract($_POST);

		// Găsește utilizatorul
		$qry = $this->db->query("SELECT * FROM admin WHERE id = $id");
		if ($qry->num_rows == 0) {
			return 0;
		}

		$user = $qry->fetch_assoc();
		$email = $user['email'];
		$nume = $user['nume_user'];

		if ($_SESSION['login_id'] == $id) {
			return 'self_delete'; // cod personalizat pentru "nu-ți poți șterge propriul cont"
		}

		// Generează token
		$token = bin2hex(random_bytes(32));
		$created_at = date('Y-m-d H:i:s');

		// Salvează tokenul într-o tabelă
		$this->db->query("INSERT INTO delete_tokens (user_id, token, created_at) VALUES ($id, '$token', '$created_at')");

		// Trimite email cu link
		require '../PHPMailer/src/Exception.php';
		require '../PHPMailer/src/PHPMailer.php';
		require '../PHPMailer/src/SMTP.php';

		$mail = new PHPMailer\PHPMailer\PHPMailer(true);
		try {
			$mail->isSMTP();
			$mail->Host = 'sandbox.smtp.mailtrap.io';
			$mail->SMTPAuth = true;
			$mail->Username = '98734f8d467e6d';
			$mail->Password = '196c1042864b0f';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->setFrom($email, $nume);
			$mail->addAddress('admin@mail.com', 'Admin Aplicatie');
			$mail->isHTML(true);
			$mail->Subject = 'Confirmare stergere cont';
			$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			$mail->Body = "Salut administrator, ai primit urmatoarea cerere de la utilizatorul cu numele: $nume<br><br>Apasa pe linkul de mai jos pentru a confirma stergerea contului tau:<br><br>
		<a href='$base_url/sterge_cont.php?token=$token'>Confirma stergerea contului</a><br><br>
		Daca nu ai cerut aceasta actiune, ignora acest mesaj.";

			$mail->send();
			return 1;
		} catch (Exception $e) {
			return 0;
		}
	}

	function salvare_setari()
	{
		extract($_POST);
		$data = " titlu = '" . str_replace("'", "&#x2019;", $titlu) . "' ";
		$data .= ", email = '$email' ";
		$data .= ", nr_tel = '$nr_tel' ";
		$data .= ", despre = '" . htmlentities(str_replace("'", "&#x2019;", $despre)) . "' ";

		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../img/upload/' . $fname);
			$data .= ", poza = '$fname' ";
		}

		$chk = $this->db->query("SELECT * FROM optiune");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE optiune set " . $data);
		} else {
			$save = $this->db->query("INSERT INTO optiune set " . $data);
		}

		if ($save) {
			$query = $this->db->query("SELECT * FROM optiune limit 1")->fetch_array();
			foreach ($query as $key => $value) {
				if (!is_numeric($key)) {
					$_SESSION['config_' . $key] = $value;
				}
			}
			return 1;
		}
	}

	function salvare_oras()
	{
		extract($_POST);
		$data = " denumire = '$denumire' ";

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO oras set " . $data);
			return 1;
		} else {
			$save = $this->db->query("UPDATE oras set " . $data . " where id=" . $id);
			return 2;
		}
		if (!$save) {
			return 0;
		}
	}

	function stergere_oras()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM oras where id = " . $id);
		if ($delete) {
			return 1;
		}
	}

	function salvare_cursa()
	{
		extract($_POST);
		$data = " origine_id = '$origine_id' ";
		$data .= ", destinatie_id = '$destinatie_id' ";
		$data .= ", program = '$program' ";
		$data .= ", locuri_disp = '$locuri_disp' ";
		$data .= ", pret = '$pret' ";

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO cursa set " . $data);
		} else {
			$save = $this->db->query("UPDATE cursa set " . $data . " where id = " . $id);
		}
		if ($save) {
			return 1;
		}
	}

	function stergere_cursa()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM cursa where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function adaugare_rezervare()
	{
		extract($_POST);
		$this->db->begin_transaction();
		$cursa = $this->db->query("SELECT locuri_disp FROM cursa WHERE id = $trip_id FOR UPDATE")->fetch_array()['locuri_disp'];
		$ocupate = $this->db->query("SELECT COUNT(*) as total FROM rezervare WHERE id_cursa = $trip_id")->fetch_array()['total'];
		$disponibile = $cursa - $ocupate;
		$cerute = count($nume);
		if ($disponibile < $cerute) {
			$this->db->rollback();
			return 3;
		}
		foreach ($nume as $k => $value) {
			$data = " id_cursa = $trip_id ";
			$data .= " , nume = '$nume[$k]' ";
			$data .= " , telefon = '$telefon[$k]' ";
			$data .= " , email = '$email[$k]' ";

			if (!$this->db->query("INSERT INTO rezervare set " . $data)) {
				$this->db->rollback();
				return 3;
			}
		}
		$this->db->commit();
		return 1;
	}
	function modificare_rezervare()
	{
		extract($_POST);
		$data = "  nume = '$nume' ";
		$data .= " , telefon = '$telefon' ";
		$data .= " , email = '$email' ";
		$data .= " , stare = '$stare' ";

		$save = $this->db->query("UPDATE rezervare set " . $data . " where id =" . $id);
		if ($save) {
			return 1;
		}
	}
	function stergere_rezervare()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM rezervare where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function confirmare_rezervare()
	{
		extract($_POST);
		$update = $this->db->query("UPDATE rezervare SET stare = 'confirmata' WHERE id = " . $id);
		if ($update) {
			return 1;
		}
	}
	function anulare_rezervare()
	{
		extract($_POST);
		$update = $this->db->query("UPDATE rezervare SET stare = 'anulata' WHERE id = " . $id);
		if ($update) {
			return 1;
		}
	}

}

$action = $_GET['action'];
$crud = new Action();

if ($action == 'login') {
	$login = $crud->login();
	if ($login)
		echo $login;
}

if ($action == 'logout') {
	$crud->logout();
}

if ($action == 'salvare_admin') {
	$save = $crud->salvare_admin();
	if ($save)
		echo $save;
}

if ($action == 'stergere_admin') {
	$save = $crud->stergere_admin();
	if ($save)
		echo $save;
}

if ($action == "salvare_setari") {
	$save = $crud->salvare_setari();
	if ($save)
		echo $save;
}

if ($action == "salvare_oras") {
	$save = $crud->salvare_oras();
	if ($save)
		echo $save;
}

if ($action == "stergere_oras") {
	$save = $crud->stergere_oras();
	if ($save)
		echo $save;
}

if ($action == "salvare_cursa") {
	$save = $crud->salvare_cursa();
	if ($save)
		echo $save;
}

if ($action == "stergere_cursa") {
	$save = $crud->stergere_cursa();
	if ($save)
		echo $save;
}

if ($action == "adaugare_rezervare") {
	$save = $crud->adaugare_rezervare();
	if ($save)
		echo $save;
}

if ($action == "modificare_rezervare") {
	$save = $crud->modificare_rezervare();
	if ($save)
		echo $save;
}

if ($action == "stergere_rezervare") {
	$save = $crud->stergere_rezervare();
	if ($save)
		echo $save;
}

if ($action == "confirmare_rezervare") {
	$save = $crud->confirmare_rezervare();
	if ($save)
		echo $save;
}

if ($action == "anulare_rezervare") {
	$save = $crud->anulare_rezervare();
	if ($save)
		echo $save;
}

?>