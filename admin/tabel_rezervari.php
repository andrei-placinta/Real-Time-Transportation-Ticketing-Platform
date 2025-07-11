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

$lista_rezervari = $conn->query("SELECT a.*, b.*, a.id as rezervare_id FROM rezervare a INNER JOIN cursa b ON b.id = a.id_cursa");

while ($row = $lista_rezervari->fetch_assoc()) {

    $comenzi = '
        <button class="btn btn-outline-primary btn-sm editeaza-rezervari" type="button"
            data-id="' . $row['rezervare_id'] . '"><i class="fa fa-edit"></i></button>
        <button class="btn btn-outline-danger btn-sm sterge-rezervari" type="button"
            data-id="' . $row['rezervare_id'] . '"><i class="fa fa-trash"></i></button>
    ';

    if ($row['stare'] === 'in progres') {
        $comenzi .= '
            <button class="btn btn-outline-success btn-sm confirma-rezervari" type="button"
                data-id="' . $row['rezervare_id'] . '"><i class="fa fa-check"></i></button>
            <button class="btn btn-outline-danger btn-sm anuleaza-rezervari" type="button"
                data-id="' . $row['rezervare_id'] . '"><i class="fa fa-times"></i></button>
        ';
    }

    $plecare = isset($city[$row['origine_id']]) ? $city[$row['origine_id']] : "Necunoscut";

    $destinatie = isset($city[$row['destinatie_id']]) ? $city[$row['destinatie_id']] : "Necunoscut";

    $data[] = [
        $index++,
        '<div class="text-left"><p>Nume: ' . $row['nume'] . '</p><p>Telefon: ' . $row['telefon'] . '</p><p>Email: ' . $row['email'] . '</p></div>',
        '<div class="text-left"><p>Ruta: ' . $plecare . ' - ' . $destinatie . '</p><p>Plecare: ' . date('M d,Y h:i A', strtotime($row['program'])) . '</p></div>',
        '<div class="text-left">' . $row['stare'] . '</div>',
        '<div class="text-center">' . $comenzi . '</div>'
    ];
}

echo json_encode(['data' => $data]);
?>