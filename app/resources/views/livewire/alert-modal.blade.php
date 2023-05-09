<div id="modal-delete" class="modal">
  <div class="modal-background --jb-modal-close"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">{{ __('Deleting') }}</p>
    </header>
    <section class="modal-card-body">
      <p>Are you sure you want <b>to delete</b></p>
      <p>selected entity?</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button --jb-modal-close" onclick="
        let modal = document.getElementById('modal-delete');
        modal.style.display = 'none';
      ">
        {{ __('Cancel') }}
      </button>
      <button class="button red --jb-modal-close" 
        onclick="
          let page_tag = document.getElementById('page');
          let page = page_tag ? page_tag.getAttribute('data-page') : 0;
          id = document.querySelector('[data-id]').
            getAttribute('data-id');
          window.livewire.emit('post-delete', id, page);
        ">
        {{ __('Delete') }}
      </button>
    </footer>
  </div>
</div>
