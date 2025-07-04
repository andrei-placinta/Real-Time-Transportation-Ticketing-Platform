function getRezervareData() {
    const tripId = $('#form-rezervare input[name="trip_id"]').val();
    const textLocuri = $('.locuri[data-id="' + tripId + '"]');
    const nrPersoane = $('#nr_pers').val();
    const persoaneRezervate = parseInt(nrPersoane);
    const limitButton = $('.rezervare[data-id="' + tripId + '"]');
    const limita_locuri = parseInt(textLocuri.text());
    const limita_noua = limita_locuri - persoaneRezervate;
    return {
        tripId,
        textLocuri,
        nrPersoane,
        persoaneRezervate,
        limitButton,
        limita_locuri,
        limita_noua
    };
}

$('#button-confirm').click(function () {
    load_begin();
    const data = getRezervareData();
    if (data.nrPersoane > data.limita_locuri) {
        alert("Numărul de persoane nu poate fi mai mare decât numărul de locuri disponibile.")
        load_end();
        return false;
    }

    $.post("verifica_locuri.php", {
        trip_id: data.tripId,
        nr_pers: data.persoaneRezervate
    }, function (resp) {
        const response = JSON.parse(resp);
        if (!response.ok) {
            $('.modal').modal('hide');
            alert_toast("Nu mai sunt locuri. Reîncarcă pagina", "danger");
            data.textLocuri.text("0");
            data.limitButton.attr("data-max", 0);
            load_end();
            return;
        }

    });

    $.ajax({
        url: "get_client.php?count=" + $('#nr_pers').val(),
        success: function (resp) {
            if (resp) {
                $('#detalii-rezervare').prepend(resp);
                $('#nr_locuri').hide();
                $('#detalii-rezervare').show();
                load_end();
            }
        }

    });
});

$('#form-rezervare').submit(function (e) {
    e.preventDefault();
    let valid = true;

    // Validare nume
    $('input[name="nume[]"]').each(function () {
        if ($(this).val().trim() === "") {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validare telefon
    $('input[name="telefon[]"]').each(function () {
        const phone = $(this).val().trim();
        if (!/^\d{10}$/.test(phone)) {
            $(this).addClass('is-invalid');
            valid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validare email
    $('input[name="email[]"]').each(function () {
        let email = $(this).val().trim();
        let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!pattern.test(email)) {
            $(this).addClass('is-invalid');
            valid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    if (!valid) {
        return false;
    }

    load_begin();
    $.ajax({
        url: 'admin/ajax.php?action=adaugare_rezervare',
        method: "POST",
        data: $(this).serialize(),
        success: function (resp) {
            if (parseInt(resp) === 1) {
                $('.modal').modal('hide');
                alert_toast("Rezervarea a fost efectuată cu succes.", "success");
                const data = getRezervareData();
                if (data.limita_locuri > 0) {
                    data.textLocuri.text(data.limita_noua);
                    data.limitButton.attr('data-max', data.limita_noua);
                }
                load_end();
            }
            else if (parseInt(resp) === 3) {
                $('.modal').modal('hide');
                alert_toast("Nu mai sunt locuri. Reîncarcă pagina", "danger");
                const data = getRezervareData();
                data.textLocuri.text(0);
                data.limitButton.attr('data-max', 0);
                load_end();
            }
        }
    });
});