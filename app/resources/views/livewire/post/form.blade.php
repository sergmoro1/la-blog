{{--
  @var object $tags List of tags options
--}}
<form method="post" wire:submit.prevent="submit">
  @csrf
  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
    <div class="card">
      <div class="card-content">
        <div class="field">
          <label class="label">Title</label>
          <div class="control">
            <input class="input" type="text" wire:model="title" placeholder="Briefly about the content">
          </div>
          <p class="help text-red-500">
             @error('title') <span class="error">{{ $message }}</span> @enderror
          </p>
        </div>

        <div class="field">
          <label class="label">Excerpt</label>
          <div class="control">
            <textarea class="textarea" wire:model="excerpt" placeholder="Main value of content"></textarea>
          </div>
          <p class="help text-red-500">
            @error('excerpt') <span class="error">{{ $message }}</span> @enderror
          </p>
        </div>

        <div class="field">
          <label class="label">Content</label>
          <div class="control">
            <textarea class="textarea" wire:model="content"></textarea>
          </div>
          <p class="help text-red-500">
            @error('content') <span class="error">{{ $message }}</span> @enderror
          </p>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content">
        <div class="field">
          <label class="label">{{ __('Status') }}</label>
          <div class="control">
            <div class="select">
              <select wire:model="status">
                <option value="disabled">{{__('Please select') }}</option>
                <option>draft</option>
                <option>published</option>
                <option>archived</option>
              </select>
            </div>
          </div>
          <p class="help text-red-500">
             @error('status') <span class="error">{{ $message }}</span> @enderror
          </p>         
        </div>
        <div class="field">
          <label class="label">{{ __('Tags') }}</label>
          <div class="control">
            <div class="select" wire:ignore>
              <select id="select-tags" multiple></select>
            </div>
          </div>
          <p class="help text-red-500">
             @error('tags') <span class="error">{{ $message }}</span> @enderror
          </p>         
        </div>
    </div>
  </div>
  <div class="grid grid-cols-1">
    <div class="card">
      <hr>
      <div class="card-content">
        <div class="field grouped">
          <div class="control">
            <button type="submit" class="button green">
              Submit
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    $('#select-tags').select2({
      ajax: {
        url: 'api/tags',
        type: 'get',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'public'
          }
          return query;
        },
        processResults: function (response) {
          const data = response.data;
          let results = data.map(function (item) {
            return {
              id: item.id,
              text: item.name
            };
          });
          return {results: results};
        }
      }
    });
    $('#select-tags').on('submit', function (e) {
      let input = $('#select-tags').select2("val");
      @this.set('tags', input);
    });
  });
</script>
