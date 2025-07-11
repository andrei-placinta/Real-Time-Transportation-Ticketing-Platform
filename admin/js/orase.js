let table = $('#tabel-orase').DataTable({
    ajax: 'tabel_orase.php',
    columns: [
        { title: "#" },
        { title: "Denumire Oraș" },
        { title: "Comandă" }
    ],
    columnDefs: [
        {
            targets: [1, 2],
            className: 'text-center'
        }
    ]
});

function _reset() {
    $('[name="id"]').val('');
    $('#modif_orase').get(0).reset();
}

$('#modif_orase').submit(function (e) {
    e.preventDefault();

    // Validare denumire
    const denumire = $('[name="denumire"]').val().trim();
    if (denumire === '') {
        alert_toast("Introduceți o denumire validă pentru oraș!", 'danger');
        $('[name="denumire"]').addClass('is-invalid').focus();
        return;
    } else {
        $('[name="denumire"]').removeClass('is-invalid');
    }

    load_begin();

    $.ajax({
        url: 'ajax.php?action=salvare_oras',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function (resp) {
            if (parseInt(resp) === 1) {
                alert_toast("Detaliile au fost salvate", 'success');
                table.ajax.reload(null, false);
                _reset();
            }
            else if (parseInt(resp) === 2) {
                alert_toast("Detaliile au fost actualizate", 'success');
                table.ajax.reload(null, false);
                _reset();
            }
        }
    });
});

$('#tabel-orase').on('click', '.editeaza_oras', function () {

    //load_begin();

    const form_orase = $('#modif_orase');
    form_orase.get(0).reset();
    form_orase.find("[name='id']").val($(this).attr('data-id'));
    form_orase.find("[name='denumire']").val($(this).attr('data-denumire'));

    //load_end();
});

$('#tabel-orase').on('click', '.sterge_oras', function () {
    conf_window("Ștergere", "Doriți să efectuați ștergerea?", "stergerea_orasului", [$(this).attr('data-id')]);
});

function stergerea_orasului($id) {
    load_begin();

    $.ajax({
        url: 'ajax.php?action=stergere_oras',
        method: 'POST',
        data: { id: $id },
        success: function (resp) {
            if (parseInt(resp) === 1) {
                $('.modal').modal('hide');
                alert_toast("Orașul a fost șters cu succes", 'success');
                table.ajax.reload(null, false);
                _reset();
            }
        }
    });
}