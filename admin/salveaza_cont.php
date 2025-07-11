<?php
session_start();
require 'db_connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $qry = $conn->query("SELECT * FROM save_tokens WHERE token = '$token'");
    if ($qry->num_rows == 1) {
        $data = $qry->fetch_assoc();
        $data_array = json_decode($data['data'], true);

        // Verificăm dacă e update sau insert
        if (!empty($data_array['id'])) {
            $id = $data_array['id'];
            $update_data = " nume_user = '{$data_array['nume_user']}' ";
            $update_data .= ", email = '{$data_array['email']}' ";
            $update_data .= ", nr_tel = '{$data_array['nr_tel']}' ";
            if (!empty($data_array['hash_parola'])) {
                $update_data .= ", hash_parola = '{$data_array['hash_parola']}' ";
            }
            $save = $conn->query("UPDATE admin SET $update_data WHERE id = $id");
            if ($_SESSION['login_id'] == $data_array['id']) {
                $_SESSION['login_nume_user'] = $data_array['nume_user'];
            }
            $conn->query("DELETE FROM save_tokens WHERE user_id = '$id'");
        } else {
            $insert_fields = "nume_user, email, nr_tel";
            $insert_values = "'{$data_array['nume_user']}', '{$data_array['email']}', '{$data_array['nr_tel']}'";
            if (!empty($data_array['hash_parola'])) {
                $insert_fields .= ", hash_parola";
                $insert_values .= ", '{$data_array['hash_parola']}'";
            }
            $save = $conn->query("INSERT INTO admin ($insert_fields) VALUES ($insert_values)");
            $conn->query("DELETE FROM save_tokens WHERE token = '$token'");
        }
        $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

        if ($save) {
            header("Location: $base_url/index.php?page=conturi&status=save_success");
        } else {
            header("Location: $base_url/index.php?page=conturi&status=save_error");
        }
    } else {
        echo "Token invalid sau expirat.";
    }
} else {
    echo "Token lipsă.";
}
?>