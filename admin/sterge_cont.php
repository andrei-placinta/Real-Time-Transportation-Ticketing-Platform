<?php
require 'db_connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Caută tokenul
    $qry = $conn->query("SELECT * FROM delete_tokens WHERE token = '$token'");
    if ($qry->num_rows == 1) {
        $data = $qry->fetch_assoc();
        $user_id = $data['user_id'];

        // Șterge utilizatorul
        $delete_user = $conn->query("DELETE FROM admin WHERE id = $user_id");

        // Șterge tokenul
        $conn->query("DELETE FROM delete_tokens WHERE user_id = '$user_id'");
        $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

        if ($delete_user) {
            header("Location: $base_url/index.php?page=conturi&status=deleted");
        } else {
            header("Location: $base_url/index.php?page=conturi&status=error");
        }
    } else {
        echo "Token invalid sau expirat.";
    }
} else {
    echo "Token lipsă.";
}
?>