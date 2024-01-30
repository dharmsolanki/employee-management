$(document).ready(function () {
  $(".dropdown-status").change(function (e) {
    e.preventDefault();
    var statusValue = $(this).val();
    var taskId = $(this).data("task-id");

    // Make AJAX request
    $.ajax({
      url: "/site/update-status", // Replace with your actual controller action URL
      method: "POST",
      data: { statusValue: statusValue, id: taskId },
      success: function (response) {},
      error: function (xhr, status, error) {
        // Handle errors if any
        console.error(error);
      },
    });
  });
});

// showPassword.js

document.addEventListener("DOMContentLoaded", function () {
  let showPasswordCheckbox = document.getElementById("showPasswordCheckboxId");

  function togglePasswordFields() {
    if (!showPasswordCheckbox) {
      console.error("Show Password checkbox not found.");
      return;
    }

    let passwordFieldIds = ["signupform-password", "loginform-password"];

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
