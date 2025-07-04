<?php
include 'db_connect.php';

header('Content-Type: application/json');

$data = [];
$index = 1;

$lista_orase = $conn->query("SELECT * FROM oras ");

while ($row = $lista_orase->fetch_assoc()) {

    $comenzi = '
        <button class="btn btn-sm btn-primary editeaza_oras" type="button"
            data-id="' . $row['id'] . '" data-denumire="' . $row['denumire'] . '">Modifică</button>
        <button class="btn btn-sm btn-danger sterge_oras" type="button"
            data-id="' . $row['id'] . '">Șterge</button>
    ';

    $data[] = [
        $index++,
        '<div class="text-left">' . $row['denumire'] . '</div>',
        '<div class="text-center">' . $comenzi . '</div>'
    ];
}

echo json_encode(['data' => $data]);
?>