(function ($) {

  "use strict";

  // Inițializează loader-ul la încărcarea paginii
  $(document).ready(function () {
    $('#loader-screen').fadeOut('fast', function () {
      $(this).remove();
    });
  });

  // Funcții loader
  window.load_begin = () => {
    $('body').prepend('<div id="loader-screen-alt"></div>');
  };

  window.load_end = () => {
    $('#loader-screen-alt').fadeOut('fast', function () {
      $(this).remove();
    });
  };

  // Deschide fereastră confirmare
  window.conf_window = function ($title = '', $msg = '', $func = '', $params = []) {
    $('#modal_confirm #confirm_btn').attr('onclick', $func + "(" + $params.join(',') + ")");
    $('#modal_confirm .modal-title').html($title);
    $('#modal_confirm .modal-body').html($msg);
    $('#modal_confirm').modal('show');
  }

  // Deschide fereastră modală
  window.modal_window = function ($title = '', $url = '', $size = '') {
    load_begin();
    $.ajax({
      url: $url,
      error: () => {
        console.log('Eroare la încărcare');
        alert("A apărut o eroare");
      },
      success: function (resp) {
        if (!resp) return;

        $('#modal_window .modal-title').html($title);
        $('#modal_window .modal-body').html(resp);
        const dialog = $('#modal_window .modal-dialog');
        if ($size !== '') {
          dialog.addClass($size);
        } else {
          dialog.removeAttr("class").addClass("modal-dialog modal-md");
        }
        $('#modal_window').modal('show');
        load_end();
      }
    });
  };

  // Afișare notificări toast
  window.alert_toast = function ($msg = 'TEST', $bg = 'success') {
    let toastbg = $('#alert_toast');
    toastbg.removeClass('bg-success bg-danger');

    if ($bg === 'success') toastbg.addClass('bg-success');

    if ($bg === 'danger') toastbg.addClass('bg-danger');
    $('#alert_toast .toast-body').html($msg);
    load_end(); // comentează și decomentează loader-ul de pe pagina index
    toastbg.toast({ delay: 3000 }).toast('show');
  };

})(jQuery);