$(document).ready(function () {
  $("#phone_num").on("input", function () {
    //This function is used to only allow number input
    let inputValue = $(this).val().replace(/\D/g, "");

    //Add "-" for the format like 012-3456789
    if (inputValue.length > 3) {
      inputValue = `${inputValue.substring(0, 3)}-${inputValue.substring(3)}`;
    }
    $(this).val(inputValue);
  });

  $("input").on("focus", function () {
    $(this).parent().addClass("focused");
  })

  $("input").on("blur", function () {
    $(this).parent().removeClass("focused");
  })

  $(".input-box i").on("mousedown", function (event) {
    event.preventDefault();
    event.stopPropagation();
  }).on("click", function () {
    let passwordInput = $(this).prev("input");
    let inputValue = passwordInput.val();
    if (passwordInput.attr("type") === "password") {
      passwordInput.attr("type", "text");
      $(this).removeClass("fa-eye-slash").addClass("fa-eye");
    } else {
      passwordInput.attr("type", "password");
      $(this).removeClass("fa-eye").addClass("fa-eye-slash");
    }
    setTimeout(function () {
      passwordInput.focus();
      passwordInput[0].setSelectionRange(inputValue.length, inputValue.length);
    }, 0);
  });
});