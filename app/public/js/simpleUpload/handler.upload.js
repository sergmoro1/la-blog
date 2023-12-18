/**
 * @author Sergey Morozov <sergmoro1@ya.ru>
 * @see http://simpleupload.michaelcbrook.com/
 * @see createRequest() in main.js
 */

/**
 * Image line actions handler.
 * Image line - line with additional fields as caption for image.
 */
const imageLine = {
  // Delete image form DB, all related files from the disk and delete imaqe line
  delete: function(that) {
    let li = that.closest('li');
    let id = li.getAttribute('id');
    let request = createRequest('DELETE', '/api/images/' + id, 'json'); 
    request.onload = function () {
      if (request.status == 200) {
        li.remove();
      } else {
        alert(`Error ${request.status}: ${request.statusText}`);
      }
    };
    request.send();
  },
  edit: function(that) {
    let li = that.closest('li');
    let id = li.getAttribute('id');
    uploadOptions.fields.forEach((field) => {
        li.querySelector("[name='" + field + "']").removeAttribute('disabled');
    });
  },
};

/**
 * SimpleUpload.js handler.
 */
$(document).ready(function () {
  $('#file_input').change(function () {
      $(this).simpleUpload('/api/images', {

      allowedTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
      maxFileSize: 0,
      data: uploadOptions.data,
      expect: 'json',

      start: function (file) {
        // add new line
        this.li = $('<li/>');
        // add block
        this.block = $('<span class="block"></span>');
        // add progressbar to a block
        this.progressBar = $('<span class="progressBar"></span>');
        this.li.append(this.block.append(this.progressBar));
        // add line to table
        let table = $('#uploads ul.table');
        table.append(this.li);
        // clear prev errors
        table.find('li.error').remove();
      },

      progress: function (progress) {
        this.progressBar.width(progress + "%");
      },

      success: function (data) {
        this.progressBar.remove();
        if (data.success) {
          // Add new image line with addons fields
          // set line id
          this.li.attr('id', data.file.id);
          // add image
          let img = $('<img/>').attr('src', data.file.thumb).data('img', data.file.url);
          this.block.append(img);
          this.block.append(uploadOptions.image.tools);
          // add new line
          this.block.after(uploadOptions.image.line);
          // add buttons
          let buttons = $('<span/>').attr('id', 'buttons');
          buttons.append(uploadOptions.image.buttons);
          this.li.append(buttons);
        } else {
          // and message
          let message = $('<span/>').addClass('message').text(data.message);
          // add line with error to the table
          this.li.addClass('error').append(message);
        }
      },

      error: function (error) {
        this.progressBar.remove();
        this.li.addClass('error');
        this.block.addClass('message').text(error.message);
      }
    });
  });
});
