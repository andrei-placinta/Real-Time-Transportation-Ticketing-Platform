<?php
include 'admin/db_connect.php';

$trip_id = $_POST['trip_id'];
$nr_pers = $_POST['nr_pers'];

$cursa = $conn->query("SELECT locuri_disp FROM cursa WHERE id = $trip_id")->fetch_array()['locuri_disp'];
$ocupate = $conn->query("SELECT COUNT(*) as total FROM rezervare WHERE id_cursa = $trip_id")->fetch_array()['total'];
$disponibile = $cursa - $ocupate;

if ($disponibile >= $nr_pers) {
    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false]);
}

?>