// Preia datele cursei pe baza elementului butonului
function getCursaData(buttonElement) {
    const idCursa = $(buttonElement).data('id');
    const maxim = $(buttonElement).attr('data-max');
    const locuriText = $('.locuri[data-id="' + idCursa + '"]').text();
    const locuri = parseInt(locuriText);

    return { idCursa, maxim, locuri };
}

$(document).ready(function () {

    // La click pe butonul de rezervare
    $('.rezervare').on('click', function () {
        const data = getCursaData(this);
        const buton = $(this);
        const textLocuri = $('.locuri[data-id="' + data.idCursa + '"]');

        // Verifică dacă numărul de locuri este valid
        if (isNaN(data.locuri)) {
            alert("Eroare: nu s-au putut prelua locurile.");
            return;
        }

        // Verifică dacă mai sunt locuri disponibile
        if (data.locuri <= 0) {
            alert("Nu mai sunt locuri disponibile!");
            return;
        }

        $.post("verifica_locuri.php", {
            trip_id: data.idCursa,
            nr_pers: 1 // se trimite inițial 1 persoană
        }, function (resp) {
            const response = JSON.parse(resp);
            if (!response.ok) {
                alert_toast("Nu mai sunt locuri. Reîncarcă pagina", "danger");
                textLocuri.text("0");
                buton.attr("data-max", 0);
                return;
            }

            modal_window($(this).data('nume'), "rezervare.php?id=" + data.idCursa + "&max=" + data.maxim, 'medium-size');
        }.bind(this));
    });
});