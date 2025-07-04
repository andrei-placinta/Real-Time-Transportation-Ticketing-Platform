<?php
include 'db_connect.php';
$lista_conturi = $conn->query("SELECT * FROM admin");
$index = 1;
while ($row = $lista_conturi->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo $index++ ?></td>
        <td><?php echo $row['nume_user'] ?></td>
        <td><?php echo $row['email'] ?></td>
        <td><?php echo $row['nr_tel'] ?></td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Comenzi
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item editeaza_cont" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                        <i class="fa fa-edit mr-2 text-warning"></i>Modifică
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item elimina_cont text-danger" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                        <i class="fa fa-trash mr-2"></i>Șterge
                    </a>
                </div>
            </div>
        </td>
    </tr>
<?php endwhile; ?>