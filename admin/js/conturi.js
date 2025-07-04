$('#adauga_cont').click(function () {
    modal_window('Cont nou', 'get_cont.php');
});

$('.editeaza_cont').click(function () {
    modal_window('Modificare detalii', 'get_cont.php?id=' + $(this).attr('data-id'));
});

$('.elimina_cont').click(function () {
    conf_window("Ștergere", "Doriți să efectuați ștergerea?", "stergerea_contului", [$(this).attr('data-id')]);
});

function stergerea_contului($id) {
    load_begin();
    $.ajax({
        url: 'ajax.php?action=stergere_admin',
        method: 'POST',
        data: { id: $id },
        success: function (resp) {
            if (parseInt(resp) === 1) {
                $('.modal').modal('hide');
                alert_toast("Cererea de ștergere a fost trimisă", 'success');
            }
            else if (resp === 'self_delete') {
                $('.modal').modal('hide');
                alert_toast("Nu puteți șterge contul cu care sunteți conectat!", 'danger');
            } else {
                $('.modal').modal('hide');
                alert_toast("A apărut o eroare la ștergere.", 'danger');
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'deleted') {
        alert_toast("Utilizatorul a fost șters cu succes", 'success');
    } else if (status === 'error') {
        alert_toast("Eroare la ștergerea utilizatorului.", 'danger');
    } else if (status === 'save_success') {
        alert_toast("Utilizatorul a fost salvat cu succes.", 'success');
    } else if (status === 'save_error') {
        alert_toast("Eroare la salvarea utilizatorului.", 'danger');
    }

    // Elimină status din URL fără reload
    if (status !== null) {
        const newUrl = window.location.pathname + window.location.search.replace(/([&?])status=[^&]*(&)?/g, function (match, p1, p2) {
            return p1 === '?' && p2 ? '?' : p1;
        }).replace(/[?&]$/, ''); // elimină ? sau & de la final dacă rămâne

        window.history.replaceState({}, document.title, newUrl);
    }
});