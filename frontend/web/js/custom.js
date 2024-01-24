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
