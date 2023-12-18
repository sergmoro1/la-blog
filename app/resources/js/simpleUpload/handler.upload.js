/**
 * SimpleUpload.js handler.
 * UploadOptions should be defined before handler.
 * 
 * @author Sergey Morozov <sergmoro1@ya.ru>
 * @see http://simpleupload.michaelcbrook.com/
 */
$(document).ready(function () {
  imageLine = {
    add: function(that, data) {
      // add image
      let img = $('<img/>').attr('src', data.file.thumb).data('img', data.file.url);
      that.block.append(img);
      that.block.append(uploadOptions.image.tools);
      // add new line
      that.li.prop('id', data.id);
      that.block.after(uploadOptions.image.line);
      // add buttons
      let buttons = $('<span/>').prop('id', 'buttons');
      buttons.append(uploadOptions.image.buttons);
      that.li.append(buttons);
    },
    edit: function() {

    },
  };
  
  btn_edit = document.getElementById('#btn-edit');
  btn_edit.addEventListener('click', function() {
    alert('Hi!');
  });
  //$('#btn-edit').click(function() {
  //  alert($(this).closest('li').prop('id'));
  //});
  
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
          imageLine.add(this, data);
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
