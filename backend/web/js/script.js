$(document).ready(function () {
  $("#div_taskForm").hide();
  $("#btnAssignTask").click(function (e) {
    e.preventDefault();
    $("#div_taskForm").show();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  let showPasswordCheckbox = document.getElementById("showPasswordCheckboxId");

  function togglePasswordFields() {
    if (!showPasswordCheckbox) {
      console.error("Show Password checkbox not found.");
      return;
    }

    let passwordFieldIds = ["loginform-password"];

    passwordFieldIds.forEach(function (fieldId) {
      let passwordField = document.getElementById(fieldId);
      if (passwordField) {
        passwordField.type = showPasswordCheckbox.checked ? "text" : "password";
      } else {
        // console.error("Password field with ID '" + fieldId + "' not found.");
      }
    });
  }

  if (showPasswordCheckbox) {
    showPasswordCheckbox.addEventListener("change", togglePasswordFields);

    // Trigger the initial state
    togglePasswordFields();
  } else {
    // console.error("Show Password checkbox not found.");
  }
});
