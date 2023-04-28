$(document).ready(function () {
  $('#data-table').DataTable({
    ajax: '/api/posts', 
    headers: { Authorization: credentials }
  });
});
