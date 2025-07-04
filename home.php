<!-- Fundal -->
<header class="banner">
    <div class="container h-100">
        <!-- Centrare verticală și orizontală -->
        <div class="row h-100 justify-content-center align-items-center text-center">
            <!-- Titlu -->
            <div class="col-lg-10 align-self-end page-title mb-4">
                <h3 class="text-white">Curse</h3>

                <!-- Formular căutare curse -->
                <div class="col-md-12 text-left mb-2 ">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="index.php?page=curse">
                                <div class="row form-group">

                                    <!-- Oraș plecare -->
                                    <div class="col-sm-3">
                                        <label for="departure_id">Plecare din</label>
                                        <select name="from_id" id="departure_id" class="custom-select">
                                            <option value="select_from">-- Selectează --</option>
                                            <?php
                                            $lista_orase = $conn->query("SELECT * FROM oras order by denumire");
                                            while ($row = $lista_orase->fetch_assoc()):
                                                ?>
                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($from_id) && $from_id == $row['id'] ? "selected" : '' ?>><?php echo $row['denumire'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Oraș destinație -->
                                    <div class="col-sm-3">
                                        <label for="arrival_id">Sosire la</label>
                                        <select name="to_id" id="arrival_id" class="custom-select">
                                            <option value="select_to">-- Selectează --</option>
                                            <?php
                                            $lista_orase = $conn->query("SELECT * FROM oras order by denumire");
                                            while ($row = $lista_orase->fetch_assoc()):
                                                ?>
                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($to_id) && $to_id == $row['id'] ? "selected" : '' ?>><?php echo $row['denumire'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <!-- Data plecării -->
                                    <div class="col-sm-3">
                                        <label for="departure_date" class="control-label">Dată plecare</label>
                                        <input type="date" name="departure_date"
                                            class="form-control input-sm datetimepicker2" autocomplete="off"
                                            value="<?php echo isset($departure_date) && !empty($departure_date) ? date("Y-m-d", strtotime($departure_date)) : "" ?>">
                                    </div>

                                    <!-- Buton căutare -->
                                    <div class="col-sm-3">
                                        <button type="submit"
                                            class="btn btn-primary btn-sm btn-block no-select">Căutare</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>