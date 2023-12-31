import './bootstrap';

//import Alpine from 'alpinejs';
//window.Alpine = Alpine;
//Alpine.start();

window.$ = window.jQuery = require('jquery');

require('datatables.net-dt');
require('./post/handler.datatables.js');

import SimpleMDE from 'simplemde/dist/simplemde.min.js';
let el = document.getElementById("content");
if (el) {
  var simplemde = new SimpleMDE({element: el});
}

require('select2');                
require('./post/select2.js');

require('jquery-simple-upload/simpleUpload');
require('./simpleUpload/handler.upload.js');

import Sortable from 'sortablejs';

el = document.querySelector('ul.table');
if (el) {
  var sortable = Sortable.create(el, {
	  onEnd: function (evt) {
      axios.put('/api/images/' + evt.item.id, {
        oldIndex: evt.oldIndex,
        newIndex: evt.newIndex,
      })
      .then(response => {
        console.log(response);
      })
      .catch(err => {
        console.log(err);
      });
	  },    
  });
}
