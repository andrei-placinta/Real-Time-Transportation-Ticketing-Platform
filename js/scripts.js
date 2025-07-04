(function ($) {

  "use strict";

  // Navbar scroll
  const $nav = $("#navCore");
  const handleNavbarScroll = () => {
    if (!$nav.length) return;
    const isScrolled = $nav.offset().top > 100;
    $nav.toggleClass("navbar-scrolled", isScrolled);
  };

  // Inițial
  handleNavbarScroll();

  // La scroll
  $(window).on("scroll", handleNavbarScroll);

  // Închide meniul
  $(".js-scroll-trigger").on("click", () => {
    $(".navbar-collapse").collapse("hide");
  });

  // Date picker handling
  document.addEventListener("DOMContentLoaded", function () {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(field => {
      field.addEventListener('mousedown', e => {
        e.preventDefault();
      });
      field.addEventListener('click', e => {
        e.preventDefault();
        if (field.showPicker) field.showPicker();
      });
    });
  });

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
    toastbg.toast({ delay: 3000 }).toast('show');
  };

  // Destinație != plecare
  window.onload = function () {
    const origine = document.getElementById("departure_id");
    const destinatie = document.getElementById("arrival_id");
    if (!origine || !destinatie) return;

    function actualizeazaDestinatii() {
      const plecare = origine.value;
      for (let i = 0; i < destinatie.options.length; i++) {
        const opt = destinatie.options[i];
        opt.hidden = (opt.value === plecare);
      }

      // Dacă opțiunea curentă este ascunsă, alegem prima vizibilă
      if (destinatie.value === plecare) {
        for (let j = 0; j < destinatie.options.length; j++) {
          if (!destinatie.options[j].hidden) {
            destinatie.value = destinatie.options[j].value;
            break;
          }
        }
      }
    }
    origine.onchange = actualizeazaDestinatii;
    actualizeazaDestinatii();
  };

})(jQuery);