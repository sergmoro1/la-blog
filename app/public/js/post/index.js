$(document).ready(function () {
  $('#data-table').DataTable({
    serverSide: true,
    processing: true,
    paging: true,             
    ajax: {
      url: '/api/posts/',
      type: 'GET',
    },
    headers: { Authorization: app_credentials },
    columns: [
      { data: 'id' },
      { data: 'status' },
      { data: 'title' },
      { data: 'excerpt', orderable: false },
      { data: 'tags_to_str', orderable: false},
      { 
        data: 'created_at',
        render: function (data, type) {
          if (type === 'display') {
            date = new Date(data);
            return date.toLocaleDateString("en-US");
          }
          return data;
        }
      },
      {
        render: function (data, type, row) {
          if (type === 'display') {
            return luke.buttons(['view', 'delete'], row.id);
          }
          return '';
        }
      }
    ]
  });
});
