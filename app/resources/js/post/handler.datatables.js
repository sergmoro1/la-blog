/**
 * Datatable line actions handler.
 * @author Sergey Morozov <sergmoro1@ya.ru>
 */
const luke = (function () {
  const views = {
    'buttons': ['view', 'edit', 'delete']
  };
  return {
    get: function (url, id) {
      axios.get(url + '/' + id)
      .then(response => {
        let modal = document.getElementById('modal-show');
        modal.innerHTML = response.data;
        modal.classList.add('active');
      })
      .catch(err => {
        console.log(err);
      });
    },
    delete: function (url, id = null) {
      if (!id) {
      	id = document.querySelector('[data-id]').getAttribute('data-id');
      }
      axios.delete(url + '/' + id)
      .then(response => {
        $('#data-table').DataTable().draw(false);
      })
      .catch(err => {
        console.log(err);
      });
    },
    actions: function (list, id) {
      let html = '';
      for (let action of list) {
        let index = views.buttons.indexOf(action);
        html += this.widgets.buttons[index](id);
      }
      return `<div class="buttons right nowrap">${html}</div>`;
    },
    widgets: {
      buttons: [
        function (id) // view
        {
          return `<a onclick="luke.get('post-show-modal', ${id});">
              <button class="button small green" type="button">
                <span class="material-icons">visibility</span>
              </button>
            </a>`;
        },
        function (id) // edit
        {
          return `<a href="/post-edit/${id}">
              <button class="button small blue" type="button">
                <span class="material-icons">edit</span>
              </button>
            </a>`;
        },
        function (id) // delete
        {
          return `<button class="button small red --jb-modal"  
              data-target="modal-delete" type="button" 
              onclick="this.setAttribute('data-id', ${id}); 
                let modal = document.getElementById('modal-delete'); 
                modal.classList.add('active');">
                <span class="material-icons">delete</span>
            </button>`;
        }
      ]
    }
  };
}());

/**
 * Datatable.js handler.
 * @see https://www.datatables.net/
 */
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
            return luke.actions(['view', 'edit', 'delete'], row.id);
          }
          return '';
        }
      }
    ]
  });
});
