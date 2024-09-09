$("#app-form-2").on("beforeSubmit", function() {
  // validate again in case user changes it by editing HTML
  if(validatePass($(".passvalid").val()))
      $("#submit-btn").prop("disabled", true);
  else {
      alert("Please enter a strong password");
      return false;
  }
});

$(document).on("keyup", ".passvalid", function() {
  if(validatePass($(this).val()))
      $("#submit-btn").prop("disabled", false);
  else
      $("#submit-btn").prop("disabled", true);
});

function validatePass(pass) {
  var allgood = 0;
  var lowerCaseLetters = /[a-z]/g;
  if(pass.match(lowerCaseLetters)) {
      allgood = 1;
      valid($("#v1"));
  } else {
      allgood = 0;
      invalid($("#v1"));
  }

  var upperCaseLetters = /[A-Z]/g;
  if(pass.match(upperCaseLetters)) {
      allgood = allgood && 1;
      valid($("#v2"));
  } else {
      allgood = 0;
      invalid($("#v2"));
  }

  var digit = /[0-9]/g;
  if(pass.match(digit)) {
      allgood = allgood && 1;
      valid($("#v3"));
  } else {
      allgood = 0;
      invalid($("#v3"));
  }

  if(pass.length>=8) {
      allgood = allgood && 1;
      valid($("#v4"));
  } else {
      allgood = 0;
      invalid($("#v4"));
  }

  if(allgood == "1")
      $("#submit-btn").prop("disabled", false);
  else
      $("#submit-btn").prop("disabled", true);

  return allgood;
}

function valid(elem) {
  elem.removeClass("invalid");
  elem.addClass("valid");
}
function invalid(elem) {
  elem.removeClass("valid");
  elem.addClass("invalid");
}
