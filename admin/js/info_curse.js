let table = $('#tabel-curse').DataTable({
    ajax: 'tabel_curse.php',
    columns: [
        { title: "#" },
        { title: "Cursă" },
        { title: "Locuri" },
        { title: "Ocupate" },
        { title: "Libere" },
        { title: "Preț" },
        { title: "Comenzi" }
    ],
    columnDefs: [
        {
            targets: [1, 2, 3, 4, 5, 6],
            className: 'text-center'
        }
    ]
});

$('#cursa_noua').click(function () {
    modal_window("Cursă nouă", "get_cursa.php", 'medium-size');
});

$('#tabel-curse').on('click', '.editeaza_cursa', function () {
    const edit_id = $(this).data('id');
    const edit_ocupate = $(this).data('ocupate');
    modal_window("Modificare cursă", "get_cursa.php?id=" + edit_id + "&ocupate=" + edit_ocupate, 'medium-size');
});

$('#tabel-curse').on('click', '.sterge_cursa', function () {
    if ($(this).data('ocupate') > 0) {
        alert_toast("Nu puteți șterge cursa deoarece are rezervări active.", 'danger');
        return;
    }
    conf_window("Ștergere", "Doriți să ștergeți cursa?", "stergerea_cursei", [$(this).attr('data-id')]);
})

function stergerea_cursei($id) {
    load_begin();
    $.ajax({
        url: 'ajax.php?action=stergere_cursa',
        method: 'POST',
        data: { id: $id },
        success: function (resp) {
            if (resp == 1) {
                $('.modal').modal('hide');
                alert_toast("Cursa a fost ștearsă cu succes", 'success');
                table.ajax.reload(null, false);
            }
        }
    });
}