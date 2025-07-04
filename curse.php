<?php

// Preluare date din POST în variabile dinamice
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    foreach ($_POST as $key => $value) {
        $$key = $value;
    }
}

// Include formularul de căutare din pagina home
include 'home.php';
?>

<!-- Secțiune curse disponibile -->
<section id="tur" class="section-block">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2><strong>Curse disponibile</strong></h2>
                        </div>
                    </div>

                    <?php

                    // Preluare listă orașe din baza de date
                    $lista_orase = $conn->query("SELECT * FROM oras");
                    $city = [];

                    if ($lista_orase->num_rows > 0) {
                        while ($row = $lista_orase->fetch_assoc()) {
                            $city[$row['id']] = $row['denumire'];
                        }
                    }

                    // Construim clauza WHERE în funcție de inputul din POST
                    $where = "";
                    if ($_SERVER['REQUEST_METHOD'] === "POST") {
                        $data_cursei = date('Y-m-d', strtotime($departure_date));
                        $where = " where origine_id ='$from_id' and destinatie_id = '$to_id' and date(program) >= '$data_cursei'  ";
                    }

                    // Preluare listă curse disponibile după filtrare
                    $lista_curse = $conn->query("SELECT * FROM cursa $where order by program desc");

                    if ($lista_curse->num_rows > 0):
                        while ($row = $lista_curse->fetch_assoc()):

                            // Calcul locuri libere
                            $ocupate = $conn->query("SELECT * FROM rezervare where id_cursa = " . $row['id'])->num_rows;
                            $libere = $row['locuri_disp'] - $ocupate;
                            $plecare = isset($city[$row['origine_id']]) ? $city[$row['origine_id']] : "Necunoscut";
                            $destinatie = isset($city[$row['destinatie_id']]) ? $city[$row['destinatie_id']] : "Necunoscut";

                            ?>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <p><small>Tur:
                                            <strong><?php echo $plecare . ' - ' . $destinatie; ?></strong></small>
                                    </p>
                                    <p><small>Plecare:
                                            <strong><?php echo date('Y-m-d h:i A', strtotime($row['program'])); ?></strong></small>
                                    </p>
                                    <p>Locuri: <strong class="locuri"
                                            data-id="<?php echo $row['id']; ?>"><?php echo $libere; ?></strong></p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h4><strong><?php echo number_format($row['pret'], 2); ?> RON</strong></h4>
                                    <button type="button" class="btn btn-outline-primary mb-5 rezervare"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-nume="<?php echo $plecare . ' - ' . $destinatie; ?>"
                                        data-max="<?php echo $libere; ?>">Confirmă</button>
                                </div>
                            </div>
                        <?php endwhile; else: ?>
                        <div class="row align-items-center">
                            <h5 class="text-center"><strong>Nicio cursă disponibilă.</strong></h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script JS pentru interactivitate curse -->
<script src="js/curse.js"></script>