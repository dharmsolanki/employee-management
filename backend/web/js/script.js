$(document).ready(function () {
  $("#div_taskForm").hide();
  $("#btnAssignTask").click(function (e) {
    e.preventDefault();
    $("#div_taskForm").show();
  });
});
