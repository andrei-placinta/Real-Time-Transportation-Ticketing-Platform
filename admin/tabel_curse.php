<?php

include 'db_connect.php';

header('Content-Type: application/json');

$lista_orase = $conn->query("SELECT * FROM oras ");
$city = [];
while ($row = $lista_orase->fetch_assoc()) {
    $city[$row['id']] = $row['denumire'];
}

$data = [];
$index = 1;

$lista_curse = $conn->query("SELECT * FROM cursa");

while ($row = $lista_curse->fetch_assoc()) {
    $ocupate = $conn->query("SELECT * FROM rezervare where id_cursa = " . $row['id'])->num_rows;

    $comenzi = '
        <button class="btn btn-outline-primary btn-sm editeaza_cursa" type="button"
            data-id="' . $row['id'] . '" data-ocupate="' . $ocupate . '"><i class="fa fa-edit"></i>
        </button>
        <button class="btn btn-outline-danger btn-sm sterge_cursa" type="button"
            data-id="' . $row['id'] . '" data-ocupate="' . $ocupate . '"><i class="fa fa-trash"></i>
        </button>
    ';

    $plecare = isset($city[$row['origine_id']]) ? $city[$row['origine_id']] : "Necunoscut";

    $destinatie = isset($city[$row['destinatie_id']]) ? $city[$row['destinatie_id']] : "Necunoscut";

    $data[] = [
        $index++,
        '<div class="text-left"><p>Ruta: ' . $plecare . ' - ' . $destinatie . '</p><p>Plecare: ' . date('M d,Y h:i A', strtotime($row['program'])) . '</p></div>',
        '<div class="text-right">' . $row['locuri_disp'] . '</div>',
        '<div class="text-right">' . $ocupate . '</div>',
        '<div class="text-right">' . $row['locuri_disp'] - $ocupate . '</div>',
        '<div class="text-right">' . number_format($row['pret'], 2) . '</div>',
        '<div class="text-center">' . $comenzi . '</div>'
    ];
}

echo json_encode(['data' => $data]);
?>