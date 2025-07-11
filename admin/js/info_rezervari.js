let table = $('#tabel-rezervari').DataTable({
    ajax: 'tabel_rezervari.php',
    columns: [
        { title: "#" },
        { title: "Client" },
        { title: "Cursă" },
        { title: "Stare" },
        { title: "Comenzi" }
    ],
    columnDefs: [
        {
            targets: [1, 2, 3, 4],
            className: 'text-center'
        }
    ]
});

$('#tabel-rezervari').on('click', '.editeaza-rezervari', function () {
    modal_window("Modificare", "get_rezervare.php?id=" + $(this).attr('data-id'), 'medium-size');
});

$('#tabel-rezervari').on('click', '.sterge-rezervari', function () {
    conf_window("Ștergere", "Doriți sa efectuați ștergerea?", "stergere_rezervare", [$(this).attr('data-id')]);
});

function stergere_rezervare($id) {
    load_begin();
    $.ajax({
        url: 'ajax.php?action=stergere_rezervare',
        method: 'POST',
        data: { id: $id },
        success: function (resp) {
            if (resp == 1) {
                $('.modal').modal('hide');
                alert_toast("Rezervarea a fost ștearsă cu succes!", 'success');
                table.ajax.reload(null, false);
            }
        }
    });
}

$('#tabel-rezervari').on('click', '.confirma-rezervari', function () {
    conf_window("Confirmare", "Ești sigur că vrei să confirmi această rezervare?", "confirmare_rezervare", [$(this).attr('data-id')]);
});

function confirmare_rezervare($id) {
    load_begin();
    $.ajax({
        url: 'ajax.php?action=confirmare_rezervare',
        method: 'POST',
        data: { id: $id },
        success: function (resp) {
            if (resp == 1) {
                $('.modal').modal('hide');
                alert_toast("Rezervare confirmată cu succes!", 'success');
                table.ajax.reload(null, false);
            }
        }
    });
}

$('#tabel-rezervari').on('click', '.anuleaza-rezervari', function () {
    conf_window("Anulare", "Ești sigur că vrei să anulezi această rezervare?", "anulare_rezervare", [$(this).attr('data-id')]);
});

function anulare_rezervare($id) {
    load_begin();
    $.ajax({
        url: 'ajax.php?action=anulare_rezervare',
        method: 'POST',
        data: { id: $id },
        success: function (resp) {
            if (resp == 1) {
                $('.modal').modal('hide');
                alert_toast("Rezervare anulată cu succes!", 'success');
                table.ajax.reload(null, false);
            }
        }
    });
}