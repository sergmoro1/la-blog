"use strict";

/* Aside & Navbar: dropdowns */
Array.from(document.getElementsByClassName('dropdown')).forEach(function (elA) {
  elA.addEventListener('click', function (e) {
    if (e.currentTarget.classList.contains('navbar-item')) {
      e.currentTarget.classList.toggle('active');
    } else {
      var dropdownIcon = e.currentTarget.getElementsByClassName('mdi')[1];
      e.currentTarget.parentNode.classList.toggle('active');
      dropdownIcon.classList.toggle('mdi-plus');
      dropdownIcon.classList.toggle('mdi-minus');
    }
  });
});
/* Aside Mobile toggle */

Array.from(document.getElementsByClassName('mobile-aside-button')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    var dropdownIcon = e.currentTarget.getElementsByClassName('icon')[0].getElementsByClassName('mdi')[0];
    document.documentElement.classList.toggle('aside-mobile-expanded');
    dropdownIcon.classList.toggle('mdi-forwardburger');
    dropdownIcon.classList.toggle('mdi-backburger');
  });
});
/* NavBar menu mobile toggle */

Array.from(document.getElementsByClassName('--jb-navbar-menu-toggle')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    var dropdownIcon = e.currentTarget.getElementsByClassName('icon')[0].getElementsByClassName('mdi')[0];
    document.getElementById(e.currentTarget.getAttribute('data-target')).classList.toggle('active');
    dropdownIcon.classList.toggle('mdi-dots-vertical');
    dropdownIcon.classList.toggle('mdi-close');
  });
});
/* Modal: open */

Array.from(document.getElementsByClassName('--jb-modal')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    var modalTarget = e.currentTarget.getAttribute('data-target');
    document.getElementById(modalTarget).classList.add('active');
    document.documentElement.classList.add('clipped');
  });
});
/* Modal: close */

Array.from(document.getElementsByClassName('--jb-modal-close')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    e.currentTarget.closest('.modal').classList.remove('active');
    document.documentElement.classList.remove('is-clipped');
  });
});
/* Notification dismiss */

Array.from(document.getElementsByClassName('--jb-notification-dismiss')).forEach(function (el) {
  el.addEventListener('click', function (e) {
    e.currentTarget.closest('.notification').classList.add('hidden');
  });
});

function createRequest(type, url, responseType = '') { 
  let request = new XMLHttpRequest();
  request.responseType = responseType;
  request.open(type, url);
  request.setRequestHeader('Authorization', app_credentials);
  request.setRequestHeader('Content-Type', 'application/json');
  return request;
}; 

let luke = (function () {
  const views = {
    'buttons': ['view', 'edit', 'delete']
  };
  return {
    get: function (url, id) {
      let request = createRequest('GET', url + '/' + id); 
      request.onload = function () {
        if (request.status == 200) {
          let modal = document.getElementById('modal-show');
          modal.innerHTML = request.response;
          modal.classList.add('active');
        } else {
          alert(`Ошибка ${request.status}: ${request.statusText}`);
        }
      };
      request.send();
    },
    delete: function (url, id = null) {
      if (!id) {
      	id = document.querySelector('[data-id]').getAttribute('data-id');
      }
      let request = createRequest('DELETE', url + '/' + id, 'json'); 
      request.onload = function () {
        if (request.status == 200) {
          $('#data-table').DataTable().draw(false);
        } else {
          alert(`Ошибка ${request.status}: ${request.statusText}`);
        }
      };
      request.send();
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
                <span class="icon"><i class="mdi mdi-eye"></i></span>
              </button>
            </a>`;
        },
        function (id) // edit
        {
          return `<a href="/post-edit/${id}">
              <button class="button small blue" type="button">
                <span class="icon"><i class="mdi mdi-pencil"></i></span>
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
                <span class="icon">
                  <i class="mdi mdi-trash-can"></i>
                </span>
            </button>`;
        }
      ]
    }
  };
}());
