$('#formular-rezervare').on('submit', function (e) {
    e.preventDefault();

    let valid = true;

    // Validare nume
    $('input[name="nume"]').each(function () {
        const numeVal = $(this).val().trim();
        if (numeVal === "") {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validare telefon
    $('input[name="telefon"]').each(function () {
        const phone = $(this).val().trim();
        if (!/^\d{10}$/.test(phone)) {
            $(this).addClass('is-invalid');
            valid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validare email
    $('input[name="email"]').each(function () {
        const email = $(this).val().trim();
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
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
        url: 'ajax.php?action=modificare_rezervare',
        method: "POST",
        data: $(this).serialize(),
        success: function (resp) {
            if (parseInt(resp) === 1) {
                $('.modal').modal('hide');
                alert_toast("Actualizare efectuată cu succes", "success");
                table.ajax.reload(null, false);
            }
        }
    });
});