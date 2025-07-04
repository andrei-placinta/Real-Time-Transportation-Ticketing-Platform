$(document).ready(function () {
    function actualizeazaDestinatii() {
        const origineVal = $('#origine_id').val();
        const destinatieVal = $('#destinatie_id').val();

        if (destinatieVal === origineVal) {
            const primaValida = $('#destinatie_id option').filter(function () {
                return $(this).val() !== origineVal;
            }).first().val();

            $('#destinatie_id').val(primaValida).trigger('change.select2');
        }
    }

    $('#origine_id').on('change', function () {
        $('#destinatie_id').select2('destroy').select2({
            templateResult: function (data) {
                const origineVal = $('#origine_id').val();
                if (data.id === origineVal) {
                    return null;
                }
                return data.text;
            }
        });

        actualizeazaDestinatii();
    });

    $('#destinatie_id').on('change', actualizeazaDestinatii);

    actualizeazaDestinatii();
});


$(document).ready(function () {
    $('.select2').each(function () {
        $(this).select2({
            width: "100%"
        });
    });
});

$('.datetimepicker').datetimepicker({
    format: 'Y-m-d H:i'
});

$('.datetimepicker').attr('autocomplete', 'off');

document.getElementById('setNowBtn').onclick = function () {
    const now = new Date();

    function pad(n) {
        return n < 10 ? '0' + n : n;
    }

    const formattedDate = now.getFullYear() + '-' +
        pad(now.getMonth() + 1) + '-' +
        pad(now.getDate()) + ' ' +
        pad(now.getHours()) + ':' +
        pad(now.getMinutes());

    document.getElementById('program').value = formattedDate;
};

// Validare și trimitere formular
$('#formular-cursa').on('submit', function (e) {
    e.preventDefault();

    let valid = true;

    $('select[name="origine_id"]').each(function () {
        const val_from = $(this).val().trim();
        if (val_from === "select_from") {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    $('select[name="destinatie_id"]').each(function () {
        const val_to = $(this).val().trim();
        if (val_to === "select_to") {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    $('input[name="program"]').each(function () {
        const val = $(this).val().trim();
        if (val === "" || isNaN(Date.parse(val))) {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    $('input[name="locuri_disp"]').each(function () {
        const val = $(this).val().trim();
        const ocup = $(this).data('ocupate')
        if (val === "" || isNaN(val) || parseFloat(val - ocup) < 0 || parseFloat(val) > 100) {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    $('input[name="pret"]').each(function () {
        const val = $(this).val().trim();
        if (val === "" || isNaN(val) || parseFloat(val) < 1 || parseFloat(val) > 9999) {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    if (!valid) {
        return false;
    }

    load_begin();

    $.ajax({
        url: 'ajax.php?action=salvare_cursa',
        method: 'POST',
        data: $(this).serialize(),
        success: function (resp) {
            if (parseInt(resp) === 1) {
                $('.modal').modal('hide');
                alert_toast("Detaliile cursei au fost salvate", "success");
                table.ajax.reload(null, false);
            }
        }
    });
});