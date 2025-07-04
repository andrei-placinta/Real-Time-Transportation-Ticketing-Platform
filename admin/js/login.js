$('#formular-login').submit(function (e) {
    e.preventDefault();
    $(this).find('.alert-warning').remove();
    $.ajax({
        url: 'ajax.php?action=login',
        method: "POST",
        data: $(this).serialize(),
        success: function (resp) {
            if (parseInt(resp) === 1) {
                location.href = 'index.php?page=home';
            } else {
                $('#formular-login').prepend('<div class="alert alert-warning mt-2">Numele sau parola sunt incorecte.</div>');
            }
        }
    });
});