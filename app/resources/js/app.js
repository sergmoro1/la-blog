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
    getIDs: function() {
      let uploads = getElementById('uploads');
      let rows = uploads.querySelector('ul.table li');
      let ids = [];
      rows.forEach(function(row, index) {
        ids[index] = row.id; 
      });
      return ids;
    },
	onStart: function (evt) {
        console.log(`id = ${evt.item.id}, oldIndex = ${evt.oldIndex}`);
	},
	onEnd: function (/**Event*/evt) {
        let uploads = document.getElementById('uploads');
        let rows = uploads.querySelectorAll('ul.table li');
        let swapWith = rows[evt.oldIndex].id;
        console.log(`id = ${evt.item.id}, newIndex = ${evt.newIndex}, swap with = ${swapWith}`);
	},    
  });
}
