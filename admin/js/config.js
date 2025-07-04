function afisare_imagine(input, _this) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!allowedTypes.includes(file.type)) {
            // Adaugă clasa is-invalid și afișează feedback
            $(_this).addClass('is-invalid');
            $(_this).closest('.form-group').find('.invalid-feedback').text('Selectați o imagine validă (jpg, png, gif).').show();

            input.value = ''; // resetează inputul invalid
            return;
        } else {
            // Scoate clasa is-invalid dacă era
            $(_this).removeClass('is-invalid');
            $(_this).closest('.form-group').find('.invalid-feedback').hide();
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            $('#pozaId').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    }
}

$('.text-jqte').jqte();

$('#editare_setari').submit(function (e) {
    e.preventDefault();

    let valid = true;

    // Validare titlu
    $('input[name="titlu"]').each(function () {
        if ($(this).val().trim() === "") {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Validare telefon
    $('input[name="nr_tel"]').each(function () {
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

    // Validare descriere
    $('textarea[name="despre"]').each(function () {
        const descriere = $(this).val().trim();
        if (descriere === "") {
            $(this).addClass('is-invalid');
            $(this).closest('.form-group').find('.invalid-feedback').show();
            valid = false;
        } else {
            $(this).removeClass('is-invalid');
            $(this).closest('.form-group').find('.invalid-feedback').hide();
        }
    });

    if (!valid) {
        return false;
    }

    load_begin();

    $.ajax({
        url: 'ajax.php?action=salvare_setari',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        error: err => {
            console.log(err)
        },
        success: function (resp) {
            if (resp == 1) {
                alert_toast('Setările au fost salvate.', 'success');
            }
        }
    });
});