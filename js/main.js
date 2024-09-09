// for modal
$(document).on('click', '.openModal', function() {
  var size = $(this).attr('size');
  var url = $(this).attr('href');
  var header = $(this).attr("header");
  header = header ? header : '';
  $('#modal-'+size).find(".header-text").text(header);
  $('#modal-'+size+'-loader').show();
  $('#modal-'+size).modal('show').find('#modal-'+size+'-body')
  .html("").load(url, function() {
      $('#modal-'+size+'-loader').hide();
  });
  return false;
});

$(document).ready(function() {
  $("#mainloader").fadeOut('fast');
});

$(document).on("beforeSubmit", "#app-form", function() {
  $("#submit-btn").prop("disabled", true);
});

// bs5 toast
function toast(msg, color = 'bg-danger', duration = 4000) {
  let toastElem = $(".toast");
  toastElem.addClass(color);
  toastElem.find(".toast-body").text(msg);
  toastElem.fadeIn();
  setTimeout(function() {
      toastElem.fadeOut('slow', function() {
          toastElem.removeClass(color);
      });
  }, duration);
}

$(document).on("click", ".go-back", function() {
  window.history.back();
});

$("#sidebarToggleTop").click(function() {
  $("#accordionSidebar").toggleClass("toggled");
});
